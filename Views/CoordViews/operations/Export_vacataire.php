<?php
require_once __DIR__ . '/../../../Controller/controller.php';
require_once __DIR__ . '/../../operations/exportAction.php'; 
session_start();

if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
}

$Coord = GetFromDb("SELECT * FROM coordinateurs WHERE id_coordinateur = ?", $_SESSION['id'], false);
$filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$Coord['id_filiere'],false);

$vacataires = GetFromDb("SELECT 
                                u.id,
                                u.firstName,
                                u.lastName,
                                u.CIN,
                                u.Birthdate,
                                u.email,
                                u.speciality 
                                FROM utilisateurs u
                                JOIN userroles r 
                                ON u.id=r.user_id 
                                WHERE r.role_id=? AND u.id!=? ;",[5,$Coord['id_coordinateur']]);
// Header row
$data = [[
    'Id','Prenom','Nom','CIN','Date de Naissance','Email','Spécialité'
]];

// Data rows
foreach ($vacataires as $vacataire) {
    $data[] = [
        $vacataire['id'],
        $vacataire['firstName'],
        $vacataire['lastName'],
        $vacataire['CIN'],
        $vacataire['Birthdate'],
        $vacataire['email'],
        $vacataire['speciality']
    ];
}

exportTableToExcel($data, 'Liste_Vacataires_'.$filiere['acronym'].'.xlsx');
