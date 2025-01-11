<style>

    .card-header, .card-header2 {
        background-color: #014bae !important;
        font-family: "PBold";
        font-size : 1.2rem;
        color: white;
    }


    
    th, td {
    padding: 10px; /* Add some space around content */
    text-align: center; /* Center text horizontally */
    vertical-align: middle; /* Center text vertically */
    border: 1px solid #ddd; /* Add borders for clarity */

}

td {
    border: 2px solid white !important; /* Thicker border with custom color */
}

.btn-danger {
    font-family: "PSemiBold";
    padding: 5px 10px !important;
}

th {
    background-color: #2c91c9;
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

.col-md-12 h1 {
    color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
        
            letter-spacing: 3px;
            margin-top: 20px;

            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
  }

.btn-primary {
    font-family: "PSemiBold";
    background-color: #2c91c9 !important;
}

.card {
    border: 2px solid #014bae !important;
   
}

.row h6 {
    font-family: "PSemiBold";
    color: #014bae;
}

.form-control {
    border: 2px solid #014bae !important;
    font-family: "PMedium";
    color: #014bae !important;
}




</style>

<?php
    include('dashboard_sidebar_start.php');

   $staffbmis->create_announcement();
   $staffbmis->delete_announcement();
   $view = $staffbmis->view_announcement();
   $announcementcount = $staffbmis->count_announcement();

   $dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
   $tm = new DateTime("now", new DateTimeZone('Asia/Manila'));
   $cdate = $dt->format('Y/m/d');   
   $ctime = $tm->format('H');

?>
<?php
$toastdelete = '';
if (isset($_SESSION['toast'])) {
    $toastdelete = $_SESSION['toast'];
    unset($_SESSION['toast']); // Clear the session after displaying
}

// Check for the toast message in the session
$toast = '';
if (isset($_SESSION['toast'])) {
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']); // Clear the session after displaying
}
?>


<?php 
?>

<!-- Begin Page Content -->

<div class="container">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="col-md-12"> 
            <h1 class="mb-4 text-center">Event Announcement Page</h1>
        </div>
    </div>

    <hr>

    <br>
      
    <div class="row"> 
        <div class="col-sm-6"> 
            <div class="card">
                <div class="card-header"> Event Announcement Form </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row"> 
                            <div class="col">
                                <h6>
                                    <i class="fas fa-bullhorn"></i>
                                    Announcement Message
                                </h6>
                                <br>
                                <textarea name="event" class="form-control" rows="6" placeholder="Enter Message Here"></textarea>
                            </div>
                        </div>

                        <br>
                        <hr>

                        <div class="row"> 
                            <div class="col"> 
                                <input name="created_by" type="hidden" value="<?= $userdetails['id'] ?>">
                                <button type="submit" name="create_announce" class="btn btn-primary" style="margin-left: 34%; border-radius: 15px; width: 150px; font-size: 18px;"> Submit Entry </button>
                            </div>
                        </div>       
                    </form>
                </div>
            </div>
        </div>
        <?php if (!empty($toast)): ?>
        <?= $toast; ?>
    <?php endif; ?>

    <?php if (!empty($toastdelete)): ?>
        <?= $toastdelete; ?>
    <?php endif; ?>
        <div class="col-sm-6"> 
            <div class="card">
                <div class="card-header"> Current Announcement Posted </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered table-responsive text-center">
                        <form action="" method="post">
                            <thead class="alert-info"> 
                                <tr>
                                    <th> Actions </th>
                                    <th> Announcement </th>
                                    <th> Date Posted </th>
                                    <th> Added By </th>        
                                </tr>
                            </thead>
                            <tbody> 
                                <?php if(is_array($view)) {?>
                                    <?php foreach($view as $view) {?>
                                        <tr>
                                            <td>    
                                                <form action="" method="post">
                                                    <input type="hidden" name="id_announcement" value="<?= $view['id_announcement'];?>">
                                                    <button class="btn btn-danger" type="submit" name="delete_announcement"> Remove </button>
                                                </form>
                                            </td>
                                            <td> <?= $view['event'];?> </td>
                                            <td> <?= $view['created_date'];?> </td>
                                            <td style="text-transform: capitalize;"> <?= $view['fname'];?> <?= $view['mi'];?>. <?= $view['lname'];?></td>              
                                        </tr>
                                    <?php }?>
                                <?php } ?>
                            </tbody>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br><br>

 
    <?php include('popup.php'); ?>
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
