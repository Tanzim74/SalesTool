// const express = require("express");
// const http = require("http");
// const { Server } = require("socket.io");
// const path = require("path");

// const app = express();
// const server = http.createServer(app);

// // CORS-enabled Socket.IO so Laravel frontend can connect
// const io = new Server(server, {
//     cors: {
//         origin: "http://127.0.0.1:8000", // Laravel frontend
//         methods: ["GET", "POST"]
//     }
// });

// // (Optional) Serve static frontend if you want Node to serve it
// // app.use(express.static(path.join(__dirname, "public")));

// io.on("connection", (socket) => {
//     console.log("✅ User connected:", socket.id);

//     socket.on("join-room", (roomId, role) => {
//         socket.join(roomId);
//         socket.role = role;
//         console.log(`${role} joined room ${roomId}`);

//         // Notify others
//         socket.to(roomId).emit("user-joined", { id: socket.id, role });

//         // Relay WebRTC signals
//         socket.on("signal", (data) => {
//             io.to(data.target).emit("signal", { sender: socket.id, signal: data.signal });
//         });

//         // Send existing users to late joiners
//         socket.on("get-users", (roomId) => {
//             const users = [];
//             const socketsInRoom = io.sockets.adapter.rooms.get(roomId);
//             if (socketsInRoom) {
//                 socketsInRoom.forEach(id => {
//                     const s = io.sockets.sockets.get(id);
//                     users.push({ id: s.id, role: s.role });
//                 });
//             }
//             socket.emit("existing-users", users);
//         });

//         socket.on("disconnect", () => {
//             socket.to(roomId).emit("user-left", socket.id);
//         });
//     });
// });

// server.listen(3001, () => console.log("🚀 Server running on http://localhost:3001"));
const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = new Server(server);

app.use(express.static("public")); // Serve HTML + JS files

io.on("connection", socket => {
  console.log("User connected");
});

server.listen(3000, () => console.log("Server running on port 3000"));