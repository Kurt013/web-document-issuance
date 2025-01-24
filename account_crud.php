<?php
    include('dashboard_sidebar_start.php');
 
    $id_user = $userdetails['id'];

    if ($userdetails['role'] === 'administrator') {
        $view = $staffbmis->get_single_admin($id_user);
    } 
    else if ($userdetails['role'] === 'staff') {
        $view = $staffbmis->get_single_staff($id_user);
    }

    $staffbmis->update_account_profile();
    $staffbmis->update_account_password();
?>


<?php
    include('popup-confirm.php');
    include('popup.php');

?>

<?php 
$toast = '';
if (isset($_SESSION['toast'])) {
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']); // Clear the session after displaying
}
?>
<style>

input.is-invalid,
textarea.is-invalid,
select.is-invalid,
input[type="file"].is-invalid {
  border-left: 4px solid #ff0000 !important;
  border-color: #ff0000 !important;
}

.col-md-12 h1 {
    color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
        
            letter-spacing: 3px;
            margin-top: 20px;

            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
  }

  .card {
    margin-bottom: 100px;
    border-top-left-radius: 10px !important; /* Adjust the radius as needed */
    border-top-right-radius: 10px !important; /* Adjust the radius as needed */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Subtle shadow */   
    background: linear-gradient(to top, #E0F7FF, #FFFFFF) !important;
    border-bottom: 10px solid #014bae;
    border-bottom-left-radius: 10px !important; /* Adjust the radius as needed */
    border-bottom-right-radius: 10px !important; /* Adjust the radius as needed */
 
   
}

.btn-primary {
    background-color: #2c91c9 !important;
    font-family: "PSemiBold";
}

.card-body {
    padding : 30px 50px !important;
}

.card-header, .card-header2 {
    background: linear-gradient(to top, #014bae, #2c91c9);
    font-family: "PBold";
    text-align: left;
    color: white;
    display: flex;
    align-items: center;
    padding: 20px !important;
    border-top-left-radius: 10px !important; /* Adjust the radius as needed */
    border-top-right-radius: 10px !important; /* Adjust the radius as needed */

}

.feedback-error {
    font-family: "PMedium";
    color: red;
    font-size: 0.8rem;
    width: 80%;
    margin-top: -15px;
}

.h5 {
    font-size: 1.7rem;
    display: flex;
    align-items: center;

}

.fa-user-circle {
    font-size: 1.8rem !important;
    display: flex;
    align-items: center;
    margin-left: 30px;
    margin-right: 7px;
}

form label {
    font-family: "PSemiBold";
    color: #014bae;
    
}

form input {
    font-family: "PMedium" !important;
    margin-bottom: 20px;
    padding: 22px !important;
   
}

.form-control:focus {
    border-color: #012049; /* Highlight border on focus */
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); /* Subtle shadow on focus */
    color: #012049 !important;
  
    
}
  </style>

<?php if (!empty($toast)): ?>
        <?= $toast; ?>
    <?php endif; ?>
<div class="container">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="col-md-12"> 
            <h1 class="mb-4 text-center">Account Profile</h1>
        </div>
    </div>
    <hr>
    <br>
    <div style="display: flex; justify-content: flex-end;">
    <button class = "btn btn-primary" onclick="window.location.href='./change_password.php?id=<?php echo $userdetails['id']; ?>'"
        style="
            width: 200px;
            display: flex;
            padding: 10px;
            justify-content: center; /* Center the text/icon inside the button */
            align-items: center; /* Align vertically */
            border-radius: 10px;
            font-size: 1rem;
            margin-bottom: 20px;
        "> <i class="fas fa-key" style="margin-right: 8px;"></i>
        Change Password
    </button>
</div>
    <div class="card" >
    <div class="card-header bg-primary text-white d-flex align-items-center">
    <h5 class="d-flex align-items-center mb-0">
        <i class="fas fa-user-circle me-2"></i> <!-- Font Awesome icon -->
        Personal Details
    </h5>
</div>

               
        <div class="card-body"> 
            <form method="post">
                <div class="row" >
                    <div class="col">
                        <label class="form-group"> Last Name</label>
                        <input style="text-transform: capitalize;" type="text" class="form-control" name="lname"  Value="<?= $view['lname'];?>" readonly>
                    </div>
                    <div class="col">
                        <label class="form-group" >First Name </label>
                        <input style="text-transform: capitalize;" type="text" class="form-control" name="fname"  Value="<?= $view['fname'];?>" readonly>
                    </div>
</div>

<div class="row" >
                    <div class="col">
                        <label class="form-group"> Middle Name </label>
                        <input style="text-transform: capitalize;" type="text" class="form-control" name="mi" Value="<?= $view['mi'];?>" readonly>
                    </div>
            
                    <div class="col">
                        <label class="form-group">Email </label>
                        <input type="email" class="form-control" value="<?= $view['email'];?>" name="email" placeholder="Enter Email" data-tr-rules="required|email|maxlength:32" required>
                        <div class= "feedback-error" data-tr-feedback="email"></div>
                    </div>
</div>


<div class="row" >
                    <div class="col">
                        <label class="form-group">Contact Number</label>
                        <input type="text" class="form-control" name="contact" value="<?= $view['contact'];?>" id="contact" placeholder="Enter Contact Number" value="09" oninput="this.value = this.value.startsWith('09') ? this.value : '09';" required data-tr-rules="required|length:11|numeric">
                        <div class= "feedback-error" data-tr-feedback="contact"></div>
                    </div>
                </div>
                
                <input type="hidden" class="form-control" name="role" value="user">
                <input type="hidden" class="form-control" name="addedby" value="<?= $userdetails['surname']?>, <?= $userdetails['firstname']?>">
                <br>
                <hr>
                <input type="hidden" name="id" value="<?= htmlspecialchars($userdetails['id'], ENT_QUOTES); ?>">
                <button class="btn btn-primary update-profile-btn"  type="button" name="update_account_profile" 
                        style="
                               width: 150px;
                               margin: 0 auto;
                               display: flex;
                               padding: 10px;
                               justify-content: center;
                               border-radius: 30px;
                               font-size: 1rem;"> 
                    Update  
                </button>
                <button class="btn btn-primary" type="submit" style = "display:none;" id = "hiddenUpdProf" name="update_account_profile"> 
                    Update  
                </button>
            </form>
        </div>
    </div>



<!-- /.container-fluid -->

<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Get the single archive button
    const logoutBtn = document.querySelector('.logout-btn');
    
    // Get popup and other necessary elements
    const popup = document.getElementById('popup-logout');
    const confirmBtn = document.getElementById('confirm-btn-logout');
    const cancelBtn = document.getElementById('cancel-btn-logout');

    // Add event listener to the archive button
    logoutBtn.addEventListener('click', function () {


        // Show the popup
        popup.classList.remove('hidden');
    });

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden'); // Hide the popup when cancel is clicked
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        // Redirect directly to logout.php
        window.location.href = 'logout.php';

        // Hide the popup after redirection
        popup.classList.add('hidden');
    });
});
</script>

<?php 
    include('validation_script.php');
    include('dashboard_sidebar_end.php');
?>