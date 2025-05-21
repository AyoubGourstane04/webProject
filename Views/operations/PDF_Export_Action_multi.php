<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function exportMultipleTablesToPDF(array $sheetsData, string $fileName = 'export.pdf', array $highlightedRowsPerSheet = []) {
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $dompdf = new Dompdf($options);

    $html = '';
    foreach ($sheetsData as $sheetIndex => $sheetInfo) {
        $title = htmlspecialchars($sheetInfo['title']);
        $data = $sheetInfo['data'];
        $highlightedRows = $highlightedRowsPerSheet[$sheetIndex] ?? [];

        $html .= "<h2 style='text-align:center;'>$title</h2>";
        $html .= "<table border='1' cellpadding='6' cellspacing='0' style='width:100%; border-collapse:collapse; font-size:12px;'>";
        $html .= "<thead><tr style='background-color:#f2f2f2;'>";

        // Headers
        foreach ($data[0] as $headerCell) {
            $html .= "<th>" . htmlspecialchars($headerCell) . "</th>";
        }
        $html .= "</tr></thead><tbody>";

        // Data rows
        for ($i = 1; $i < count($data); $i++) {
            $rowStyle = in_array($i, $highlightedRows) ? "style='background-color:#FFC7CE;'" : '';
            $html .= "<tr $rowStyle>";
            foreach ($data[$i] as $cell) {
                $html .= "<td>" . htmlspecialchars($cell) . "</td>";
            }
            $html .= "</tr>";
        }

        $html .= "</tbody></table>";

        // Add page break except after last sheet
        if ($sheetIndex < count($sheetsData) - 1) {
            $html .= '<div style="page-break-after: always;"></div>';
        }
    }

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream($fileName, ["Attachment" => true]);
    exit;
}
