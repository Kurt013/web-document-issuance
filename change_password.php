<?php
    include('dashboard_sidebar_start.php');
    include('popup-confirm.php');
    include('logout_script.php');

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

<style>
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

.h5 {
    font-size: 1.7rem;
    display: flex;
    align-items: center;

}

.fa-key {
    font-size: 1.7rem !important;
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
    width: 450px !important;
   
}

.form-control:focus {
    border-color: #012049; /* Highlight border on focus */
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); /* Subtle shadow on focus */
    color: #012049 !important;
  
    
}
  </style>
  <div class="container">


  <div class="row"> 
        <div class="col-md-12"> 
            <h1 class="mb-4 text-center">Reset Password</h1>
        </div>
    </div>
    <hr>
    <br>


<div class="card" >
<div class="card-header bg-primary text-white d-flex align-items-center">
    <h5 class="d-flex align-items-center mb-0">
        <i class="fas fa-key me-2"></i> <!-- Updated Font Awesome icon -->
        Change Password
    </h5>
</div>
            
        <div class="card-body"> 
            <form method="post">
                <div class="row" style="margin-top: 1.1em;">
                    <div class="col">
                        <label class="form-group"> Old Password </label>
                        <input type="text" class = "form-control" name="oldpassword" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label class="form-group"> New Password </label>
                        <input type="text" class = "form-control" name="newpassword" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label class="form-group"> Confirm Password </label>
                        <input type="text" class = "form-control" name="checkpassword" required>
                    </div>
                </div>
                <br>
                <hr>
                <button class="btn btn-primary" type="submit" name="update_account_password"

                        style="
                               width: 200px;
                               margin: 0 auto;
                               display: flex;
                               padding: 10px;
                               justify-content: center;
                               border-radius: 30px;
                               font-size: 1rem;"> Change Password </button>
            </form>
        </div>
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

<?php 
    include('dashboard_sidebar_end.php');
?>