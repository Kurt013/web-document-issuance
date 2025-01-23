<?php 
// Enable Output Buffering to prevent unexpected output
ob_start(); 

// Include necessary classes
include 'classes/staff.class.php';

date_default_timezone_set('Asia/Manila');

$staffbmis->validate_staff();

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
$user = $staffbmis->get_userdata();
$firstName = $user['firstname'];
$lastName = $user['surname'];
$role = $user['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include("loading.php"); ?>
    
    <link rel="icon" href="./assets/sinlogo.png" type="image/x-icon">
    <title>Sinalhan Document Issuance System</title>

    <link rel="shortcut icon" href="./assets/sinlogo.png" type="image/x-icon">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="./css/general.css">
    
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>



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

@keyframes swing {
  0%,
  30%,
  50%,
  70%,
  100% {
    transform: rotate(0deg);
  }

  10% {
    transform: rotate(10deg);
  }

  40% {
    transform: rotate(-10deg);
  }

  60% {
    transform: rotate(5deg);
  }

  80% {
    transform: rotate(-5deg);
  }
}

.hidden {
    display: none;
}

.sidebar-brand-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #012049; /* Matches the dark background */
    padding: 20px 10px;
    border-radius: 8px;
}

.profile-card {
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
}

.profile-img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background-color: #00aff0; /* Matches the blue circle */
    display: flex;
    justify-content: center;
    align-items: center;
}



.profile-info h3 {
    margin: 0;
    font-size: 0.95rem;
    font-family: "PBold";
    color: white;
}

.profile-info p {
    margin: 0;
    font-size: 0.8rem;
    text-align: left !important;
    color: #b0c4de; /* Lighter color for the role */
    font-family: "PRegular";
}

.nav-link:hover {
    color:white !important;
}

.nav-link:hover i {
    animation: swing ease-in-out 0.5s 1 alternate; /* Apply animation to the icon */
    color: white !important;
}
        .nav-item {
    position: relative;
    background-color: #012049;
    font-family: "PMedium";
    display: flex;

    align-items: center;
    font-size: 0.7rem;
   
}


.btn-logout {
    border: 2px solid white !important;
    display: inline-flex;               /* Ensure button stays inline */

background-color: #01439c !important;  /* Green background */
position: absolute !important;
right: 30px !important;
letter-spacing: 1px !important;
color: white !important;               /* White text color */
font-size: 0.9rem !important;            /* Font size */
padding: 10px 20px !important;         /* Padding around the text */
border: 2px solid white !important;               /* Remove default border */
border-radius: 5px !important;         /* Rounded corners */
cursor: pointer !important;   
font-family: "PExBold" !important;        /* Pointer cursor on hover */
transition: background-color 0.3s ease !important;

}

.wrapperbtn {
    width: 100% !important;
    max-width: 1170px !important; /* Keeps content within a max width */
    margin: 0 auto !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important; /* Aligns the button to the right */
    padding: 0 20px !important; /* Padding to ensure spacing */
}

.btn-logout i {
    margin-right: 5px;
    margin-top: 5px;
}



.sidebar.toggled {
    overflow: visible;
    width: 10rem !important;
  }

.bg-primary {
    background-color: #012049 !important;

}

.nav-link {
    display: flex; /* Flex container for icon and text */
    align-items: center; /* Vertically center icon and text */
    text-decoration: none; /* Remove underline */
    line-height: 20px !important;
    color: #7d84ab !important; /* Text color */
}

.nav-link span {
 
    font-size: 0.8rem !important;
    line-height: 1.1rem !important;
}

.sidebar-heading {
    font-family: "PBlack";
    color: #7d84ab !important; /* Text color */
    font-size: 0.80em!important;
    letter-spacing: 1px;
    opacity: 0.8;

    margin-bottom: 15px;
}

.sidebar, .nav-link {
    width: 15.5rem !important;
}

.nav-link i {
    width: 25px; /* Set a fixed width for all icons */
    text-align: center; /* Center the icon within the fixed width */
    font-size: 1.3em; /* Adjust icon size */
    line-height: 1; /* Keep consistent spacing around icons */
    color: #7d84ab !important ;
}

