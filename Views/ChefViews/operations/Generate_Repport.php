<?php
   require_once __DIR__ . '/../../../Controller/controller.php';

   session_start();
   
   if (!isset($_SESSION['role'])&&!isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }

   $fil_id=isset($_POST['filiere'])?intval($_POST['filiere']):null;
   $semestre=isset($_POST['semestre'])?htmlspecialchars($_POST['semestre']):null;




   print_r($fil_id);
   print_r($semestre);









?>