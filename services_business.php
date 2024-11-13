<?php 
    require('classes/main.class.php');
    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';
    $userdetails = $bmis->get_userdata();
   
    if (!$bmis->get_userdata()) {
        $bmis->set_userdata();
    }

    if ($userdetails && $userdetails['role'] == 'administrator') {
        echo '<script>window.location.href="./admn_dashboard.php"</script>';
        exit;
    }
?>

<?php
    // Dynamically set the section you want to link to
    $section = "annsec"; // This could be dynamic, e.g., from a database or user input
    $baseUrl = "http://localhost/sinalhan/index.php";
?>

<!DOCTYPE html>

<html>
  <head> 
    <title> Barangay Management System </title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
      <script src="./js-components/component-js-custompurpose.js"></script>
      <!-- responsive tags for screen compatibility -->
    
      <meta name="viewport" content="width=device-width, initial-scale=1"><!-- bootstrap css --> 
      <link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
      <!-- fontawesome icons --> 
      <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    
    <?php 
    include('user-sidebar.php');
?>

<?php 
    include('user-header.php');
?>


        <style>
            /* Back-to-Top */
            .content {margin-left: 270px;}

    

            .top-link {
            transition: all 0.25s ease-in-out;
            bottom: 0;
            right: 0;
            display: inline-flex;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            margin: 0 3em 3em 0;
            border-radius: 50%;
            padding: 0.25em;
            width: 80px;
            height: 80px;
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
            height: 12px;
            }
            .top-link:hover {
            background-color: #3498DB;
            }
            .top-link:hover svg {
            fill: #000000;
            }

            .screen-reader-text {
            position: absolute;
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

            .container1
            {
                background-color: transparent;
                height: 342px;
                color: black;
                font-family: Arial, Helvetica, sans-serif;
                text-align: center;
            }

            /* Back-To-Top Button */
#js-top {
    position: fixed;
     /* Distance from the right */
    background-color: #333; /* Background color */
    color: #fff; /* Text color */
    padding: 2px 6px;
    border-radius: 50%; /* Make it circular */
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 5px;
    z-index: 999; /* Ensure it is on top of other elements */
    transition: background-color 0.3s;
}

/* Change background color on hover */
#js-top:hover {
    background-color: #ff7b00;
}

/* Optional: Hide the element initially if desired */
.hide {
    display: none;
}

#js-top svg {
    width: auto; /* Adjust the size of the arrow */
    height: 20%;
    fill: #fff; /* Arrow color */
}


