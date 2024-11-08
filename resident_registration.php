<?php 
     require('classes/resident.class.php');
    $residentbmis->create_resident();
     //$data = $bms->get_userdata();

     
?>

<!DOCTYPE html> 
<html> 
    <head> 
        <title> Barangay Management System </title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
        <!-- responsive tags for screen compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- bootstrap css --> 
        <link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
        <!-- fontawesome icons -->
        <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    </head>

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




    body {
    margin: 0; 
  
    height: 100vh; 
    overflow: hidden; 
    background-color: #5ADAE6;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='260' height='260' viewBox='0 0 200 200'%3E%3Cg %3E%3Cpolygon fill='%2300669a' points='100 57.1 64 93.1 71.5 100.6 100 72.1'/%3E%3Cpolygon fill='%23007bb1' points='100 57.1 100 72.1 128.6 100.6 136.1 93.1'/%3E%3Cpolygon fill='%2300669a' points='100 163.2 100 178.2 170.7 107.5 170.8 92.4'/%3E%3Cpolygon fill='%23007bb1' points='100 163.2 29.2 92.5 29.2 107.5 100 178.2'/%3E%3Cpath fill='%232C91C9' d='M100 21.8L29.2 92.5l70.7 70.7l70.7-70.7L100 21.8z M100 127.9L64.6 92.5L100 57.1l35.4 35.4L100 127.9z'/%3E%3Cpolygon fill='%23003492' points='0 157.1 0 172.1 28.6 200.6 36.1 193.1'/%3E%3Cpolygon fill='%230040a0' points='70.7 200 70.8 192.4 63.2 200'/%3E%3Cpolygon fill='%23014BAE' points='27.8 200 63.2 200 70.7 192.5 0 121.8 0 157.2 35.3 192.5'/%3E%3Cpolygon fill='%230040a0' points='200 157.1 164 193.1 171.5 200.6 200 172.1'/%3E%3Cpolygon fill='%23003492' points='136.7 200 129.2 192.5 129.2 200'/%3E%3Cpolygon fill='%23014BAE' points='172.1 200 164.6 192.5 200 157.1 200 157.2 200 121.8 200 121.8 129.2 192.5 136.7 200'/%3E%3Cpolygon fill='%23003492' points='129.2 0 129.2 7.5 200 78.2 200 63.2 136.7 0'/%3E%3Cpolygon fill='%23014BAE' points='200 27.8 200 27.9 172.1 0 136.7 0 200 63.2 200 63.2'/%3E%3Cpolygon fill='%230040a0' points='63.2 0 0 63.2 0 78.2 70.7 7.5 70.7 0'/%3E%3Cpolygon fill='%23014BAE' points='0 63.2 63.2 0 27.8 0 0 27.8'/%3E%3C/g%3E%3C/svg%3E");
}




.field-icon {
    margin-left: 74%;
    margin-top: -8%;
    position: absolute;
    z-index: 2;
}

.form-control {
    margin-top: 1px;
    width: 100%;   
    padding: 10px;               
    border: none;                
    border-bottom: 2px solid black; 
    border-radius: 0;           
    font-size: 1rem !important;         
    line-height: 1.5;            
    box-sizing: border-box;     
    margin-bottom: 20px;         
    transition: border-color 0.3s, border-radius 0.3s; 
    background-color: white;     
    font-family: 'OSMedium', sans-serif;   
   
}

.form-box {
    padding: 50px;              
    background-color: white;  
    width: 45%;                
    height: 100vh;               
    position: fixed;             
    top: 0;                      
    right: 0;   
    bottom: 0;             
    overflow-y: auto;           
    box-sizing: border-box;
    box-shadow: -10px 0 10px rgba(0, 0, 0, 0.4); 
}

.logo-container {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 0px;
            z-index: 10;
        }
        
        .logo-container img {
            width: 12%; /* Adjust size as needed */
            height: auto;
        }

.form-control:focus {
    border: 2px solid black;
    outline: none;
    border-radius: 5px;
    background-color: white;
    color: #535353;

}

.form-control::placeholder {
    font-size: 0.9rem;
    letter-spacing: 0.5px;
  
}

.form-group {
    margin-bottom: 20px; 
    min-height: 40px;    
}

.form-group label {
    font-family: 'OSBold', sans-serif;
    font-size: 1rem;
    display: block; 
    line-height: 1.5; 
}