.nav-link span {
    
    font-size: 1em; /* Ensure consistent text size */
    line-height: 1;
}


.sidebar {
    color: #012049 !important;
    padding: 5px !important;
}

.navbar { 
    background-color: #014BAE !important;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='250' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='.1'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/svg%3E");

}

.nav-item {
    background-color: transparent;
}




        .sidebar-brand {

  background-color: #012049;
}


        .notif {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            background-color: red;
            padding: 5px;
            width: 20px;
            font-size: 13px;
            height: 20px;
            border-radius: 100%;
            right: 10px;
            top: 10px;
        }
.sidebar.toggled .profile-info h3,
.sidebar.toggled .profile-info p {
  display: none; /* Hide the name and role */
}

    </style>
</head>
<body>
    


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            
            <div class="sidebar-brand-icon">
    <div class="profile-card">
        <a href="./account_crud.php?id=<?php echo $userdetails['id']; ?>"><img src="assets/<?= $role === 'administrator' ? "profile-admin.png": "profile-staff.png"; ?>" alt="Profile Image" class="profile-img"></a>
        <div class="profile-info">
        <h3><?php echo htmlspecialchars(ucwords(strtolower($firstName . ' ' . $lastName))); ?></h3>
        <p><?php echo htmlspecialchars(ucfirst($role)); ?></p>
        </div>
    </div>
</div>

            </a>

            <!-- Divider -->


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                GENERAL
            </div>

            <li class="nav-item">
                <a class="nav-link" href="<?= $role === 'administrator' ? 'admn_dashboard.php' : 'staff_dashboard.php'?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Barangay Staff CRUD -->
             <?php 
                if ($userdetails['role'] == 'administrator') {
             ?>
                <li class="nav-item">
                    <a class="nav-link" href="admn_staff_crud.php">
                        <i class="fas fa-user-tie"></i>
                        <span>Manage Staff</span></a>
                </li>
            <?php } ?>
            
            <li class="nav-item">
                <a class="nav-link" href="admn_announcement_crud.php">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Tool
            </div>

            <!-- Scan QR Code -->
               <li class="nav-item">
                <a class="nav-link" href="admn_scanqrcode.php">
                    <i class="fas fa-qrcode"></i>
                    <span>QR Code Scanner</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Document Requests
            </div>

            <!-- Announcement Management -->


         

            <!-- Certificate of Residency -->
            <li class="nav-item">
                <a class="nav-link" href="admn_certofres.php?list=active">
                    <i class="fas fa-file-word"></i>
                    <span>Certificate of Residency</span></a>
                <span class="notif rescert"><?= $rescertcount ?></span>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admn_brgyid.php?list=active">
                    <i class="fas fa-id-card"></i>
                    <span>Barangay ID </span></a>
                    <span class="notif brgyid"><?= $brgyidcount ?></span>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admn_bspermit.php?list=active">
                    <i class="fas fa-file-contract"></i>
                    <span>Business Permit</span></a>
                    <span class="notif bspermit"><?= $bspermitcount ?></span>
            </li>



            <!-- Barangay Clearance -->
            <li class="nav-item">
                <a class="nav-link" href="admn_brgyclearance.php?list=active">
                    <i class="fas fa-file"></i>
                    <span>Barangay Clearance</span></a>
                    <span class="notif clearance"><?= $clearancecount ?></span>
            </li>

            <!-- Certificate of Indigency -->
            <li class="nav-item">
                <a class="nav-link" href="admn_certofindigency.php?list=active">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Certificate of Indigency</span></a>
                    <span class="notif indigency"><?= $indigencycount ?></span>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center">
                <button class="rounded-circle border-0" id="sidebarToggle" style="height: 3rem !important; width: auto !important;"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Left-aligned container for logo and logout button -->
    <div class="d-flex align-items-center w-100 justify-content-between">
        <!-- Logo Section -->
        <div class="navbar-brand mb-0">
            <img src="assets/sinlogo.png" alt="Logo" style="height: 65px; display:flex; justify-content: flex-end;">
        </div>

        <!-- Logout Button -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <div class="wrapperbtn">
                    <button class="btn-logout logout-btn" >
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</nav>

