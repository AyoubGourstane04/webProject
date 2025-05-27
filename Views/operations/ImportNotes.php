<?php
   require_once __DIR__ . '/../../Controller/controller.php';
   session_start();
   
    $prof_id = isset($_GET['id_prof']) ? intval($_GET['id_prof']) : null;
    $unit_id = isset($_POST['unit']) ? intval($_POST['unit']) : null;
    $session = isset($_POST['session']) ? htmlspecialchars($_POST['session']) : null;
    $annee = isset($_POST['Au']) ? htmlspecialchars($_POST['Au']) : null;

    if(!empty($_POST['semestre'])){
        $semestre= htmlspecialchars($_POST['semestre']);
    }else{
        $fullUnit=GetFromDb('SELECT * FROM units WHERE id=?;',$unit_id,false);
        $semestre=$fullUnit['semestre'];     
    }




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['Note_file']) && $_FILES['Note_file']['error'] === UPLOAD_ERR_OK) {
        $fileTempPath=$_FILES['Note_file']['tmp_name'];
        $fileNameTemp=$_FILES['Note_file']['name'];
        $fileNameCmps = pathinfo($fileNameTemp);
        $fileExtension = strtolower($fileNameCmps['extension']);

        $allowedExtensions = ['csv', 'xls', 'xlsx','pdf'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName=uniqid().$fileNameTemp;
            $destination = __DIR__ . '/../../resources/Notes/' . $fileName;

            if (move_uploaded_file($fileTempPath,  $destination)) {
                $result=changeTable('INSERT INTO notes (id_prof, id_unit, semestre, session, anneeUniversitaire, Notes) VALUE(?,?,?,?,?,?);',[$prof_id,$unit_id,$semestre,$session,$annee,$fileName]);
                    if($result){
                        $_SESSION['flash'] = ['success' => true, 'message' => 'Notes importé avec succès.'];
                    } else {
                        $_SESSION['flash'] = ['success' => false, 'message' => 'Erreur lors de l\'enregistrement en base de données.'];
                    }
            } else {
                $_SESSION['flash'] = ['success' => false, 'message' => 'Erreur lors du déplacement du fichier.'];
            }
        } else {
            $_SESSION['flash'] = ['success' => false, 'message' => "Extension non autorisée : .$fileExtension"];
        }
    } else {
        $_SESSION['flash'] = ['success' => false, 'message' => 'Erreur dans l\'envoi du fichier (code : ' . $_FILES['emploi_file']['error'] . ')'];
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}


?>
