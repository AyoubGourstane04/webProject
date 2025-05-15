<?php
require_once __DIR__ . '/../../../Controller/controller.php';
require_once __DIR__ . '/../../operations/exportAction.php'; 
session_start();

if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
}

$Chef=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);
$department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$Chef['id_departement'],false);
$professeurs = GetFromDb("SELECT 
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
                                WHERE u.id_departement=? AND r.role_id=2 AND u.id!=? ;",[$Chef['id_departement'],$Chef['id']]);

// Header row
$data = [[
    'Id','Prenom','Nom','CIN','Date de Naissance','Email','Spécialité'
]];

// Data rows
foreach ($professeurs as $prof) {
    $data[] = [
        $prof['id'],
        $prof['firstName'],
        $prof['lastName'],
        $prof['CIN'],
        $prof['Birthdate'],
        $prof['email'],
        $prof['speciality']
    ];
}

exportTableToExcel($data, 'Liste_Enseignats_'.$department['acronym'].'.xlsx');