.small-input {
    width: 110px;
}

.row {
    display: flex;          
    flex-wrap: wrap;      
    align-items: flex-start; 
}

.tgl {
            width: 25px; height: auto; margin-top: 25px;
        }

.was-validated h1 {
    font-family: 'OSBlack';
            color: rgb(1, 75, 174);
            text-align:center;
            background-color: white;
            margin-bottom: 15px;
            font-size: 2rem;
}

.was-validated p {
    text-align: center;
    font-family: 'OSMedium';
    margin-bottom: 20px;
    line-height: 25px;
    
}



.btn-back {
    width: 130px; 
    color: RGB(44, 145, 201); 
    text-align: center; 
    display: block; 
    text-decoration: none; 
    padding: 10px; 
    border-radius: 5px; 
    transition: background-color 0.3s; 
    font-family: 'OSBlack';
    letter-spacing: 1px;
    font-size: 16px;
    margin: 0 auto; 
}

.copyright {
            position: fixed;
            bottom: 10px;
            left: 10px;
            font-family: 'OSBold', sans-serif;
            color: white;
            font-size: 0.85rem;
            opacity: 0.8;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }


.btn-back:hover {
    text-decoration: underline;
    color: rgb(1, 75, 174);
}

.submit:hover {
    background-color: rgb(1, 75, 174);
}


.col {
    flex: 1; 
    min-width: 40%;
    margin-right: 30px; 
}

.submit {
            color: white;
            padding: 15px 15px;
            border: none;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-family: 'OSBlack';
            letter-spacing: 1px;
            margin-top: 10px;
            background-color: RGB(44, 145, 201);

}


@media (max-width: 920px) {
    .copyright {
        width: 50%;
    }
.form-box {
    padding-left: 30px;
    padding-right: 30px;
}


}
@media (max-width: 600px) {
    .form-box {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin: 25px auto; /* This applies 20px margin on top and bottom, and auto margin on left and right */
        width: calc(100% - 40px); /* Ensure form width respects margin */
        position: relative;
        display: flex; /* Ensure it uses flexbox for alignment */
        flex-direction: column; /* Stack children vertically */
        justify-content: flex-start; /* Align items at the start */
        padding: 30px;
        height: auto; /* Allow height to adjust based on content */
        overflow-y: auto; /* Enable scrolling if content overflows */
        font-size: smaller; /* Reduce font size for smaller screens */
    }



    body {
        overflow-y: auto;
    }

    .tgl {
    width: 20px;
    }

    .was-validated h1 {
        font-size: 1.7rem;
    }

    .logo-container
    {
        display: none;
    }

    .submit {
        font-size: 0.9rem;
    }

    .btn-back {
        font-size: 0.9rem;
    }

    .form-control::placeholder {
        font-size: 0.8rem;
    }

    .copyright {
        display: none;
    }

    .form-control {
        font-size: 0.9rem;
    }
    
    .form-group label {
        font-size: 0.9rem;
    }





    .row {
        flex-direction: column; 
    }

    .col {
        margin-right: 0; 
        width: 100%; 
    }

}




    </style>
    
    <body >

    <!-- eto yung navbar -->
  
    
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12">
             
            </div>
        </div>

        <div class="row margin mtop"> 
            <div class="col-sm"> </div>

            <div class="col-sm-8">   
                <div class="card mbottom">
                    <div class="card-body" >

                        <!-- Form box wrapper -->

                        <div class="form-box">
                        <div class="logo-container">
    <img src="assets/sinlogo.png" alt="Logo 1">
    <img src="assets/sntrlogo.png" alt="Logo 2">
