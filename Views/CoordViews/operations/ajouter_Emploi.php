<?php
   require_once __DIR__ . '/../../../Controller/controller.php';
   
   session_start();

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
                        $profs =GetFromDb('SELECT DISTINCT p.id_professeur FROM professeur p 
                                           JOIN units u ON p.id_unit=u.id
                                           WHERE u.id_filiere = ? AND p.anneeUniversitaire=?;',[$filiere_id,$annee]);

                        $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$filiere_id,false);
                        $message = 'L\'emploi du temps du semestre '.$semestre.' de la filière '.$filiere['label'].' pour l\'année universitaire '.$annee.' est maintenant disponible.
                                    <a href="/webProject/Views/operations/exportEmploi.php?semestre='.$semestre.'&filiere='.$filiere['id'].'&annee='.$annee.'" class="btn btn-primary" style="margin-top:15px;display:inline-block;">Exporter</a>';

                        foreach($profs as $prof){
                            envoyerNotification($prof['id_professeur'],$message,'Emploi du Temps - Semestre '.$semestre);
                        }     
                        $_SESSION['flash'] = ['success' => true, 'message' => 'Emploi du temps importé avec succès.'];
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
