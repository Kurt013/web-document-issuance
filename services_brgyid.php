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
      <!-- fontawesome icons --> 
      <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>

<?php 
    include('user-sidebar.php');
?>

<?php 
    include('user-header.php');
?>

        <style>
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

            .header {
            display: flex;
            flex-direction: column;
            text-align: center;
            justify-content: center;
            align-items: center;
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

            * {
                margin:0;
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



            .idpicture{
                border: 1px solid black;
            }





        </style>
  </head>

    <body>
        <div class = "content">
        <!-- Back-to-Top and Back Button -->

        <a data-toggle="tooltip"  class="top-link hide" href="" id="js-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6"><path d="M12 6H0l6-6z"/></svg>
            <span class="screen-reader-text">Back to top</span>
        </a>

        <!-- Eto yung navbar -->

        

        <div class="container-fluid container1"> 
            <div class="row"> 
                <div class="col"> 
                    <div class="header">
                        <h1 class="text1">Barangay ID </h1>
                        <h5> A Barangay ID is a proof for your personal information that can
                         be issued by the Barangay Staff.</h5>
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
                                    <li> Valid for Three (3) - Six (6) Months. </li>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Barangay ID Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Body -->

                        <div class="modal-body">
                            <form method="post" class="was-validated" enctype="multipart/form-data"> 

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
                                            <label for="mi" class="mtop">Middle Initial: </label>
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
                                            placeholder="Enter Last Name"  required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="date"class="mtop">Birthdate: </label>
                                            <input name="bdate" id="date" type="date" class="form-control" 
                                             required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="precint_no">Precint No: </label>
                                            <input name="precint_no" id="precint_no" class="form-control" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> House No: </label>
                                            <input type="text" class="form-control" name="houseno"  
                                            placeholder="Enter House No." required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

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
                                            placeholder="Enter Barangay" value="Sinalhan" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> City: </label>
                                            <input type="text" class="form-control" name="city"  
                                            placeholder="Enter City" value="City of Santa Rosa" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Municipality: </label>
                                            <input type="text" class="form-control" name="municipality" 
                                            placeholder="Enter Municipality" value="Laguna" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="status"> Civil Status: </label>
                                            <select class="form-control" name="status" id="status" onchange="toggleCustomPurpose()" required>
                                                <option value="">Choose your status</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 style="font-size: 18px;">Guidelines for ID Picture:</h6>

                                <br>

                                    <h6>Appearances & Quality:</h6>
                                    <p>
                                        <ul style="font-size: 13.5px;">
                                            <li>
                                                Facing forwards and looking straight at the Camera.
                                            </li>
                                            <li>
                                                Have your eyes open and visible.
                                            </li>
                                            <li>
                                                Not have a head covering (unless it's for religious or medical reasons).
                                            </li>
                                            <li>
                                                Contain no other objects or people.
                                            </li>
                                            <li>
                                                White background only.
                                            </li>
                                            <li>
                                                Wear Collar Shirt.
                                            </li>
                                            <li>
                                                1x1 Photo Size.
                                            </li>
                                            <li>
                                                At least 50KB and no more than 10MB.
                                            </li>
                                            <li>
                                                File Format: JPEG or PNG
                                            </li>
                                            <li>
                                                Clear and in focus.
                                            </li>
                                            <li>
                                                Good Quality Photo
                                            </li>
                                        </ul>
                                    </p>
                                
                                <div class="row">

                                    <div class="col">
                                        <label>Barangay ID Photo:</label>
                                        <div class="custom-file mb-3 form-group">
                                            <input type="file" onchange="readURL(this);" class="custom-file-input" id="customFile" name="res_photo" required>
                                            <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label>Photo Display:</label>
                                        <br>
                                        <img id="photoDisplay" src="http://placehold.it/200x200" alt="your image" style="width: 192px; height: 192px;" />
                                    </div>

                                </div>

                                <hr>

                                <br>

                                <h6>In case of emergency :</h6>

                                <hr>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="inc_fname">First Name:</label>
                                            <input id="inc_fname" name="inc_fname" type="text" class="form-control" placeholder="Enter First Name" required>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="inc_mi" class="mtop">Middle Name </label>
                                            <input id="inc_mi" name="inc_mi" type="text" class="form-control" placeholder="Enter Middle Name" required>
                                                <div class="valid-feedback">Valid.</div>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="inc_lname">Last Name:</label>
                                            <input name="inc_lname" id="inc_lname" type="text" class="form-control" placeholder="Enter Last Name" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">            
                                            <label for="cno">Contact Number:</label>
                                            <input id="cno" name="inc_contact" type="text" maxlength="11" class="form-control" pattern="[0-9]{11}" placeholder="Enter Contact Number" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> House No: </label>
                                            <input type="text" class="form-control" name="inc_houseno"  placeholder="Enter House No." required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Street: </label>
                                            <input type="text" class="form-control" name="inc_street"  placeholder="Enter Street" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Barangay: </label>
                                            <input type="text" class="form-control" name="inc_brgy"  placeholder="Enter Barangay" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> City: </label>
                                            <input type="text" class="form-control" name="inc_city"  placeholder="Enter Barangay" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Municipality: </label>
                                            <input type="text" class="form-control" name="inc_municipality" placeholder="Enter Municipality" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php $bmis->create_brgyid(); ?>
                        <!-- Modal Footer -->
            
                        <div class="modal-footer">
                            <div class="paa">
                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                <button name ="create_brgyid" type="submit" class="btn btn-primary">Submit Request</button>
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
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
            
                    reader.onload = function (e) {
                        const img = document.getElementById('photoDisplay');
                        img.src = e.target.result;
                    };
            
                    reader.readAsDataURL(input.files[0]);
                }
            }



            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>

    
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

        <script src="./js-components/component-js-capturecamera.js"></script>
        <script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

    </body>
</html>
