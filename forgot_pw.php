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
                $mail->Username = 'MS_7mbW1m@trial-7dnvo4djj3x45r86.mlsender.net'; // Your SMTP username
                $mail->Password = '8XhCkcoNPuzNMq0i'; // Your SMTP password or app password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Sender and recipient settings
                $mail->setFrom('MS_7mbW1m@trial-7dnvo4djj3x45r86.mlsender.net', 'Brgy. Sinalhan');
                $mail->addAddress($detailFetch['email'], $detailFetch['fname']);

                $mail->isHTML(true);
                $mail->Subject = 'Verification Code -- DO NOT SHARE';
                
                $mail->Body = '<html>
            
              
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
            \
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
                  $message_success = '
    <body>
        <div class="toast">
            <div class="toast-content">
                <i class="fas fa-solid fa-check check"></i>
                <div class="message">
                    <span class="text text-1">OTP Sent</span>
                    <span class="text text-2">Please check your email for the OTP to reset your password</span>
                </div>
            </div>
            <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
            <div class="progress"></div>
        </div>
    </body>';
                  $showVerificationForm = true;
                  $_SESSION['email'] = $recipient_email;
                  $_SESSION['verification_code'] = $verification_code;
                }

            } catch (Exception $e) {
                $message = '
        <body>
            <div class="toast" style = "border-left: 6px solid #D32F2F;">
                <div class="toast-content">
                    <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                    <div class="message">
                <span class="text text-1">Error</span>
                <span class="text text-2">Error sending email: ' . $e->getMessage() . '</span>                    </div>
                </div>
                <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                <div class="progress progress-error"></div>
            </div>
        </body>';
            }
      } else {
        $message = '
        <body>
            <div class="toast" style = "border-left: 6px solid #D32F2F;">
                <div class="toast-content">
                    <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                    <div class="message">
                        <span class="text text-1">Account Not Found</span>
                        <span class="text text-2">The username or email address you entered does not exist </span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                <div class="progress progress-error"></div>
            </div>
        </body>';
      }
  }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sinalhan Document Issuance System | Forgot Password</title>
  <link rel="icon" href="assets/sinlogo.png" type="image/x-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
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
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #012049;
    color: white;
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

.right-side h3, .right-side h1 {
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
}

.form-group, .form-field-2 {
    
    width: 80%;
    text-align: center;
}

.input-field, .form-control-verify {
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

        .form-control-verify {
          text-align: center;
          font-family: "PExBold";
          font-size: 1.2rem;
          letter-spacing: 5px;
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



.btn, .btn-2, .btn-3 {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 5px;
    text-transform: uppercase;
    font-family: "PBold";
    font-size: 1rem;
    text-decoration: none;
    
    cursor: pointer;
}

.btn {
    color: white;
    margin-top: 5px;
}

.btn:hover {
    text-decoration: underline;
}



.btn-2 {
    color: white;
    background-color: #2c91c9;
    border: 2px solid #2c91c9;
    border-radius: 20px
  
}

.btn-4 {
  text-align: center !important;
  font-style: italic;
}




    </style>
    <?php include('loading.php'); ?>
</head>
<?php
$invalidotp = '';
if (isset($_SESSION['toast'])) {
    $invalidotp = $_SESSION['toast'];
    unset($_SESSION['toast']); // Clear the session after displaying
}
?>

<body>
<?php if (!empty($invalidotp)): ?>
        <?= $invalidotp; ?>
    <?php endif; ?>

<?php include('popups.php'); ?>
    <div class="container-custom">
        <!-- Left Side with Background and Title -->
        <div class="left-side">
            
        </div>

        <!-- Right Side with Conditional Forms -->
        <div class="right-side">
            

            <!-- Show Reset Form -->
            <?php if (!$showVerificationForm) : ?>
                <form class="form-group" role="form" method="POST">
                    <h3>Forgot Your Password?</h3>
                    <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 15px;margin-bottom: 10px">
                    <p>Not to worry, enter the username and email address you registered with and we'll help you reset your password.</p>
                    
                    <label class="input-label" for="username">Username</label>
                    <input class="input-field" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"  required>
                    
                    <label class="input-label" for="email">Email</label>
                    <input class="input-field" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"  required>
                    <div class = btn-container>
                   
                    <button type="submit" class="btn-2" name="submit">Submit</button>
                    <a class="btn" href="login.php">Back</a>
                  </div>
                    <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 15px;margin-bottom: 10px">


                    <?php if (!empty($message)) : ?>
                        <?= $message; ?>
                    <?php endif; ?>
                    

                </form>

            <!-- Show OTP Verification Form -->
            <?php else : ?>
                <form class="form-field-2" role="form" method="POST" action="forgot_password_reset.php">
                    <h1>OTP Verification</h1>
                    <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 15px;margin-bottom: 10px">
                    <div class="submit-group">
                        <p>A One-Time Passcode has been sent to your email. Please enter the OTP below to reset your password.</p>
                        <label class="input-label" for="verification_code">Enter OTP</label>
                        <input class="form-control-verify" id="verification_code" name="verification_code"  required maxlength="6" minlength="6" pattern="[0-9]+">
                        
                        <?php if (!empty($message)) : ?>
                            <div class="error-message"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>

                        <?php if (!empty($message_success)) : ?>
                        <?= $message_success; ?>
                    <?php endif; ?>

                        <div class="btn-container">
                            <button type="submit" class="btn-2" name="submit_verification_code">Verify OTP</button>
                            <p class="btn-4">Didn't receive a code? Please check your spam folder</p>
                            
                        </div>
                        <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 15px;margin-bottom: 10px">
                    </div>
                </form>
            <?php endif; ?>

            <!-- Logo -->

        </div>
    </div>

    <!-- Footer -->

</body>


</html>
