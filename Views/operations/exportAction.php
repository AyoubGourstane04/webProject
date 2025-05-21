<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

//hada ghir commentaire : 
/**
 * @param array $data           dakchi li ghatjib mn tableau li flpage
 * @param string $fileName      smya ta3 lfile li ghayt'exporta 
 * @param string $sheetTitle    smay ta3 sheet
 */


function exportTableToExcel(array $data, string $fileName = 'export.xlsx', string $sheetTitle = 'Sheet1' ,array $highlightedRows = []) {
    if (empty($data)) {
        throw new Exception('No data provided for export.');
    }
    //kay creer spreadsheet :
    $spreadSheet = new Spreadsheet();
    $sheet = $spreadSheet->getActiveSheet();
    $sheet->setTitle($sheetTitle);

    //katkteb data : 
    foreach ($data as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1); 
            $cellAddress = $columnLetter . ($rowIndex + 1);
            $sheet->setCellValue($cellAddress, $value);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        }
            if (in_array($rowIndex, $highlightedRows)) {
                $firstCol = 'A';
                $lastCol = Coordinate::stringFromColumnIndex(count($row));
                $range = "{$firstCol}" . ($rowIndex + 1) . ":{$lastCol}" . ($rowIndex + 1);

                $sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFC7CE'); // light red
            }
    }

    // hadchi ta3 lbrowser bach i dir download : 
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$fileName}\"");
    header('Cache-Control: max-age=0');

    //hadchi kaykte flfile excel : 
    $writer = new Xlsx($spreadSheet);
    $writer->save('php://output');
    exit;
}


















?>