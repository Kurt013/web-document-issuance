<?php
    include('dashboard_sidebar_start.php');

    $list = $_GET['list'];

    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';

    $conn = $staffbmis->openConn();
    $staffbmis->validate_admin();
    $staffbmis->archive_bspermit();
    $staffbmis->unarchive_bspermit();
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
            <h1> Business Permit Requests</h1>
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
                    <input type="search" class="form-control" name="keyword" value="" style="border-radius: 30px;" required=""/>
                </div>
                <button class="btn btn-success" name="search_bspermit" style="width: 90px; font-size: 18px; border-radius:30px; margin-left:41.5%;">Search</button>
                <a href="admn_bspermit.php?list=<?= $list ?>" class="btn btn-info" style="width: 90px; font-size: 18px; border-radius:30px;">Reload</a>
            </form>
            <br>
        </div>
    </div>

    <br>

    <div class="row"> 
        <div class="col-md-12"> 
            <?php 
                include('admn_bspermit_search.php');
            ?>
        </div>
    </div>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->
<?php 
    include('dashboard_sidebar_end.php');
?>
