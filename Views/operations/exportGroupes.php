<?php
   require_once __DIR__ . '/../../Controller/controller.php';


    $filiere_id = isset($_GET['filiere']) ? intval($_GET['filiere']) : null;
    $semestre = isset($_GET['semestre']) ? htmlspecialchars($_GET['semestre']) : null;
    $annee = isset($_GET['annee']) ? htmlspecialchars($_GET['annee']) : null;


   $Groupes=GetFromDb('SELECT * FROM groupes WHERE id_filiere=? AND semestre=? AND anneeUniversitaire=?;',[$filiere_id,$semestre,$annee],false);



    
    $sanitizedPath = basename($Groupes['groupes_file']);

    $fullPath = __DIR__ . '/../../resources/Groupes/' . $sanitizedPath;

    if (file_exists($fullPath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullPath));
        readfile($fullPath);
        exit;
    } else {
        die('Fichier introuvable.');
    }

    
?>