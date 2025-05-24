<?php
 require_once __DIR__ . '../Controller/controller.php';
 //$userId =$_GET['user_id'];
 
    session_start();
    $response = edit();

    $_SESSION['flash'] = $response;
   
    header('location: '.$_SERVER['HTTP_REFERER']);
    exit();


