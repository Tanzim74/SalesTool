<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Classroom Screen Share</title>
  <link rel="stylesheet" href="{{ asset('webrtc/style.css') }}">
  <style>
    video {
      width: 300px;
      margin: 5px;
      border: 1px solid #ccc;
    }
    .video-container {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>🎓 Classroom Screen Share</h2>

    <label for="role">Select Role:</label>
    <select id="role">
      <option value="teacher">Teacher</option>
      <option value="student">Student</option>
    </select>

    <button id="joinBtn">Join Room</button>
    <button id="shareScreenBtn" style="display:none;">Share Screen</button>

    <div id="videos">
      <div class="video-container">
        <h4>Teacher Preview</h4>
        <video id="teacherVideo" autoplay playsinline muted></video>
      </div>

      <div id="studentVideos"></div>
    </div>
  </div>

  <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
  <script src="{{ asset('webrtc/main.js') }}"></script>
</body>
</html>
