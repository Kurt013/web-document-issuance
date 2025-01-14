<?php
    include('dashboard_sidebar_start.php');

    $current_month = isset($_POST['month']) ? $_POST['month'] : date('n');
    $total_pending = 0;
    $total_reservations = 0;

    $total_days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, date('Y'));

    $staffcount = $staffbmis->count_staff();
    $staffcountm = $staffbmis->count_mstaff();
    $staffcountf = $staffbmis->count_fstaff();

    $total_pending = $staffbmis->count_total_day();
    $totalDailyEarnings = $staffbmis->getDailyEarnings();


   // Fetch document issuance counts for each month from January to the selected month
    $documentIssuanceCounts = [];
    $monthLabels = [];

    for ($month = 1; $month <= $current_month; $month++) {
        // Generate month labels (e.g., January, February)
        $monthLabels[] = date('F', mktime(0, 0, 0, $month, 10));
        
        // Fetch document issuance count for the entire month of the current year
        $startDate = date('Y-m-d', strtotime(date('Y') . '-' . $month . '-01'));
        $endDate = date('Y-m-t', strtotime($startDate)); // Last day of the month
        $documentIssuanceCounts[] = $staffbmis->count_documents_issued_in_month($startDate, $endDate);
    }

    // Encode labels and data to JSON for JavaScript
    $monthLabelsJson = json_encode($monthLabels);
    $documentIssuanceTrendDataJson = json_encode($documentIssuanceCounts);


?>
<head>

<style> 


/* General container styling */
.container-fluid {
    display: flex;
    padding: 0 30px;
    flex-wrap: wrap; /* Allow cards to wrap if necessary */
    
 
   
    background-color: #f8f9fc;

}

/* Headings */
h4 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    font-weight: bold;
    width: 100%;
    color: #012049;
    font-family: "PBold";
}

/* Card body styling */
.card-body {
    display: flex;
   
    align-items: center;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-left: 10px solid #014bae;
    background-color: #f9f9f9;
    padding: 20px;
    width: 100%;
    margin-top: 20px;

    box-sizing: border-box; /* Include padding and border in width calculation */
}

