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

<!DOCTYPE html>

<html>
  <head> 
    <title> Barangay Management System </title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
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
            @font-face {
            font-family: 'OSMedium'; 
            src: url('fonts/OpenSauceSans-Medium.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSBold'; 
            src: url('fonts/OpenSauceSans-Bold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSBlack'; 
            src: url('fonts/OpenSauceSans-Black.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSExBold'; 
            src: url('fonts/OpenSauceSans-ExtraBold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSBlackIt'; 
            src: url('fonts/OpenSauceSans-BlackItalic.ttf') format('truetype'); 
        }
            /* Back-to-Top */
    .content {
    display: flex;
    flex-direction: column;
    margin-left: 270px;
    margin-right: 20px;
    max-width: 100%; /* Ensure it doesn't overflow */
    box-sizing: border-box; /* Ensures padding is included in total width */
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
    width: 40%;
    height: 40%;
    }

    .top-link:hover {
    background-color: #00357b;
    }
    .top-link:hover svg {
    fill: white;
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

    .header h1 {
    color: white;
    font-family: 'OSBlack' !important;
    font-size: 2.2rem;
    width: 85%;
    letter-spacing: 3px;
    margin-bottom: 1px;
    margin-top: 115px; /* Remove margin to fully center */
    text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
    line-height: 42px;
    -webkit-text-stroke: 7px #012049;
    paint-order: stroke fill;
}

.header h5 {
    font-family: "OSMedium";
        font-size: 1rem;
        margin-top: 15px;
        color: #012049;
        width: 85%;
        line-height: 25px;
}

.header {
    display: flex;
    flex-direction: column;
    text-align: center;
    justify-content: center;
    align-items: center;
}





            .applybutton
            {
                width: 100% !important;
                height: 50px !important;
                border-radius: 20px;
                margin-top: 5%;
                margin-bottom: 8%;
                font-size: 25px;
                letter-spacing: 2px;
            }



            * {
    margin:0;
}



        </style>
  </head>

    <body>

        <!-- Back-to-Top and Back Button -->

        <a data-toggle="tooltip"  class="top-link hide" href="" id="js-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6"><path d="M12 6H0l6-6z"/></svg>
            <span class="screen-reader-text">Back to top</span>
        </a>
        <!-- Eto yung navbar -->

        <div class = "content">

        <div class="container-fluid container1"> 
            <div class="row"> 
                <div class="col"> 
                    <div class="header">
                        <h1 class="text1">Barangay Clearance </h1>
                        <h5> A Barangay Clearance is a document issued by the Barangay Secretary and signed by the 
                         Barangay Captain stating that you are a living at that specific place and you are 
                         of good moral character. Somehow, a smaller version of NBI or Police clearance.</h5>
                    </div>

                    <br>

                    
                </div>
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
                                    <li> Recent Cedula. </li>
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
                                    <li> Valid for Six (6) Months. Not valid without Barangay dry seal </li>
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
                            <h6> Reason to get a Barangay Clearance<br><br> <i class="fas fa-file fa-2x"></i>  </h6>
                        </div>
                        <div class="card-body">
                            <ul style="text-align: left; font-size: 16px;">
                                <p class="card-text">
                                    <li> Job Requirement  </li>
                                    <li> Open a Bank Account </li>
                                    <li> NBI Clearance </li>
                                    <li> Police Clearance </li>
                                    <li> Postal ID </li>
                                    <li> UMID Card</li>
                                    <li> Driver's License </li>
                                    <li> Business Requirement </li>
                                    <li> Indigent Certification of Philhealth</li>
                                </p>
                            </ul>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Barangay CLearance Form</h5>
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
                                            <input name="fname" type="text" class="form-control" 
                                            placeholder="Enter First Name" required>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="mi" class="mtop">Middle Initial </label>
                                            <input name="mi" type="text" class="form-control" 
                                            placeholder="Enter Middle Initial" required>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="lname">Last Name:</label>
                                            <input name="lname" type="text" class="form-control" 
                                            placeholder="Enter Last Name" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Age" class="mtop">Age: </label>
                                            <input type="number" name="age" max="90" min="1" step="1" class="form-control" 
                                            placeholder="Enter your Age" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label> House No: </label>
                                            <input type="text" class="form-control" name="houseno"  
                                            placeholder="Enter House No." required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> Street: </label>
                                            <input type="text" class="form-control" name="street"  
                                            placeholder="Enter Street" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Barangay: </label>
                                            <input type="text" class="form-control" name="brgy"  
                                            placeholder="Enter Barangay" value="Sinalhan" readonly>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> City: </label>
                                            <input type="text" class="form-control" name="city" 
                                            placeholder="Enter city" value="City of Santa Rosa" readonly>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Municipality: </label>
                                            <input type="text" class="form-control" name="municipality" 
                                            placeholder="Enter Municipality" value="Laguna" readonly>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="purposes">Purposes:</label>
                                            <select class="form-control" name="purpose" id="purpose" placeholder="Enter Status" onchange="toggleCustomPurpose()" required>
                                                <option value="">Choose your Purpose</option>
                                                <option value="Job Requirement">Job Requirement</option>
                                                <option value="Open a Bank Account">Open a Bank Account</option>
                                                <option value="NBI Clearance">NBI Clearance</option>
                                                <option value="Police Clearance">Police Clearance</option>
                                                <option value="Postal ID">Postal ID</option>
                                                <option value="UMID Card">UMID Card</option>
                                                <option value="Driver's License">Driver's License</option>
                                                <option value="Business Requirement">Business Requirement</option>
                                                <option value="Philhealth">Philhealth</option>
                                                <option value="Other">Other (Please specify)</option>
                                            </select>
                                            <div id="customPurposeContainer" style="display:none; margin-top:10px;">
                                                <input type="text" class="form-control" name="custom_purpose" id="custom_purpose" placeholder="Enter your purpose">
                                            </div>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>  
                                </div>
                        </div>
                        <?php $bmis->create_brgyclearance(); ?>

                        <!-- Modal Footer -->
            
                        <div class="modal-footer">
                            <div class="paa">
                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                <button name ="create_brgyclearance" type="submit" class="btn btn-primary">Submit Request</button>
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
        </div>
        <!-- Footer -->
        <?php include('user-footer.php'); ?>
        
        <script src="./js-components/component-js-custompurpose.js"></script>
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
