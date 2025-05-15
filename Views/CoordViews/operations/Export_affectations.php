<?php
require_once __DIR__ . '/../../../Controller/controller.php';
require_once __DIR__ . '/../../operations/exportAction.php'; 
session_start();

if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
}

$Coord = GetFromDb("SELECT * FROM coordinateurs WHERE id_coordinateur = ?", $_SESSION['id'], false);
$units = GetFromDb("SELECT * FROM units WHERE id_filiere = ?", $Coord['id_filiere']);
$filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$Coord['id_filiere'],false);


// Header row
$data = [[
    'Code Module','Intitulé','Semestre','Département','Enseignant Responsable'
]];

// Data rows
foreach ($units as $unit) {
    $department = GetFromDb("SELECT * FROM departement WHERE id=?;", $unit['departement_id'], false);
    $prof = GetFromDb("SELECT u.firstName, u.lastName FROM utilisateurs u
                       JOIN professeur p ON u.id = p.id_professeur
                       WHERE p.id_unit = ?;", $unit['id'], false);
   
    $data[] = [
        $unit['code_module'],
        $unit['intitule'],
        $unit['semestre'],
        $department['departement_name'] ?? '',
        ($prof['firstName'] ?? '') . ' ' . ($prof['lastName'] ?? '')
    ];
}

exportTableToExcel($data, 'List_Affectations_'.$filiere['acronym'].'.xlsx');
