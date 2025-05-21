<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @param array $data Table data including headers (headers as first row)
 * @param string $fileName File name for the PDF
 * @param string $title Document title
 */
// Suppose $highlightRows is an array of row indexes (starting from 1, because 0 is header)
function exportTableToPDF(array $data, string $fileName = 'export.pdf', string $title = 'Rapport', array $highlightRows = []) {
    if (empty($data)) {
        throw new Exception('No data provided for export.');
    }

    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $dompdf = new Dompdf($options);

    $html = "<h2 style='text-align:center;'>$title</h2>";
    $html .= "<table border='1' cellpadding='6' cellspacing='0' style='width:100%; border-collapse:collapse; font-size:12px;'>";
    $html .= "<thead><tr style='background-color:#f2f2f2;'>";

    // Headers
    foreach ($data[0] as $headerCell) {
        $html .= "<th>" . htmlspecialchars($headerCell) . "</th>";
    }
    $html .= "</tr></thead><tbody>";

    // Data rows
    for ($i = 1; $i < count($data); $i++) {
        // Check if this row should be highlighted
        // Option 1: using $highlightRows array passed in
        $highlight = in_array($i, $highlightRows);

        // Option 2: or check volume horr from external data if you want:
        // $highlight = isset($volumeHorrData[$i-1]) && $volumeHorrData[$i-1] < $minHours;

        $rowStyle = $highlight ? "style='background-color:#FFC7CE;'" : '';

        $html .= "<tr $rowStyle>";
        foreach ($data[$i] as $cell) {
            $html .= "<td>" . htmlspecialchars($cell) . "</td>";
        }
        $html .= "</tr>";
    }

    $html .= "</tbody></table>";

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream($fileName, ["Attachment" => true]);
    exit;
}

