<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;


function exportMultipleTablesToExcel(array $sheetsData, string $fileName = 'export.xlsx',array $highlightedRowsPerSheet = []) {
    $spreadSheet = new Spreadsheet();

    foreach ($sheetsData as $index => $sheetInfo) {
        $title = $sheetInfo['title'];
        $data = $sheetInfo['data'];
        $highlightedRows = $highlightedRowsPerSheet[$index] ?? [];

        // First sheet is already created
        $sheet = ($index === 0) ? $spreadSheet->getActiveSheet() : $spreadSheet->createSheet();
        $sheet->setTitle($title);
        

        foreach ($data as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 1);
                $sheet->setCellValue($cell, $value);
                $sheet->getColumnDimensionByColumn($colIndex + 1)->setAutoSize(true);

            }
                if (in_array($rowIndex, $highlightedRows)) {
                    $firstCol = 'A';
                    $lastCol = Coordinate::stringFromColumnIndex(count($row));
                    $range = "{$firstCol}" . ($rowIndex + 1) . ":{$lastCol}" . ($rowIndex + 1);

                    $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FFC7CE'); // light red
                }
        }
    }

    // Output headers
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$fileName}\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadSheet);
    $writer->save('php://output');
    exit;
}
















?>