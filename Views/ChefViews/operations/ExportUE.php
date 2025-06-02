<?php
require_once __DIR__ . '/../../../Controller/controller.php';
require_once __DIR__ . '/../../operations/exportAction.php'; 
session_start();

if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
}

$Chef=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);
$units=GetFromDb("SELECT * FROM units WHERE departement_id=? ;",$Chef['id_departement']);
$department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$Chef['id_departement'],false);


// Header row
$data = [[
    'Code Module', 'Intitulé', 'Semestre', 'Nombre de crédits',
    'Cours', 'TD', 'TP', 'Autre', 'Évaluation', 'Volume Total','Spécialité',
    'Filière', 'Statut', 'Professeur'
]];

// Data rows
foreach ($units as $unit) {
    $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
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
        $filiere['label'] ?? '',
        $unit['statut'] == 0 ? 'Non Réservé' : 'Réservé',
        ($prof['firstName'] ?? '') . ' ' . ($prof['lastName'] ?? '')
    ];
}
$dept=trim($department['acronym']);
$fileName='unites_enseignement_'.$dept.'.xlsx';
exportTableToExcel($data,$fileName);
