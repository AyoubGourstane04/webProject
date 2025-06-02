<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function exportMultipleTablesToExcel(array $sheetsData, string $fileName = 'export.xlsx', array $highlightedRowsPerSheet = []) {
    if (empty($sheetsData)) {
        throw new Exception('No sheets data provided for export.');
    }

    $spreadsheet = new Spreadsheet();

    foreach ($sheetsData as $index => $sheetInfo) {
        $title = $sheetInfo['title'] ?? 'Sheet' . ($index + 1);
        $data = $sheetInfo['data'] ?? [];
        $highlightedRows = $highlightedRowsPerSheet[$index] ?? [];

        // Use active sheet for first sheet, else create new sheet
        $sheet = ($index === 0) ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet();
        $sheet->setTitle($title);

        foreach ($data as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                $cell = Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 1);
                $sheet->setCellValue($cell, $value);
                $sheet->getColumnDimensionByColumn($colIndex + 1)->setAutoSize(true);
            }

            if (in_array($rowIndex, $highlightedRows, true)) {
                $firstCol = 'A';
                $lastCol = Coordinate::stringFromColumnIndex(count($row));
                $range = "{$firstCol}" . ($rowIndex + 1) . ":{$lastCol}" . ($rowIndex + 1);

                $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFC7CE'); // light red
            }
        }
    }

    // Clean any output buffers to prevent corruption
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // Write file to output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
