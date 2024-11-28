<style>



.tnc-content {
            overflow-y: auto;
    max-height: calc(100vh - 250px); /* Adjust this value based on header/footer height */
    padding: 20px;
    box-sizing: content-box;
 
    }

.popup-tnc {
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
        .overlay-tnc {
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

        .overlay-tnc.show {
            display: flex;
            opacity: 1;
        }

        .tnc-content h2 {
                font-family: "PBold";
                color: rgba(0, 0, 0, 0.8);
            }

            .tnc-content p, .tnc-content h4 {
               color: black;
               font-size: 0.9rem;
               margin: 10px 0;
               font-family: "PMedium";
               font-weight: normal;
                
            }

            .tnc-head h1 {
    margin: 0; /* Remove default margin */
    font-size: 1.7rem;
    color: #014bae;
    font-family: "PBold";
    text-align: center; /* Center text horizontally */
}

.tnc-head h1{
    padding: 20px;
    color:rgba(0, 0, 0, 0.8);
  
}


.btn-close-tnc {
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

.btn-close-tnc:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.tnc-footer {

    padding: 20px;
    text-align: center;
    
}


</style>


<div id="tnc" 
         class="overlay-tnc">

        <div class="popup-tnc">
          <div class = "tnc-head">
            <h1>Terms & Conditions</h1>
            <hr style = "margin-bottom: 10px;">
          </div>
        <div class = "tnc-content">
            <h2> 1. Acceptance of Terms </h2>
            <p>By using this site, you agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use the System.

</h3>
            <h2> 2. Description of Service</h2>
            <p> This site allows users to request official documents, fill out forms, and generate QR codes for quick processing at the Barangay Hall. You agree to use this site only for lawful purposes and in compliance with all applicable laws and regulations. </p>
        
            <h2> 3. Enhancement and Errors </h2>
            <p> Unless explicitly stated otherwise, any new features that enhance the current functionality of this site shall be subject to these Terms and Conditions. The Barangay does not warrant or represent nor assumes any responsibility for the timeliness, accuracy, reliability, deletion, or misdelivery of information available on or through this site, or for the failure to store any user communications. The Barangay also does not warrant that this site will be error-free, free of viruses, or other harmful components or defects. Additionally, you must provide and are responsible for all equipment necessary to access and use the this site.</p>
            <h2> 4. Your Registration Obligations </h2>
            <p> You agree to: (a) provide true, accurate, current, and complete information about yourself as prompted during user registration and (b) maintain and promptly update your registration information to keep it true, accurate, current, and complete. If any information provided is found to be untrue, inaccurate, or incomplete, or if this site has reasonable grounds to suspect such inaccuracies, the Barangay reserves the right to deny or cancel your request and restrict access to this site’s services. </p>
            <h2> 5. Use of QR Code </h2>
            <p> Upon successfully submitting a document request, the System generates a unique QR code. This QR code is used to retrieve your requested document at the Barangay Hall. It is your responsibility to keep the QR code secure. Sharing this code with unauthorized persons may result in data breaches, for which we are not liable.</p>
            <h2> 6. Changes to this Privacy Policy </h2>
            <p> This Privacy Policy will remain effective except with respect to any changes in its provision in the future, which will take effect immediately after being posted on this site.
            We may occasionally update our Privacy Policy which you should check periodically. Your continued use of our services after we post amendments or revisions to this Privacy Policy will constitute your acknowledgment, acceptance, and adherence to the modifications, and your consent to abide and be bound by the modified Privacy Policy.</p>
            <h2> 7. Contact Us </h2>
            <p> If you have questions or concerns about this Privacy Policy or your data, please reach out to us through the following contact details:</p>
            <h4> • Email Address: barangaysinalhan1123@gmail.com</h4>
            <h4> • Contact Number: +639215516456</h4>
            <p> By using the Document Issuance System, you acknowledge that you have read, understood, and agreed to this Privacy Policy. We are committed to protecting your personal information and ensuring your privacy. </p>

        
        </div>
        <hr style = "margin-top: 10px;">
        <div class = "tnc-footer">
       
        <button id = "termsncondi" class="btn-close-tnc" 
                    onclick="openTnCModal()">
              CLOSE
              </button>
        </div>
      
</div>

</div>

<script>


        function openTnCModal() {
            const overlay = document.getElementById('tnc');
            overlay.classList.toggle('show');
        }

            // Get the close button for privacy policy modal
    document.getElementById('termsncondi').addEventListener('click', function(event) {
        event.preventDefault();  // Prevent any default action like page reload
        // Hide the privacy policy modal when the button is clicked
        document.getElementById('tnc').style.display = 'none';  
    })
    
    document.getElementById('opentnc').addEventListener('click', function(event) {
        event.preventDefault();  // Prevent any default action like page reload
        // Hide the privacy policy modal when the button is clicked
        document.getElementById('tnc').style.display = 'flex';  
    });
    </script>
