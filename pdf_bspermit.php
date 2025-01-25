<?php
// Include the main TCPDF library (search for installation path).
require './vendor/autoload.php';
require './classes/main.class.php';

class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Path to the header image
        $image_file = __DIR__ . '/assets/pdfheader8.jpg';

        // Check if the image file exists
        if (file_exists($image_file)) {
            // Get the page width
            $pageWidth = $this->getPageWidth();
            // Set the image on the top-left corner with the width of the page
            $this->Image($image_file, 0, 0, $pageWidth, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        } else {
            // Handle the case where the image file does not exist
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 10, 'Header Image Not Found', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
    }
}


if (isset($_POST['views_data'])) {
    $columns = json_decode($_POST['views_data'], true); 

        // Initialize TCPDF object
        $pdf = new MYPDF();
        $pdf->SetCreator('TCPDF');
        $pdf->SetTitle('Daily Report');
        $pdf->SetSubject('Daily Report for ' . date('F j, Y'));
        // Set page orientation to landscape
        $pdf->AddPage('L');
        // Set document information
        $pdf->SetMargins(15, 15, 15); // Set margins
        // Add a header
        
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 15, 'Generated List', 0, 1, 'C');
        

        $pdf->SetY(40);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(35, 10, 'ID', 1, 0, 'C');
        $pdf->Cell(50, 10, 'First Name', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Last Name', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Suffix', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Business Name', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Industry', 1, 0, 'C');
        $pdf->Cell(30, 10, 'AOE', 1, 1, 'C');

        // Add the rescert list
        $pdf->SetFont('helvetica', '', 12);
        foreach ($columns as $column) {
            $rowHeight = max(
                $pdf->getStringHeight(35, $column['id_bspermit']),
                $pdf->getStringHeight(50, $column['fname']),
                $pdf->getStringHeight(30, $column['lname']),
                $pdf->getStringHeight(20, $column['suffix']),
                $pdf->getStringHeight(50, $column['bsname']),
                $pdf->getStringHeight(40, $column['bsindustry']),
                $pdf->getStringHeight(30, $column['aoe'] . ' sqm.')
            );

            $pdf->MultiCell(35, $rowHeight, $column['id_bspermit'], 1, 'L', 0, 0);
            $pdf->MultiCell(50, $rowHeight, $column['fname'], 1, 'L', 0, 0);
            $pdf->MultiCell(30, $rowHeight, $column['lname'], 1, 'L', 0, 0);
            $pdf->MultiCell(20, $rowHeight, $column['suffix'], 1, 'L', 0, 0);
            $pdf->MultiCell(50, $rowHeight, $column['bsname'], 1, 'L', 0, 0);
            $pdf->MultiCell(40, $rowHeight, $column['bsindustry'], 1, 'L', 0, 0);
            $pdf->MultiCell(30, $rowHeight, $column['aoe'] . ' sqm.', 1, 'L', 0, 1);
        }

        // Correct Output method to ensure proper file download
        $pdf->Output('daily_report.pdf', 'I');
        exit;
}