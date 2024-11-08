    <div class="form">
        <video id="video" autoplay style="display: inline-block; width: 400px; height: 400px"></video>
        <canvas id="canvas" style="display:none;"></canvas>
        <label>
        Select Camera:
        <select id="cameraSelect" class="camera-select"></select>
        </label>

        <button type="button" class="capture-button" id="captureButton">Capture Image</button>
        <button class="save-button" id="saveButton">Save</button>

        <input type="hidden" name="res_photo" id="res_photo">
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('captureButton');
        const cameraSelect = document.getElementById('cameraSelect');
        const res_photoInput = document.getElementById('res_photo');
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

            // Calculate dimensions for drawing on the canvas while maintaining aspect ratio
            let drawWidth, drawHeight;
            if (videoAspectRatio > 1) {
                // Video is wider than it is tall
                drawWidth = canvas.width;
                drawHeight = canvas.width / videoAspectRatio;
            } else {
                // Video is taller than it is wide
                drawHeight = canvas.height;
                drawWidth = canvas.height * videoAspectRatio;
            }

            // Calculate position to center the image on the canvas
            const offsetX = (canvas.width - drawWidth) / 2;
            const offsetY = (canvas.height - drawHeight) / 2;

            // Draw the video frame onto the canvas with centered positioning
            context.drawImage(video, offsetX, offsetY, drawWidth, drawHeight);
            
            // Convert canvas image to base64 string
            const imageDataUrl = canvas.toDataURL('image/jpeg');
            
            // Set the value of the hidden input to the base64 string for form submission
            res_photoInput.value = imageDataUrl;

            // Optional: Show the captured image on the canvas
            canvas.style.display = 'inline-block';
        });

        const urlParams = new URLSearchParams(window.location.search);
        const residentId = urlParams.get('id_resident');

        // Set the URL dynamically based on the 'resident' parameter
        let ajaxUrl = `barangayid_form.php ${residentId}`;
        // if (residentId) {
        //     ajaxUrl += `?resident=${residentId}`;
        // }

        $(document).ready(function () {
            $('.save-button').on('click', function () {
                // Capture the editable content
                const data = {
                    update_resphoto: true,
                    res_photo: $('#res_photo').val()
                };

                $.ajax({
                    type: "POST",
                    url: ajaxUrl,
                    data: data,
                    success: function (response) {
                        alert("updated succesfully!");
                        console.log("Data being sent:", data);
                        window.opener.location.reload();
                        window.close();
                },
                    error: function () {
                        alert("An error occurred while updating.");
                    }
                });
            });
        });

    </script>