<?php
   require_once __DIR__ . '/../../../Controller/controller.php';

   $filiere_id=isset($_GET['id_filiere'])?htmlspecialchars($_GET['id_filiere']):'';
   $dept_id=isset($_GET['id_dept'])?htmlspecialchars($_GET['id_dept']):'';

   $result=addUnit($filiere_id,$dept_id);

   session_start();
   $_SESSION['AddMessage']=$result;
   header('location: '.$_SERVER['HTTP_REFERER']);
   exit();

?>