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
    include('popup-toast.php');

    $list = $_GET['list'];
    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';

    $conn = $staffbmis->openConn();
    
    $staffbmis->archive_certofres();
    $staffbmis->unarchive_certofres();
?>

<style>

.dataTable {
    width: 100% !important;
    border-collapse: collapse; /* Neat borders */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    border-top: 7px solid #014bae !important;
    border-radius: 7px !important;
    border-bottom: 7px solid #014bae !important;
   
   
}

.dataTables_info, label  {
    font-family: "PMedium";
    font-size: 1rem;
    color: #012049 !important; 
}

.dataTables_paginate {
    font-family: "PMedium";
    font-size: 1rem;
    color: #014bae !important; 
    padding: .3em 0.8em !important;
}
.paginate_button.current {

    border: 2px solid #014bae !important;
    color: white !important;
  
}



.paginate_button:hover {
background: #014bae !important;
border: none !important;
transform: none !important;
transition: none !important;

  
}

.paginate_button {
background: #014bae;

  
}

.paginate_button.previous.disabled:hover {
background: transparent !important;
border: 0 !important;
}

.paginate_button.previous.disabled{
background: transparent !important;
border: 0 !important;
}

.paginate_button.next.disabled:hover {
background: transparent !important;
border: 0 !important;

}

.paginate_button.next.disabled {
background: transparent !important;
border: 0 !important;

}

.paginate_button.current:hover {
    
    border: 2px solid #014bae !important;
    background: transparent !important;

 
  
}

select {
    padding: 2px !important;
    z-index: 2 !important;
    border-radius: 5px;
    border: 2px solid #012049 !important;
    padding: 0 5px !important;
    cursor: pointer !important;
}
/* Table cell styles */
th, td {

    text-align: center; /* Center text horizontally */
    vertical-align: middle; /* Center text vertically */

}

td {
    border: none !important; /* Thicker border with custom color */
}

/* General container adjustments */
.container-fluid {
    width: 100%; /* Ensure it spans the full width */
    overflow: visible !important; /* Prevent it from scrolling on its own */
}

.dataTables_wrapper {
    z-index: 1 !important;
    
}

/* Table Header */
th {
    background-color: #014bae;
    color: white;
    text-align: center !important; /* Horizontal alignment */
    vertical-align: middle !important; /* Vertical alignment */
    border: none !important; /* Thicker border with custom color */
    font-size: 1rem;
    font-family: "PSemiBold" !important;
    height: 30px; /* Adjust as needed to make the header row taller */
    
}

/* Table Rows */
td {
    text-align: center;
    padding: 5px !important;
    vertical-align: middle !important;
    font-family: "PRegular" !important;
    font-size: 0.9rem;
    color: #333;
    border-bottom: 1px solid #ddd;
}

.row h1 {
    color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
            margin-top: 30px;
            letter-spacing: 3px;

            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
}

.btn-success {
    background-color: #28a745	;
    font-size: 0.9rem !important;
    border: none;
    font-family: "PSemiBold";
    vertical-align: middle;
}

.btn-danger {
    font-size: 0.9rem !important;
    border: none;
    font-family: "PSemiBold";
    margin-bottom: 3px !important;

}

/* Alternate Row Colors */
tr:nth-child(even) {
    background-color: #e7f3ff;
}

/* Hover Effect */
tr:hover {
    background-color: #e6f7ff;
    transition: background-color 0.3s ease-in-out;
}

/* Responsive Table */
@media (max-width: 768px) {
    table {
        font-size: 0.8rem;
    }
    th, td {
        padding: 10px;
    }
}
</style>

<style>


    .searchbox{
        display: flex; /* Aligns input and button in a row */
        flex-wrap: wrap;
        row-gap: 10px;
    align-items: center; /* Vertical alignment */
    justify-content: space-between; /* Space between input and button */
    background: #014bae;
    padding:13px;
    width:500px;
    margin:20px auto;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
    box-sizing:border-box;
    border-radius:6px;
    -webkit-box-shadow: 
    0 2px 4px 0 rgba(1, 75, 174, 0.83),
    0 10px 15px 0 rgba(1, 75, 174, 0.12),
    0 -2px 6px 1px rgba(1, 75, 174, 0.55) inset, 
    0 2px 4px 2px rgba(1, 75, 174, 0.83) inset;
-moz-box-shadow: 
    0 2px 4px 0 rgba(1, 75, 174, 0.83),
    0 10px 15px 0 rgba(1, 75, 174, 0.12),
    0 -2px 6px 1px rgba(1, 75, 174, 0.55) inset, 
    0 2px 4px 2px rgba(1, 75, 174, 0.83) inset;
box-shadow: 
    0 2px 4px 0 rgba(1, 75, 174, 0.83),
    0 10px 15px 0 rgba(1, 75, 174, 0.12),
    0 -2px 6px 1px rgba(1, 75, 174, 0.55) inset, 
    0 2px 4px 2px rgba(1, 75, 174, 0.83) inset;
}

.left-search {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}


.right-search {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.right-search label {
    margin: 0;
    font-family: "PRegular";
    font-size: 1rem;
    color:white !important;
}

.searchinp{
    width: calc(100% - 45px);
    height:40px;
    padding-left:15px;
    border-radius:6px;
    box-sizing: border-box;
    border:none;
    color:#939393;
    font-weight:500;
    background-color:#fffbf8;
    -webkit-box-shadow:
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
    -moz-box-shadow: 
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
    box-shadow:
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
}
.searchbtn, .reloadbtn {
    width:40px;
    height:40px;
    border:none;
    cursor:pointer;
    padding: 0 5px !important;
    background-color: transparent;
    color: white !important;
}
.searchinp:focus{
    outline:0;
    color: black;
    font-family: "PRegular";
}
.searchinp::placeholder {
    font-family: "PRegular";
}
.fa-search {
    color: white;
    font-size: 1.1rem;
}



</style>


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

    <div class="row"> 
        <div class="col">

<form class="searchbox" method="POST">
                <div class="left-search">
                    <input class = "searchinp" placeholder="Search" name ="keyword" />
                    <button class="searchbtn" type="submit" value="search" name="search_certofres">
                      <i class="fas fa-search"></i>
                    </button>
                </div>
<?php if ($_GET['list'] == 'archived') {?>
    <div class="right-search">
        <div class="row">
            <div class="col-md-6">
                <label for="from_date" class="form-label">From:</label>
                <input type="date" class="form-control" id="from_date" name="from" value="<?= isset($_POST['from']) ? date('Y-m-d', strtotime($_POST['from'])) : date('Y-m-d'); ?>">
            </div>
            <div class="col-md-6">
                <label for="to_date" class="form-label">To:</label>
                <input type="date" class="form-control" id="to_date" name="to" value="<?= isset($_POST['to']) ? date('Y-m-d', strtotime($_POST['to'])) : date('Y-m-d'); ?>">
            </div>
        </div>
    </div>

<?php } ?>

    </form>                     
            
            <br>
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
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->



<?php 
    include('dashboard_sidebar_end.php');
?>