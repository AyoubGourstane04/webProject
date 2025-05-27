<?php
   require_once __DIR__ . '/../../../Controller/controller.php';

   session_start();
   
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
                        $profs =GetFromDb('SELECT DISTINCT p.id_professeur FROM professeur p 
                                        JOIN units u ON p.id_unit=u.id
                                        WHERE u.id_filiere = ? AND p.anneeUniversitaire=?;',[$filiere_id,$annee]);

                        $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$filiere_id,false);
                       $message = 'Les groupes de '.$type.' du semestre '.$semestre.' de la filière '.$filiere['label'].' pour l\'année universitaire '.$annee.' est maintenant disponible.
                                    <a href="/webProject/Views/operations/exportGroupes.php?semestre='.$semestre.'&filiere='.$filiere['id'].'&annee='.$annee.'" class="btn btn-primary" style="margin-top:15px;display:inline-block;">Exporter</a>';

                        foreach($profs as $prof){
                            envoyerNotification($prof['id_professeur'],$message,'Groupes '.$type.' - Semestre '.$semestre);
                        } 
                               
                        $_SESSION['flash'] = ['success' => true, 'message' => 'Fichier des groupes importé avec succès.'];
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
        $_SESSION['flash'] = ['success' => false, 'message' => 'Erreur dans l\'envoi du fichier (code : ' . $_FILES['Groupe_file']['error'] . ')'];
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>
