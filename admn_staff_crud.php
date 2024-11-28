<?php
    include('dashboard_sidebar_start.php');

    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_staff();
    $staffbmis->create_staff();
    $upstaff = $staffbmis->update_staff();
    $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_staff();
    
?>
<style>
.container-fluid h1 {
    color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
            margin-top: 30px;
            letter-spacing: 3px;

            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
}
table {
    width: auto; /* Let the table size itself based on content */
    table-layout: auto; /* Cells adjust to their content */
    border-collapse: collapse; /* Neat borders */
   
}

/* Table cell styles */
th, td {
    padding: 10px; /* Add some space around content */
    text-align: center; /* Center text horizontally */
    vertical-align: middle; /* Center text vertically */
    border: 1px solid #ddd; /* Add borders for clarity */
    white-space: nowrap; /* Prevent text from wrapping */
}

td {
    border: 2px solid white !important; /* Thicker border with custom color */
}

th {
    background-color: #014bae;
    color: white;
    text-align: center; /* Horizontal alignment */
    vertical-align: middle !important; /* Vertical alignment */
    border: 2px solid white !important; /* Thicker border with custom color */
    padding: 15px;
    font-size: 1rem;
    font-family: "PSemiBold" !important;
    height: 60px; /* Adjust as needed to make the header row taller */
}

/* Table Rows */
td {
    text-align: center;
    padding: 20px;
    font-family: "PRegular" !important;
    font-size: 0.9rem;
    color: #333;
    border-bottom: 1px solid #ddd;
}
    .btn-open-popup {
    padding: 12px 24px;
    font-size: 1.2rem;
    background-color: #2c91c9;
    width: 30%; /* This defines the width of the button */
    margin: 50px auto; /* Centers the button horizontally */
    color: #fff;
    border: none;
    font-family: "PBold";
    border-radius: 30px;
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
            font-size: 1rem;
            border-radius: 5px;
            padding: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            color: black !important;
            
           
          
            
        }

        .form-control option:hover {
    background-color: #2c91c9; /* Light gray background on hover */
    color: #000; /* Darker text on hover */
}



        .form-control:focus {
    border-color: black; /* Highlight border on focus */
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); /* Subtle shadow on focus */
    color: black !important;
  
    
}

        .popup-box {
            background-color: #fff;
            width: 500px; /* Fixed width */
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
       
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            font-family: "PRegular";
            box-sizing: border-box;
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
            margin-top: -20px;
 
         
      
        }

  

        .btn-submit:hover
         {
            background-color: #2c91c9;
        }

        /* Keyframes for fadeInUp animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

.form-group {
    margin:0 !important;
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
</style>
<?php 
?>
<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="mb-4 text-center">Barangay Staff Data</h1>
    <hr>
    <br><br>

    <div class="row">
        <!-- Table Column -->
        <div class="col-md-12">
            <table class="table table-hover text-center table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
                <form action="" method="post">
                    <thead class="alert-info">
                        <tr>
                            <th> </th>
                            <th> Username </th>
                            <th> Email </th>
                            <th> Surname </th>
                            <th> First name </th>
                            <th> Middle Initial </th>
                            <th> Sex </th>
                            <th> Contact </th>
                            <th> Position </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($view)) { ?>
                            <?php foreach ($view as $view) { ?>
                                <tr>
                                    <td>
                                        <form action="" method="post">
                                            <a href="update_staff_form.php?id_user=<?= $view['id_user']; ?>" style="width: 70px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" class="btn btn-success">  <i class="fas fa-edit"></i> </a>
                                            <input type="hidden" name="id_user" value="<?= $view['id_user']; ?>">
                                            <button class="btn btn-danger" type="submit" name="delete_staff" style="width: 70px; font-size: 17px; border-radius:30px;">  <i class="fas fa-trash"></i> </button>
                                        </form>
                                    </td>
                                    <td> <?= $view['username']; ?> </td>
                                    <td> <?= $view['email']; ?> </td>
                                    <td> <?= $view['lname']; ?> </td>
                                    <td> <?= $view['fname']; ?> </td>
                                    <td> <?= $view['mi']; ?> </td>
                                    <td> <?= $view['sex']; ?> </td>
                                    <td> <?= $view['contact']; ?> </td>
                                    <td> <?= $view['position']; ?> </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
        </div>

        <!-- Staff Count Column -->

 
</div>



<button class="btn-open-popup" onclick="togglePopup()">
      Add Staff
      </button>

      <div id="popupOverlay" 
         class="overlay-container">
         
        <div class="popup-box">
        <div class = "popup-hd">
            <h2>Add Staff Form</h2>
       
            
            <h3>Please fill in all the required fields with accurate information for the new staff member and review the details before submitting.</h3>
            
            
            <button class="btn-close-header" onclick="togglePopup()">
            <i class="fas fa-times"></i> <!-- Font Awesome "X" icon -->
           
        </button>
     
        </div>
        <hr style = "margin: 25px;">
        <div class="form-body"> 
                    <form method="post" class="form-container"> 
                       
                            <div class="col">
                                <div class="form-group">
                                    <label class = "form-label"> Last Name: </label>
                                    <input type="text" class="form-input" name="lname"  placeholder="Enter Last Name" required>
                            
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label class = "form-label" >First Name: </label>
                                    <input type="text" class="form-input" name="fname"  placeholder="Enter First Name" required>
                                    
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label class = "form-label"> Middle Initial: </label>
                                    <input type="text" class="form-input" name="mi" placeholder="Enter Middle Initial" required>
                                    
                                </div>
                            </div>
                        

                      
                            <div class="col">
                                <div class="form-group">
                                    <label class = "form-label">Contact Number:</label>
                                    <input type="tel" class="form-input" name="contact" maxlength="11" pattern="[0-9]{11}" placeholder="Enter Contact Number" required>

                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label class = "form-label">Username: </label>
                                    <input type="username" class="form-input" name="username"  placeholder="Enter username" required>
                         
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label class = "form-label">Email: </label>
                                    <input type="email" class="form-input" name="email"  placeholder="Enter Email" required>
                             
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label class = "form-label">Password:</label>
                                    <input class="form-input"  id="password-field" name="password" value="staff123" placeholder="Enter Password" readonly>
                         
                                </div>
                            </div>
                      

                     
                            <div class="col"> 
                                <div class="form-group">
                                    <label class = "form-label">Position: </label>
                                    <select class="form-control" name="position" id="position" required>
                                        <option value="">Choose your Position</option>
                                        <option value="Kagawad">Kagawad</option>
                                        <option value="Chairman">Chairman</option>
                                    </select>
                       
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label class = "form-label">Age</label>
                                    <input type="number" class = "form-input" name="age" placeholder="Enter Age" required>
                                 
                                </div>
                            </div>

                            <div class="col rb">
                                <div class="form-group" >
                                    <label class = "form-label">Sex</label>
                                    <select class="form-control" name="sex" id="sex" required>
                                        <option value="">Choose your Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
               
                                </div>
                            </div>         
                        

                        <br>
                        <hr>
                        <button class="btn-submit" 
                        type="submit" name="add_staff">
                  SUBMIT
                  </button>

             
</div>
</div>
        </div>


</form>

</div>

        </div>



   


<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
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
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

<?php 
    include('dashboard_sidebar_end.php');
?>