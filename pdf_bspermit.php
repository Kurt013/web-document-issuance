<?php
// Include the main TCPDF library (search for installation path).
require './vendor/autoload.php';
require './classes/main.class.php';




if (isset($_POST['views_data'])) {
    $columns = json_decode($_POST['views_data'], true); 

        // Initialize TCPDF object
        $pdf = new TCPDF();
        $pdf->SetCreator('TCPDF');
        $pdf->SetTitle('Daily Report');
        $pdf->SetSubject('Daily Report for ' . date('F j, Y'));
        // Set page orientation to landscape
        $pdf->AddPage('L');
        // Set document information
        $pdf->SetMargins(15, 15, 15); // Set margins
        // Add a header
        
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 15, 'Summarized Report', 0, 1, 'C');
        

        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(35, 10, 'ID', 1, 0, 'C');
        $pdf->Cell(50, 10, 'First Name', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Last Name', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Suffix', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Business Name', 1, 0, 'C');
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
                $pdf->getStringHeight(40, $column['bsname']),
                $pdf->getStringHeight(40, $column['bsindustry']),
                $pdf->getStringHeight(30, $column['aoe'] . ' sqm.')
            );

            $pdf->MultiCell(35, $rowHeight, $column['id_bspermit'], 1, 'L', 0, 0);
            $pdf->MultiCell(50, $rowHeight, $column['fname'], 1, 'L', 0, 0);
            $pdf->MultiCell(10, $rowHeight, $column['mi'], 1, 'L', 0, 0);
            $pdf->MultiCell(30, $rowHeight, $column['lname'], 1, 'L', 0, 0);
            $pdf->MultiCell(20, $rowHeight, $column['suffix'], 1, 'L', 0, 0);
            $pdf->MultiCell(40, $rowHeight, $column['bsname'], 1, 'L', 0, 0);
            $pdf->MultiCell(40, $rowHeight, $column['bsindustry'], 1, 'L', 0, 0);
            $pdf->MultiCell(30, $rowHeight, $column['aoe'] . ' sqm.', 1, 'L', 0, 1);
        }

        // Correct Output method to ensure proper file download
        $pdf->Output('daily_report.pdf', 'I');
        exit;
}