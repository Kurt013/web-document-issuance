<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fixed Header with HTML and CSS | Collapsing Header Tutorial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Unique parent container to prevent style leakage -->
    <div id="user-header">
    <div class="box-area">
        <header>
            <div class="wrapper">
                <!-- Add Font Awesome icon inside the button -->
                <button id = "adminbtn" onclick="window.location.href='login.php';">
                    <i class="fa fa-user"></i> Sign in as Admin
                </button>
            </div>
        </header>
    </div>
</div>


    <!-- Scoped styles inside the unique container -->
    <style>
            @font-face {
            font-family: 'OSExBold'; 
            src: url('fonts/OpenSauceSans-ExtraBold.ttf') format('truetype'); 
        }
        /* Basic reset for elements inside user-header */
        #adminbtn i {
            margin-right: 5px !important;
            /* Adds space between the icon and the text */
}

        #user-header * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Font family */
        #user-header {
            font-family: 'Poppins', sans-serif;
        }

        /* Header Styling */
        #user-header header {
            height: 70px;
            background: linear-gradient(to left,  #014bae,#2c91c9) ;

            width: 100%;
            z-index: 1;
            position: fixed;
            top: 0;
            left: 0;
        }

        /* Wrapper for flexbox layout */
        #user-header .wrapper {
            width: 100%;
            max-width: 1170px; /* Keeps content within a max width */
            margin: 0 auto;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Aligns the button to the right */
            padding: 0 20px; /* Padding to ensure spacing */
        }

        /* Button Styling */
        #adminbtn {
            background-color: transparent;  /* Green background */
            position: absolute;
            right: 30px;
            
            letter-spacing: 1px;
            color: white;               /* White text color */
            font-size: 0.8rem;            /* Font size */
            padding: 10px 20px !important;         /* Padding around the text */
            border: 2px solid white;               /* Remove default border */
            border-radius: 5px;         /* Rounded corners */
            cursor: pointer;   
            font-family: "OSBold";        /* Pointer cursor on hover */
            transition: background-color 0.3s ease; /* Smooth background color transition */
        }

        /* Hover effect for the button */
        #adminbtn:hover {
            background-color: #3661D5;  
        }

        /* Focus effect for accessibility */
        #adminbtn:focus {
            outline: none;  /* Remove outline */
            box-shadow: 0 0 5px rgba(72, 161, 99, 0.8); /* Greenish glow around the button */
        }


        /* Mobile responsiveness */
</style>

</body>
</html>
