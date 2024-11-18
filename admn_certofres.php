<?php
    include('dashboard_sidebar_start.php');
    
    $list = $_GET['list'];

    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';

    $conn = $staffbmis->openConn();
    $staffbmis->validate_admin();
    $staffbmis->unarchive_certofres();
?>

<?php 
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
            <h1> Certificate of Residency Requests</h1>
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col">
            <form method="POST">
            <div class="input-icons" >
                <i class="fa fa-search icon"></i>
                <input type="search" class="form-control" name="keyword" value="" required="" style="border-radius: 30px;"/>
            </div>
                <button class="btn btn-success" name="search_certofres" style="width: 90px; font-size: 17px; border-radius:30px; margin-left:41.5%;">
                    Search
                </button>
                <a href="admn_certofres.php?list=<?= $list ?>" class="btn btn-info" style="width: 90px; font-size: 17px; border-radius:30px;">Reload</a>
            </form>
            <br>
        </div>
    </div>

    <br>
<?php
    $bmis->archive_certofres();
?>
    <div class="row"> 
        <div class="col-md-12"> 
            <?php 
                include('./admn_table_certofres_search.php');
            ?>
        </div>
    </div>
    
    <!-- /.container-fluid -->
    
</div>

<?php 
    include('dashboard_sidebar_end.php');
?>
