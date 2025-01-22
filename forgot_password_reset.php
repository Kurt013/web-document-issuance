<?php
session_start();
$message = "";
// $_SESSION['message'] = "";
$modal = false;

include './classes/staff.class.php';
$conn = $staffbmis->openConn();

// Handle verification code submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_verification_code'])) {
    $key = $_POST['verification_code'];
    $email = $_SESSION['email'];

    $check = $conn->prepare("
        SELECT * FROM tbl_forget_password WHERE email= ? and temp_key= ?
    ");
    $check->execute([$email, $key]);
    // $check = $stmt->fetch();

    if (!$check) {
        $message = "Database query failed: ";
    } else if ($check->rowCount() != 1) {
        $invalidotp = '
                
        <div class="toast" style = "border-left: 6px solid #D32F2F;">
            <div class="toast-content">
                <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                <div class="message">
                    <span class="text text-1">Invalid OTP</span>
                    <span class="text text-2">Please re-enter your email or username to restart the process </span>
                </div>
            </div>
            <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
            <div class="progress progress-error"></div>
        </div>
   ';

    $_SESSION['toast'] = $invalidotp;
        header('Location: forgot_pw.php');
        exit;
      } else { 
        $_SESSION['verification_code'] = $key;
        $validotp = '
    
        <div class="toast">
            <div class="toast-content">
                <i class="fas fa-solid fa-check check"></i>
                <div class="message">
                    <span class="text text-1">OTP Accepted</span>
                    <span class="text text-2">You can now reset your password</span>
                </div>
            </div>
            <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
            <div class="progress"></div>
        </div>
    ';
    $_SESSION['toast'] = $validotp;
    header('Location: forgot_password_reset.php');
    exit;
    }
}

function is_valid_password($password1) {
    // Length check
    if (strlen($password1) < 8) {
        return false;
    }
    
    // Character types check
    if (!preg_match('/[A-Za-z]/', $password1) || // contains at least one letter
        !preg_match('/\d/', $password1) ||      // contains at least one number
        !preg_match('/[^A-Za-z\d]/', $password1) // contains at least one special character
    ) {
        return false;
    }
    
    return true;
}
// Handle password reset submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  if (isset($_SESSION['email']) && isset($_SESSION['verification_code'])) {
      $email = $_SESSION['email'];
      $key = $_SESSION['verification_code'];

      $password1 = $_POST['password1'];
      $password2 = $_POST['password2'];

      if ($password1 === $password2) {
        if(is_valid_password($password1)){
            $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE `email`= ?");

            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch();
                if (password_verify($password1, $result['password'])) {
                    $message = '                      <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">New Password Required</span>
                            <span class="text text-2">Your new password cannot be the same as your current password.</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>';
                } else {
                    // Proceed with updating the password
                    $password_hash = password_hash($password1, PASSWORD_DEFAULT);

                    $deleteQuery = $conn->prepare("DELETE FROM tbl_forget_password WHERE email= ? AND temp_key= ?");
                    $deleteQuery->execute([$email, $key]);

                    $update_query = $conn->prepare("UPDATE tbl_user SET `password`= ? WHERE `email`= ?");
                    $update_query->execute([$password_hash, $email]);

                    if ($update_query) {

                        $updatepw = '
    
                        <div class="toast">
                            <div class="toast-content">
                                <i class="fas fa-solid fa-check check"></i>
                                <div class="message">
                                    <span class="text text-1">Password Reset Successful</span>
                                    <span class="text text-2">You can now log in with your new password.</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                            <div class="progress"></div>
                        </div>
                    ';
                    $_SESSION['toast'] = $updatepw;
                    header('Location: login.php');
                    exit;
                    } else {
                        $message = "Error updating password: ";
                    }
                }
         } else {
              $message = "Error fetching user data.";
          }
      } else {
            $message = '                      <div class="toast" style = "border-left: 6px solid #D32F2F;">
                            <div class="toast-content">
                                <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                                <div class="message">
                                    <span class="text text-1">Weak Password</span>
                                    <span class="text text-2">Password must be 8 characters or more, and include letters, numbers, and special characters</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                            <div class="progress progress-error"></div>
                        </div>';
      } 
      }
      else {
          $message = '<div class="toast" style = "border-left: 6px solid #D32F2F;">
                            <div class="toast-content">
                                <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                                <div class="message">
                                    <span class="text text-1">Passwords Do Not Match</span>
                                    <span class="text text-2">The new password and confirm password fields must be identical. Please try again.</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                            <div class="progress progress-error"></div>
                        </div>';
      }
  } else {
    
      header('Location: login.php');
  }
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sinalhan Document Issuance System | Reset Password</title>
  <link rel="icon" href="images/villa-gilda-logo3.png">
  <link rel="stylesheet" type="text/css" href="css/forgot_password_reset.css">
  <link rel="stylesheet" type="text/css" href="css/general.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <?php include('loading.php'); ?>
  <?php include('popups.php'); ?>
  <style>
