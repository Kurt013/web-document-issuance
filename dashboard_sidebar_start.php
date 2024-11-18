<?php 
    include 'classes/staff.class.php';

    $userdetails = $staffbmis->get_userdata();


    $brgyidcount = $staffbmis->count_brgyid();
    $indigencycount = $staffbmis->count_indigency();
    $clearancecount = $staffbmis->count_clearance();
    $rescertcount = $staffbmis->count_rescert();
    $bspermitcount = $staffbmis->count_bspermit();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Barangay Services</title>

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
        .nav-item {
            position: relative;
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
            right: 45px;
            top: 10px;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admn_dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    
                </div>
                <div class="sidebar-brand-text">Administrator Dashboard </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="admn_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                User Management
            </div>

            <!-- Barangay Staff CRUD -->
            <li class="nav-item">
                <a class="nav-link" href="admn_staff_crud.php">
                    <i class="fas fa-user-tie"></i>
                    <span>Barangay Staffs</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Barangay Services
            </div>

            <!-- Announcement Management -->
            <li class="nav-item">
                <a class="nav-link" href="admn_announcement_crud.php">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span></a>
            </li>

            <!-- Scan QR Code -->
            <li class="nav-item">
                <a class="nav-link" href="admn_scanqrcode.php">
                    <i class="fas fa-bullhorn"></i>
                    <span>QR Code Scanner</span></a>
            </li>

            <!-- Certificate of Residency -->
            <li class="nav-item">
                <a class="nav-link" href="admn_certofres.php?list=active">
                    <i class="fas fa-file-word"></i>
                    <span>Certificate of Residency</span></a>
                <span class="notif"><?= $rescertcount ?></span>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admn_brgyid.php?list=active">
                    <i class="fas fa-id-card"></i>
                    <span>Barangay ID </span></a>
                    <span class="notif"><?= $brgyidcount ?></span>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admn_bspermit.php?list=active">
                    <i class="fas fa-file-contract"></i>
                    <span>Business Permit</span></a>
                    <span class="notif"><?= $bspermitcount ?></span>
            </li>



            <!-- Barangay Clearance -->
            <li class="nav-item">
                <a class="nav-link" href="admn_brgyclearance.php?list=active">
                    <i class="fas fa-file"></i>
                    <span>Barangay Clearance</span></a>
                    <span class="notif"><?= $clearancecount ?></span>
            </li>

            <!-- Certificate of Indigency -->
            <li class="nav-item">
                <a class="nav-link" href="admn_certofindigency.php?list=active">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Certificate of Indigency</span></a>
                    <span class="notif"><?= $indigencycount ?></span>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="logout.php" id="userDropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-800 small"><?= $userdetails['surname']?>, <?= $userdetails['firstname']?></span>
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                </a>
                            </li>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                
                <!-- End of Topbar -->