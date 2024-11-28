<style>

@font-face {
            font-family: 'PMedium'; 
            src: url('fonts/Poppins-Medium.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PRegular'; 
            src: url('fonts/Poppins-Regular.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PBold'; 
            src: url('fonts/Poppins-Bold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PSemiBold'; 
            src: url('fonts/Poppins-SemiBold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PBlack'; 
            src: url('fonts/Poppins-Black.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PExBold'; 
            src: url('fonts/Poppins-ExtraBold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PBlackIt'; 
            src: url('fonts/Poppins-BlackItalic.ttf') format('truetype'); 
        }

.pnp-content {
            overflow-y: auto;
    max-height: calc(100vh - 250px); /* Adjust this value based on header/footer height */
    padding: 20px;
    box-sizing: content-box;
 
    }

.popup-pnp {
            padding: 0 20px;
            width: 65%;
            height: 80vh;
            border-left: 15px solid white;
            border-right: 15px solid white;
            border-radius: 10px;
            background-color: #fff;
            position: relative; 
             z-index: 1000;
             overflow-y: hidden;
             margin-left: 30px;
             margin-right: 30px;
             display: flex;
             flex-direction: column;
             box-sizing: border-box;
         
        }
        .overlay-pnp {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .overlay-pnp.show {
            display: flex;
            opacity: 1;
        }

        .pnp-content h2 {
                font-family: "PBold";
                color: rgba(0, 0, 0, 0.8);
            }

            .pnp-content p, .pnp-content h4 {
               color: black;
               font-size: 0.9rem;
               margin: 10px 0;
               font-family: "PMedium";
               font-weight: normal;
                
            }

            .pnp-head h1 {
    margin: 0; /* Remove default margin */
    font-size: 1.7rem;
    color: #014bae;
    font-family: "PBold";
    text-align: center; /* Center text horizontally */
}

.pnp-head h1{
    padding: 20px;
    color:rgba(0, 0, 0, 0.8);
  
}


.btn-close-pnp {
    background-color: rgba(0, 0, 0, 0.3);
    font-family: "PExBold";
    letter-spacing: 1px;
    color: #fff;
    width: 100%;
    border: none;
    padding: 20px 20px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 0 0 10px 10px;
}

.btn-close-pnp:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.pnp-footer {

    padding: 20px;
    text-align: center;
    
}


</style>


<div id="pnp" 
         class="overlay-pnp">

        <div class="popup-pnp">
          <div class = "pnp-head">
            <h1>Privacy Policy</h1>
            <hr style = "margin-bottom: 10px;">
          </div>
        <div class = "pnp-content">
            <h2> 1. Introduction </h2>
            <p>This Privacy Policy outlines our policies regarding the collection, use, storage, disclosure, and disposal of personal data collected through this site and other related interactions. These interactions include contacting our support number, sending inquiries to our email, and providing information when using our services. By using this site, you agree to the terms of this Privacy Policy and the collection and use of your personal data in compliance with applicable laws and regulations.</h3>
            <h2> 2. Collection and Use of Personal Data</h2>
            <p> We collect personal data to facilitate your document requests, improve our services, and ensure the proper functioning of this site. Personal data refers to any information from which your identity can be reasonably and directly ascertained. This may include, but is not limited to:</h3>
            <h4> • Full Name </h4>
            <h4> • Date of Birth </h4>
            <h4> • Home Address </h4>
            <h4> •  Address </h4>
            <h4> • Contact Number(s) </h4>
            <h4> • Government Identification Number(s) </h4>
            <h4> • Other relevant information necessary for your transaction with this site </h4>
            <p> We collect this information when you register or update your details, fill out request forms, or engage in other transactions through this site. The information collected is used to process your document requests, generate necessary forms, and produce a QR code for use at the Barangay Hall.</p>
            <h2> 3. Security of Your Personal Data </h2>
            <p> We take reasonable measures to ensure the security of your personal data during its collection and processing. Although we strive to maintain the integrity and confidentiality of your information, we cannot guarantee absolute security, as no site is fully immune to potential threats.</p>
            <h2> 4. Data Retention and Disposal </h2>
            <p> We retain your personal data only for as long as necessary to fulfill the purposes outlined in this Privacy Policy or as required by law. Once your data is no longer needed, it will be securely disposed of to prevent unauthorized access, following guidelines set by the National Archives of the Philippines in accordance with R.A. 9470.</p>
            <p> Data may be classified for: </p>
            <h4> • Temporary Retention: Data needed for short-term operational purposes is securely stored and deleted after a defined period.</h4>
            <h4> • Permanent Deletion: Data that has reached the end of its retention period is permanently and securely removed from this site. </h4>
            <h2> 5. Use of QR Code </h2>
            <p> Upon successfully submitting a document request, this site generates a unique QR code. This QR code is used to retrieve your requested document at the Barangay Hall. It is your responsibility to keep the QR code secure. Sharing this code with unauthorized persons may result in data breaches, for which we are not liable.</p>
            <h2> 6. Changes to this Privacy Policy </h2>
            <p> This Privacy Policy will remain effective except with respect to any changes in its provision in the future, which will take effect immediately after being posted on this site.
            We may occasionally update our Privacy Policy which you should check periodically. Your continued use of our services after we post amendments or revisions to this Privacy Policy will constitute your acknowledgment, acceptance, and adherence to the modifications, and your consent to abide and be bound by the modified Privacy Policy.</p>
            <h2> 7. Contact Us </h2>
            <p> If you have questions or concerns about this Privacy Policy or your data, please reach out to us through the following contact details:</p>
            <h4> • Email Address: barangaysinalhan1123@gmail.com</h4>
            <h4> • Contact Number: +639215516456</h4>
            <p> By using the this site, you acknowledge that you have read, understood, and agreed to this Privacy Policy. We are committed to protecting your personal information and ensuring your privacy. </p>

        
        </div>
        <hr style = "margin-top: 10px;">
        <div class = "pnp-footer">
       
        <button id = "privpop" class="btn-close-pnp" 
                    onclick="openPrivacyModal()">
              CLOSE
              </button>
        </div>
      
</div>

</div>

<script>


        function openPrivacyModal() {
            const overlay = document.getElementById('pnp');
            overlay.classList.toggle('show');
        }

            // Get the close button for privacy policy modal
    document.getElementById('privpop').addEventListener('click', function(event) {
        event.preventDefault();  // Prevent any default action like page reload
        // Hide the privacy policy modal when the button is clicked
        document.getElementById('pnp').style.display = 'none';  
    })
    
    document.getElementById('openpriv').addEventListener('click', function(event) {
        event.preventDefault();  // Prevent any default action like page reload
        // Hide the privacy policy modal when the button is clicked
        document.getElementById('pnp').style.display = 'flex';  
    });
    </script>
