<?php
session_start();

include './classes/staff.class.php';
$conn = $staffbmis->openConn();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust the path as needed if you're not using Composer

$mail = new PHPMailer(true);

$message = "";
$showVerificationForm = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $recipient_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = $_POST['username'];

    $stmt = $conn->prepare('
      SELECT fname, lname, email FROM tbl_user WHERE username = ? AND email = ?
    ');

    $stmt->execute([$username, $recipient_email]);
    
    $detailFetch = $stmt->fetch();

    if ($detailFetch) {
      $stmt = $conn->prepare('
        DELETE FROM tbl_forget_password WHERE email = ?
      ');
      $stmt->execute([$recipient_email]);

      $verification_code = mt_rand(100000, 999999);

      $stmt = $conn->prepare('
        INSERT INTO tbl_forget_password(email, temp_key) VALUES(?, ?)
      ');
      $stmt->execute([$recipient_email, $verification_code]);

          try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.mailersend.net';  // Set your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'MS_aEACuu@trial-0p7kx4xjwevl9yjr.mlsender.net'; // Your SMTP username
                $mail->Password = 'ZsOeSK3qqlPGnXj7'; // Your SMTP password or app password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Sender and recipient settings
                $mail->setFrom('MS_aEACuu@trial-0p7kx4xjwevl9yjr.mlsender.net', 'Brgy. Sinalhan');
                $mail->addAddress($detailFetch['email'], $detailFetch['fname']);

                $mail->isHTML(true);
                $mail->Subject = 'Verification Code -- DO NOT SHARE';
                
                $mail->Body = '<html>
              <head>
                  <style>
                      * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                        font: 14px / 1.2 "Montserrat", "Helvetica", sans-serif;
                      }

                      a {
                        color: #4EB1CB;
                        word-break: break-all;
                      }

                      .card-container  {
                        width: 100%;
                        max-width: 700px;
                        margin: auto;
                        background-color: #ffffff;
                      }

                      .header-card {
                        text-align: center;
                        height: 90px;
                        background-image: url("https://scontent.fmnl33-6.fna.fbcdn.net/v/t1.15752-9/449048471_452239437525588_272269953370891782_n.png?_nc_cat=107&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeHTy-oQj3Uj41iB2J4xK9LgOvJNqU_Wwy068k2pT9bDLXXgweOat34wwr2glrhynQZyblrvet-tbppoUf5Yy2Jm&_nc_ohc=gtjpG9gbncsQ7kNvgGUC6IX&_nc_ht=scontent.fmnl33-6.fna&oh=03_Q7cD1QF7hSpPEgBw3S-qbjlXY6Sk4qwW0X60UhFM6b327mzD8g&oe=66A6D4CE");
                      }

                      .logo {
                        width: 150px;
                      }

                      .body-card {
                        padding: 30px 0 15px;
                        margin: auto;
                        width: 90%;
                      }

                      .body-card h1 {
                        font-size: 18px;
                        font-weight: bold;
                        color: #226060;
                      }

                      .body-card p{
                        font-weight: 600;
                        margin-top: 20px;
                      }

                      .verification__code {
                        letter-spacing: 5px;
                        font-size: 30px;
                        font-weight: bold;
                        margin: 40px auto;
                        width: 100%;
                        text-align: center;
                        max-width: 300px;
                        padding: 20px;
                        border-radius: 20px;
                        background-color: #DBDEDA;  
                        color: #226060;
                        }

                      .body-card .last-p {
                        color: #AFADAD;
                        font-style: italic;
                      }

                      .footer-card {
                        padding: 15px;
                        margin: auto;
                        width: 90%;
                        color: #A6A6A6;
                        text-align: center;
                      }

                      .footer-card .first-p {
                        font-weight: 600;
                      }

                      .footer-card .second-p {
                        max-width: 300px;
                        margin: 15px auto;
                      }

                      .icon {
                        width: 50px;
                        padding: 5px;
                        margin-top: 20px;
                        border-radius: 50%;
                      }

                      .icon-redirect {
                        text-align: center;
                      }

                      hr {
                        margin: 0 auto;
                        width: 90%;
                      }

                    </style>
                  </head>
                  <body>
                    <div class="card-container">
                      <div class="header-card">
                        <img class="logo" src="https://i.ibb.co/vP2N8bQ/sinlogo.png" alt="sinlogo" border="0">
                      </div>
                      <div class="body-card">
                        <h1>Hi '.$detailFetch['fname'].' '.$detailFetch['lname'].',</h1>
                        <p>We&apos;d been told that you&apos;d like to reset the password for your account.</p>
                        <p>If you made such request, go back to the website and enter the verification code below.</p>
                        <div class="verification__code">'.$verification_code.'</div>
                        <p class="last-p">If you believe you have received this email in error, please disregard this email or <a class="notif-link" href="https://mail.google.com/mail/?view=cm&to=resortvillagilda@gmail.com&su=Notify%20the%20Resort">notify us.</a></p>
                        <div class="icon-redirect">
                          <a href="https://www.facebook.com/profile.php?id=100092186237360"><img class="icon" src="https://scontent.fmnl9-3.fna.fbcdn.net/v/t1.15752-9/448805439_1033824851691076_1924524101978291005_n.png?_nc_cat=100&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeE9aPRH_OGP0V0aJCnFpQkPEDWtl9pklFYQNa2X2mSUVomkxi-0lupO9jucL73DWWrv9hh_LvmB2yLwLuIjefU9&_nc_ohc=TsTB9zB4jLgQ7kNvgGSQWqG&_nc_ht=scontent.fmnl9-3.fna&oh=03_Q7cD1QE_069nPaOOI8Rzn--Jybq7xY8MU05G2WRV1G3WVrgd-w&oe=66A7C320"/></a>
                          <a href="mailto:resortvillagilda@gmail.com"><img class="icon" src="https://scontent.fmnl9-3.fna.fbcdn.net/v/t1.15752-9/448665658_1005997041102081_7020963237239717707_n.png?_nc_cat=111&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeHE3_QUTfqAlZQW0Rswo88XGtPR5f8vZN8a09Hl_y9k31S3U4Gm_a6p7llRzxhqFwpjlpw6oeY4LEbkxg1KoMnL&_nc_ohc=kU_V_p-0oD4Q7kNvgFQNKIz&_nc_ht=scontent.fmnl9-3.fna&oh=03_Q7cD1QFx3CUFMyd_D6tKluLkL7xxQt7OyuHRMIptfVyF0AxQEA&oe=66A7C3D9"/></a>
                        </div>
                      </div>
                      <hr>
                      <div class="footer-card">
                        <p class="first-p">@ Gilda Private Resort, Purok 2, Brgy. Caingin, Santa Rosa, Laguna</p>
                        <p class="second-p">This message was sent to <a href="mailto:'.$recipient_email.'">'.$recipient_email.'</a></p>
                        <p>To help keep your account secure, please don&apos;t forward this email.</p>
                      </div>
                    </div>
                  </body>
                </html>
                ';

                // Send the email
                if(!$mail->send()){
                  $message = 'Failed to send email: ' . $mail->ErrorInfo;
                } else {
                  $message_success = 'Email sent successfully';
                  $showVerificationForm = true;
                  $_SESSION['email'] = $recipient_email;
                  $_SESSION['verification_code'] = $verification_code;
                }

            } catch (Exception $e) {
                $message = 'Error sending email: ' . $e->getMessage();
            }
      } else {
        $message = 'Username and/or email address not found.';
      }
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sinalhan Document Issuance System | Forgot Password</title>

  <!-- Favicon -->
  <link rel="icon" href="./assets/sinlogo.png" type="image/x-icon" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Stylesheets -->
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
<style>

  
@font-face {
  font-family: 'PMedium'; 
  src: url('fonts/Poppins-Medium.ttf') format('truetype'); 
}

@font-face {
  font-family: 'PRegular'; 
  src: url('fonts/Poppins-Regular.ttf') format('truetype'); 
}

@font-face {
  font-family: 'PBold'; 
  src: url('fonts/Poppins-Bold.ttf') format('truetype'); 
}

@font-face {
  font-family: 'PSemiBold'; 
  src: url('fonts/Poppins-SemiBold.ttf') format('truetype'); 
}

@font-face {
  font-family: 'PBlack'; 
  src: url('fonts/Poppins-Black.ttf') format('truetype'); 
}

@font-face {
  font-family: 'PExBold'; 
  src: url('fonts/Poppins-ExtraBold.ttf') format('truetype'); 
}

@font-face {
  font-family: 'PExBoldIt'; 
  src: url('fonts/Poppins-ExtraBoldItalic.ttf') format('truetype'); 
}

@font-face {
  font-family: 'PBlackIt'; 
  src: url('fonts/Poppins-BlackItalic.ttf') format('truetype'); 
}




body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  min-height: 100dvh;
  background-color: #012049;
  background-image: url("assets/fgtpwbg.png");
  background-size: cover; /* Scale the image to cover the entire screen */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Prevent the image from repeating */
}