</div>
                            <form method="post" enctype='multipart/form-data' class="was-validated">
                        <h1>Create Account</h1>
                        <p>To create your account and start your journey with us, please fill in your details below accurately and securely:</p>
                            <div class="row">
    <div class="col"> <!-- Use col-6 to take half the row -->
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" name="lname" placeholder="Enter Last Name" required>

        </div>
    </div>
    
    <div class="col"> <!-- Use col-6 to take the other half of the row -->
        <div class="form-group">
            <label>First Name</label>
            <input type="text" class="form-control" name="fname" placeholder="Enter First Name" required>

        </div>
    </div>

                                    <div class="col"> 
                                        <div class="form-group">
                                            <label class="mtop"> Middle Name </label>
                                            <input type="text" class="form-control" name="mi" placeholder="Enter Middle Name" required>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Contact Number</label>
                                            <input type="tel" class="form-control" name="contact" maxlength="11" pattern="[0-9]{11}" placeholder="Enter Contact Number" required>
                                            
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col">
                                    
                                        <div class="form-group" style = "position: relative">
                                        <label>Password</label>
                <input type="password" class="form-control" id="password-field" name="password" placeholder="Enter Password" required>
                <button type="button" onclick="myFunction()" style="position: absolute; right: 10px; top: 10px; background: none; border: none; cursor: pointer;">
                    <img id="toggleIcon" src="assets/show.png" alt="Show password" class="tgl">
                </button>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> House No </label>
                                            <input type="text" class="form-control" name="houseno" placeholder="Enter House No." required>
                                 
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Street: </label>
                                            <input type="text" class="form-control" name="street" placeholder="Enter Street" required>
                                         
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Barangay </label>
                                            <input type="text" class="form-control" name="brgy" placeholder="Enter Barangay" required>
                                       
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> City </label>
                                            <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                                          
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> Municipality </label>
                                            <input type="text" class="form-control" name="municipal" placeholder="Enter Municipality" required>
                                         
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Birth Date </label>
                                            <input type="date" class="form-control" name="bdate" required>
                               
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Birth Place </label>
                                            <input type="text" class="form-control" name="bplace" placeholder="Enter Birth Place" required>
                                    
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Nationality </label>
                                            <input type="text" class="form-control" name="nationality" placeholder="Enter Nationality" required>
         
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col"> 
                                        <div class="form-group">
                                            <label>Status </label>
                                            <select class="form-control small-input" name="status" id="status" required>
                                                <option value="">...</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Divorced">Divorced</option>
                                            </select>
                                        
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Age</label>
                                            <input type="number" class="form-control small-input" name="age" placeholder="Enter Age" required>
                              
                                        </div>
                                    </div>
</div>
                                    <div class = "row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Sex</label>
                                            <select class="form-control small-input" name="sex" id="sex" required>
                                                <option value="">...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                              
                                        </div>
                                    </div>      
                                  
                                

                           
                                   
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Are you a registered voter?</label>
                                            <select class="form-control small-input" name="voter" id="regvote" required>
                                                <option value="">...</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
</div>
                                

                                <!-- Input field for Precinct Number -->
                                <div class="row" id="precinctContainer" style="display: none;">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="precinct-number">Precinct No.</label>
                                            <input type="text" class="form-control" name="precinct-number" id="precinct-number" placeholder="Enter your precinct number">
                                        </div>
                                    </div>
                                </div>

                           
                                    <!-- <div class="col"> 
                                        <div class="form-group">
                                            <label>Are you head of the family? </label>
                                            <select class="form-control" name="family_role" id="famhead" required>
                                                <option value="">...</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div> -->

                                

                                <br>
                                    
                                <input type="hidden" class="form-control" name="role" value="resident">
                                
                                <button class="submit" class="btn btn-primary" type="submit" name="add_resident"> Submit </button>
                                <a  class="btn-back" href="index.php"> Back to Login</a>
                            </form>
                        </div>
                    </div> 
                </div>
                <div class="col-sm"> </div>
            </div>
        </div>

        <!-- Footer -->

        <div class="copyright">
    &copy; <?php echo date("Y"); ?> Barangay Management System. All Rights Reserved.
</div>

        <script>
        function myFunction() {
            const passwordField = document.getElementById("password-field");
            const toggleIcon = document.getElementById("toggleIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.src = "assets/eye.png"; // Change to the hide icon
            } else {
                passwordField.type = "password";
                toggleIcon.src = "assets/show.png"; // Change back to the show icon
            }
        }

        // Event listener for registered voter dropdown
        document.getElementById('regvote').addEventListener('change', function () {
                const precinctContainer = document.getElementById('precinctContainer');
                // Show the precinct number input field if "Yes" is selected, hide if "No"
                if (this.value === 'Yes') {
                    precinctContainer.style.display = 'block'; // Show input
                } else {
                    precinctContainer.style.display = 'none'; // Hide input
                }
            });
    </script>

        <script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>
    </body>
</html>

