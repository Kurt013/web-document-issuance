  <?php
    // Enable Output Buffering to prevent unexpected output
    ob_start();

    // Include necessary classes
    include 'classes/staff.class.php';


    // Fetch user details
    $userdetails = $staffbmis->get_userdata();
    $brgyidcount = $staffbmis->count_brgyid();
    $indigencycount = $staffbmis->count_indigency();
    $clearancecount = $staffbmis->count_clearance();
    $rescertcount = $staffbmis->count_rescert();
    $bspermitcount = $staffbmis->count_bspermit();

    // Handle AJAX request
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // Return JSON response and exit
        echo json_encode([
            'rescertcount' => $rescertcount,
            'brgyidcount' => $brgyidcount,
            'bspermitcount' => $bspermitcount,
            'clearancecount' => $clearancecount,
            'indigencycount' => $indigencycount
        ]);
        exit; // Stop further execution for AJAX request
    }

    // Fetch user data for non-AJAX requests
    $bmis = new BMISClass();
    $user = $bmis->get_userdata();

    $firstName = $user['firstname'];
    $lastName = $user['surname'];
    $role = $user['role'];
    ?>

  <?php

    include('popup-confirm.php');
    include('popup.php');
    include('view_details_design.php');

    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_staff();
    $staffbmis->create_staff();
    $upstaff = $staffbmis->update_staff();
    $staffbmis->delete_view_staff();
    $staffcount = $staffbmis->count_staff();
    $id_user = $_GET['id_user'];
    $staff = $staffbmis->get_single_staff($id_user);
    ?>

  <style>
      .form-dtls {
          padding: 10px;
          margin-top: 5px;
          width: 100%;
          border: 2px solid #aaa !important;
          border-radius: 8px;
          font-size: 1rem;
          font-family: "PRegular";
          box-sizing: border-box;
      }

      form label {
        font-size:  1.1rem !important;
        font-family: "PSemiBold" !important;
        
      }
      

      body {
        background-color: #012049 !important;
        background-image: none;
       
      }

      .container {
        width: 90%;
        height: 100%;
        border-radius: 30px;
        padding: 50px 50px 0 50px;
        border-top: 30px solid #2c91c9;
        border-bottom: 30px solid #2c91c9;
        background: linear-gradient(to top, #E0F7FF 0%, #FFFFFF 50%, #E0F7FF 100%) !important;
    }

      .parent {
padding: 50px 0;
      }

      .staffprofile {
        width: 35%;
      }
form input {
      border: 2px solid #aaa !important;
}

      .usernamestf {
        font-family: "PSemiBold";
        background-color: #2c91c9;
        width: 60%;
        margin: 20px auto;
        font-size: 2rem;
        color: white;
        padding: 10px 0;
        border-radius: 50px;
      }
      
      
  </style>
  <!-- Begin Page Content -->
  <div class="rows" style ="display: flex; align-items: center; justify-content: center">
      <div class="col-md-8">
          <div class="parent">
              <div class="container" >
                  <form method="post" id = "removeform">
                  <div class="row mb-3 justify-content-center align-items-center text-center">
    <div class="col">
        <img src="assets/staffprof.png" alt="No Data Available" class="staffprofile">
        <h1 class="usernamestf"><?php echo $staff['username']; ?></h1>
    </div>
</div>

                      <div class="row mb-3">
                          <div class="col-md-11">
                              <div class="form-group">
                                  <label> Last Name:</label> </br>
                                  <input type="text" class="form-dtls" name="lname" placeholder="Enter Last Name" value="<?= $staff['lname']; ?>">
                              </div>
                          </div>
                          </div>
                          <div class="row mb-3">
                          <div class="col-md-11">
                              <div class="form-group">
                                  <label>First Name: </label> </br>
                                  <input type="text" class="form-dtls" name="fname" placeholder="Enter First Name" value="<?= $staff['fname']; ?>">
                              </div>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <div class="col-md-11">
                              <div class="form-group">
                                  <label> Middle Name: </label> </br>
                                  <input type="text" class="form-dtls" name="mi" placeholder="Enter Middle Name" value="<?= $staff['mi']; ?>">
                              </div>
                          </div>
                      </div>

                      <div class="row mb-3">
                          <div class="col-md-11">
                              <div class="form-group">
                                  <label>Email: </label>
                                  <input type="email"  class ="form-dtls" name="email"  placeholder="Enter Email" value="<?= $staff['email']; ?>">
                              </div>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <div class="col-md-11">
                              <div class="form-group">
                                  <label>Contact Number:</label>
                                  <input type="tel" class="form-dtls" name="contact" placeholder="Enter Contact Number" value="<?= $staff['contact']; ?>">
                              </div>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <div class="col-md-11">
                              <div class="form-group">
                                  <label>Sex</label>
                                  <select class="form-dtls" name="sex" id="sex" required>
                                      <option value="">Select Staff Sex</option>
                                      <option value="Male" <?= $staff['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                      <option value="Female" <?= $staff['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                  </select>
                              </div>
                          </div>
                      </div>

                      <input type="hidden" class="form-control" name="role" value="user">
                      <input type="hidden" class="form-control" name="addedby" value="<?= $userdetails['surname'] ?>, <?= $userdetails['firstname'] ?>">
                      <input type="hidden" name="id_user" value="<?= $staff['id_user'];?>">
                      <div class="row mb-3 justify-content-center align-items-center text-center">
                      <div class="col">
                      <button type = "button" title="Remove Staff" class="btn btn-danger remove-staff-btn" name="delete_staff"
   style="width: 80px; height: 80px; font-size: 25px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; text-align: center;">
   <i class="fas fa-trash"></i></button>

                      <button type = "submit"
                      name="delete_staff"
                      title="Remove Staff"
                      id = "hiddenSubmitBtn"
   class="btn btn-danger" 
   style="display: none;">
   
                      </button>

<button class="btn btn-primary update-staff-btn" 
title="Update Staff"
        type="button" 
        name="update_staff" 
        style="width: 80px; margin-left: 10px; background-color: #014bae; height: 80px; font-size: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; text-align: center;">
    <i class="fa-solid fa-floppy-disk"></i>
</button>
<button class="btn btn-primary" 
title="Update Staff"
        type="submit" 
        id = "hiddenbtn"
        name="update_staff" 
        style="display: none;">
</button>
    </div>
    </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <script>
document.addEventListener("DOMContentLoaded", () => {
    // Get all archive buttons (assuming they have the same class 'remove-staff-btn')
    const archiveBtn = document.querySelector('.remove-staff-btn');
    
    // Get popup and other necessary elements
    const popup = document.getElementById('popup-remove-staff');
    const confirmBtn = document.getElementById('confirm-btn-rms');
    const cancelBtn = document.getElementById('cancel-btn-rms');
    const hiddenSubmitBtn = document.getElementById('hiddenSubmitBtn'); // Hidden submit button
    const removestaff = document.getElementById('removeform'); // Hidden submit button

    // Add event listeners to each archive button
    
        archiveBtn.addEventListener('click', function () {
            const dataId = document.querySelector('input[name="id_user"]').value;
        // Set the ID in the form
        removestaff.querySelector('input[name="id_user"]').value = dataId;

        // Show the popup
        popup.classList.remove('hidden');
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Get all archive buttons (assuming they have the same class 'remove-staff-btn')
    const updateBtn = document.querySelector('.update-staff-btn');
    
    // Get popup and other necessary elements
    const popup = document.getElementById('popup-update-staff');
    const confirmBtn = document.getElementById('confirm-btn-upd');
    const cancelBtn = document.getElementById('cancel-btn-upd');
    const hiddenSubmitBtn = document.getElementById('hiddenbtn'); // Hidden submit button
    const removestaff = document.getElementById('removeform'); // Hidden submit button

    // Add event listeners to each archive button
    
        updateBtn.addEventListener('click', function () {
            const dataId = document.querySelector('input[name="id_user"]').value;
        // Set the ID in the form
        removestaff.querySelector('input[name="id_user"]').value = dataId;

        // Show the popup
        popup.classList.remove('hidden');
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