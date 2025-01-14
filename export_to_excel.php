<?php
require './vendor/autoload.php'; // Autoload for PHPSpreadsheet and other libraries
require './classes/main.class.php'; // Your main class

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start(); // Prevent unintended output

if (isset($_POST['views_data']) && isset($_POST['table_name'])) {
    $tableName = $_POST['table_name'];
    $rows = json_decode($_POST['views_data'], true);

    try {
        // Connect to the database
        $connection = $bmis->openConn();

        $query = "SHOW COLUMNS FROM `" . $tableName . "`";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($columns)) {
            throw new Exception("No columns found for the table.");
        }

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Barangay Sinalhan - DOCUMENT ISSUANCE SYSTEM')
            ->setLastModifiedBy('Barangay Sinalhan')
            ->setTitle('List of Transactions')
            ->setSubject('List of Transactions')
            ->setDescription('Auto-generated Excel file of transactions.');

        // Set column headers
        $colIndex = 'A'; // Start with column A
        foreach ($columns as $column) {
            if (!isset($column['Field']) || $column['Field'] === 'res_photo') continue;
            $sheet->setCellValue($colIndex . '1', $column['Field']);
            $colIndex++;
        }

        // Fill data rows
        $rowIndex = 2; // Start filling from the second row (below headers)
        foreach ($rows as $row) {
            $colIndex = 'A';
            foreach ($columns as $column) {
                if (!isset($column['Field']) || $column['Field'] === 'res_photo') continue;
                $sheet->setCellValue($colIndex . $rowIndex, $row[$column['Field']] ?? '');
                $colIndex++;
            }
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
