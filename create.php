<?php
 require_once __DIR__ . '../Controller/controller.php';
 
    session_start();
    
    $id=$_GET['id'];
    
    $response = create($id);

    $_SESSION['flash'] = $response; 

    header('location: Views/adminViews/admin.php');
      exit();