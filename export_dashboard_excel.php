<?php
require './vendor/autoload.php'; // Autoload for PHPSpreadsheet and dependencies
require './classes/main.class.php'; // Your main class

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$conn = $bmis->openConn();

$dateToday = date('F j, Y'); // e.g., January 14, 2025

// Fetch counts and data lists
$totalRescert = $bmis->count_rescert();
$totalBrgyID = $bmis->count_brgyid();
$totalCertofindigency = $bmis->count_indigency();
$totalBusinessPermit = $bmis->count_bspermit();

$totalDailyRequest = $totalRescert + $totalBrgyID + $totalCertofindigency + $totalBusinessPermit;

$totalEarnings = $bmis->getDailyEarnings();

$totalEarningsFormatted = '₱' . number_format($totalEarnings, 2, '.', ',');

$rescertList = $bmis->daily_rescert_list();
$brgyidList = $bmis->daily_brgyid_list();
$bspermitList = $bmis->daily_bspermit_list();
$clearanceList = $bmis->daily_clearance_list();
$indigencyList = $bmis->daily_indigency_list();

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add the title
$sheet->setCellValue('A1', "Daily Report ($dateToday)");
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->mergeCells('A1:D1');

// Add Total Document Issued section
$sheet->setCellValue('A3', 'Total Document Issued');
$sheet->getStyle('A3')->getFont()->setBold(true);

$sheet->setCellValue('A4', 'Certificate of Residency');
$sheet->setCellValue('B4', $totalRescert);

$sheet->setCellValue('A5', 'Barangay ID');
$sheet->setCellValue('B5', $totalBrgyID);

$sheet->setCellValue('A6', 'Business Permit');
$sheet->setCellValue('B6', $totalBusinessPermit);

$sheet->setCellValue('A7', 'Barangay Clearance');
$sheet->setCellValue('B7', count($clearanceList));

$sheet->setCellValue('A8', 'Certificate of Indigency');
$sheet->setCellValue('B8', $totalCertofindigency);

// Add Total Daily Requests
$sheet->setCellValue('A10', 'Total Daily Requests');
$sheet->setCellValue('B10', '=SUM(B4:B8)'); // Automatically calculates the sum

// Add Daily Earnings
$sheet->setCellValue('A12', 'Daily Earnings');
$sheet->setCellValue('B12', $totalEarningsFormatted);



$rowStart = 14; // Starting row for the lists