.form-field {
  margin: 50px 20px;
  background-color: #ffffff;
  padding-top: 6rem;
  border-radius: 1.25rem;
  border: none;
  position: relative;
  width: 100%;
  max-width: 650px;
  min-width: 100px;
  display: flex;
  flex-direction: column;
  text-align: center;
}

.lock-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 6.5rem;
  height: 6.5rem;
  border: 10px solid white;
  border-radius: 50%;
  background-color: #2c91c9;
  position: absolute;
  top: -2.1875rem;
  left: 50%;
  transform: translateX(-50%);
}

.fa-lock {
  color: #ffffff;
  font-size: 3.7rem;
}


.form-group h1{
  color: #2c91c9;
  font-size: clamp(24px, 3vw, 30px);
  font-family: "PBold";
}

.form-group p {
  max-width: 570px;
  margin: auto;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  font-size: clamp(14px, 2vw, 16px);
  padding-bottom: 30px;
  font-weight: 600;
  color: #A6A6A6;
  padding-top: .6rem;
  font-family: "PSemiBold";
}


.input-wrapper + .input-wrapper {
  margin-top: 20px;
}

.input-wrapper {
  display: flex;
  max-width: 430px;
  width: 70%;
  margin: auto;
  justify-content: center;
  border: 2.8px solid #949191;
  overflow: hidden;
  border-radius: 10px;
}

