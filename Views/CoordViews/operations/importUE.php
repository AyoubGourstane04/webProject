<?php
require_once '../../../Controller/controller.php';
require_once '../../../include/ImportingExcel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['UeFile']) || $_FILES['UeFile']['error'] !== UPLOAD_ERR_OK) {
        die("Error: Please upload a valid file.");
    }

    $filiere_id = isset($_GET['id_filiere']) ? (int)htmlspecialchars($_GET['id_filiere']) : 0;
    $dept_id = isset($_GET['id_dept']) ? (int)htmlspecialchars($_GET['id_dept']) : 0;

    if (empty($filiere_id) || empty($dept_id)) {
        die("Error: Missing filière or department ID.");
    }

    $pdo = dataBaseConnection();
    $importUE = new ExcelImporter($pdo);
    $filePath = $_FILES['UeFile']['tmp_name'];

    session_start();
    $message = $importUE->import($filePath, $filiere_id, $dept_id);
    $_SESSION['AddMessage'] = $message;

    header('location: '.$_SERVER['HTTP_REFERER']);
        exit();
}
?>