.dropdown {
    display: flex;
    justify-content: flex-end; /* Aligns to the right */
}


            .applybutton
            {
                width: 100% !important;
                height: 50px !important;
                border-radius: 20px;
                margin-top: 5%;
                margin-bottom: 8%;
                font-size: 25px;
                letter-spacing: 3px;
            }

            .text1{
                margin-top: 80px;
                font-size: 50px;
            }

            .picture{
                height: 120px;
                width: 120px;
            }

        </style>
  </head>

    <body>
        <div class = "content">

        <!-- Back-to-Top and Back Button -->

        <a data-toggle="tooltip" title="Back-To-Top" class="top-link hide" href="" id="js-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6"><path d="M12 6H0l6-6z"/></svg>
            <span class="screen-reader-text">Back to top</span>
        </a>

        <!-- Eto yung navbar -->

        
          
            <div class="dropdown ml-auto">
                
            </div>
       

        <div class="container-fluid container1"> 
            <div class="row"> 
                <div class="col"> 
                    <div class="header">
                        <h1 class="text1">Business Permit (Mayor's Permit) </h1>
                        <h5> Before you can start operating your business in the Philippines, you need to secure 
                        <br> a Mayor’s Permit or Business Permit from the Local Government Unit (LGU) where your 
                        <br> company office is located. </h5>
                    </div>

                    <br>

                    <img class="picture" src="../BarangaySystem/icons/Documents/docu1.png">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img class="picture" src="../BarangaySystem/icons/Documents/docu3.png">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img class="picture" src="../BarangaySystem/icons/Documents/docu2.png">
                </div>
            </div>
        </div>

        <div id="down3"></div>

        <br>
        <br>
        <br>

        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <h1>Procedure</h1>
                    <hr style="background-color: black;">
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col">
                    <i class="fas fa-id-card fa-7x"></i>

                    <br>
                    <br>

                    <h3>Step 1: Prepare</h3>
                    <p>First step is to prepare all of the information that will be needed
                    in acquiring a certificate of residency.</p>
                </div>

                <div class="col">
                    <i class="fas fa-laptop fa-7x"></i>

                    <br>
                    <br>

                    <h3>Step 2: Fill-Up</h3>
                    <p>Second step is to Fill-Up the entire form in our system.</p>
                </div>

                <div class="col">
                    <i class="fas fa-user-check fa-7x"></i>

                    <br>
                    <br>

                    <h3>Step 3: Assessment</h3>
                    <p>Third step is to verify all of the information you've been given
                    in our system that we can use to make the information of your document
                    accurately.</p>
                </div>

                <div class="col">
                    <i class="fas fa-file fa-7x"></i>

                    <br>
                    <br>

                    <h3>Step 4: Release</h3>
                    <p>Fourth step is for releasing of your Business/Mayor's Permit.</p>
                </div>
            </div>

            <div id="down2"></div>

            <br>
            <br>
            <br>

            <div class="row">
                <div class="col">
                    <h1>Other Details</h1>
                    <hr style="background-color: black;">
                </div>
            </div>

            <br> 

            <div class="row text2">
                <div class="col">
                    <div class="card bg-primary card1">
                        <div class="card-header">
                            <h5> Eligibility <br><br> <i class="fas fa-user-check fa-2x"></i>  </h5>
                        </div>
                        <div class="card-body">
                            <ul style="text-align: left; font-size: 16px;">
                                <p class="card-text">
                                    <li> A Philippines Resident. </li>
                                </p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-primary card2">
                        <div class="card-header">
                            <h5> Validity <br><br> <i class="fas fa-clipboard-check fa-2x"></i>  </h5>
                        </div>
                        <div class="card-body">
                            <ul style="text-align: left; font-size: 16px;">
                                <p class="card-text">
                                    <li> Your permit is valid for 1 year. </li>
                                </p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-primary card3">
                        <div class="card-header">
                            <h5> Fees <br><br> <i class="fas fa-coins fa-2x"></i>  </h5>
                        </div>
                        <div class="card-body">
                            <ul style="text-align: justify;">
                                <p class="card-text">
                                    <li> 100% Free </li>
                                </p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-primary card4">
                        <div class="card-header">
                            <h5 style="font-size: 19.4px;"> Processing Time <br><br> <i class="fas fa-clock fa-2x"></i>  </h5>
                        </div>
                        <div class="card-body">
                            <ul style="text-align: justify;">
                                <p class="card-text">
                                    <li> Within Working Hours (8:00am - 5:00pm) </li>
                                </p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-primary card5">
                        <div class="card-header">
                            <h6> What you need <br><br> <i class="fas fa-file fa-2x"></i>  </h6>
                        </div>
                        <div class="card-body">
                            <ul style="text-align: left; font-size: 16px;">
                                <p class="card-text">
                                    <li> DTI Business Name Certificate or SEC Registration Certificate </li>
                                    <li> Latest Community Tax Certificate (Cedula) </li>
                                    <li> Barangay Clearance </li>
                                    <li> Location Clearance </li>
                                    <li> Certificate of Occupancy </li>
                                    <li> Building Permit </li>
                                    <li> Contract of Lease or Land Title Tax Declaration (whichever is applicable) </li>
                                    <li> Picture or Sketch of the Site </li>
                                    <li>Fire Safety or Inspection Permit</li>
                                    <li> Electrical Inspection Certificate </li>
                                    <li>Sanitary Permit</li>
                                    <li> Picture or Sketch of the Site </li>
                                    <li>Public Liability Insurance</li>
                                </p>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="down1"></div>

        <br>
        <br>
        <br>

        <!-- Button trigger modal -->

        <div class="container">

            <h1 class="text-center">Registration</h1>
            <hr style="background-color:black;">

            <div class="col">   
                <button type="button" class="btn btn-primary applybutton" data-toggle="modal" data-target="#exampleModalCenter">
                    Request Form
                </button>
            </div>


            <!-- Modal -->

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Business Permit Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Body -->

                        <div class="modal-body">
                            <form method="post" class="was-validated">

                                <div class="row"> 
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fname">First Name:</label>
                                            <input name="fname" type="text" class="form-control" placeholder="Enter your first name" required>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="mi" class="mtop">Middle Initial </label>
                                            <input name="mi" type="text" class="form-control"  placeholder="Enter your middle initial" required>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="lname">Last Name:</label>
                                            <input name="lname" type="text" class="form-control"  placeholder="Enter your last name" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="bsname">Business Name:</label>
                                            <input name="bsname" type="text" class="form-control" placeholder="Enter Business Name" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <br>

                                <h6>Business Address:</h6>

                                <hr>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> House No: </label>
                                            <input type="text" class="form-control" name="bshouseno"  placeholder="Enter House No." required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Street: </label>
                                            <input type="text" class="form-control" name="bsstreet"  placeholder="Enter Street" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Barangay: </label>
                                            <input type="text" class="form-control" name="bsbrgy"  placeholder="Enter Barangay" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> City </label>
                                            <input type="text" class="form-control" name="bscity"  placeholder="Enter City" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Municipality: </label>
                                            <input type="text" class="form-control" name="bsmunicipality" placeholder="Enter Municipality" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="purpose">Business Industry:</label>
                                            <select class="form-control" name="bsindustry" id="purpose" placeholder="Enter Status" onchange="toggleCustomPurpose()" required>
                                            <option value="">Choose your Business Industry</option>
                                                <option value="Computer">Computer</option>
                                                <option value="Telecommunication">Telecommunication</option>
                                                <option value="Agriculture">Agriculture</option>
                                                <option value="Construction">Construction</option>
                                                <option value="Education">Education</option>
                                                <option value="Pharmaceutical">Pharmaceutical</option>
                                                <option value="Food">Food</option>
                                                <option value="HealthCare">HealthCare</option>
                                                <option value="Hospitality">Hospitality</option>
                                                <option value="Entertainment">Entertainment</option>
                                                <option value="News Media">News Media</option>
                                                <option value="Energy">Energy</option>
                                                <option value="Manufacturing">Manufacturing</option>
                                                <option value="Music">Music</option>
                                                <option value="Mining">Mining</option>
                                                <option value="WorldWide Web">WorldWide Web</option>
                                                <option value="Electronics">Electronics</option>
                                               <option value="Transport">Pharmaceutical</option>
                                                <option value="Transport">Aerospace</option>
                                                <option value="Other">Others (Please Specify)</option>
                                            </select>
                                            <div id="customPurposeContainer" style="display:none; margin-top:10px;">
                                                <input type="text" class="form-control" name="custom_purpose" id="custom_purpose" placeholder="Enter your purpose">
                                            </div>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="aoe" class="mtop">Area of Establishment (SqM): </label>
                                            <input type="number" name="aoe" class="form-control" placeholder="Enter your AOE" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                           
                        </div>
                        <?php $bmis->create_bspermit(); ?>

                        <!-- Modal Footer -->
            
                        <div class="modal-footer">
                            <div class="paa">                                
                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                <button name ="create_bspermit" type="submit" class="btn btn-primary">Submit Request</button>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        </form>

        <br>
        <br>
        <br>

        <!-- Footer -->

        <footer id="footer" class="bg-primary text-white d-flex-column text-center">
            <hr class="mt-0">

            <div class="text-center">
                <h1>Services</h1>
                <ul class="list-unstyled list-inline">

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Documents">
                    <i class="fas fa-file fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Card">
                    <i class="fas fa-id-card fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Friend">
                    <i class="fas fa-user-friends fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Blotter">
                    <i class="fas fa-user-shield fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Contact">
                    <i class="fas fa-phone fa-2x"></i>
                    </a>
                </li>
                </ul>
            </div>

            <hr class="mb-0">

            <!--Footer Links-->

            <div class="container text-left text-md-center">
                <div class="row">

                    <!--First column-->

                    <div class="col-md-3 mx-auto shfooter">
                        <h5 class="my-2 font-weight-bold d-none d-md-block">Documentation</h5>
                        <div class="d-md-none title" data-target="#Documentation" data-toggle="collapse">
                            <div class="mt-3 font-weight-bold">Documentation
                                <div class="float-right navbar-toggler">
                                    <i class="fas fa-angle-down"></i>
                                    <i class="fas fa-angle-up"></i>
                                </div>
                            </div>
                        </div>
                        <ul class="list-unstyled collapse" id="Documentation">
                            <li><a href="services_certofres.php">Certificate of Residency</a></li>
                            <li><a href="services_brgyclearance.php">Barangay Clearance</a></li>
                            <li><a href="services_certofindigency.php">Certificate of Indigency</a></li>
                            <li><a href="services_business.php">Business Permit</a></li>
                            <li><a href="services_brgyid.php">Barangay ID</a></li>
                        </ul>
                    </div>

                    <!--/.First column-->

                    <hr class="clearfix w-100 d-md-none mb-0">

                    <!--Third column-->

                    <div class="col-md-3 mx-auto shfooter">
                        <h5 class="my-2 font-weight-bold d-none d-md-block">Other Services</h5>
                        <div class="d-md-none title" data-target="#OtherServices" data-toggle="collapse">
                            <div class="mt-3 font-weight-bold">Other Services
                                <div class="float-right navbar-toggler">
                                    <i class="fas fa-angle-down"></i>
                                    <i class="fas fa-angle-up"></i>
                                </div>
                            </div>
                        </div>

                        <ul class="list-unstyled collapse" id="OtherServices">
                            <li><a href="services_blotter.php">Peace and Order</a></li>
                        </ul>
                    </div>

                    <!--/.Third column-->

                    <hr class="clearfix w-100 d-md-none mb-0">
 
                    <!--Fourth column-->

                    <div class="col-md-3 mx-auto shfooter" id="down">
                        <h5 class="my-2 font-weight-bold d-none d-md-block">Contact Us:</h5>
                        <div class="d-md-none title" data-target="#Contact-Us" data-toggle="collapse">
                        <div class="mt-3 font-weight-bold">Contact Us:
                            <div class="float-right navbar-toggler">
                            <i class="fas fa-angle-down"></i>
                            <i class="fas fa-angle-up"></i>
                            </div>
                        </div>
                        </div>
                        <ul class="list-unstyled collapse" id="Contact-Us">
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/mikhos.png" alt="Person" width="96" height="96">
                                        Mikhos Dungca | 09514053044
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/pj.png" alt="Person" width="96" height="96">
                                        PJ Mendros | 09179450661
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/vincent.png" alt="Person" width="96" height="96">
                                        Vincent Vilfamat | 09512873394
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/eugene.png" alt="Person" width="96" height="96">
                                        Joel Evangelista | 09301112368
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/kyle.png" alt="Person" width="96" height="96">
                                        Kyle Pilapil | 09618853017
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!--/.Fourth column-->

                </div>
            </div>

            <!--/.Footer Links-->

            <hr class="mb-0">

            <!--Copyright-->

            <div class="py-3 text-center">
                Copyright 2021 -
                <script>
                document.write(new Date().getFullYear())
                </script> 
                BI & ESMS | For Educational Purposes Only
            </div>

        </footer>
        </div>

        <script>
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
