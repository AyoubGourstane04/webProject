<?php
   require_once __DIR__ . '/../../../Controller/controller.php';
   
    $filiere_id = isset($_GET['id_filiere']) ? intval($_GET['id_filiere']) : null;
    $coord_id = isset($_GET['id_coord']) ? intval($_GET['id_coord']) : null;
    $semestre = isset($_POST['semestre']) ? $_POST['semestre'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $annee = isset($_POST['AU']) ? $_POST['AU'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['Groupe_file']) && $_FILES['Groupe_file']['error'] === UPLOAD_ERR_OK) {
        $fileTempPath=$_FILES['Groupe_file']['tmp_name'];
        $fileNameTemp=$_FILES['Groupe_file']['name'];
        $fileNameCmps = pathinfo($fileNameTemp);
        $fileExtension = strtolower($fileNameCmps['extension']);

        $allowedExtensions = ['csv', 'xls', 'xlsx','pdf'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName=uniqid().$fileNameTemp;
            $destination = __DIR__ . '/../../../resources/Groupes/' . $fileName;

            if (move_uploaded_file($fileTempPath,  $destination)) {
                 $result=changeTable('INSERT INTO groupes (id_coordinateur, id_filiere, type, semestre, anneeUniversitaire, groupes_file) VALUE(?,?,?,?,?,?);',[$coord_id,$filiere_id,$type,$semestre,$annee,$fileName]);
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
        echo "Erreur dans l'envoi du fichier : " . $_FILES['Groupe_file']['error'];
    }
}



?>
