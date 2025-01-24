<?php 
// Enable Output Buffering to prevent unexpected output
ob_start(); 

// Include necessary classes
include 'classes/staff.class.php';


// Fetch user details
$userdetails = $staffbmis->get_userdata();
$brgyidcount = $staffbmis->count_brgyid();
$indigencycount = $staffbmis->count_indigency();
$clearancecount = $staffbmis->count_clearance();
$rescertcount = $staffbmis->count_rescert();
$bspermitcount = $staffbmis->count_bspermit();

// Handle AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Return JSON response and exit
    echo json_encode([
        'rescertcount' => $rescertcount,
        'brgyidcount' => $brgyidcount,
        'bspermitcount' => $bspermitcount,
        'clearancecount' => $clearancecount,
        'indigencycount' => $indigencycount
    ]);
    exit; // Stop further execution for AJAX request
}

// Fetch user data for non-AJAX requests
$bmis = new BMISClass();
$user = $bmis->get_userdata();

$firstName = $user['firstname'];
$lastName = $user['surname'];
$role = $user['role'];
?>
<?php
    include('popup-confirm.php');
    include('popup.php');
    include ('view_details_design.php');

    require 'phpqrcode/qrlib.php';
    require 'vendor/autoload.php';

    $conn = $staffbmis->openConn();
    $staffbmis->validate_staff();
    $staffbmis->view_unarchive_bspermit();
    // $staffbmis->archive_bspermit();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>View Business Permit || <?= $_GET['id_bspermit']; ?></title>
        <link rel="shortcut icon" href="./assets/sinlogo.png" type="image/x-icon">
    </head>

<body>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                    <?php
// Ensure the database connection is initialized properly
// Assuming $db is your PDO connection

if (isset($_GET['id_bspermit'])) {
    $id_bspermit = $_GET['id_bspermit']; // Get the 'report_id' parameter from the URL
    $doc_status = 'archived';

    // Prepare SQL query to fetch data based on the 'report_id'
    $stmt = $conn->prepare("SELECT * FROM tbl_bspermit WHERE id_bspermit = :id_bspermit AND doc_status = :doc_status");
    $stmt->bindParam(':doc_status', $doc_status); // Bind the 'doc_status' as a string
    $stmt->bindParam(':id_bspermit', $id_bspermit); // Bind the 'report_id' as a string
    $stmt->execute();

    // Fetch the specific row (no loop)
    $row = $stmt->fetch();

    if ($row) { // Check if the row exists
?>
    <div class = "parent">
    <div class="container">
    <!-- Issuance Information -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label class = "biglabel">Issuance No.</label>
                <input class="form-control issueno" type="text" value="<?php echo htmlspecialchars($row['id_bspermit']); ?>" readonly>
            </div>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-4">
            <div class="form-group">
                <label>First Name</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['fname']); ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['lname']); ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['mi']); ?>" readonly>
            </div>
        </div>
    </div>

    
    <h5>Address</h5>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label>House Number</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['bshouseno']); ?>" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Street</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['bsstreet']); ?>" readonly>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label>Barangay</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['bsbrgy']); ?>" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>City</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['bscity']); ?>" readonly>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label>Municipality</label>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['bsmunicipality']); ?>" readonly>
            </div>
        </div>
    </div>

    <!-- Business Information -->
    <h5>Business Information</h5>
<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label>Business Name</label>
            <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['bsname']); ?>" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Business Industry</label>
            <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['bsindustry']); ?>" readonly>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label>Area of Establishment</label>
            <input class="form-control" type="text" value="<?php echo htmlspecialchars($row['aoe']); ?>" readonly>
        </div>
    </div>
</div>

<!-- delete payment -->


            
        <?php
    } else {
        // If no data found for the given ID
        echo "No data found for the given ID.";
    }
} else {
    // If the 'id' parameter is missing from the URL
    echo "ID parameter is missing.";
}
?>

                    </div>
                    <form id="archiveForm" action="" method="post">
            <div class="button-dtls text-center">
                <input type="hidden" name="id" value="<?= $userdetails['firstname']; ?> <?= $userdetails['surname'];?>">
                <input type="hidden" name="id_bspermit" value="<?= $row['id_bspermit'];?>">
                <button type="submit" id="hiddenSubmitBtn" style="display:none;" name="unarchive_bspermit">Submit</button>
                
         
   

    <a>
    <button class="btn btn-danger retrieve-btn archive-btn" type="button" style="width: 70px; font-size: 17px;" title = "Retrieve" name="unarchive_bspermit">  <i class="fas fa-undo"></i>
    </button>
    
            </div>
        </form>
                </div>
                
            </div>

            
</div>

     <script>
document.addEventListener("DOMContentLoaded", () => {
    // Get the single archive button
    const archiveBtn = document.querySelector('.archive-btn');
    
    // Get popup and other necessary elements
    const popup = document.getElementById('popup-retrieve');
    const confirmBtn = document.getElementById('confirm-btn-ret');
    const cancelBtn = document.getElementById('cancel-btn-ret');
    const archiveForm = document.getElementById('archiveForm');
    const hiddenSubmitBtn = document.getElementById('hiddenSubmitBtn'); // Hidden submit button

    // Add event listener to the archive button
    archiveBtn.addEventListener('click', function () {
        // Get the data ID from the input field inside the form
        const dataId = document.querySelector('input[name="id_bspermit"]').value;
        // Set the ID in the form
        archiveForm.querySelector('input[name="id_bspermit"]').value = dataId;

        // Show the popup
        popup.classList.remove('hidden');
    });

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden'); // Hide the popup when cancel is clicked
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        // Trigger the hidden submit button
        hiddenSubmitBtn.click(); // Programmatically click the hidden submit button
        
        // Hide the popup after submission
        popup.classList.add('hidden');
    });
});


</script>
</body>


<!-- add-appointment24:07-->
</html>