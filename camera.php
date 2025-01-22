<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take a Picture (2x2)</title>

    <style>
    .form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .camera-select {
        width: 100%;
        padding: 5px;
    }

    .capture-button {
        padding: 10px;
        background-color: #012049;
        color: white;
        border: none;
        cursor: pointer;
    }

    .capture-button:hover {
        background-color: #001f3f;
    }
</style>
</head>
<body style="background-color: #014bae;">
    



<div class="form">
        <video id="video" autoplay style="display: inline-block; width: 200px; height: 200px; object-fit: cover;"></video>
        <canvas id="canvas" style="display:none;"></canvas>
        <label style="text-align: center; font-family: 'Arial'; color: white; font-weight: bold;">
        Select Camera:
        <select id="cameraSelect" class="camera-select"></select>
        </label>

        <button type="button" class="capture-button" id="captureButton">Capture Image</button>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('captureButton');
        const cameraSelect = document.getElementById('cameraSelect');
        const res_photoInput = window.opener.document.getElementById('res_photo');
        const context = canvas.getContext('2d');
        const addFileInput = document.getElementById('addFile');
        let currentStream = null;

        // Function to stop any active video streams
        function stopVideoStream() {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }
        }

        // Function to start video stream from selected device
        function startVideoStream(deviceId) {
            stopVideoStream();
            navigator.mediaDevices.getUserMedia({ video: { deviceId: deviceId } })
                .then(stream => {
                    currentStream = stream;
                    video.srcObject = stream;
                })
                .catch(error => {
                    console.error("Error accessing webcam:", error);
                });
        }

        // Get list of video input devices (cameras)
        navigator.mediaDevices.enumerateDevices()
            .then(devices => {
                const videoDevices = devices.filter(device => device.kind === 'videoinput');
                videoDevices.forEach((device, index) => {
                    const option = document.createElement('option');
                    option.value = device.deviceId;
                    option.text = device.label || `Camera ${index + 1}`;
                    cameraSelect.appendChild(option);
                });

                // Start the video with the first available camera
                if (videoDevices.length > 0) {
                    startVideoStream(videoDevices[0].deviceId);
                }
            })
            .catch(error => {
                console.error("Error listing devices:", error);
            });

        // Change video source when a new camera is selected
        cameraSelect.addEventListener('change', () => {
            startVideoStream(cameraSelect.value);
        });

        // Capture a photo and store it in the hidden input
        captureButton.addEventListener('click', () => {
            const inchSize = 2;
            const dpi = 96;
            canvas.width = inchSize * dpi;
            canvas.height = inchSize * dpi;

            // Get video dimensions and calculate aspect ratio
            const videoWidth = video.videoWidth;
            const videoHeight = video.videoHeight;
            const videoAspectRatio = videoWidth / videoHeight;

            // Calculate dimensions for drawing on the canvas with object-fit: cover effect
            let drawWidth, drawHeight;
            if (videoAspectRatio > 1) {
                // Video is wider than it is tall (landscape)
                drawHeight = canvas.height;
                drawWidth = canvas.height * videoAspectRatio;
            } else {
                // Video is taller than it is wide (portrait)
                drawWidth = canvas.width;
                drawHeight = canvas.width / videoAspectRatio;
            }

            // Calculate position to center the image on the canvas
            const offsetX = (canvas.width - drawWidth) / 2;
            const offsetY = (canvas.height - drawHeight) / 2;

            // Draw the video frame onto the canvas with centered positioning
            context.drawImage(video, offsetX, offsetY, drawWidth, drawHeight);
            
            // Convert canvas image to base64 string
            const imageDataUrl = canvas.toDataURL('image/png');
            
            // Set the value of the hidden input to the base64 string for form submission
            res_photoInput.src = imageDataUrl;

        });
    </script>
    </body>
</html>
