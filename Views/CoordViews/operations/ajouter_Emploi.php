<?php
   require_once __DIR__ . '/../../../Controller/controller.php';
   
    $filiere_id = isset($_GET['id_filiere']) ? intval($_GET['id_filiere']) : null;
    $coord_id = isset($_GET['id_coord']) ? intval($_GET['id_coord']) : null;
    $semestre = isset($_POST['semestre']) ? $_POST['semestre'] : null;
    $annee = isset($_POST['AU']) ? $_POST['AU'] : null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['emploi_file']) && $_FILES['emploi_file']['error'] === UPLOAD_ERR_OK) {
        $fileTempPath=$_FILES['emploi_file']['tmp_name'];
        $fileNameTemp=$_FILES['emploi_file']['name'];
        $fileNameCmps = pathinfo($fileNameTemp);
        $fileExtension = strtolower($fileNameCmps['extension']);

        $allowedExtensions = ['csv', 'xls', 'xlsx','pdf'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName=uniqid().$fileNameTemp;
            $destination = __DIR__ . '/../../../resources/Emplois/' . $fileName;

            if (move_uploaded_file($fileTempPath,  $destination)) {
                 $result=changeTable('INSERT INTO emploi (id_coordinateur, id_filiere, semestre, anneeUniversitaire, Emploi) VALUE(?,?,?,?,?);',[$coord_id,$filiere_id,$semestre,$annee,$fileName]);
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
        echo "Erreur dans l'envoi du fichier : " . $_FILES['emploi_file']['error'];
    }
}



?>
