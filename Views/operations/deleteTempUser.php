<?php
    require_once __DIR__ . '/../../Controller/controller.php';

    $id= $_GET['id'];

    session_start();

    $result = deleteTempUser($id);

    $_SESSION['flash']=$result;

  header('location: '.$_SERVER['HTTP_REFERER']);
    exit();