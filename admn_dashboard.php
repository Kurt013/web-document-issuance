<?php
    error_reporting(E_ALL ^ E_WARNING);
    include('classes/staff.class.php');

    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();

    $current_month = isset($_POST['month']) ? $_POST['month'] : date('n');
    $total_pending = 0;
    $total_reservations = 0;

    $total_days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, date('Y'));

    $brgyidcount = $staffbmis->count_brgyid();
    $indigencycount = $staffbmis->count_indigency();
    $clearancecount = $staffbmis->count_clearance();
    $rescertcount = $staffbmis->count_rescert();
    $bspermitcount = $staffbmis->count_bspermit();


    $staffcount = $staffbmis->count_staff();
    $staffcountm = $staffbmis->count_mstaff();
    $staffcountf = $staffbmis->count_fstaff();



        // Example: Fetch daily document issuance counts for the selected month
    // $documentIssuanceCounts = [];
    // for ($day = 1; $day <= $total_days_in_month; $day++) {
    //     $date = date('Y-m-d', strtotime(date('Y') . '-' . $current_month . '-' . $day));
    //     // You would replace this with your logic to fetch the document count for the specific day
    //     $documentIssuanceCounts[] = $staffbmis->count_documents_issued_on_date($date);
    // }

    // Pass PHP data into JavaScript
    $documentIssuanceTrendData = json_encode($documentIssuanceCounts);
    $monthLabels = [];
    for ($day = 1; $day <= $total_days_in_month; $day++) {
        $monthLabels[] = date('d', strtotime(date('Y') . '-' . $current_month . '-' . $day));
    }
    $monthLabelsJson = json_encode($monthLabels);

?>

<style> 
.card-upper-space {
    margin-top: 35px;
}

.card-row-gap {
    margin-top: 3em;
}
</style>


<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->

<div class="container-graph" style="display: flex;">
    
    
    <div class="select-wrapper">
            <form class="select-month" method="POST" action="">
                <label for="month">Select Month:</label>
                <select id="month" name="month" onchange="this.form.submit()">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = ($i == $current_month) ? 'selected' : '';
                        echo '<option value="' . $i . '" ' . $selected . '>' . date('F', mktime(0, 0, 0, $i, 10)) . '</option>';
                    }
                    ?>
                </select>
            </form>
        <canvas id="documentIssuanceTrendChart" style="width: 500px; height: 280px; display: inline-block;"></canvas>
        </div>

        <canvas id="documentTypesDistributionChart" style="width: 300px; height: 300px; display: inline-block;"></canvas>

</div>


    <div class="row"> 
    <div class="col-md-4">
        <h4> Barangay Staff Data </h4> 
        <br>

        <div class="card border-left-info shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Barangay Staffs</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $staffcount?></div>
                                <br>
                                <a href="admn_table_totalstaff.php"> View Records </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">  
            <br>
            <div class="card border-left-info shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Barangay Male Staff
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-dark"><?= $staffcountm?></div>
                            <br>
                            <a href="admn_table_malestaff.php"> View Records </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-male fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">  
            <br>
            <div class="card border-left-info shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Barangay Female Staffs</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $staffcountf?></div>
                                <br>
                                <a href="admn_table_femalestaff.php"> View Records </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<br>
<br>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dynamic Data for Document Issuance Trends (based on the current month)
const documentIssuanceTrendData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'], // Dynamic months (or days in the month)
    datasets: [{
        label: 'Total Documents Issued',
        data: [10, 20, 30, 40, 20, 20, 20, 10, 20, 30, 20], // Dynamic values from PHP
        fill: false,
        borderColor: 'rgba(75, 192, 192, 1)',
        tension: 0.1
    }]
};

// Create the line chart for document issuance trends
const ctx1 = document.getElementById('documentIssuanceTrendChart').getContext('2d');
const documentIssuanceTrendChart = new Chart(ctx1, {
    type: 'line', // 'line' chart
    data: documentIssuanceTrendData,
    options: {
        responsive: false,
        scales: {
            x: {
                beginAtZero: true
            }
        }
    }
});




// Data for Document Types Distribution (example: document types)
// Data for Document Types Distribution (using dynamic PHP data)
const documentTypesDistributionData = {
    labels: ['Certificate of Residency', 'Barangay ID', 'Business Permit', 'Barangay Clearance', 'Certificate of Indigency'],
    datasets: [{
        label: 'Documents Issued (By Types)',
        data: [<?= $rescertcount ?>, <?= $brgyidcount ?>, <?= $bspermitcount ?>, <?= $clearancecount ?>, <?= $indigencycount ?>],
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
        ],
        borderWidth: 1
    }]
};

// Create the pie chart for document types distribution
const ctx2 = document.getElementById('documentTypesDistributionChart').getContext('2d');
const documentTypesDistributionChart = new Chart(ctx2, {
    type: 'pie', // 'pie' chart
    data: documentTypesDistributionData,
    options: {
        responsive: false
    }
});

</script>
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