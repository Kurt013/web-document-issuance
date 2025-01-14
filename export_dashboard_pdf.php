<?php
require './vendor/autoload.php'; // Autoload for TCPDF and dependencies
require './classes/main.class.php'; // Your main class


// Initialize TCPDF object
$pdf = new TCPDF();
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('BMIS');
$pdf->SetTitle('Daily Report');
$pdf->SetSubject('Daily Report for ' . date('F j, Y'));

// Set document information
$pdf->SetMargins(15, 15, 15); // Set margins
$pdf->AddPage(); // Add a page to the PDF

$dateToday = date('F j, Y'); // e.g., January 14, 2025

// Fetch counts and data lists
$totalRescert = $bmis->count_rescert();
$totalBrgyID = $bmis->count_brgyid();
$totalCertofindigency = $bmis->count_indigency();
$totalBusinessPermit = $bmis->count_bspermit();

$totalDailyRequest = $totalRescert + $totalBrgyID + $totalCertofindigency + $totalBusinessPermit;

$totalEarnings = $bmis->getDailyEarnings();

$totalEarningsFormatted = 'P' . number_format($totalEarnings, 2, '.', ',');

$rescertList = $bmis->daily_rescert_list();
$brgyidList = $bmis->daily_brgyid_list();
$bspermitList = $bmis->daily_bspermit_list();
$clearanceList = $bmis->daily_clearance_list();
$indigencyList = $bmis->daily_indigency_list();

// Add the title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Daily Report ($dateToday)", 0, 1, 'C');

// Add Total Document Issued section
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Total Document Issued', 0, 1, 'L');

// Add the total counts
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(100, 10, 'Certificate of Residency:', 0, 0);
$pdf->Cell(0, 10, $totalRescert, 0, 1, 'R');
$pdf->Cell(100, 10, 'Barangay ID:', 0, 0);
$pdf->Cell(0, 10, $totalBrgyID, 0, 1, 'R');
$pdf->Cell(100, 10, 'Business Permit:', 0, 0);
$pdf->Cell(0, 10, $totalBusinessPermit, 0, 1, 'R');
$pdf->Cell(100, 10, 'Barangay Clearance:', 0, 0);
$pdf->Cell(0, 10, count($clearanceList), 0, 1, 'R');
$pdf->Cell(100, 10, 'Certificate of Indigency:', 0, 0);
$pdf->Cell(0, 10, $totalCertofindigency, 0, 1, 'R');

// Add Total Daily Requests
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(100, 10, 'Total Daily Requests:', 0, 0);
$pdf->Cell(0, 10, $totalDailyRequest, 0, 1, 'R');

// Add Daily Earnings
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(100, 10, 'Daily Earnings:', 0, 0);
$pdf->Cell(0, 10, $totalEarningsFormatted, 0, 1, 'R');

// Add section headers for lists
$listHeaders = [
    'Certificate of Residency List' => $rescertList,
    'Barangay ID List' => $brgyidList,
    'Business Permit List' => $bspermitList,
    'Barangay Clearance List' => $clearanceList,
    'Certificate of Indigency List' => $indigencyList,
];

foreach ($listHeaders as $header => $list) {
    // Add section header
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $header, 0, 1, 'L');
    
    // Add table headers
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(80, 10, 'Name', 1, 0, 'C');
    $pdf->Cell(80, 10, 'Date', 1, 1, 'C');

    // Add the list items
    $pdf->SetFont('helvetica', '', 10);
    foreach ($list as $item) {
        $pdf->Cell(80, 10, $item['name'] ?? 'N/A', 1, 0, 'C');
        $pdf->Cell(80, 10, $item['date'] ?? 'N/A', 1, 1, 'C');
    }
}

// Output the PDF file
if (isset($_POST['exportToPdf'])) {
    // Correct Output method to ensure proper file download
    $pdf->Output('daily_report.pdf', 'D');
    exit;
} else {
    // Display the PDF in the browser
    $pdf->Output('daily_report.pdf', 'I');
    exit;
}