.input-wrapper:last-child {
  margin-bottom: 30px;
}

.icon {
  flex: 0 0 40px;
  background-color: #949191;
  color: #EFF1EF;
  padding: 5px;
  font-size: 2rem;
}

.form-control {
  border: none;
  width: 0;
  flex: 1;
  font-weight: 600;
  /* padding: .9375rem .3125rem; */
  padding: .3125rem 0.8rem;
  font-family: "PRegular";
  font-size: 0.9rem;
}

.form-border {
  border-radius: 0 .625rem .625rem 0;
}

.bottom-part {
  background-color: #DBDEDA;
  display: flex;
  justify-content: flex-end;
  align-items: end;
  border-radius: 0 0 1.25rem 1.25rem;
  height: 80px;
  padding: .9375rem;
  column-gap: .625rem;
}

.btn, .btn-2 {
  display: inline-block;
  font-size: 1.25rem;
  padding-block: .3125rem;
  border-radius: .625rem;
  font-family: "PBold";
  width: 7.5rem;
  text-transform: uppercase;
  font-weight: 700;
}

.btn {
  text-decoration: none;
  color: #949191;
  border: 3px solid #949191;
  background-color: #EFF1EF;
  transition: background-color 0.2s, border 0.2s;
}

.btn-2 {
  border: 3px solid #2c91c9;
  background-color: #2c91c9;

  color: #EFF1EF;
  transition: background-color 0.2s, border-color 0.2s;
}

