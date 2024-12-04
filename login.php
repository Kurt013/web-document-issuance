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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/fontawesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/regular.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'PSemiBold';
            color: white;
        }
/* Parent container */


/* Logo container */
/* Right-side styles */
.right-side {
    width: 55%;
    background-image: url('assets/bgimage.png');
    background-size: cover;
    background-position: right;
    background-repeat: no-repeat;
    display: flex;
    justify-content: flex-end;
    align-items: flex-start;
    position: relative;
    padding: 20px;
}

/* Parent container styles */
.parent-container {
    position: relative;
    width: 100%; /* Ensures it spans the full width of the .right-side */
    height: 100%; /* Spans the full height of the .right-side */
}

#toggleIcon {
    color: #012049;
    font-size: 1.1rem;


}

.fgtpw {
    color: white;
    text-align: right;
    font-family: "PMedium";
    font-size: 0.9rem;

}

.fgtpw:hover {
    color: #5adae6;
}
/* Logo container styles */
.logo-container {
    position: absolute; /* Enables precise positioning */
    top: 20px; /* Adjusts the vertical placement */
    right: 20px; /* Adjusts the horizontal placement */
    z-index: 10; /* Ensures it’s above other elements */
}

/* Logo image styles */
.logo-container img {
    width: 80px; /* Adjust logo size as needed */
    height: auto; /* Maintains aspect ratio */
}



        .left-side h3 {
            font-family: 'PBold';
            color: white;
            text-align:center;
            
      
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
    background-color: #012049;
    padding: 90px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    z-index: 5;
  
    

}

.registration-section {
    text-align: right;
    margin: 0;
}
        



.right-side {
    width: 55%;
    background-image: url('assets/bgimage4.png'); /* Path to your image */
    background-size: cover; /* Ensures the image scales to cover the entire area */
    background-position: right center; /* Focuses on the right side of the image */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    display: flex;
    justify-content: center; 
    align-items: flex-end; 
    position: relative; 
    padding: 0;
}


        .input-field {
            margin-top: 5px;
            width: 100%;
            padding: 10px 15px;               
            border: none;                
            border-bottom: 2px solid white; 
            color: #012049;
            font-size: 1rem;        
           border-radius: 10px;            
            box-sizing: border-box;     
        
            background-color: white;
                
            font-family: 'PMedium', sans-serif;           
        }

        .input-label {
            margin-top: 30px;
        }



        .tgl {
            width: 25px; height: auto; margin-top: 3px;
        }

        .login-button {
            background-color: RGB(44, 145, 201);
            width: 100%;
            padding: 9px 15px;
            
   
        }




    .login-button:hover {
        background-color: RGB(44, 145, 201);}

        
        .btn {
            
           
            border: none;
            border-radius: 30px;
            cursor: pointer;
            
            font-family: "PBold";;
            font-size: 16px;
            letter-spacing: 1px;
            margin-top: 10px;
        }


        .btn:hover {
            opacity: 0.9;
        }

        .copyright {
            position: fixed;
            bottom: 10px;
            left: 15px;
            opacity: 1;
            font-family: 'PMedium', sans-serif;
            color: white;
            font-size: 0.85rem;
      
            z-index: 6;
        }

@media (max-width: 1115px) {
    .left-side {
        padding: 50px;
    }




}

@media (max-width: 1070px) {

}

@media (max-width: 920px) {
    .copyright {
        width: 40%;
    }

    .left-side h3 {
        margin-bottom: 0;
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



    .copyright,
    .right-side,
    .logo-container {
        display: none;
    }
}


    </style>
</head>

<body>
 


<div class="container-custom">
    <div class="left-side">
        <h3>Welcome Back!</h3>
        
        

        <form method="post">
        <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 15px;margin-bottom: 10px">
            <label class = "input-label">Username</label>
            <input class="input-field" type="username"  name="username" required>

            <label class = "input-label" for="password">Password</label>
<div style="position: relative;">
    <input class="input-field" type="password" id="myInput" name="password" required>
    <button type="button" onclick="myFunction()" style="position: absolute; right: 10px; top: 17px; background: none; border: none; cursor: pointer;">
        <i id="toggleIcon" class="fa-solid fa-eye-slash"></i> <!-- Font Awesome icon -->
    </button>
</div>
<div class="registration-section mt-3">
    <p>
        <a href="#" class="fgtpw" onclick="trying();">Forgot Password?</a>
    </p>
</div>

            <button class="btn btn-primary login-button" type="submit" name="login">Login</button>
            <hr style = "background-color: white; height: 3px; border: none;  opacity: 1;  margin-left: auto;margin-right: auto; margin-top: 35px;margin-bottom: 15px">
        </form>

     



    </div>


    <div class="right-side">
  
   

    <div class="parent-container">
    <div class="logo-container">
        <img src="assets/sinlogo.png" alt="Logo">
    </div>
</div>

</div>

</div>

<div class="copyright">
    &copy; <?php echo date("Y"); ?> Barangay Management System. All Rights Reserved.
</div>


<script>



    function myFunction() { 
        var x = document.getElementById("myInput");
        var icon = document.getElementById("toggleIcon");
        
        if (x.type === "password") {
            x.type = "text"; // Show the password
            icon.classList.remove("fa-eye-slash");  // Remove the eye icon
            icon.classList.add("fa-eye"); // Add the eye-slash icon for visibility
        } else {
            x.type = "password"; // Hide the password
            icon.classList.remove("fa-eye"); // Remove the eye-slash icon
            icon.classList.add("fa-eye-slash"); // Add the eye icon for hiding
        }
    }



    function trying() {
        window.location.href = "forget_password.php";
    }
</script>
<?php ob_start(); include('popup.php'); ob_end_flush(); ?>
</body>
</html>
