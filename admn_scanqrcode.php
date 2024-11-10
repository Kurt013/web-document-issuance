<?php
  require './classes/main.class.php';

  $userdetails = $bmis->get_userdata();
  $bmis->validate_admin();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>QR Code Scanner</title>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  </head>
  <body style="text-align: center;">
    
    <?php 
        include('dashboard_sidebar_start.php');
    ?>

    <h1>QR Code Scanner</h1>
    <video id="preview"></video>
    <br>
    <label for="cameraSelect">Select Camera:</label>
    <select id="cameraSelect"></select>
    
    <button id="open">Open Camera</button>
    <button id="close">Close Camera</button>
    

    <?php 
        include('dashboard_sidebar_end.php');
    ?>
    
    <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      let cameras = [];
      let isScanning = false;

      // Listener for QR code content
      scanner.addListener('scan', function (content) {
        console.log("Scanned content:", content);
        
        try {
        // Parse the JSON data to verify it's correct
        let data = JSON.parse(content);

        // Stringify and URL-encode the JSON data
        let jsonString = encodeURIComponent(JSON.stringify(data));

        // Create a link with the JSON as a parameter in the URL
        let link = document.createElement("a");
        link.href = `./${data.doc_type}_form.php?data=${jsonString}`;
        link.target = "_blank";
        link.click();
        } catch (e) {
            console.error("Error parsing QR content as JSON:", e);
        }
      });

      // Fetch available cameras and populate the dropdown
      Instascan.Camera.getCameras().then(function (availableCameras) {
        if (availableCameras.length > 0) {
          cameras = availableCameras;
          let cameraSelect = document.getElementById('cameraSelect');
          cameraSelect.innerHTML = ''; // Clear existing options

          cameras.forEach((camera, index) => {
            let option = document.createElement('option');
            option.value = index;
            option.text = camera.name || `Camera ${index + 1}`;
            cameraSelect.appendChild(option);
          });
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error("Error accessing camera:", e);
      });

      // Function to start the selected camera
      function startCamera() {
        let cameraIndex = document.getElementById('cameraSelect').value;
        if (cameras[cameraIndex]) {
          scanner.start(cameras[cameraIndex]).then(() => {
            isScanning = true;
            console.log(`Camera ${cameraIndex} started.`);
          }).catch(e => {
            console.error("Error starting camera:", e);
          });
        } else {
          console.error('Selected camera not found.');
        }
      }

      // Function to stop the camera
      function stopCamera() {
        if (isScanning) {
          scanner.stop();
          isScanning = false;
          console.log("Camera stopped.");
        }
      }

      // Event listeners for open and close buttons
      document.getElementById('open').addEventListener('click', startCamera);
      document.getElementById('close').addEventListener('click', stopCamera);
    </script>
  </body>
</html>

