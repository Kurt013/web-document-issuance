<?php 
session_start();
$toast = '';
if (isset($_SESSION['toast'])) {
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']); // Clear the session after displaying
}
?>
<?php
    include('dashboard_sidebar_start.php');
    include('table_design.php');
    include('popup.php');
    include('popup-confirm.php'); 


    $list = $_GET['list'];
    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';

    $conn = $staffbmis->openConn();
    
    $staffbmis->archive_certofres();
    $staffbmis->unarchive_certofres();
?>


<!-- Begin Page Content -->
<?php if (!empty($toast)): ?>
        <?= $toast; ?>
    <?php endif; ?>
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="col text-center"> 
            <h1> Certificate of Residency Requests </h1>
        </div>
    </div>

    <hr>
    <br>
    <br>

    <div class="search-row"> 
    <div class="cols">
<form class="searchbox" method="POST">
                <div class="left-search">
                    <input class = "searchinp" placeholder="Search" name ="keyword" />
                    <div class = "btn-container">
                    <button class="searchbtn" type="submit" value="search" name="search_certofres">
                      <i class="fas fa-search"></i>
                    </button>
                    <button class="btns button-info" onclick="location.reload();">
    <i class="fa fa-sync" aria-hidden="true"></i>
</button>
</div>
</div>
<?php if ($_GET['list'] == 'archived') {?>
    <div class="custom-date-search">
    <label for="from_date" class="form-label">From:</label>
    <input type="date" class="form-control date-input" id="from_date" name="from" value="<?= isset($_POST['from']) ? date('Y-m-d', strtotime($_POST['from'])) : date('Y-m-d'); ?>">
    
    <label for="to_date" class="form-label">To:</label>
    <input type="date" class="form-control date-input" id="to_date" name="to" value="<?= isset($_POST['to']) ? date('Y-m-d', strtotime($_POST['to'])) : date('Y-m-d'); ?>">
</div>
<?php } ?>
    </form>       
        </div>
</div>


    <br>

    <div class="row"> 
        <div class="col-md-12"> 
            <?php 
                include('./admn_table_certofres_search.php');
            ?>
        </div>
    </div>
</div>



<?php 
    include('dashboard_sidebar_end.php');
?>