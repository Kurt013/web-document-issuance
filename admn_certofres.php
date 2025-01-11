<?php
    include('dashboard_sidebar_start.php');
    
    $list = $_GET['list'];

    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';


    $conn = $staffbmis->openConn();
    $staffbmis->unarchive_certofres();
    $staffbmis->archive_certofres();

?>
  <?php include('popup.php'); ?>
<style>


table {
      width: 100%;
      border-collapse: collapse;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      border-bottom: 5px solid #014bae !important;
    }

    th {
      background-color: #014bae;
      color: white;
      text-align: middle;
      font-family: "PMedium";
      vertical-align: middle; /* Align text vertically in the center */
      font-weight: normal;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;  
      border: none !important; /* Remove cell borders */
    }

    td {
        color: #012049;
    }

    td {
        font-family: "PRegular";
    }

    tbody tr:nth-child(even) {
      background-color: #e5fdff;
    }

    tbody tr:hover {
      background-color: #f0f0f0;
    }

    .container-fluid {
    width: 100%; /* Ensure it spans the full width */
    overflow: visible !important; /* Prevent it from scrolling on its own */
    }

/* Table Header */


.row h1 {
    color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
        
            letter-spacing: 3px;
            margin-top: 30px;
            
            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
}

.btn-success {
    background-color: #28a745;
    font-size: 0.9rem !important;
    border: none;
    vertical-align: middle;
    font-family: "PSemiBold";
}

.btn-danger {
    font-size: 0.9rem !important;
    border: none;
    margin-bottom: 3px !important;
    font-family: "PSemiBold";

}

</style>

<style>
.input-icons {
    width: 100%; /* Ensures the container spans full width */
    max-width: 600px; /* Adjust to control container width */
    margin: 0 auto; /* Centers the container horizontally */
    position: relative; /* Needed to position the icon */
}

.icon {
    position: absolute; /* Positions the icon relative to the container */
    left: 15px; /* Aligns the icon within the input */
    top: 50%; /* Centers the icon vertically */
    transform: translateY(-50%); /* Adjusts vertical alignment */
    color: #012049;
    font-size: 18px; /* Adjust icon size */
}

.form-control {
    width: 100%; /* Ensures input spans full width of its container */
    padding-left: 50px; /* Adds space for the icon */
    height: 50px; /* Adjust height as needed */
    border: 3px solid #012049;
    border-radius: 30px; /* Rounds the corners */
    color: black;
    font-size: 1rem;
    font-family: "PMedium";
    box-sizing: border-box; /* Includes padding in width */
}


    .button-container {
    display: flex;
    justify-content: center; /* Aligns buttons horizontally at the center */
    gap: 10px; /* Adds space between the buttons */
    margin-top: 20px; /* Optional: Adds spacing above the buttons */
}


    .btns {
    background-color: #2c91c9;
    font-size: 0.95rem !important;
    border: none;
    border-radius: 20px;
    padding: 8px 20px;
    font-family: "PSemiBold";
    }

    .btns:hover {
        background-color: #014bae;
    }

    .form-control:focus {
        color: black;
        font-family: "PMedium";

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
    <hr>
    <br><br>

    <div class="row">
        <div class="col">
            <form method="POST">
            <div class="input-icons" >
                <i class="fa fa-search icon"></i>
                <input type="search" class="form-control" name="keyword" value="" required="" style="border-radius: 30px;"/>
            </div>
            <div class="button-container">
    <button class="btns btn-success" name="search_certofres">
        Search
    </button>
    <button class="btns btn-info" onclick="window.location.href='admn_certofres.php?list=<?= $list ?>'">
        Reload
    </button>
</div>

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

<?php 
    include('dashboard_sidebar_end.php');
?>