/* Inner columns in the cards */
.card-body .col {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card-body .col div:first-child {
    font-size: 1rem;
    color: #014bae;
    font-family: 'PMedium';
}

.card-body .col div:nth-child(2) {
    font-size: 1.5rem;
    font-weight: bold;
    color: red;
}

.card-body a {
    text-decoration: none;
    color: green;
    margin-top: 10px;
    font-size: 0.9rem;
}

/* Icons */
.card-body .col-auto {
    font-size: 2.5rem;
    color: #4e73df;
}

.col-md-4 {
  
    min-width: 20%;
    flex-wrap: wrap;
    



}

.row {
    display: flex;          
    flex-wrap: wrap;      
    align-items: flex-start; 
    margin-top: 10px;
   
}

body{

    background:#FAFAFA;
    
}
.order-card {
    color: #fff;
}

.card-block h6 {
    font-family: 'PBold';
    font-size: 1.2rem;

}

.card-block h2 {
    font-family: 'PBold';
    font-size: 2rem;

}

.card-block a {
    font-family: 'PBold';
    font-size: 0.8rem;
    color: white;
}

.card-block a:hover {
    font-family: 'PBold';
    font-size: 0.8rem;
    color: white;
}

.bg-c-blue1 {
   
    background: #6fd974;  /* fallback for old browsers */


}

.bg-c-blue2 {
    background: #00aff0;  /* fallback for old browsers */

}

.bg-c-blue3 {
    background: #ff5275;  /* fallback for old browsers */


}

.bg-c-blue4 {
    background: linear-gradient(to right, #014bae, #00aff0);  /* fallback for old browsers */


}




.card {
    
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    width: 100%;
    
}

.card .card-block {
    padding: 25px;

    
}

.card-block .btn {
    background-color: transparent;
    border: 2px solid white;
    border-radius: 20px;
    color: white;
    font-family: 'PBold';
    font-size: 0.9rem;
    padding: 5px;
    width: 100%;

}


.card-block .btn1:hover {
    background-color: white;
    color: #6fd974;
}
.card-block .btn2:hover {
    background-color: white;
    color: #00aff0;
}
.card-block .btn3:hover {
    background-color: white;
    color: #ff5275;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}
.form-buttons {
    display: flex; /* Aligns items in a row */
    gap: 10px; /* Adds space between the buttons */
    align-items: center; /* Ensures buttons align vertically */
    margin-left: auto; /* Pushes the buttons to the right side of the container */
    width: 100%;
}

.form-buttons form {
    margin: 0; /* Removes default margins from forms */
}

.btnexpex, .btnexpdf {
    padding: 5px 15px; /* Adjust padding to control size */
    font-size: 1rem; /* Adjusts font size for better fit */
    border: 2px solid #012049; /* Adds a border */
    border-radius: 5px; /* Rounds button corners */
    background-color: white; /* Sets button background */
    font-family: "PSemiBold", sans-serif; /* Ensures a clean font style */
    cursor: pointer; /* Changes cursor to pointer on hover */
    white-space: nowrap; /* Prevents text from wrapping */
    width: fit-content; /* Makes button width adjust to content */
    height: auto; /* Allows natural height */
    text-align: center; /* Centers text within buttons */
}

.btnexpex {
    color: #388E3C;
    border: 2px solid #388E3C; 
}

.btnexpdf {
    color: #D32F2F;
    border: 2px solid #D32F2F; 
}

.btnexpex i,.btnexpdf i {
    margin-right: 5px; /* Adds spacing between icon and text */

}

.btnexpex:hover {
    background-color: #388E3C; /* Darker background on hover */
    color: white; /* White text on hover */
}

.btnexpdf:hover {
    background-color: #D32F2F; /* Darker background on hover */
    color: white; /* White text on hover */
}


/* Responsive layout for tablets */
@media (max-width: 992px) {
    .card-body {
        flex: 1 1 calc(45% - 20px); /* Two cards per row on tablet screens */
    }
}

/* Responsive layout for mobile */
@media (max-width: 768px) {
    .container-fluid {
        flex-direction: column;
        align-items: center;
    }

    .card-body {
        flex: 1 1 100%; /* Full width on mobile */
        max-width: 100%;
        height: auto; /* Let the height adjust for smaller screens */
        margin-bottom: 20px; /* Add space between cards on mobile */
    }

    .card-body .col-auto {
        margin-top: 15px;
        font-size: 2rem;
    }
}
.card-upper-space {
    margin-top: 35px;
}

.card-row-gap {
    margin-top: 3em;
}

.form-label {
         
         font-size: 1rem;
         color: #012049;
         font-family: "PSemiBold";
         text-align: left;
     }

     .form-controldoc  {
            font-family: "PMedium";
            font-size: 1rem;
            border-radius: 5px;
            border: 2px solid #012049;
        
            cursor: pointer;
            width: 30%;
            
            text-align: center;
            margin-bottom: 10px;
            color: #012049;
          
            
        }


</style>
    </head>



<div class="container-fluid">


<!-- Page Heading -->

<div class="container-graph" style="display: flex;">
    
    
    <div class="select-wrapper">
            <form class="select-month" method="POST" action="">
                <label for="month" class = "form-label">Select Month:</label>
                <select class = "form-controldoc" id="month" name="month" onchange="this.form.submit()">
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

        <canvas id="documentTypesDistributionChart" style="margin-left: 20px; width: 500px; height: 300px; display: inline-block;"></canvas>

        <div class="price-stats" style="display: flex; justify-content: center; margin-left: 20px;">
            <div class="card bg-c-blue3 order-card" style = "border-radius: 20px 20px 20px 0;">
                <div class="card-block">
                    <h6 class="m-b-20 text-left">Daily Earnings</h6>
                    <h2 class="text-left">₱ <?= $totalDailyEarnings ?></h2>
                </div>
            </div>
        </div>

    </div>




<div class="row w-100" style="flex-grow: 1;"> 
<div class="col-md-3">
            <div class="card bg-c-blue4 order-card" style = "border-radius: 20px 20px 20px 0;">
            <div class="card-block">
                    <h6 class="m-b-20 text-left">Total Daily Requests</h6>
                    <h2 class="text-right"><i class="fa fa-file-alt f-left"></i></i><span><?= $total_pending ?></span></h2>
                   
                
                </div>
            </div>
        </div>


    <?php if ($userdetails['role'] === 'administrator') { ?>
<div class="col-md-3">
            <div class="card bg-c-blue1 order-card">
            <div class="card-block">
                    <h6 class="m-b-20">Total Staff</h6>
                    <h2 class="text-right"><i class="fas fa-user-friends f-left"></i></i><span><?= $staffcount ?></span></h2>
                    <button class="btn btn1" onclick="window.location.href='admn_table_totalstaff.php'">View Records</button>
                
                </div>
            </div>
        </div>
               
   
    <div class="col-md-3">
            <div class="card bg-c-blue2 order-card">
            <div class="card-block">
                    <h6 class="m-b-20">Total Male Staff</h6>
                    <h2 class="text-right"><i class="fas fa-male f-left"></i></i><span><?= $staffcountm ?></span></h2>
                    <button class="btn btn2" onclick="window.location.href='admn_table_malestaff.php'">View Records</button>
                
                </div>
            </div>
        </div>
           
    <div class="col-md-3">
            <div class="card bg-c-blue3 order-card">
            <div class="card-block">
                    <h6 class="m-b-20">Total Female Staff</h6>
                    <h2 class="text-right"><i class="fas fa-female f-left"></i></i><span><?= $staffcountf ?></span></h2>
                    <button class="btn btn3" onclick="window.location.href='admn_table_femalestaff.php'">View Records</button>
                
                </div>
            </div>
                </div>
    <?php } ?>

    <form method="POST" action="./export_dashboard_pdf.php" class="form-buttons" target="_blank">
    <button class="btnexpdf" name="exportToPDF">
        <i class="fas fa-file-pdf"></i> Export to PDF
    </button>
    </form>

    <form method="POST" action="./export_dashboard_excel.php" class="form-buttons" target="_blank">
    <button class="btnexpex" name="exportToExcel">
        <i class="fas fa-file-excel"></i> Export to Excel
    </button>
    </form>

        

</div>

</div>
              
<!-- End of Main Content -->

<br>
<br>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dynamic Data for Document Issuance Trends (based on the current month)
const documentIssuanceTrendData = {
    labels: <?= $monthLabelsJson ?>,
    datasets: [{
        label: 'Total Documents Issued',
        data: <?= $documentIssuanceTrendDataJson ?>,
        fill: false,
        borderColor: '#00aff0',
        tension: 0.1,
        backgroundColor: '#00aff0',
        pointBorderColor: '#00aff0',
        pointBackgroundColor: '#fff',
        pointBorderWidth: 2,
    }]
};

// Create the line chart for document issuance trends
const ctx1 = document.getElementById('documentIssuanceTrendChart').getContext('2d');
const documentIssuanceTrendChart = new Chart(ctx1, {
    type: 'line', // 'line' chart
    data: documentIssuanceTrendData,
    options: {
        responsive: false,
        plugins: {
            legend: {
                onClick: (e) => e.stopPropagation(),
                display: true,
              
                labels: {
                    color: '#012049', // Change legend text color
                    font: {
                        family: 'PSemiBold', // Custom font
                        size: 15, // Font size
                        weight: 'bold' // Font weight
                    }
                }
            },
            title: {
                display: true,
                text: 'Document Issuance Trends',
                color: '#012049',
                font: {
                    family: 'PBold',
                    size: 18,
                    weight: 'bold'
                }
            }
        },
        
        scales: {
            x: {
                ticks: {
                    color: '#012049',
                    font: {
                        family: 'PMedium',
                        size: 12
                    }
                },
                grid: {
                    color: 'rgba(1, 32, 73, 0.5)', // Light gray for x-axis grid lines
                    lineWidth: 1.5, // X-axis grid line thickness
                    drawBorder: false // Remove the border on the x-axis
                }
            },
            y: {
                beginAtZero: true, // Start from 0
                ticks: {
                    color: '#012049',
                    font: {
                        family: 'PMedium',
                        size: 12
                    },
                     // Ensure only whole numbers are displayed
                     callback: function(value) {
                        return Number.isInteger(value) ? value : null;
                    },
                    stepSize: 1
                },
                grid: {
                    color: 'rgba(1, 32, 73, 0.5)', // Light gray for y-axis grid lines
                    lineWidth: 1.5, // Y-axis grid line thickness
                    drawBorder: false // Remove the border on the y-axis
                },
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
            '#00aff0', // Certificate of Indigency
            '#6fd974', // Barangay Clearance
            '#fd8524', // Business Permit
            '#fec107', // Barangay ID
            '#ff5275'  // Certificate of Residency
        ],
        borderColor: [
            '#00aff0', // Certificate of Indigency
            '#6fd974', // Barangay Clearance
            '#fd8524', // Business Permit
            '#fec107', // Barangay ID
            '#ff5275'  // Certificate of Residency
        ],
        borderWidth: 2 // Slightly thicker borders for better visibility
    }]
};

// Create the pie chart for document types distribution
const ctx2 = document.getElementById('documentTypesDistributionChart').getContext('2d');

const documentTypesDistributionChart = new Chart(ctx2, {
    type: 'pie',
    data: documentTypesDistributionData,
    options: {
        responsive: false,
        plugins: {
            legend: {
                onClick: (e) => e.stopPropagation(),
                display: true,
                position: 'right', 
            
                labels: {
                    color: '#012049', // Text color for legend items
                    font: {
                        family: 'PMedium', // Custom font
                        size: 14, // Font size for legend
            
                    }
                }
            },
            title: {
                display: true,
                text: 'Distribution of Document Types Issued',
                color: '#012049',
                font: {
                    family: 'PBold', // Custom font for title
                    size: 18,
                 
                },
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return `${tooltipItem.label}: ${tooltipItem.raw} documents`;
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.7)', // Dark background for tooltips
                titleFont: {
                    family: 'PMedium',
                    size: 14
                },
                bodyFont: {
                    family: 'PMedium',
                    size: 12
                },
                padding: 10
            }
        }
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
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"> </script>

           
<?php 
    include('dashboard_sidebar_end.php');
?>
     