.form-field-2 {
  display: flex;
  flex-direction: column;
  background-color: #EFF1EF;
  border-radius: 1.25rem;
  overflow: hidden;
  margin: 0 10px;
  min-height: 250px;
  max-width: 550px;
}

.form-field-2 h1 {
  padding: 20px 35px;
  flex: 0 0 30px;
  background-color: #4CABAB;
  color: #EFF1EF;
}

.submit-group {
  padding: 20px 35px;
  flex: 1;
}

.form-field-2 p {
  color:#A6A6A6;
  font-weight: 600;
  padding-bottom: 15px;

}

#verification_code {
  letter-spacing: 15px;
  display: block;
  max-width: 300px;
  width: 100%;
  padding: 10px;
  font-size: 20px;
  font-weight: 600;
  border: 2px solid #949191;
  border-radius: 10px;
  margin-bottom: 30px;
}

#verification_code::placeholder {
  letter-spacing: 0;
}

.bottom-part-2 {
  text-align: center;
}

.btn-3 {
  width: 100%;
  background-color: #4CABAB;
  border: none;
  color: #EFF1EF;
  text-transform: uppercase;
  font-weight: bold;
  padding: 15px;
  font-size: 20px;
  border-radius: 10px;
  transition: background-color 0.2s, color 0.2s;
}

.btn-4 {
  font-size: 15px;
}

@media only screen and (min-width: 992px) {    
  .btn:hover{
    color: #EFF1EF;
    border: 3px solid #949191;
    background-color: #949191;
  }

  .btn-2:hover, .btn-3:hover {
    background-color: #014bae;
    border-color: #014bae;
    color: #EFF1EF;
    cursor: pointer;
  }
  
}
</style>
</head>
<body>
            <?php if (!$showVerificationForm) : ?>
                <form class="form-field" role="form" method="POST">
                    <div class="lock-container"><i class="fas fa-lock"></i></i></div>

                    <div class="form-group">
                        <h1>Forgot Your Password?</h1>
                        <p>Not to worry, enter the username and email address you registered with and we'll help you reset your password</p>
                        <div class="input-wrapper">
                            <i class="bx bxs-user icon"></i>
                            <input class="form-control form-border" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" placeholder="Username" required>
                        </div>
                        <div class="input-wrapper">
                            <i class="bx bxs-envelope icon"></i>
                            <input class="form-control form-border" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Email" required>
                        </div>
                    </div>

                    <?php if ($message <> "") {
                        echo "<div class='error-message'>" . $message . "</div>";
                    } ?>
                    <?php if (isset($message_success)) {
                        echo "<div class='message-success'>" . $message_success . "</div>";
                    } ?>
                    <div class="bottom-part">
                        <a class="btn" href="login.php">Back</a>
                        <button type="submit" class="btn-2" name="submit">Submit</button>
                    </div>
                </form>
            <?php else : ?>
                <form class="form-field-2" role="form" method="POST" action="forgot_password_reset.php">
                    <h1>OTP Verification</h1>
                    <div class="submit-group">
                        <p>A One-Time Passcode has been sent to your email. Please enter the OTP below to reset your password. </p>
                        <input maxlength="6" minlength="6" title="Please only enter numbers from 0-9" pattern="[0-9]+" class="form-control-verify" id="verification_code" name="verification_code" placeholder="Enter the OTP" required>
                        
                        <?php if ($message <> "") {
                        echo "<div class='error-message" . $message . "</div>";
                        } ?>

                        <div class="bottom-part-2">
                            <button type="submit" class="btn-3" name="submit_verification_code">Verify OTP</button>
                            <p class="btn-4">Didn't receive a code? Please check your spam folder</p>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
</body>
</html>
