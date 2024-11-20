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
        $_SESSION['message'] = 'Invalid verification code';
        header('Location: forget_password.php');
        exit;
      } else { 
        $_SESSION['verification_code'] = $key;
        $message_success = "Verification code accepted. Please enter your new password.";
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
            $result = $stmt->fetch();
            if ($result && $stmt->rowCount() == 1) {
                if (password_verify($password1, $result['password'])) {
                    $message = "You cannot reuse the same password.";
                } else {
                    // Proceed with updating the password
                    $password_hash = password_hash($password1, PASSWORD_DEFAULT);

                    $deleteQuery = $conn->prepare("DELETE FROM tbl_forget_password WHERE email= ? AND temp_key= ?");
                    $deleteQuery->execute([$email, $key]);

                    $update_query = $conn->prepare("UPDATE tbl_user SET `password`= ? WHERE `email`= ?");
                    $update_query->execute([$password_hash, $email]);

                    if ($update_query) {
                        $modal = true;
                        $message_success = "New password has been set for " . $email;
                        session_unset();
                        session_destroy();
                    } else {
                        $message = "Error updating password: ";
                    }
                }
         } else {
              $message = "Error fetching user data.";
          }
      } else {
            $message = "Password must be 8 characters or more, and include letters, numbers, and special characters";
      } 
      }
      else {
          $message = "Passwords do not match.";
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
  <title>Villa Gilda Resort || Reset Password</title>

  <!-- Favicon -->
  <link rel="icon" href="images/villa-gilda-logo3.png">

  <!-- Stylesheets -->
  <link rel="stylesheet" type="text/css" href="css/forgot_password_reset.css">
  <link rel="stylesheet" type="text/css" href="css/general.css">

  <!-- Boxicon Link -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <!-- Remixicon Link -->
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
  />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <form class="password-form" role="form" method="POST">
        <h1>Reset Password</h1>
        <div class="group-wrapper">
            <p>You can now choose a new password for this user account. This password will replace the old one; everything about the user account will remain unchanged.</p>
            <div class="form-group">
                <label for="pwd">New Password:</label>
                <input type="password" class="form-control" id="pwd" name="password1">
            </div>
            <div class="form-group">
                <label for="confirm-pwd">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm-pwd" name="password2">
            </div>
        </div>
        <?php if ($message <> "") {
                        echo "<div class='error-message'>" . $message . "</div>";
                    } ?>
                    <?php if (isset($message_success)) {
                        echo "<div class='message-success'>" . $message_success . "</div>";
                    } ?>
        <div class="bottom-part-3"><button type="submit" class="btn-save" name="submit">Save Password</button></div>
    </form>
</div>
<?php
if ($modal) {
    echo '<dialog class="field">
                <div class="icon-wrapper"><i class="ri-verified-badge-fill"></i></div>
                <div class="text-group">
                    <h1>Success</h1>
                    <p>Your password has been reset successfully. You can now use your new password to login!</p>
                </div>
                <div class="bottom-part">
                    <a class="btn" href="login.php">Back to Login Page</a>
                </div>
        </dialog>
            
            <script> 
                dialog = document.querySelector("dialog");
                dialog.showModal();
            </script>';
}
?>
</body>
</html>
