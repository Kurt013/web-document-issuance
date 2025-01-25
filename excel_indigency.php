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
        $sheet->setCellValue('A1', 'ID Indigency');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Middle Initial');
        $sheet->setCellValue('D1', 'Last Name');
        $sheet->setCellValue('E1', 'Suffix');
        $sheet->setCellValue('F1', 'Age');
        $sheet->setCellValue('G1', 'Nationality');
        $sheet->setCellValue('H1', 'House Number');
        $sheet->setCellValue('I1', 'Street');
        $sheet->setCellValue('J1', 'Barangay');
        $sheet->setCellValue('K1', 'City');
        $sheet->setCellValue('L1', 'Province');
        $sheet->setCellValue('M1', 'Purpose');
        $sheet->setCellValue('N1', 'Created On');
        $sheet->setCellValue('O1', 'Created By');
        $colIndex = 'P'; // Update the column index to the next column after the last header

        // Add data rows
        $rowIndex = 2;
        foreach ($columns as $column) {
            $sheet->setCellValue('A' . $rowIndex, $column['id_indigency']);
            $sheet->setCellValue('B' . $rowIndex, $column['fname']);
            $sheet->setCellValue('C' . $rowIndex, $column['mi']);
            $sheet->setCellValue('D' . $rowIndex, $column['lname']);
            $sheet->setCellValue('E' . $rowIndex, $column['suffix']);
            $sheet->setCellValue('F' . $rowIndex, $column['age']);
            $sheet->setCellValue('G' . $rowIndex, $column['nationality']);
            $sheet->setCellValue('H' . $rowIndex, $column['houseno']);
            $sheet->setCellValue('I' . $rowIndex, $column['street']);
            $sheet->setCellValue('J' . $rowIndex, $column['brgy']);
            $sheet->setCellValue('K' . $rowIndex, $column['city']);
            $sheet->setCellValue('L' . $rowIndex, $column['municipality']);
            $sheet->setCellValue('M' . $rowIndex, $column['purpose']);
            $sheet->setCellValue('N' . $rowIndex, $column['created_on']);
            $sheet->setCellValue('O' . $rowIndex, $column['created_by']);
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
