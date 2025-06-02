<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

function exportTableToExcel(array $data, string $fileName = 'export.xlsx', string $sheetTitle = 'Sheet1', array $highlightedRows = []) {
    if (empty($data)) {
        throw new Exception('No data provided for export.');
    }

    // Create new Spreadsheet and active sheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle($sheetTitle);

    // Write data to sheet
    foreach ($data as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
            $cellAddress = $columnLetter . ($rowIndex + 1);
            $sheet->setCellValue($cellAddress, $value);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        }

        // Highlight specified rows with light red background
        if (in_array($rowIndex, $highlightedRows, true)) {
            $firstCol = 'A';
            $lastCol = Coordinate::stringFromColumnIndex(count($row));
            $range = "{$firstCol}" . ($rowIndex + 1) . ":{$lastCol}" . ($rowIndex + 1);

            $sheet->getStyle($range)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFC7CE');
        }
    }

    // Clear any previous output to avoid corrupting the file
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // Write the spreadsheet to output stream
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // Stop script execution after sending the file
    exit;
}
