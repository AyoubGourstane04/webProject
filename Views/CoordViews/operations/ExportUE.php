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
    'Code Module', 'Intitulé', 'Semestre', 'Nombre de crédits',
    'Cours', 'TD', 'TP', 'Autre', 'Évaluation', 'Volume Total','Spécialité',
    'Département', 'Statut', 'Professeur'
]];

// Data rows
foreach ($units as $unit) {
    $department = GetFromDb("SELECT * FROM departement WHERE id=?;", $unit['departement_id'], false);
    $prof = GetFromDb("SELECT u.firstName, u.lastName FROM utilisateurs u
                       JOIN professeur p ON u.id = p.id_professeur
                       WHERE p.id_unit = ?;", $unit['id'], false);
    $hours = GetFromDb("SELECT * FROM volumehorraire WHERE id_unit=?;", $unit['id'], false);

    $cours = $hours['Cours'] ?? 0;
    $td = $hours['TD'] ?? 0;
    $tp = $hours['TP'] ?? 0;
    $autre = $hours['Autre'] ?? 0;
    $evaluation = $hours['Evaluation'] ?? 0;
    $total = $hours['VolumeTotal'] ?? 0; 

    $data[] = [
        $unit['code_module'],
        $unit['intitule'],
        $unit['semestre'],
        $unit['credits'],
        $cours,
        $td,
        $tp,
        $autre,
        $evaluation,
        $total,
        $unit['speciality'],
        $department['departement_name'] ?? '',
        $unit['statut'] == 0 ? 'Non Réservé' : 'Réservé',
        ($prof['firstName'] ?? '') . ' ' . ($prof['lastName'] ?? '')
    ];
}

exportTableToExcel($data, 'unites_enseignement_'.$filiere['acronym'].'.xlsx');
