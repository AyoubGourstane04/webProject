<?php
//require '../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';
//require_once '../Model/database.php';
require_once __DIR__ . '/../Model/database.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

class ExcelImporter {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function import(string $filePath, int $filiereId, int $departementId): array {
        try {
            $reader = IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);

            $this->pdo->beginTransaction();

            $worksheet = $spreadsheet->getSheet(0);
            $message = $this->processSheet($worksheet, $filiereId, $departementId);

            $this->pdo->commit();
            return ['success' => true, 'message' => 'Import completed successfully! ' . $message['message']];

        } catch (ReaderException $e) {
            return ['success' => false, 'message' => 'Unsupported file type: ' . $e->getMessage()];
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    private function processSheet($worksheet, int $filiereId, int $departementId): array {
        $highestRow = $worksheet->getHighestDataRow();
        $highestColumn = $worksheet->getHighestDataColumn();
        $message = '';

        for ($row = 3; $row <= $highestRow; $row++) {
            $rowData = $worksheet->rangeToArray("A{$row}:{$highestColumn}{$row}", null, true, false)[0];
            $data = $this->processRow($rowData, $row);
            if ($data) {
                $message = $this->insertRow($data, $filiereId, $departementId);
            }
        }

        return $message ?: ['success' => false, 'message' => 'No valid rows found.'];
    }

    private function processRow(array $data, int $row): ?array {
    $code = trim($data[0] ?? ''); // A

    if (empty($code)) {
        echo "Skipping row $row: Missing module code<br>";
        return null;
    }

    if ($this->recordExists($code)) {
        echo "Skipping duplicate: $code<br>";
        return null;
    }

    return [
        'codeModule'  => $code,                      // A
        'intitule'    => trim($data[1] ?? ''),       // B
        'semestre'    => trim($data[2] ?? ''),       // C
        'cours'       => (int)($data[3] ?? 0),       // D
        'TD'          => (int)($data[4] ?? 0),       // E
        'TP'          => (int)($data[5] ?? 0),       // F
        'autre'       => (int)($data[6] ?? 0),       // G
        'evaluation'  => (int)($data[7] ?? 0),       // H
        'credits'     => trim($data[8] ?? ''),       // I
        'speciality'  => trim($data[9] ?? '')        // J
    ];
}


    private function recordExists(string $code): bool {
        $stmt = $this->pdo->prepare('SELECT id FROM units WHERE code_module = ? LIMIT 1');
        $stmt->execute([$code]);
        return (bool) $stmt->fetch();
    }

    private function insertRow(array $data, int $filiereId, int $departementId): array {
        try {
            $unit_id = insertUnit($data['codeModule'], $data['intitule'], $data['semestre'], $data['credits'], $data['speciality'], $departementId, $filiereId);
            if ($unit_id !== -1) {
                $result = changeTable(
                    'INSERT INTO volumehorraire (id_unit, Cours, TD, TP, Autre, Evaluation) VALUES (?, ?, ?, ?, ?, ?)',
                    [$unit_id, $data['cours'], $data['TD'], $data['TP'], $data['autre'], $data['evaluation']]
                );

                if ($result === true) {
                    return ['success' => true, 'message' => 'Unité ajoutée avec succès!'];
                }
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de l’insertion: ' . $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Erreur inconnue'];
    }
}
