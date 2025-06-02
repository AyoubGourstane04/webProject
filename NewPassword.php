<?php
 require_once __DIR__ . '/Controller/controller.php';
 
    session_start();

    $result = changePassword();

    $_SESSION['flash']=$result;
    
    header("Location: /webProject/Views/login.php");
        exit();



?>