// Add the section header
$sheet->setCellValue("A$rowStart", 'Certificate of Residency List');
$sheet->getStyle("A$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add table header
$sheet->setCellValue("A$rowStart", 'ID');
$sheet->setCellValue("B$rowStart", 'First Name');
$sheet->setCellValue("C$rowStart", 'MI');
$sheet->setCellValue("D$rowStart", 'Last Name');
$sheet->setCellValue("E$rowStart", 'Purpose');
$sheet->getStyle("A$rowStart:E$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add the rescert list
foreach ($rescertList as $rescert) {
    $sheet->setCellValue("A$rowStart", $rescert['id_rescert'] ?? 'N/A');
    $sheet->setCellValue("B$rowStart", $rescert['fname'] ?? 'N/A');
    $sheet->setCellValue("C$rowStart", $rescert['mi'] ?? 'N/A');
    $sheet->setCellValue("D$rowStart", $rescert['lname'] ?? 'N/A');
    $sheet->setCellValue("E$rowStart", $rescert['purpose'] ?? 'N/A');
    $rowStart++;
}


// Add the section header
$sheet->setCellValue("A$rowStart", 'Certificate of Indigency List');
$sheet->getStyle("A$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add table header
$sheet->setCellValue("A$rowStart", 'ID');
$sheet->setCellValue("B$rowStart", 'First Name');
$sheet->setCellValue("C$rowStart", 'MI');
$sheet->setCellValue("D$rowStart", 'Last Name');
$sheet->setCellValue("E$rowStart", 'Purpose');
$sheet->getStyle("A$rowStart:E$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add the rescert list
foreach ($indigencyList as $indigency) {
    $sheet->setCellValue("A$rowStart", $indigency['id_indigency'] ?? 'N/A');
    $sheet->setCellValue("B$rowStart", $indigency['fname'] ?? 'N/A');
    $sheet->setCellValue("C$rowStart", $indigency['mi'] ?? 'N/A');
    $sheet->setCellValue("D$rowStart", $indigency['lname'] ?? 'N/A');
    $sheet->setCellValue("E$rowStart", $indigency['purpose'] ?? 'N/A');
    $rowStart++;
}


// Add the section header
$sheet->setCellValue("A$rowStart", 'Certificate of Clearance List');
$sheet->getStyle("A$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add table header
$sheet->setCellValue("A$rowStart", 'ID');
$sheet->setCellValue("B$rowStart", 'First Name');
$sheet->setCellValue("C$rowStart", 'MI');
$sheet->setCellValue("D$rowStart", 'Last Name');
$sheet->setCellValue("E$rowStart", 'Purpose');
$sheet->getStyle("A$rowStart:E$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add the rescert list
foreach ($clearanceList as $clearance) {
    $sheet->setCellValue("A$rowStart", $clearance['id_clearance'] ?? 'N/A');
    $sheet->setCellValue("B$rowStart", $clearance['fname'] ?? 'N/A');
    $sheet->setCellValue("C$rowStart", $clearance['mi'] ?? 'N/A');
    $sheet->setCellValue("D$rowStart", $clearance['lname'] ?? 'N/A');
    $sheet->setCellValue("E$rowStart", $clearance['purpose'] ?? 'N/A');
    $rowStart++;
}



// Add the section header
$sheet->setCellValue("A$rowStart", 'Business Permit List');
$sheet->getStyle("A$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add table header
$sheet->setCellValue("A$rowStart", 'ID');
$sheet->setCellValue("B$rowStart", 'First Name');
$sheet->setCellValue("C$rowStart", 'MI');
$sheet->setCellValue("D$rowStart", 'Last Name');
$sheet->setCellValue("E$rowStart", 'Business Name');
$sheet->getStyle("A$rowStart:E$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add the rescert list
foreach ($bspermitList as $bspermit) {
    $sheet->setCellValue("A$rowStart", $bspermit['id_bspermit'] ?? 'N/A');
    $sheet->setCellValue("B$rowStart", $bspermit['fname'] ?? 'N/A');
    $sheet->setCellValue("C$rowStart", $bspermit['mi'] ?? 'N/A');
    $sheet->setCellValue("D$rowStart", $bspermit['lname'] ?? 'N/A');
    $sheet->setCellValue("E$rowStart", $bspermit['bsname'] ?? 'N/A');
    $rowStart++;
}



// Add the section header
$sheet->setCellValue("A$rowStart", 'Barangay ID List');
$sheet->getStyle("A$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add table header
$sheet->setCellValue("A$rowStart", 'ID');
$sheet->setCellValue("B$rowStart", 'First Name');
$sheet->setCellValue("C$rowStart", 'MI');
$sheet->setCellValue("D$rowStart", 'Last Name');
$sheet->setCellValue("E$rowStart", 'Precint No.');
$sheet->getStyle("A$rowStart:E$rowStart")->getFont()->setBold(true);
$rowStart++;

// Add the rescert list
foreach ($brgyidList as $brgyid) {
    $sheet->setCellValue("A$rowStart", $brgyid['id_brgyid'] ?? 'N/A');
    $sheet->setCellValue("B$rowStart", $brgyid['fname'] ?? 'N/A');
    $sheet->setCellValue("C$rowStart", $brgyid['mi'] ?? 'N/A');
    $sheet->setCellValue("D$rowStart", $brgyid['lname'] ?? 'N/A');
    $sheet->setCellValue("E$rowStart", $brgyid['precint_no'] ?? 'N/A');
    $rowStart++;
}




// Set auto-size for all columns
foreach (range('A', 'B') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Output the Excel file
if (isset($_POST['exportToExcel'])) {
    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="daily_report.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
