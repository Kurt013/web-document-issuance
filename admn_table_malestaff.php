<?php
    include('dashboard_sidebar_start.php');
    include('table_design.php');
    include('popup-confirm.php');
    include('logout_script.php');

    $conn = $staffbmis->openConn();
    $bmis->validate_admin();

   $view = $staffbmis->view_staff_male();
   
?>

<!-- Begin Page Content -->

<div class="container-fluid" style = "margin-bottom: 100px !important">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="col text-center"> 
            <h1> Barangay Male Staff Records</h1>
        </div>
    </div>

    <hr>
    <br><br>

    <div class="search-row"> 
    <div class="cols">
<form class="searchbox" method="POST">
                <div class="left-search">
                    <input class = "searchinp" placeholder="Search" name ="keyword" />
                    <div class = "btn-container">
                    <button class="searchbtn" type="submit" value="search" name="search_totalstaff">
                      <i class="fas fa-search"></i>
                    </button>
                    <button class="btns button-info" onclick="location.reload();">
    <i class="fa fa-sync" aria-hidden="true"></i>
</button>
</div>
</div>
    </form>       
        </div>
</div>

    <br>

    <div class="row"> 
        <div class="col"> 
            <?php 
                include('admn_table_malestaff_search.php');
            ?>
        </div>
    </div>
    
</div>


<?php 
    include('dashboard_sidebar_end.php');
?>
