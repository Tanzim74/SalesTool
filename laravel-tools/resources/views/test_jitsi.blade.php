<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Jitsi Class</title>
</head>
<body style="margin:0; padding:0;">

    <h2 style="text-align:center; background:#f2f2f2; padding:10px;">Test Jitsi Classroom</h2>

    <div id="jitsi-container" style="width:100%; height:90vh;"></div>

    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        const domain = "meet.jit.si"; // You can change this if you host Jitsi yourself

        const options = {
            roomName: "demo-classroom-test-123", // All participants use the same room name
            width: "100%",
            height: 700,
            parentNode: document.querySelector('#jitsi-container'),
            userInfo: {
                displayName: "Teacher"
            },
            configOverwrite: {
                startWithAudioMuted: false,
                startWithVideoMuted: false,
                disableDeepLinking: true
            },
            interfaceConfigOverwrite: {
                TOOLBAR_BUTTONS: [
                    'microphone', 'camera', 'desktop', 'chat', 'raisehand', 'tileview', 'hangup'
                ],
                SHOW_JITSI_WATERMARK: false,
            }
        };

        const api = new JitsiMeetExternalAPI(domain, options);

        // Optional: Listen to events
        api.addListener('participantJoined', event => {
            console.log('Someone joined:', event.displayName);
        });
    </script>

</body>
</html>