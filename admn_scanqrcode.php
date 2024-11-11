<?php
  require './classes/main.class.php';

  $userdetails = $bmis->get_userdata();
  $bmis->validate_admin();
  $bmis->insert_certofres();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>QR Code Scanner</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    
    <?php 
        include('dashboard_sidebar_end.php');
    ?>
    
    <script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    let cameras = [];
    let isScanning = false; // Track if the scanner is already active

    // Listener to handle the QR code scan
    scanner.addListener('scan', function (content) {
      console.log("Scanned content:", content);
      
      try {
        $.ajax({
          url: window.location.href, 
          type: 'POST',
          data: {
            added_by: <?= $userdetails['id'] ?>,
            qr_data: content
          },
          success: function(response) {
            let doc_type = (JSON.parse(content)).doc_type;
            let result = JSON.parse(response);

            if (result.status === 'success') {
              alert(result.message);
              window.open(`${doc_type}_form.php?id_${doc_type}=${result.lastId}`, "_blank");
              location.reload();
            } else {
              console.error('Error:', result.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error sending data:', error);
          }
        });

      } catch (e) {
        console.error("Error parsing QR content as JSON:", e);
      }
    });

    // Fetch available cameras and populate the dropdown
    Instascan.Camera.getCameras().then(function (availableCameras) {
      if (availableCameras.length > 0) {
        cameras = availableCameras.filter(camera => !camera.name.toLowerCase().includes('obs virtual camera') && !camera.name.toLowerCase().includes('virtual'));
        let cameraSelect = document.getElementById('cameraSelect');
        cameraSelect.innerHTML = ''; // Clear existing options

        cameras.forEach((camera, index) => {
          let option = document.createElement('option');
          option.value = index;
          option.text = camera.name || `Camera ${index + 1}`;
          cameraSelect.appendChild(option);
        });

        // Start the first camera by default
        startCamera(0); // Pass the index of the first camera

        // Listen for changes in the camera dropdown
        cameraSelect.addEventListener('change', function() {
          startCamera(cameraSelect.value);
        });
      } else {
        console.error('No cameras found.');
      }
    }).catch(function (e) {
      console.error("Error accessing camera:", e);
    });

    // Function to start the selected camera
    function startCamera(cameraIndex) {
      if (isScanning) {
        // Stop the current camera if a new one is selected
        scanner.stop().then(() => {
          isScanning = false;
          activateCamera(cameraIndex);
        });
      } else {
        activateCamera(cameraIndex);
      }
    }

    // Helper function to activate a specific camera
    function activateCamera(cameraIndex) {
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
  </script>
  </body>
</html>
