<?php
   require_once __DIR__ . '/../../../Controller/controller.php';

   $dept_id=$_GET['id_dept'];
   $fil_id=$_GET['id_fil'];

   session_start();


    $result=CreerVacataire($dept_id,$fil_id);
    $_SESSION['flash']=$result;
    
        header('location: '.$_SERVER['HTTP_REFERER']);
            exit();
?>