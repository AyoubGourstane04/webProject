<?php
   require_once __DIR__ . '/../../../Controller/controller.php';
   
    $Vac_id = isset($_GET['id_vacat']) ? intval($_GET['id_vacat']) : null;
    $unit_id = isset($_POST['unit']) ? $_POST['unit'] : null;
    $session = isset($_POST['session']) ? $_POST['session'] : null;

    $fullUnit=GetFromDb('SELECT * FROM units WHERE id=?;',$unit_id,false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['Note_file']) && $_FILES['Note_file']['error'] === UPLOAD_ERR_OK) {
        $fileTempPath=$_FILES['Note_file']['tmp_name'];
        $fileNameTemp=$_FILES['Note_file']['name'];
        $fileNameCmps = pathinfo($fileNameTemp);
        $fileExtension = strtolower($fileNameCmps['extension']);

        $allowedExtensions = ['csv', 'xls', 'xlsx','pdf'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName=uniqid().$fileNameTemp;
            $destination = __DIR__ . '/../../../resources/Notes/' . $fileName;

            if (move_uploaded_file($fileTempPath,  $destination)) {
                 $result=changeTable('INSERT INTO notes (id_prof, id_unit, semestre, session, Notes) VALUE(?,?,?,?,?);',[$Vac_id,$unit_id,$fullUnit['semestre'],$session,$fileName]);
                    if($result){
                            header('location: '.$_SERVER['HTTP_REFERER']);
                            exit();
                    }else{
                            throw new Exception($result);
                        }
            } else {
                echo "Erreur lors du déplacement du fichier.";
            }
        } else {
            echo "Extension non autorisée : .$fileExtension";
        }
    } else {
        echo "Erreur dans l'envoi du fichier : " . $_FILES['Note_file']['error'];
    }
}



?>
