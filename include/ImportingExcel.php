<?php
    require 'vendor/autoload.php';
    require_once '../Model/database.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

    class ExcelImporter{
        private PDO $pdo;
       //private $allowedExtensions=['xlsx','xls','csv','ods'];

        public function __construct(PDO $pdo){
            $this->pdo=$pdo;
        }

        public function import(string $filePath,int $filiereId,int $departementId){
            try {
                $reader = IOFactory::createReaderForFile($filePath);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($filePath);

                $this->pdo->beginTransaction();

                $worksheets = $spreadsheet->getSheetCount()>1?$spreadsheet->getWorksheetIterator():[$spreadsheet->getActiveSheet()];

                foreach ($worksheets as $worksheet) {
                    $this->processSheet($worksheet,$filiereId,$departementId);
                }

                $this->pdo->commit();
                echo "<div class='alert alert-success'>Import completed successfully!</div>";
            } catch (ReaderException $e) {
                echo "<div class='alert alert-danger'>Unsupported file type: " . $e->getMessage() . "</div>";
            } catch (Exception $e) {
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
        }

        public function processSheet($worksheet){
            $title = $worksheet->getTitle();

            if (strtolower($title) === 'autre') return;

            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestDataColumn();
            for($row=3;$row<$highestRow;$row++){
                $rowData=$worksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, false)[0];
                $data=$this->processRow($rowData, $title, $row);
                if($data){
                    $this->insertRow($filiereId,$departementId);
                }
            }
        }

        public function processRow(array $data, string $title, int $row){
            $code=trim($data[0]??'');

            if(empty($code)){
                echo "Skipping row $row: Missing module code<br>";
                    return;
            }

            if ($this->recordExists($code)){
                echo "Skipping duplicate: $code<br>";
                return;
            }

            $fields =[
                'CodeModule'=>$code,
                'intitule'=>trim($data[1] ?? ''),
                'semestre'=>trim($data[2] ?? ''),
                'cours'=>(int)($data[4] ?? 0),
                'TD'=>(int)($data[5] ?? 0),
                'TP'=>(int)($data[6] ?? 0),
                'autre'=>(int)($data[7] ?? 0),
                'evaluation'=>(int)($data[8] ?? 0)
            ];
            return $fields;
        }

        public function recordExists(string $code){
            $this->pdo=dataBaseConnection();
            $statment=$this->pdo->prepare('SELECT * FROM units WHERE code_module=?;');
            $statment->execute([$code]);
            return (bool)$statment->fetch();
        }
    }


?>    