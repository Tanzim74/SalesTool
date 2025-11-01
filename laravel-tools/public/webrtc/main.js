const socket = io("http://127.0.0.1:3001"); // same origin
const roomId = "classroom-room";

const teacherVideo = document.getElementById("teacherVideo");
const studentContainer = document.getElementById("studentVideos");
const shareScreenBtn = document.getElementById("shareScreenBtn");
const joinBtn = document.getElementById("joinBtn");
const roleSelect = document.getElementById("role");

let localStream;    // teacher mic
let screenStream;   // teacher screen
let peerConnections = {}; // {id: { pc, videoSender }}
let role;           // current user role
const config = { iceServers: [{ urls: "stun:stun.l.google.com:19302" }] };

// -------------------- Join Room --------------------
joinBtn.addEventListener("click", async () => {
    role = roleSelect.value;
    socket.emit("join-room", roomId, role);

    if (role === "teacher") {
        try {
            localStream = await navigator.mediaDevices.getUserMedia({ audio: true });
        } catch (err) {
            alert("Microphone access denied!");
            console.error(err);
            return;
        }
        teacherVideo.srcObject = localStream;
        shareScreenBtn.style.display = "inline";
    } else if (role === "student") {
        teacherVideo.srcObject = null;
        socket.emit("get-users", roomId);
    }
});

// Handle existing users for late-joining students
socket.on("existing-users", users => {
    users.forEach(user => {
        if (user.role === "teacher") {
            const pcData = createPeerConnection(user.id, false); // student side
            const pc = pcData.pc;

            // Student initiates offer to teacher
            pc.createOffer({ offerToReceiveVideo: true, offerToReceiveAudio: true }).then(offer => {
                pc.setLocalDescription(offer);
                socket.emit("signal", { target: user.id, signal: offer });
            });
        }
    });
});

// -------------------- Share Screen --------------------
shareScreenBtn.addEventListener("click", async () => {
    if (!localStream) return alert("Join first!");
    try {
        screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
    } catch (err) {
        alert("Screen share denied!");
        console.error(err);
        return;
    }

    // Teacher preview: mic + screen
    teacherVideo.srcObject = new MediaStream([...localStream.getTracks(), ...screenStream.getTracks()]);
    const videoTrack = screenStream.getVideoTracks()[0];

    // Add/replace track for all students
    for (let id in peerConnections) {
        const { pc, videoSender } = peerConnections[id];

        if (videoSender) {
            videoSender.replaceTrack(videoTrack);
        } else {
            const sender = pc.addTrack(videoTrack, screenStream);
            peerConnections[id].videoSender = sender;
        }

        // Trigger renegotiation
        const offer = await pc.createOffer({ offerToReceiveVideo: true });
        await pc.setLocalDescription(offer);
        socket.emit("signal", { target: id, signal: offer });
    }

    // Stop sharing
    videoTrack.onended = async () => {
        for (let id in peerConnections) {
            const { pc, videoSender } = peerConnections[id];
            if (videoSender) videoSender.replaceTrack(null);

            const offer = await pc.createOffer({ offerToReceiveVideo: true });
            await pc.setLocalDescription(offer);
            socket.emit("signal", { target: id, signal: offer });
        }
        teacherVideo.srcObject = localStream;
        screenStream = null;
    };
});

// -------------------- Handle Signals --------------------
socket.on("signal", async ({ sender, signal }) => {
    if (!peerConnections[sender]) createPeerConnection(sender);

    const { pc } = peerConnections[sender];

    if (signal.type === "offer") {
        await pc.setRemoteDescription(new RTCSessionDescription(signal));
        const answer = await pc.createAnswer();
        await pc.setLocalDescription(answer);
        socket.emit("signal", { target: sender, signal: answer });
    } else if (signal.type === "answer") {
        await pc.setRemoteDescription(new RTCSessionDescription(signal));
    } else if (signal.candidate) {
        await pc.addIceCandidate(new RTCIceCandidate(signal));
    }
});

// -------------------- Handle User Leaving --------------------
socket.on("user-left", id => {
    if (peerConnections[id]) {
        peerConnections[id].pc.close();
        delete peerConnections[id];
        const videoEl = document.getElementById("student-" + id);
        if (videoEl) videoEl.remove();
    }
});

// -------------------- Create PeerConnection --------------------
function createPeerConnection(id, isTeacherSide = true) {
    const pc = new RTCPeerConnection(config);
    peerConnections[id] = { pc, videoSender: null };

    // Teacher adds mic
    if (localStream && role === "teacher" && isTeacherSide) {
        localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
    }

    // Add screen if already sharing (teacher)
    if (screenStream && role === "teacher" && isTeacherSide) {
        const sender = pc.addTrack(screenStream.getVideoTracks()[0], screenStream);
        peerConnections[id].videoSender = sender;
    }

    // Remote track: students see teacher
    pc.ontrack = (event) => {
        let videoEl = document.getElementById("student-" + id);
        if (!videoEl) {
            videoEl = document.createElement("video");
            videoEl.id = "student-" + id;
            videoEl.autoplay = true;
            videoEl.playsInline = true;
            studentContainer.appendChild(videoEl);
        }
        videoEl.srcObject = event.streams[0];
    };

    pc.onicecandidate = (event) => {
        if (event.candidate) socket.emit("signal", { target: id, signal: event.candidate });
    };

    return peerConnections[id];
}

// -------------------- Handle New Users --------------------
socket.on("user-joined", ({ id, role }) => {
    if (role === "teacher" || (roleSelect.value === "teacher" && role === "student")) {
        createPeerConnection(id);
    }
});
