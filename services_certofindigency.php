<?php 
// Include necessary classes and libraries
require('classes/main.class.php');
require 'phpqrcode/qrlib.php';
require 'vendor/autoload.php';

// Fetch user details
$userdetails = $bmis->get_userdata();

// Redirect if user is not authenticated
if (!$userdetails) {
    $bmis->set_userdata();
}

// Check if the user is an administrator and redirect to the admin dashboard
if ($userdetails && $userdetails['role'] == 'administrator') {
    echo '<script>window.location.href="./admn_dashboard.php"</script>';
    exit;
}
else if ($userdetails && $userdetails['role'] == 'staff') {
    echo '<script>window.location.href="./staff_dashboard.php"</script>';
    exit;
}
?>


<!DOCTYPE html>

<html>
  <head> 
    <title> Barangay Sinalhan | Certificate of Indigency </title>
    <link rel="icon" href="./assets/sinlogo.png" type="image/x-icon">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
      
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
      <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
  
      <?php include('loading.php');?> 
      
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

        .overlay-qr {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            opacity: 1;
            z-index: 50;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .overlay-qr.show {
    display: flex; 
    opacity: 1; 
    visibility: visible; 
}
        
        .popup-qr {
            background-color: #fff;
            width: 27%;
            height: 96%;
            position: relative;
            border-top: 25px solid;
            border-bottom: 25px solid;
            border-color: #2c91c9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px 30px;
        }

        .popup-qr img {
            display:block; 
            margin-bottom:20px;
            width: 75%;
        }

        .popup-qr a {
            display: block;
            width: 100%;
        }

        .popup-qr p {
            margin-top: 12px;
            font-size: 0.85rem;
            font-family: "PSemiBold";
            font-style: italic;
            
        }

        .popup-qr .qrid {
            margin-top: 20px;
            font-size: 0.8rem;
            font-family: "PSemiBold";
            font-style: normal;
            padding: 5px 20px;
            text-align: center;
            background-color: #014bae;
            color: white;
            border-radius: 15px 15px 0 0;

        }
        

        .popup-qr h3 {
            font-family: "PBold";
            text-align: center;
            color: #2c91c9;
            line-height: 20px;
            font-size: 1.2rem;
        }
        .tncpnp label {
            font-family: "PRegular";
            font-size: 0.9rem;
        }

        .btn-close-qr, .btn-dl-qr {
            width:100%;
            padding: 10px;
            border: none;
            background-color: #2c91c9;
            border-radius: 20px;
            color: white;
            font-family: "PBold";
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-close-qr:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
        .btn-dl-qr:hover {
            background-color: #014BAE;
        }
        .btn-close-qr {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .btn-dl-qr {
            margin-bottom: 15px;
           
        }
        

        * {
    box-sizing: border-box; /* Ensures padding and border are included in width/height calculations */
}
.col h1 {
    color: white;
    font-family: 'PExBold' !important;
    font-size: 1.8rem;
    text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
    line-height: 42px;
    -webkit-text-stroke: 7px #012049;
    paint-order: stroke fill;
    letter-spacing: 3px;
   
}
.qa-container {
    display: flex;
    gap: 50px;
    flex-wrap: wrap; /* Allows cards to wrap to the next row on smaller screens */
    justify-content: flex-start; /* Align cards from the start */
    padding: 20px;
    line-height: 20px;
}

.qa-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 450px; /* Ensures each card doesn't grow beyond 500px */
    margin-bottom: 10px;
    height: fit-content;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.question {
    display: flex;
    align-items: center;
    background-color: #014BAE;
    padding: 10px 20px;
    color: white;
}

.icon-container {
    background-color: white;
    color: #014BAE;
    font-size: 0.9rem;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

h2 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.answer {
    background-color:#e5fdff;
    padding: 15px 20px;
    flex-grow: 1; /* Ensures the answer section takes the remaining space */
    color: #012049;
    
}

.answer h1 {
    margin: 0;
    font-size: 0.95rem;
    
    font-family: "PSemiBold";
    margin-bottom: 30px; /* Adds space below the heading */
}

.answer h2 {
    margin-left: 20px;
    font-size: 0.85rem;
   
    font-weight: normal;
    font-family:"PRegular";
    margin-bottom: 10px;
   
}




            
                .content {
    display: flex;
    flex-direction: column;
    margin-left: 270px;
    margin-right: 20px;
    max-width: 100%; /* Ensure it doesn't overflow */
    box-sizing: border-box; /* Ensures padding is included in total width */
}

            

            * {
                margin: 0;
            }

            .header {
            display: flex;
            flex-direction: column;
            text-align: center;
            justify-content: center;
            align-items: center;
            
            }

            .header .docuname {
            color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-align: center;
            width: 85%;
            letter-spacing: 3px;
            margin-bottom: 1px;
            margin-top: 150px; /* Remove margin to fully center */
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
            }



            .header h5 {
            font-family: "PMedium";
            font-size: 1rem;
            margin-top: 15px;
            margin-bottom: 150px;
            color: #012049;
            width: 85%;
            line-height: 25px;
             }

            .top-link {
    transition: all 0.25s ease-in-out;
    position: fixed;
    bottom: 0;
    right: 0;
    display: inline-flex;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    margin: 0 1rem 5em 0;
    border-radius: 50%;
    width: 70px;
    height: 70px;
    background-color: #3661D5;
    }
    .top-link.show {
    visibility: visible;
    opacity: 1;
    }
    .top-link.hide {
    visibility: hidden;
    opacity: 0;
    }


   
    .top-link svg {
    fill: white;
    width: 24px;
    height: 14px;
    }
    .top-link:hover {
    background-color: #00357b;
    }
    .top-link:hover svg {
    fill: white;
    }

    .screen-reader-text {
  
    clip-path: inset(50%);
    margin: -1px;
    border: 0;
    padding: 0;
    width: 1px;
    height: 1px;
    overflow: hidden;
    word-wrap: normal !important;
    clip: rect(1px, 1px, 1px, 1px);
    }
    .screen-reader-text:focus {
    display: block;
    top: 5px;
    left: 5px;
    z-index: 100000;
    clip-path: none;
    background-color: #eee;
    padding: 15px 23px 14px;
    width: auto;
    height: auto;
    text-decoration: none;
    line-height: normal;
    color: #444;
    font-size: 1em;
    clip: auto !important;
    }


            .row {
    display: flex;
    flex-direction: column;
            }

            .btn-open-popup {
    padding: 12px 24px;
    font-size: 1.2rem;
    background-color: #014BAE;
    width: 50%; /* This defines the width of the button */
    margin: 50px auto; /* Centers the button horizontally */
    color: #fff;
    border: none;
    font-family: "PBold";
    border-radius: 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: block; /* Ensures the button behaves like a block element */
}

        .btn-open-popup:hover {
            background-color: #2c91c9;
        }

        .overlay-container {
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

      

        .form-control  {
            font-family: "PRegular";
            font-size: 0.8rem;
            border-radius: 5px;
            padding: 5px;
            cursor: pointer;
          
          
            
        }

        .form-control option:hover {
    background-color: #2c91c9; /* Light gray background on hover */
    color: #000; /* Darker text on hover */
}



        .form-control:focus {
    border-color: black; /* Highlight border on focus */
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); /* Subtle shadow on focus */
  
    
}

        .popup-box {
            background-color: #fff;
            width: 100%; /* Fixed width */
            max-width: 500px;
            height: 600px; /* Fixed height */
            position: relative; 
           border: 20px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            margin-left: 30px;
            margin-right: 30px;
            display: flex;
            flex-direction: column;
            border-radius: 10px;

        }

        .reg-ftr {
            padding: 30px;
        }

 
        .form-container {
            display: flex;
            flex-direction: column;
        }

        .form-label {
         
            font-size: 1rem;
            color: #012049;
            font-family: "PMedium";
            text-align: left;
        }

        .form-input {
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
            font-family: "PRegular";
        }

        .btn-submit {
            
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 1px;
            transition: background-color 0.3s ease, color 0.3s ease;
            background-color: #014BAE;
            color: #fff;
            font-family: "PExBold";
            padding: 10px;
            font-size: 1rem;
            margin: 10px 0;
         
      
        }

  

        .btn-submit:hover
         {
            background-color: #2c91c9;
        }

        /* Keyframes for fadeInUp animation */


        /* Animation for popup */
        .overlay-container.show {
            display: flex;
            opacity: 1;
        }

        .form-body::-webkit-scrollbar {
    width: 8px; /* Width of the scrollbar */
}

.form-body::-webkit-scrollbar-thumb {
    background-color: #3661D5; /* Green scrollbar thumb */

}

.form-body::-webkit-scrollbar-track {
    background: #f1f1f1; /* Light background for the track */
    border-radius: 8px;
}

        .form-body {
     
      overflow-y: auto;
      padding: 0 25px;
      max-height: calc(100vh - 220px);
     
        }

        .tncpnp label a {
            color: #014bae;
        }


        .popup-hd {
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    position: relative; /* Allow the button to be positioned absolutely within the container */
    width: 100%; /* Ensure the header takes up the full width */

}

.popup-hd p {
    text-align: center;
    font-size: 0.8rem;
    font-family : "PSemiBold";
    padding: 5px 70px;
    border-radius: 15px;
    color: white;
    font-style: italic;
    background-color: #014BAE;
}

.popup-hd h2 {
    margin: 0; /* Remove default margin */
    font-size: 1.7rem;
    color: #014bae;
    font-family: "PBold";
    text-align: center; /* Center text horizontally */
}



.popup-box h3 {
    font-size: 0.9rem;
    font-family: "PRegular";
    text-align: left;
    margin: 0 30px;
    margin-top: 10px;
    color:black;
    opacity: 0.8;
}

.btn-close-header {
    position: absolute;
    top: 0; /* Adjust the position from the top */
    right: 0; /* Adjust the position from the right */
    background-color: transparent;
    border: none;

    color: #014bae;
    cursor: pointer;

    transition: background-color 0.3s ease;
}

.btn-close-header i {
    font-size: 1.5rem; /* Font Awesome icon size */
}

.btn-close-header:hover {
    color: #2c91c9;
}

.tncpnp input[type="checkbox"] {
    accent-color: #014bae;
}

.tncpnp {
    margin-top: 30px;
}

@media (max-width: 768px) {
    .other-detail {
        margin-left: 20px;
    }
    
}



        </style>
  </head>

    <body>
    
    <?php 
        include('user-sidebar.php');
        include('user-header.php');
       
    ?>
        <!-- Back-to-Top and Back Button -->
<div class = "content">
        <a data-toggle="" title="Back-To-Top" class="top-link hide" href="" id="js-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6"><path d="M12 6H0l6-6z"/></svg>
            
        </a>

        <!-- Eto yung navbar -->

        
        <div class="container-fluid container1"> 
            <div class="row"> 
                <div class="col"> 
                    <div class="header">
                        <h1 class = "docuname"> Certificate of Indigency</h1>
                        
                        <h5> A Certificate of Indigency or a Certificate of Low Income is a document 
                         that are sometimes required by the Philippine government or a private 
                         institution as proof of an individual's financial situation.</h5>
                    </div>

                  
                    
                </div>
            </div>
        </div>

        

       
            <div class="row">
                <div class="col">
                    <hr style = "height: 3px; margin-bottom: 15px; background-color: #012049;">
                    <h1 class="other-detail">Other Details</h1>
    
                    
                </div>
            </div>
            
            <br> 
            <div class="qa-container">
    <div class="qa-card">
        <div class="question">
            <div class="icon-container">
                <span class="fas fa-user-check"></span>
            </div>
            <h2>Eligibility</h2>
        </div>
        <div class="answer">
            <h1>To be eligible for a Certificate of Indigency, applicants must meet the following criteria:</h1>
            <h2>• Applicant must have <b>minimal or no source of income</b>, indicating financial hardship.</h2>
            <h2>• Must be a resident of the barangay for <b>at least 6 months</b> or longer, depending on local barangay requirements.</h2>
            <h2>• Must be <b>at least 18 years old</b> (or a legal guardian should apply on behalf of minors).</h2>
            <h2>• Must be in good standing in the community, with <b>no criminal record or pending legal cases</b>.</h2>

        </div>
    </div>

    <div class="qa-card">
        <div class="question">
            <div class="icon-container">
                <span class="fas fa-calendar-check"></span>
            </div>
            <h2>Validity</h2>
        </div>
        <div class="answer">
            <h1>To determine the validity of a Certificate of Indigency, the following guidelines must be considered:</h1>
            <h2>• The Certificate of Indigency is generally valid for <b>six (6) months </b>from the date of issuance.</h2>
            <h2>• After the validity period, <b>a renewal may be required</b> if the certificate is still needed for any services or benefits.</h2>
            <h2>• The certificate must bear the <b>official dry seal of the issuing authority</b> to be considered valid.</h2>
        </div>
    </div>

    <div class="qa-card">
        <div class="question">
            <div class="icon-container">
                <span class="fas fa-clock"></span>
            </div>
            <h2>Duration and Fees</h2>
        </div>
        <div class="answer">
            <h1>To process a Certificate of Indigency, the following details apply:</h1>
            <h2>• The service is available only from <b>8:00 AM to 5:00 PM</b> on business days.</h2>
            <h2>• The processing time for the Certificate of Indigency is typically <b>a few minutes </b>once the application is submitted.</h2>
            <h2>• Processing time <b>may vary depending on the volume of requests</b>, but it usually takes a few minutes to complete.</h2>
            <h2>• It is recommended to submit applications during <b>service hours</b> for faster processing.</h2>
            <h2>• <b>No processing fees</b> are required for obtaining this document, making it completely free of charge.</h2>
        </div>
    </div>

    <div class="qa-card">
        <div class="question">
            <div class="icon-container">
                <span class="fas fa-file-alt"></span>
            </div>
            <h2>What You Need</h2>
        </div>
        <div class="answer">
            <h1>To obtain a Certificate of Indigency, you need to bring the following documents together with your QR code:</h1>
            <h2>• Barangay Clearance or Certificate of Residency</h2>
            <h2>• Valid Identification (ID)</h2>
            <h2>• Proof of Income or Affidavit of No Income</h2>
            <h2>• Authorization Letter <i>(if applicable)</i></h2>
        </div>
    </div>
</div>


          


                <button class="btn-open-popup" onclick="togglePopup()">
      Request Form
      </button>

    
     

    <div id="popupOverlay" 
         class="overlay-container">
         
        <div class="popup-box">
        <div class = "popup-hd">
            <h2>Request Form</h2>
            <p> for Certificate of Indigency </p>
            
            <h3>Fill in all required fields and double-check your information before submitting to ensure accuracy.</h3>
            
            
            <button class="btn-close-header" onclick="togglePopup()">
            <i class="fas fa-times"></i> <!-- Font Awesome "X" icon -->
           
        </button>
     
        </div>
        <hr style = "margin: 25px;">
        <div class="form-body">
            <form method="post" class="form-container">

<div class="row"> 

    <div class="col">
        <div class="form-group">
            <label class= "form-label" for="fname">First Name:</label>
            <input class= "form-input" name="fname" type="text" class="form-control" 
            placeholder="Enter First Name"  
            data-tr-rules="required|excludes:-,@,!,#,$,%,^,&,*,(,)|between:2,50|only:string"
            id="fname"
            required>
            <div class="invalid-feedback" data-tr-feedback="fname"></div>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="mi" class= "form-label">Middle Name: </label> <br>
            <label for="mi_na" class="form-label">I have no middle name: </label>
            <input type="checkbox" id="mi_na" onclick="toggleNA('mi')">
            
            <input name="mi" type="text" class= "form-input" 
            placeholder="Enter Middle Name"
            data-tr-rules="required|excludes:-,@,!,#,$,%,^,&,*,(,)|between:2,25|only:string"
            id="mi">
            <div id="mi-feedback" class="invalid-feedback" data-tr-feedback="mi"></div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label class= "form-label" for="lname">Last Name:</label>
            <input 
            id="lname"
            class = "form-input" 
            name="lname" 
            type="text" 
            class="form-control" 
            placeholder="Enter Last Name"  
            data-tr-rules="required|excludes:-,@,!,#,$,%,^,&,*,(,)|between:2,25|only:string"
            required
            >
            <div  class="invalid-feedback" data-tr-feedback="lname"></div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="form-label" for="suffix">Suffix:</label>
            <select class="form-control" name="suffix" id="suffix" required>
                <option value="">Select Suffix</option>
                <option value="N/A">Not Applicable</option>
                <option value="Jr.">Jr.</option>
                <option value="Sr.">Sr.</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="IV">IV</option>
                <option value="V">V</option>
            </select>
        </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="age" class= "form-label">Age: </label>
                <input type="number" name="age" class= "form-input" 
                placeholder="Enter your Age"  
                data-tr-rules="required|number|between:10, 125"
                required>
                <div class="invalid-feedback" data-tr-feedback="age"></div>
            </div>
        </div>

    <div class="col">
        <div class="form-group">
            <label  class = "form-label">Nationality: </label>
            <input id="nationality" type="text" class="form-input" name="nationality"   
            placeholder="Enter Nationality" 
            data-tr-rules="required|excludes:-,@,!,#,$,%,^,&,*,(,)|maxlength:20|only:string"
            required>
            <div class="invalid-feedback" data-tr-feedback="nationality"></div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label class= "form-label"> House No: </label>
            <input id="houseno" type="text" class= "form-input" name="houseno"  
            placeholder="Enter House No."  
            data-tr-rules="required|excludes:-,@,!,#,$,%,^,&,*,(,)|maxlength:50"
            required>
            <div class="invalid-feedback" data-tr-feedback="houseno"></div>
        </div>
    </div>

    <div class="col">
            <div class="form-group">
                <label class= "form-label"> Street/Purok (Include Village If Applicable)): </label>
                <input id="street" type="text" class= "form-input" name="street"  
                placeholder="Enter Street"  
                data-tr-rules="required|excludes:-,@,!,#,$,%,^,&,*,(,)|maxlength:50"
                required>
                <div class="invalid-feedback" data-tr-feedback="street"></div>

            </div>
        </div>

    <div class="col">
        <div class="form-group">
            <label  class = "form-label"> Barangay: </label>
            <input type="text" class="form-input" name="brgy"  
            placeholder="Enter Barangay" value="Sinalhan" readonly>

        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label  class = "form-label"> City: </label>
            <input type="text" class="form-input" name="city"  
            placeholder="Enter City" value="City of Santa Rosa" readonly>
</div>
</div>

            <div class="col">
                                        <div class="form-group">
                                            <label class = "form-label"> Province: </label>
                                            <input type="text" class="form-input" name="municipality" 
                                            placeholder="Enter province" value="Laguna" readonly>
                                           
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label class = "form-label" for="purpose">Purpose:</label>
                                            <select class="form-control" name="purpose" id="purpose" onchange="toggleCustomPurpose()" required>
                                                <option value="">Choose your Purpose</option>
                                                <option value="Job/Employment">Job/Employment</option>
                                                <option value="Business Establishment">Business Requirement</option>
                                                <option value="Financial Transaction">Financial Transaction</option>
                                                <option value="Scholarship">Scholarship</option>
                                                <option value="Other">Other (Please Specify)</option>
                                            </select>
                                            <div id="customPurposeContainer" style="display:none; margin-top:10px;">
                                                <input type="text" class="form-input" name="custom_purpose" id="custom_purpose" placeholder="Enter your purpose">
                                            </div>
                                           
                                        </div>
                                    </div>  
                                </div>

                   
                        <input type="hidden" name="created_by" value="<?= $userdetails['id'] ?>">

<div class="tncpnp">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">
            I accept the 
            <a id = opentnc href="javascript:void(0);" onclick="openTnCModal()"><b>Terms and Conditions</b></a> 
            and 
            <a id = openpriv href="javascript:void(0);" onclick="openPrivacyModal()"><b>Privacy Policy</b></a>.
        </label>
    </div>

    <button class="btn-submit" 
                        type="submit" name="create_certofindigency">
                  SUBMIT
                  </button>
                  <?php include('user_priv_and_pop.php'); 
                  include ('user_tnc.php' );?>
             
</div>
</div>
        </div>


</form>





</div>

  
        </div>

<?php $bmis->create_certofindigency(); ?>
    


     
        <!-- Footer -->

        <?php include('user-footer.php');
        
        require('./validation_script.php');
        ?>

        
        <script src="./js-components/component-js-custompurpose.js"></script>
        <script>

        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('sidebar-hide');
        });

        document.getElementById('sidebar-toggle-2').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('sidebar-hide');
        });





            // Set a variable for our button element.
            const scrollToTopButton = document.getElementById('js-top');

            // Let's set up a function that shows our scroll-to-top button if we scroll beyond the height of the initial window.
            const scrollFunc = () => {
            // Get the current scroll value
            let y = window.scrollY;
            
            // If the scroll value is greater than the window height, let's add a class to the scroll-to-top button to show it!
            if (y > 0) {
                scrollToTopButton.className = "top-link show";
            } else {
                scrollToTopButton.className = "top-link hide";
            }
            };

            window.addEventListener("scroll", scrollFunc);

            const scrollToTop = () => {
            // Let's set a variable for the number of pixels we are from the top of the document.
            const c = document.documentElement.scrollTop || document.body.scrollTop;
            
            // If that number is greater than 0, we'll scroll back to 0, or the top of the document.
            // We'll also animate that scroll with requestAnimationFrame:
            // https://developer.mozilla.org/en-US/docs/Web/API/window/requestAnimationFrame
            if (c > 0) {
                window.requestAnimationFrame(scrollToTop);
                // ScrollTo takes an x and a y coordinate.
                // Increase the '10' value to get a smoother/slower scroll!
                window.scrollTo(0, c - c / 10);
            }
            };

            // When the button is clicked, run our ScrolltoTop function above!
            scrollToTopButton.onclick = function(e) {
            e.preventDefault();
            scrollToTop();
            }

          

        </script>
            
        <script>
            $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
            });

            
        </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      // After the page content is fully loaded, make the body visible
      document.body.style.visibility = "visible";
    });
    
    // Initially hide the body until the content is fully loaded
    document.body.style.visibility = "hidden";
  </script>
        <script>
    // Function to close the modal
    function closeModal() {
        document.querySelector('.overlay-qr').style.display = 'none';
    }
</script>
<script>
    // Prevent page reload when the page is loaded or refreshed
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // Get the close button for privacy policy modal

</script>

    <script>
        function togglePopup() {
            const overlay = document.getElementById('popupOverlay');
            overlay.classList.toggle('show');
        }
    </script>

    <script>
       window.addEventListener("load", function() {
           document.getElementById("qr").style.display = "flex";
       });

         function closeModal() {
        document.querySelector(".overlay-qr").style.display = "none";
    }
   </script>

<script>
       // Wait for the DOM to be fully loaded before showing the pop-up
       window.addEventListener('load', function() {
           // Show the pop-up by setting display to 'flex'
           document.getElementById('qr').style.display = 'flex';
       });
   </script>

        <script>
            $(document).ready(function(){
            // Add smooth scrolling to all links
            $("a").on('click', function(event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
                } // End if
            });
            });
        </script>

        <script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

    </body>
</html>