body {
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #012049;
    color: white;
}

#toggleIcon1, #toggleIcon2 {
    font-size: 1.1rem;
    color: #012049;
}

.container-custom {
    display: flex;
    width: 100%;
   
    height: 100vh;
}

.left-side {
    flex: 1.30;
    background-image: url('assets/bgforgotnew.png');
    background-size: cover;
    background-position: left;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 2rem;
    width: 60%;
 
    text-align: center;
}

.right-side {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0;
    background-color: #012049;
    padding: 75px;
    width: 40%;
}

.right-side h3 {
    font-family: 'PBold';
            color: white;
            text-align:left;                  
            font-size: 2rem;
            margin: 0;
}

.right-side p {
    font-family: 'PMedium';
            color: white;
            text-align:left;
            line-height: 22px;
            margin-top: 10px;
            font-size: 0.95rem;
            font-weight: normal !important;
}

.form-group {
    
    width: 80%;
    text-align: center;
}

.input-field {
            margin-top: 5px;
            width: 100%;
            padding: 10px 15px;               
            border: none;                
            border-bottom: 2px solid white; 
            color: #012049 !important;
            font-size: 1rem;        
           border-radius: 10px;            
            box-sizing: border-box;     
        
            background-color: white;
                
            font-family: 'PMedium', sans-serif;           
        }


        .input-label {
            margin-top: 30px;
            display: block;
            text-align: left;
            font-family: "PSemiBold";
            font-size: 1rem;
        }

        .btn-container {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
           
        }






.btn-2 {
    color: white;
    background-color: #2c91c9;
    border: 2px solid #2c91c9;
    border-radius: 20px;
    display: inline-block;
    padding: 10px 20px;
    text-transform: uppercase;
    font-family: "PBold";
    font-size: 1rem;
    text-decoration: none; 
    cursor: pointer;
  
}


    </style>
</head>
<?php
$validotp = '';
if (isset($_SESSION['toast'])) {
    $validotp = $_SESSION['toast'];
    unset($_SESSION['toast']); // Clear the session after displaying
}
?>


<body>
<?php if (!empty($validotp)): ?>
        <?= $validotp; ?>
    <?php endif; ?>

<?php include('popups.php'); ?>
    <div class="container-custom">
        <!-- Left Side with Background and Title -->
        <div class="left-side">
            
        </div>

        <!-- Right Side with Conditional Forms -->
        <div class="right-side">
            

        <form class="form-group" role="form" method="POST">
                    <h3>Reset Password</h3>
                    <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 15px;margin-bottom: 10px">
                    <p>You can now choose a new password for this user account. This password will replace the old one; everything about the user account will remain unchanged.</p>
                    
                    <label class="input-label" for="pwd">New Password:</label>
                    <div style="position: relative;">
                    <input type="password" class="input-field" id="pwd" name="password1" required>
                    <button type="button" onclick="togglePassword('pwd', 'toggleIcon1')" style="position: absolute; right: 10px; top: 17px; background: none; border: none; cursor: pointer;">
                    <i id="toggleIcon1" class="fa-solid fa-eye-slash"></i> <!-- Font Awesome icon -->
                    </button>
                    </div>

                    <label class="input-label" for="confirm-pwd">Confirm Password:</label>
                    <div style="position: relative;">
                    <input type="password" class="input-field" id="confirm-pwd" name="password2" required>
                    <button type="button" onclick="togglePassword('confirm-pwd', 'toggleIcon2')" style="position: absolute; right: 10px; top: 17px; background: none; border: none; cursor: pointer;">
                    <i id="toggleIcon2" class="fa-solid fa-eye-slash"></i> <!-- Font Awesome icon -->
                    </button>
                    </div>

                    
                    <?php if (!empty($message)) : ?>
                        <?= $message; ?>
                    <?php endif; ?>
                    <?php if (isset($message_success)) {
                        echo "<div class='message-success'>" . $message_success . "</div>";
                    } ?>
                    <div class = btn-container>
                   
                    <button type="submit" class="btn-2" name="submit">Save Password</button>
                  
                  </div>
                    <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 15px;margin-bottom: 10px">
                   


                  
                </form>


            <!-- Logo -->

        </div>
    </div>
    <script>
    function togglePassword(inputId, iconId) {
    var x = document.getElementById(inputId);  // Get the input field by its id
    var icon = document.getElementById(iconId);  // Get the icon element by its id
    
    if (x.type === "password") {
        x.type = "text"; // Show the password
        icon.classList.remove("fa-eye-slash");  // Remove the eye-slash icon
        icon.classList.add("fa-eye"); // Add the eye icon for visibility
    } else {
        x.type = "password"; // Hide the password
        icon.classList.remove("fa-eye"); // Remove the eye icon
        icon.classList.add("fa-eye-slash"); // Add the eye-slash icon for hiding
    }
}


    </script>
</body>
</html>


