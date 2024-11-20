<?php 
    error_reporting(E_ALL ^ E_WARNING);
    
    if (!isset($_SESSION)) {
        $showdate = date("Y-m-d");
        date_default_timezone_set('Asia/Manila');
        $showtime = date("h:i:a");
        $_SESSION['storedate'] = $showdate;
        $_SESSION['storetime'] = $showtime;
        session_start();
    }

    require('classes/main.class.php');
    $bmis->login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

        @font-face {
            font-family: 'OSBlackIt'; 
            src: url('fonts/OpenSauceSans-BlackItalic.ttf') format('truetype'); 
        }

        body {
            background-image: 
            linear-gradient(rgba(1, 75, 174, 0.8), rgba(90, 218, 230, 0.9), rgba(1, 75, 174, 0.8)), 
            url('assets/bgpic.jpg'); /* Replace with your image path */
            background-size: cover; /* Cover the entire container */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'OSBold', sans-serif;
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
            width: 5.5%; /* Adjust size as needed */
            height: auto;
        }

        .left-side h3 {
            font-family: 'OSBlack';
            color: rgb(1, 75, 174);
            text-align:center;
            background-color: white;
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .container-custom {
            display: flex;
            width: 100%;
            height: 100vh;
            max-width: 100%;
            padding: 0;
            margin: 0;
        }

        .left-side {
    width: 45%;
    background-color: white;
    padding: 85px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    z-index: 5;
    box-shadow: 10px 0 10px rgba(0, 0, 0, 0.2); /* Right-side shadow */

}
        

        .left-side p {
            text-align: center;
            font-family: 'OSMedium';
        }

        .right-side {
            width: 55%;
            background-image: 
            linear-gradient(rgba(1, 75, 174, 0.8), rgba(90, 218, 230, 0.9), rgba(1, 75, 174, 0.8)), 
            url('assets/bgpic.jpg'); 
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat; 
            display: flex;
            justify-content: center; 
            align-items: flex-end; 
            position: relative; 
            padding: 0;
        }

        .right-side img {
            position:absolute;
            bottom:0;
            right:0;
            width: 550px; 
            height: 550px; 
           
        }

        .text-overlay {
            width: 45%; 
            text-align: left; 
            color: white; 
            font-family: 'OSBlackIt'; 
            font-size: 2.2rem; 
            z-index: 1; 
            margin-top: 120px;      
            margin-left: 40px;    
            margin-right: auto;    
            margin-bottom: auto;   
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
            line-height: 42px;
            -webkit-text-stroke: 7px rgb(1, 60, 139);
         
            paint-order: stroke fill;
            display: block; 
        }

        .input-field {
            margin-top: 1px;
            width: 100%;
            padding: 10px;               
            border: none;                
            border-bottom: 2px solid black; 
            border-radius: 0;           
            font-size: 1rem;        
            line-height: 1.5;            
            box-sizing: border-box;     
            margin-bottom: 20px;         
            transition: border-color 0.3s, border-radius 0.3s; 
            background-color: white;     
            font-family: 'OSMedium', sans-serif;           
        }

        .input-field:focus {
            border: 2px solid black;
            outline: none;
            border-radius: 5px;
            background-color: white;
            color: #535353;
        }

        .tgl {
            width: 25px; height: auto; margin-top: 3px;
        }

        .login-button {
            background-color: RGB(44, 145, 201);
            width: 100%;
            padding: 9px 15px;
   
        }
        .create-button {
    background-color: rgb(1, 75, 174); 
    color: white;
    padding: 9px 15px;
   
    width: 100%;
    
}

.create-button:hover {
    background-color: rgb(1, 75, 174);}

    .login-button:hover {
        background-color: RGB(44, 145, 201);}

        
        .btn {
            
           
            border: none;
            border-radius: 30px;
            cursor: pointer;
            
            font-family: 'OSblack';
            font-size: 16px;
            letter-spacing: 1px;
            margin-top: 10px;
        }




        .registration-section p {
            color:#535353;
            margin-bottom: 3px;
            text-align: center;
            opacity: 0.6;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .copyright {
            position: fixed;
            bottom: 10px;
            left: 10px;
            font-family: 'OSBold', sans-serif;
            color: #333333;
            font-size: 0.85rem;
            opacity: 0.7;
            z-index: 6;
        }

@media (max-width: 1115px) {
    .left-side {
        padding: 50px;
    }

    .text-overlay {
        margin-top: 100px;
        margin-left: 30px;
        margin-right: auto;
        margin-bottom: 450px;
        width: 80%;
        font-size: 1.8rem;
    }

    .right-side img {
        width: 500px;
        height: 500px;
    }
}

@media (max-width: 1070px) {
    .text-overlay {
        margin-top: 100px;
        margin-left: 30px;
        margin-right: auto;
        margin-bottom: 450px;
        width: 80%;
    }
}

@media (max-width: 920px) {
    .copyright {
        width: 40%;
    }

    .left-side h3 {
        margin-bottom: 0;
    }
}

@media (max-width: 831px) {
    .text-overlay {
        font-size: 1.7rem;
        line-height: 35px;
    }
}

@media (max-width: 768px) {
    .container-custom {
        flex-direction: column;
        align-items: center;
        margin: 25px;
        font-size: smaller;
    }

    .btn {
        font-size: 0.9rem;
    }

.left-side p {
    font-size: 0.9rem;
}

.tgl {
    width: 20px;
}




.left-side h3 {
    font-size: 1.7rem;
    margin-bottom: 10px;;
}

    .left-side {
        width: 100%;
        height: 100%;
        max-width: 500px;
        margin: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 30px;
      
        justify-content: flex-start;
    }

    .input-field {
        font-size: 0.9rem;
    }

    .registration-section p {
        font-size: 0.9rem;

    }

    .copyright,
    .right-side,
    .logo-container {
        display: none;
    }
}


    </style>
</head>
<body>

<div class="logo-container">
    <img src="assets/sinlogo.png" alt="Logo 1">
    <img src="assets/sntrlogo.png" alt="Logo 2">
</div>

<div class="container-custom">
    <div class="left-side">
        <h3>Welcome Back!</h3>
        <p>To ensure a seamless and secure experience, please enter your credentials below:</p>

        <form method="post">
            <label>Username</label>
            <input class="input-field" type="username"  name="username" required>

            <label>Password</label>
            <div style="position: relative;">
                <input class="input-field" type="password" id="myInput" name="password" required>
                <button type="button" onclick="myFunction()" style="position: absolute; right: 10px; top: 10px; background: none; border: none; cursor: pointer;">
                    <img id="toggleIcon" src="assets/show.png" alt="Show password" class="tgl">
                </button>
            </div>

            <button class="btn btn-primary login-button" type="submit" name="login">Login</button>
        </form>

        <hr>

        <div class="registration-section mt-3">
            <p><strong>Forgot Password?</strong></p>
            <button class="btn btn-success create-button" onclick="trying();">Change Password</button>
        </div>
    </div>

    <div class="right-side">
    <img src="assets/qrdecors3.png" alt="Decorative Image">

    <div class="text-overlay">
        <p>Making Document Requests and Processing Faster and Easier!</p>
    </div>
</div>

</div>

<div class="copyright">
    &copy; <?php echo date("Y"); ?> Barangay Management System. All Rights Reserved.
</div>

<script>
    function myFunction() {
        const x = document.getElementById("myInput");
        const icon = document.getElementById("toggleIcon");
        
        if (x.type === "password") {
            x.type = "text";
            icon.src = "assets/eye.png";
            icon.alt = "Hide password";
        } else {
            x.type = "password";
            icon.src = "assets/show.png";
            icon.alt = "Show password";
        }
    }

    function trying() {
        window.location.href = "forget_password.php";
    }
</script>

</body>
</html>
