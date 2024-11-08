<?php
    
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors',0);
    require('classes/resident.class.php');

    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';

    if (isset($_POST['accept_clearance'])) {
        $id_clearance = $_POST['id_clearance'];
        $id_resident = $_POST['id_resident'];

        $link = 'brgyclearance_form.php?id_resident='.$id_resident;

        $qrImage = $bmis->generateQRCode($link);
        $bmis->sendEmailWithQRCode($qrImage, $id_resident);
    }

    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $bmis->delete_clearance();
    $bmis->accept_clearance();
    $bmis->archive_clearance();
   
?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<style>
    .input-icons i {
        position: absolute;
    }
        
    .input-icons {
        width: 30%;
        margin-bottom: 10px;
        margin-left: 34%;
    }
        
    .icon {
        padding: 10px;
        min-width: 40px;
    }
    .form-control{
        text-align: center;
    }
</style>

    <!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="col text-center"> 
            <h1> Barangay Clearance Requests</h1>
        </div>
    </div>

    <hr>
    <br>
    <br>

    <div class="row"> 
        <div class="col">
            <form method="POST">
            <div class="input-icons" >
                <i class="fa fa-search icon"></i>
                <input type="search" class="form-control" style="border-radius: 30px;" name="keyword" value="" required=""/>
            </div>
                <button class="btn btn-success" name="search_clearance" style="width: 90px; font-size: 18px; border-radius:30px; margin-left:41.5%;">Search</button>
                <a href="admn_brgyclearance.php" class="btn btn-info" style="width: 90px; font-size: 18px; border-radius:30px;">Reload</a>
            
            </form>
            <br>
        </div>
    </div>

    <br>

    <div class="row"> 
        <div class="col"> 
            <?php 
                include('admn_brgyclearance_search.php');
            ?>
        </div>
    </div>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->


