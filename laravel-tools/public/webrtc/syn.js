 async function listDevices() {
      await navigator.mediaDevices.getUserMedia({ audio: true, video: true });
      const devices = await navigator.mediaDevices.enumerateDevices();
      document.getElementById('devices').textContent =
        devices.map(d => `${d.kind}: ${d.label}`).join('\n');
    }
    listDevices();