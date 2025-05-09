<?php

    require_once '../../../Controller/controller.php';

    require_once '../../../include/ImportingExcel.php';

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(!isset($_FILES['UeFile'])&&$_FILES['UeFile']['error'] !== UPLOAD_ERR_OK){
            die("Error: Please upload a valid file.");
        }
        $pdo=dataBaseConnection();
        $importUE= new ExcelImporter($pdo);
        $filePath=$_FILES['UeFile']['tmp_name'];

        $importUE->import($filePath);

    }
    




?>


