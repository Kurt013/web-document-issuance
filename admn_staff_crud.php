<?php 
session_start();
$toast = '';
if (isset($_SESSION['toast'])) {
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']); // Clear the session after displaying
}
?>
<?php
    include('dashboard_sidebar_start.php');
    include('table_design.php');
    include('popup-confirm.php');
    include('popup.php');
    include('logout_script.php');

    $conn = $staffbmis->openConn();
    $staffbmis->validate_admin();
    $view = $staffbmis->view_staff();
    $staffbmis->create_staff();
    $upstaff = $staffbmis->update_staff();
    $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_staff();
?>


<?php if (!empty($toast)): ?>
        <?= $toast; ?>
    <?php endif; ?>
<div id="popupOverlay" class="overlay-container">
    <div class="popup-box">
        <div class="popup-hd">
        <h2>Add Staff Form</h2>

            <h3>Please fill in all the required fields with accurate information for the new staff member and review the details before submitting.</h3>
            <button class="btn-close-header" onclick="togglePopup()">
                <i class="fas fa-times"></i> <!-- Font Awesome "X" icon -->
            </button>
        </div>
        <hr style="margin: 25px;">
        <div class="form-body">
            <form method="post" class="form-container">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Last Name:</label>
                        <input type="text" class="form-input" name="lname" id ="lname" placeholder="Enter Last Name" data-tr-rules="required|between:2,80|only:string" required>
                        <div class= "feedback-error" data-tr-feedback="lname"></div>

                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label class="form-label">First Name:</label>
                        <input type="text" class="form-input" name="fname" id = "fname" placeholder="Enter First Name" data-tr-rules="required|between:2,80|only:string" required>
                        <div class= "feedback-error" data-tr-feedback="fname"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Middle Name:</label>
                        <input type="text" class="form-input" name="mi" id = "mi" placeholder="Enter Middle Name" data-tr-rules="required|between:2,80|only:string" required>
                        <div class= "feedback-error" data-tr-feedback="mi"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Contact Number:</label>
                        <input type="text" class="form-input" name="contact" id="contact" placeholder="Enter Contact Number" value="09" oninput="this.value = this.value.startsWith('09') ? this.value : '09';" required data-tr-rules="required|length:11|numeric">
                        <div class= "feedback-error" data-tr-feedback="contact"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Username:</label>
                        <input type="text" class="form-input" name="username" id="username" placeholder="Enter Username"  required data-tr-rules="required|between:3,20|string"/>
                        <div class= "feedback-error" data-tr-feedback="username"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-input" name="email" placeholder="Enter Email" data-tr-rules="required|email|maxlength:32" required>
                        <div class= "feedback-error" data-tr-feedback="email"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Password:</label>
                        <input class="form-input" id="password-field" name="password" value="staff123" placeholder="Enter Password" readonly>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Age:</label>
                        <input type="number" class="form-input" name="age" placeholder="Enter Age" required data-tr-rules="required|numeric|min:18|max:125">
                        <div class= "feedback-error" data-tr-feedback="age"></div>
                    </div>
                </div>

                <div class="col rb">
                    <div class="form-group">
                        <label class="form-label">Sex:</label>
                        <select class="form-control" name="sex" id="sex" required data-tr-rules="required|string">
                            <option value="">Select Staff Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <div class= "feedback-error" data-tr-feedback="sex" style = "margin-top: 2px"></div>
                    </div>
                </div>
                <br>
                <hr>
                <button class="btn-submit" type="submit" style = "display: none;" id = "hiddenAddStaff" name="add_staff">SUBMIT</button>
                <button class="btn-submit add-staff-btn" type="button" >SUBMIT</button>
            </form>
        </div>
    </div>
</div>


<style>

input.is-invalid,
textarea.is-invalid,
select.is-invalid,
input[type="file"].is-invalid {
  border-left: 4px solid #ff0000 !important;
  border-color: #ff0000 !important;
}

input.success,
textarea.success,
select.success,
input[type="file"].success {
  border-left: 4px solid #28a745;
  border-color: #28a745;
}
::placeholder {
            text-transform: none; /* Placeholder remains as is */
        }
.mid-ini {
    text-transform: uppercase;
}

