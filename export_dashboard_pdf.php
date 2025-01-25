<?php
require './vendor/autoload.php'; // Autoload for TCPDF and dependencies
require './classes/main.class.php'; // Your main class


// Initialize TCPDF object
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Path to the header image
        $image_file = __DIR__ . '/assets/pdfheader2.png';

        // Check if the image file exists
        if (file_exists($image_file)) {
            // Get the page width
            $pageWidth = $this->getPageWidth();
            // Set the image on the top-left corner with the width of the page
            $this->Image($image_file, 0, 0, $pageWidth, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        } else {
            // Handle the case where the image file does not exist
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 10, 'Header Image Not Found', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
    }
}


// Create new PDF document
$pdf = new MYPDF();
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

$rescertList = $bmis->daily_rescert_list();
$brgyidList = $bmis->daily_brgyid_list();
$bspermitList = $bmis->daily_bspermit_list();
$clearanceList = $bmis->daily_clearance_list();
$indigencyList = $bmis->daily_indigency_list();

// Add the title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Daily Report ($dateToday)", 0, 1, 'C');

// Add Total Document Issued section
$pdf->SetY(50); // Sets the vertical position to 50 units from the top
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

// Section header for rescert list

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Certificate of Residency List', 0, 1, 'L');

// Add table header
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(35, 10, 'ID', 1, 0, 'C');
$pdf->Cell(40, 10, 'First Name', 1, 0, 'C');
$pdf->Cell(7, 10, 'MI', 1, 0, 'C');
$pdf->Cell(40, 10, 'Last Name', 1, 0, 'C');
$pdf->Cell(50, 10, 'Purpose', 1, 1, 'C');

// Add the rescert list
$pdf->SetFont('helvetica', '', 12);
foreach ($rescertList as $rescert) {
    $pdf->Cell(35, 10, $rescert['id_rescert'], 1, 0, 'L');
    $pdf->Cell(40, 10, $rescert['fname'], 1, 0, 'L');
    $pdf->Cell(7, 10, $rescert['mi'], 1, 0, 'L');
    $pdf->Cell(40, 10, $rescert['lname'], 1, 0, 'L');
    $pdf->Cell(50, 10, $rescert['purpose'], 1, 1, 'L');
}


// Section header for indigency list --------

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Certificate of Indigency List', 0, 1, 'L');

// Add table header
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(35, 10, 'ID', 1, 0, 'C');
$pdf->Cell(40, 10, 'First Name', 1, 0, 'C');
$pdf->Cell(7, 10, 'MI', 1, 0, 'C');
$pdf->Cell(40, 10, 'Last Name', 1, 0, 'C');
$pdf->Cell(50, 10, 'Purpose', 1, 1, 'C');

// Add the rescert list
$pdf->SetFont('helvetica', '', 12);
foreach ($indigencyList as $indigency) {
    $pdf->Cell(35, 10, $indigency['id_indigency'], 1, 0, 'L');
    $pdf->Cell(40, 10, $indigency['fname'], 1, 0, 'L');
    $pdf->Cell(7, 10, $indigency['mi'], 1, 0, 'L');
    $pdf->Cell(40, 10, $indigency['lname'], 1, 0, 'L');
    $pdf->Cell(50, 10, $indigency['purpose'], 1, 1, 'L');
}



// Section header for indigency list --------

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Certificate of Clearance List', 0, 1, 'L');

// Add table header
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(35, 10, 'ID', 1, 0, 'C');
$pdf->Cell(40, 10, 'First Name', 1, 0, 'C');
$pdf->Cell(7, 10, 'MI', 1, 0, 'C');
$pdf->Cell(40, 10, 'Last Name', 1, 0, 'C');
$pdf->Cell(50, 10, 'Purpose', 1, 1, 'C');

// Add the rescert list
$pdf->SetFont('helvetica', '', 12);
foreach ($clearanceList as $clearance) {
    $pdf->Cell(35, 10, $clearance['id_clearance'], 1, 0, 'L');
    $pdf->Cell(40, 10, $clearance['fname'], 1, 0, 'L');
    $pdf->Cell(7, 10, $clearance['mi'], 1, 0, 'L');
    $pdf->Cell(40, 10, $clearance['lname'], 1, 0, 'L');
    $pdf->Cell(50, 10, $clearance['purpose'], 1, 1, 'L');
}


// Section header for bspermit list --------

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Business Permit List', 0, 1, 'L');

// Add table header
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(35, 10, 'ID', 1, 0, 'C');
$pdf->Cell(40, 10, 'First Name', 1, 0, 'C');
$pdf->Cell(7, 10, 'MI', 1, 0, 'C');
$pdf->Cell(40, 10, 'Last Name', 1, 0, 'C');
$pdf->Cell(50, 10, 'Business Name', 1, 1, 'C');

// Add the rescert list
$pdf->SetFont('helvetica', '', 12);
foreach ($bspermitList as $bspermit) {
    $pdf->Cell(35, 10, $bspermit['id_bspermit'], 1, 0, 'L');
    $pdf->Cell(40, 10, $bspermit['fname'], 1, 0, 'L');
    $pdf->Cell(7, 10, $bspermit['mi'], 1, 0, 'L');
    $pdf->Cell(40, 10, $bspermit['lname'], 1, 0, 'L');
    $pdf->Cell(50, 10, $bspermit['bsname'], 1, 1, 'L');
}


// Section header for Barangay ID--------

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Barangay ID List', 0, 1, 'L');

// Add table header
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(35, 10, 'ID', 1, 0, 'C');
$pdf->Cell(40, 10, 'First Name', 1, 0, 'C');
$pdf->Cell(7, 10, 'MI', 1, 0, 'C');
$pdf->Cell(40, 10, 'Last Name', 1, 0, 'C');
$pdf->Cell(50, 10, 'Precint No.', 1, 1, 'C');

// Add the rescert list
$pdf->SetFont('helvetica', '', 12);
foreach ($brgyidList as $brgyid) {
    $pdf->Cell(35, 10, $brgyid['id_brgyid'], 1, 0, 'L');
    $pdf->Cell(40, 10, $brgyid['fname'], 1, 0, 'L');
    $pdf->Cell(7, 10, $brgyid['mi'], 1, 0, 'L');
    $pdf->Cell(40, 10, $brgyid['lname'], 1, 0, 'L');
    $pdf->Cell(50, 10, $brgyid['precint_no'], 1, 1, 'L');
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
