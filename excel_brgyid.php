<?php
require './vendor/autoload.php'; // Autoload for PHPSpreadsheet and other libraries
require './classes/main.class.php'; // Your main class

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$dateToday = date('F j, Y'); // e.g., January 14, 2025

if (isset($_POST['views_data'])) {
        $columns = json_decode($_POST['views_data'], true);

    try {
      
        if (empty($columns)) {
            throw new Exception("No columns found for the table.");
        }

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add table header
        $colIndex = 'A';
        $sheet->setCellValue('A1', 'ID Barangay ID');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Middle Initial');
        $sheet->setCellValue('D1', 'Last Name');
        $sheet->setCellValue('E1', 'Suffix');
        $sheet->setCellValue('F1', 'House Number');
        $sheet->setCellValue('G1', 'Street');
        $sheet->setCellValue('H1', 'Barangay');
        $sheet->setCellValue('I1', 'City');
        $sheet->setCellValue('J1', 'Province');
        $sheet->setCellValue('K1', 'Birth Date');
        $sheet->setCellValue('L1', 'Status');
        $sheet->setCellValue('M1', 'Precinct Number');
        $sheet->setCellValue('N1', 'In Case of Emergency Last Name');
        $sheet->setCellValue('O1', 'In Case of Emergency First Name');
        $sheet->setCellValue('P1', 'In Case of Emergency Middle Initial');
        $sheet->setCellValue('Q1', 'In Case of Emergency Contact');
        $sheet->setCellValue('R1', 'In Case of Emergency House Number');
        $sheet->setCellValue('S1', 'In Case of Emergency Street');
        $sheet->setCellValue('T1', 'In Case of Emergency Barangay');
        $sheet->setCellValue('U1', 'In Case of Emergency City');
        $sheet->setCellValue('V1', 'In Case of Emergency Municipality');
        $sheet->setCellValue('W1', 'Valid Until');
        $sheet->setCellValue('X1', 'Created On');
        $sheet->setCellValue('Y1', 'Created By');
        $colIndex = 'P'; // Update the column index to the next column after the last header

        // Add data rows
        $rowIndex = 2;
        foreach ($columns as $column) {
            $sheet->setCellValue('A' . $rowIndex, $column['id_brgyid']);
            $sheet->setCellValue('B' . $rowIndex, $column['fname']);
            $sheet->setCellValue('C' . $rowIndex, $column['mi']);
            $sheet->setCellValue('D' . $rowIndex, $column['lname']);
            $sheet->setCellValue('E' . $rowIndex, $column['suffix']);
            $sheet->setCellValue('F' . $rowIndex, $column['houseno']);
            $sheet->setCellValue('G' . $rowIndex, $column['street']);
            $sheet->setCellValue('H' . $rowIndex, $column['brgy']);
            $sheet->setCellValue('I' . $rowIndex, $column['city']);
            $sheet->setCellValue('J' . $rowIndex, $column['municipality']);
            $sheet->setCellValue('K' . $rowIndex, $column['bdate']);
            $sheet->setCellValue('L' . $rowIndex, $column['status']);
            $sheet->setCellValue('M' . $rowIndex, $column['precint_no']);
            $sheet->setCellValue('N' . $rowIndex, $column['inc_lname']);
            $sheet->setCellValue('O' . $rowIndex, $column['inc_fname']);
            $sheet->setCellValue('P' . $rowIndex, $column['inc_mi']);
            $sheet->setCellValue('Q' . $rowIndex, $column['inc_contact']);
            $sheet->setCellValue('R' . $rowIndex, $column['inc_houseno']);
            $sheet->setCellValue('S' . $rowIndex, $column['inc_street']);
            $sheet->setCellValue('T' . $rowIndex, $column['inc_brgy']);
            $sheet->setCellValue('U' . $rowIndex, $column['inc_city']);
            $sheet->setCellValue('V' . $rowIndex, $column['inc_municipality']);
            $sheet->setCellValue('W' . $rowIndex, $column['valid_until']);
            $sheet->setCellValue('X' . $rowIndex, $column['created_on']);
            $sheet->setCellValue('Y' . $rowIndex, $column['created_by']);
            $rowIndex++;
        }



        // Auto-size columns for readability
        foreach (range('A', chr(ord($colIndex) - 1)) as $col) {
            if (!preg_match('/^[A-Z]$/', $col)) continue; // Validate column names
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set header style
        $sheet->getStyle('1:1')->getFont()->setBold(true);

        // Write the spreadsheet to a file or output directly
        $writer = new Xlsx($spreadsheet);

        // Set headers for file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="archived_list.xlsx"');
        header('Cache-Control: max-age=0');

        // Output the file to the browser
        $writer->save('php://output');
        exit;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die("An error occurred while processing your request.");
    } catch (Exception $e) {
        error_log("Error creating Excel file: " . $e->getMessage());
        die("An error occurred while generating the file.");
    }
}
?>
