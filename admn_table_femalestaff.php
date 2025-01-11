<?php    
   include('dashboard_sidebar_start.php');

    $conn = $staffbmis->openConn();
    $bmis->validate_admin();

   $view = $staffbmis->view_staff_female();

?>

<style>
table {
    width: auto; /* Let the table size itself based on content */
    table-layout: auto; /* Cells adjust to their content */
    border-collapse: collapse; /* Neat borders */
   
}

/* Table cell styles */
th, td {
    padding: 10px; /* Add some space around content */
    text-align: center; /* Center text horizontally */
    vertical-align: middle; /* Center text vertically */
    border: 1px solid #ddd; /* Add borders for clarity */
    white-space: nowrap; /* Prevent text from wrapping */
}

td {
    border: 2px solid white !important; /* Thicker border with custom color */
}

/* General container adjustments */
.container-fluid {
    width: 100%; /* Ensure it spans the full width */
    overflow: visible !important; /* Prevent it from scrolling on its own */
}

/* Table Header */
th {
    background-color: #014bae;
    color: white;
    text-align: center; /* Horizontal alignment */
    vertical-align: middle !important; /* Vertical alignment */
    border: 2px solid white !important; /* Thicker border with custom color */
    padding: 15px;
    font-size: 1rem;
    font-family: "PSemiBold" !important;
    height: 60px; /* Adjust as needed to make the header row taller */
}

/* Table Rows */
td {
    text-align: center;
    padding: 20px;
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
            <h1> Barangay Female Staff Table</h1>
        </div>
    </div>

    <hr>
    <br>
    <br>

    <div class="row"> 
        <div class="col-md-12">
            <form method="POST" action="">
                <div class="input-icons" >
                    <i class="fa fa-search icon"></i>
                    <input type="search" class="form-control" style="border-radius:30px;" name="keyword" value="" required=""/>
                </div>
                <div class="button-container">
                    <button class="btns btn-success" name="search_totalstaff">Search</button>
                    <button class="btns btn-info" onclick="window.location.href = 'admn_table_femalestaff.php'">Reload</button>
                </div>
            </form>
        </div>
    </div>
    
    <br><br>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php 
                include('admn_table_femalestaff_search.php');
            ?>
        </div>
        <div class="col-md-1"></div>
    </div>

    
    <!-- /.container-fluid -->
    
</div>

<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css --> 
<link href="../BarangaySystem/customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

<?php 
    include('dashboard_sidebar_end.php');
?>
