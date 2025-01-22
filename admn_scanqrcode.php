<?php
  include('dashboard_sidebar_start.php');
  include('popup.php');
  include('table_design.php');
?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js-components/instascan.min.js"></script>

    <script src="./js-components/custom-popup.js"></script>    
    <link rel="stylesheet" href="./css/custom-popup.css">

  <style>
    @font-face {
  font-family: 'PMedium'; 
  src: url('fonts/Poppins-Medium.ttf') format('truetype'); 
}
  
  h1 {
    color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
        
            letter-spacing: 3px;

            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
  }
  video {
    margin-top: 20px;
  }

  label {
         
         font-size: 1rem;
         color: #012049;
         font-family: "PSemiBold";
         margin-top: 10px;

     }

     select  {
            font-family: "PMedium" !important;
            font-size: 1rem;
            border-radius: 5px;
            border: 2px solid #012049;
            padding: 0 5px;
            cursor: pointer;
            width: 20%;
            margin-left: 5px;
            text-align: center;
            color: #012049;
          
            
        }
  </style>

  <div class="modal payment-popup">

  </div>

  <div style="text-align: center;">

    <h1>QR Code Scanner</h1>
    <video id="preview"></video>
    <br>
    <label for="cameraSelect">Select Camera:</label>
    <select id="cameraSelect"></select>
    
   <!-- make simple popup-->
    <div class="custom-modal payment-popup" id="payment-popup">
      <div class="custom-form">
        <button class="custom-close-btn" id="close-button">X</button>
        <div class="custom-content">
          <button class="custom-submit" id="free">FREE</button>
          <button class="custom-submit" id="paid">PAID</button>
        </div>
      </div>
    </div>


      
    <div class="toasterr" id = "toasterr" style = "border-left: 6px solid #D32F2F;" >
                <div class="toasterr-content">
                    <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                    <div class="message">
                    <span class="text text-1">Invalid QR Code Format</span>
                    <span class="text text-2">You scanned a QR code with an invalid format.</span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close close-error"  onclick="closeToasterr()"></i>
                <div class="progresserr progresserr-error"></div>
            </div>
        
    <!-- end of simple popup-->
    
    <script>
       // Close the modal when clicking the close button
      document.getElementById('close-button').addEventListener('click', () => {
        document.getElementById('payment-popup').style.display = 'none';
      });

      
    </script>

    <script type="text/javascript">
      const toast = document.querySelector(".toasterr");
      const progress = document.querySelector(".progresserr");
let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
let cameras = [];
let isScanning = false; // Track if the scanner is already active

// Listener to handle the QR code scan
scanner.addListener('scan', function (content) {
  // scan qr code then prompt the user a popup that lets the user choose whether their payment is FREE or PAID
  let regex = /.*\/([a-zA-Z]+)_form\.php\?id_\1=(\d{4}-\d{2}-\d{2}-\d{3}|\d{4}-\d{3})/;

  if (regex.test(content)) {
    document.getElementById('payment-popup').style.display = 'block';

    document.getElementById('free').addEventListener('click', () => {
      document.getElementById('payment-popup').style.display = 'none';
      window.open(content + '&payment=free', '_blank');
    });
    document.getElementById('paid').addEventListener('click', () => {
      document.getElementById('payment-popup').style.display = 'none';
      window.open(content + '&payment=paid', '_blank');
    });

  } else {
    toast.classList.add("active");
    progress.classList.add("active");

    // Set timers to remove 'active' class after 5 seconds for toast and 5.5 seconds for progress bar
    timer1 = setTimeout(() => {
        toast.classList.remove("active");
    }, 5000);

    timer2 = setTimeout(() => {
        progress.classList.remove("active");
    }, 5000);
  }


  // try {
  //   $.ajax({
  //     url: window.location.href, 
  //     type: 'POST',
  //     data: {
  //       added_by: <?= $userdetails['id'] ?>,
  //       qr_data: content
  //     },
  //     success: function(response) {
  //       let coc_type = JSON.parse(content);
  //       let result = JSON.parse(response);

  //       if (result.status === 'success') {
  //         alert(result.message);
  //         window.open(`${doc_type}_form.php?id_${doc_type}=${result.lastId}`, "_blank");
  //       } else {
  //         console.error('Error:', result.message);
  //       }
  //     },
  //     error: function(xhr, status, error) {
  //       console.error('Error sending data:', error);
  //     }
  //   });

  // } catch (e) {
  //   console.error("Error parsing QR content as JSON:", e);
  // }
});

function closeToasterr() {
    const toast = document.querySelector(".toasterr");
    const progress = document.querySelector(".progresserr");

    toast.classList.remove("active");
    progress.classList.remove("active");
}
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

    // Check if there is a saved camera index in sessionStorage
    let savedCameraIndex = sessionStorage.getItem('selectedCameraIndex');
    if (savedCameraIndex !== null) {
      startCamera(parseInt(savedCameraIndex)); // Start the saved camera
      cameraSelect.selectedIndex = savedCameraIndex; // Set the dropdown to the saved camera
    } else {
      // Start the first camera by default if no saved index
      startCamera(0);
      cameraSelect.selectedIndex = 0; // Set the dropdown to the first camera
    }

    // Listen for changes in the camera dropdown
    cameraSelect.addEventListener('change', function() {
      let selectedIndex = cameraSelect.value;
      startCamera(selectedIndex);
      sessionStorage.setItem('selectedCameraIndex', selectedIndex); // Save the selected camera index
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

</div>
<?php 
      include('dashboard_sidebar_end.php');
?>