.feedback-error {
    font-family: "PMedium";
    color: red;
    font-size: 0.8rem;
    width: 80%;
    margin-top: -8px;
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
            padding: 10px !important;
            margin-top: 5px;
            border: 1px solid #ccc !important;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
            height: 100%;
            color: black !important;
            font-family: "PRegular";
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
       
            margin-bottom: 10px;
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

<style>

.col {

    margin-bottom: 20px; 
}

/* Card styling */
.card {
    position: relative; /* Make the card a positioning context */
    border-left: 10px solid #014bae !important; /* Remove any default borders */
    padding: 5px; /* Ensure space for content inside the card */
    background: white; /* Card background */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Optional shadow */
    border-radius: 10px; /* Optional rounded corners */

    overflow: hidden; /* Ensure content doesn't spill out */
}



/* Card hover effect */
.card:hover {
    transform: scale(1.02); /* Slightly enlarge the card */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Card body */
.card-body {
    padding: 20px;
}

/* Title styling */
.card-title {
    font-size: 22px;
    font-weight: bold;
    color: white;
	background-color: #014bae; /* Horizontal gradient */

	padding:10px;
	border-radius: 10px 10px 10px 0;


    margin-bottom: 15px;
	font-family: "PSemiBold";
}

/* Text styling */
.card-text {
    font-size: 1rem;
	font-family: "PRegular" !important;
	line-height: 25px;
	
    color: #555;
}

/* Strong text (labels) */
.card-text strong {
    color: #014bae;
	font-family: "PRegular" !important;
}
.card-buttons {
    position: absolute;
    bottom: 10px; /* Position at the bottom */
    right: 10px; /* Position at the left */
}

.container-fluid {
    margin-bottom: 100px !important;
}

.card-buttons .btn {
    width: 70px;
    font-size: 17px;
    border-radius: 30px;
    margin-right: 5px; /* Space between buttons */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        max-width: 100%; /* Ensure cards use full width on smaller screens */
    }
}

.form-control.is-invalid {
    background-position: right calc(0.9rem + .10000rem) center !important;
}

</style>



<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="col text-center"> 
            <h1> Barangay Staff Management </h1>
        </div>
    </div>

    <hr>
    <br><br>
    
    <?php include ('validation_script.php'); ?>
    <div class="search-row"> 
    <div class="cols">
<form class="searchbox" method="POST">
                <div class="left-search">
                    <input class = "searchinp" placeholder="Search" name ="keyword" />
                    <div class = "btn-container">
                    <button class="searchbtn" type="submit" value="search" name="search_totalstaff">
                      <i class="fas fa-search"></i>
                    </button>
                    <button class="btns button-info" onclick="location.reload();">
    <i class="fa fa-sync" aria-hidden="true"></i>
</button>
</div>
</div>
    </form>       
        </div>
</div>

    <br>


    
    <?php

$sql = "SELECT * FROM tbl_user WHERE role = :role";
$stmt = $conn->prepare($sql);

// Bind the parameter
$role = 'staff';
$stmt->bindParam(':role', $role, PDO::PARAM_STR);

// Execute the statement
$stmt->execute();

// Fetch all rows
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 

if (count($result) == 0) {
    echo '
    <div style="text-align: center; padding: 20px !important; margin-top: 20px; margin-bottom: 50px">
        <img src="assets/emptystaff.png" alt="No Data Available" style="max-width: 600px; display: block; padding: 0 !important; margin: 0 auto;">
        <p class="norec">Oops! There are no staff members available at the moment.</p>
        <p class="norec2">This list is currently empty. You can add new staff members or check back later.</p>
        <!-- Button added below the text -->
<button class="btnqr" onclick="togglePopup()" id="addstaff">
    <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Add Staff
</button>
    </div>';


    include('dashboard_sidebar_end.php');

    return;
} 
?>

<div class = "add-staff-cnt">
<button class="add-staff-btn" id="addstaff" onclick="togglePopup()">
    <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Add Staff
</button>
</div>

<?php
	// require the database connection
	if(isset($_POST['search_totalstaff'])){
		$keyword = $_POST['keyword'];
?>



  
		<?php
$keywordLike = "%$keyword%";

$stmt = $conn->prepare("
SELECT * 
FROM `tbl_user` 
WHERE (`lname` LIKE ? OR  
       `mi` LIKE ? OR  
       `username` LIKE ? OR 
       `fname` LIKE ? OR 
       `sex` LIKE ? OR 
       `contact` LIKE ? OR 
       `email` LIKE ?)
  AND `role` = 'staff'
ORDER BY `lname` ASC
");

// Bind the parameters
$stmt->execute([
$keywordLike, $keywordLike, $keywordLike, 
$keywordLike, $keywordLike, $keywordLike, 
$keywordLike
]);

// Fetch the results
$results = $stmt->fetchAll();
?>
    <div class="row" style = "display:flex">

 <?php if ($stmt->rowCount() > 0) { ?>
	<?php foreach ($results as $view) { ?>
		<div class="col-md-4 mb-4"> <!-- Column for each card -->
			<div class="card">
				<div class="card-body">
					<h5 class="card-title"><?= htmlspecialchars($view['fname']) . ' ' . htmlspecialchars($view['lname']); ?></h5>
					<p class="card-text">
                        <strong>Username:</strong> <?= htmlspecialchars($view['username']); ?><br>
						<strong>Email:</strong> <?= htmlspecialchars($view['email']); ?><br>
						<strong>Middle Initial:</strong> <?= htmlspecialchars($view['mi']); ?><br>
						<strong>Sex:</strong> <?= htmlspecialchars($view['sex']); ?><br>
						<strong>Contact #:</strong> <?= htmlspecialchars($view['contact']); ?><br>
					</p>

                    <div class="card-buttons"> <!-- Buttons container -->
                    <form action="" method="post" id="removeform">
                <a href="update_staff_form.php?id_user=<?= $view['id_user']; ?>" class="btn btn-success">  
                    <i class="fas fa-edit"></i>
                </a>
                <input type="hidden" name="id_user" value="<?= $view['id_user']; ?>">
                <button class="btn btn-danger remove-staff-btn" type="button"  name="delete_staff">  
                    <i class="fas fa-trash"></i>
                </button>
                <button class="btn btn-danger" type="submit" id = "hiddenSubmitBtn" style = "display: none"  name="delete_staff">  
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>

				</div>
			</div>
		</div>

	<?php } ?>
<?php } else { ?>
    </div>
    
    <div style="text-align: center; padding: 20px !important; background-color: transparent !important; margin-bottom: 20px;">
                    <img src="assets/notfound.png" alt="No Data Available" style="max-width: 700px; display: block;  padding: 0 !important; margin: 0 auto;">
                        
                    <p class="norec">No staff found matching your search criteria.<p>
                        <p class="norec2">It seems no staff match your search. Try adjusting your search criteria or check back later.</p>
                        <button class="btnqr"  onclick="window.location.href = window.location.href;">
            <i class="fas fa-sync" style="margin-right: 8px;"></i> Reload
        </button>
                </div>

        

<?php		
	}}else{
?>


<div class="row"> <!-- Start row -->
    <?php if (is_array($view)) { ?>
        <?php foreach ($view as $view) { ?>
            <div class="col-md-4 mb-4"> <!-- Column for each card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($view['fname']) . ' ' . htmlspecialchars($view['lname']); ?></h5>
                        <p class="card-text">
                            <strong>Username:</strong> <?= htmlspecialchars($view['username']); ?><br>
                            <strong>Email:</strong> <?= htmlspecialchars($view['email']); ?><br>
                            <strong>Middle Initial:</strong> <?= htmlspecialchars($view['mi']); ?><br>
                            <strong>Sex:</strong> <?= htmlspecialchars($view['sex']); ?><br>
                            <strong>Contact #:</strong> <?= htmlspecialchars($view['contact']); ?><br>

                        </p>
                        <div class="card-buttons"> <!-- Buttons container -->
                        <form action="" method="post" id="removeform">
                <a  onclick="openPopup('update_staff_form.php?id_user=<?= urlencode($view['id_user']) ?>')" class="btn btn-success">  
                    <i class="fas fa-edit"></i>
                </a>
                <input type="hidden" name="id_user" value="<?= $view['id_user']; ?>">
                <button class="btn btn-danger remove-staff-btn" type="button"  name="delete_staff">  
                    <i class="fas fa-trash"></i>
                </button>
                <button class="btn btn-danger" type="submit" id = "hiddenSubmitBtn" style = "display: none"  name="delete_staff">  
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div> <!-- End row -->



<?php
	}
$conn = null;


?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Get all archive buttons (assuming they have the same class 'remove-staff-btn')
    const archiveBtns = document.querySelectorAll('.remove-staff-btn');
    
    // Get popup and other necessary elements
    const popup = document.getElementById('popup-remove-staff');
    const confirmBtn = document.getElementById('confirm-btn-rms');
    const cancelBtn = document.getElementById('cancel-btn-rms');
    const hiddenSubmitBtn = document.getElementById('hiddenSubmitBtn'); // Hidden submit button
    const removestaff = document.getElementById('removeform'); // Hidden submit button

    // Add event listeners to each archive button
    archiveBtns.forEach(archiveBtn => {
        archiveBtn.addEventListener('click', function () {
            const dataId = this.closest('form').querySelector('input[name="id_user"]').value;

           removestaff.querySelector('input[name="id_user"]').value = dataId;
            // Open the popup when a button is clicked
            popup.classList.remove('hidden');
        });
    });

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden'); // Hide the popup when cancel is clicked
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        // Trigger the hidden submit button
        hiddenSubmitBtn.click(); // Programmatically click the hidden submit button
        
        // Hide the popup after submission
        popup.classList.add('hidden');
    });
});
</script>



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
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>
    <?php include('table_script.php'); ?>
</div>
<?php 
    include('dashboard_sidebar_end.php');
?>