<?php
   require_once 'Controller/controller.php';

   session_start();
   $result=addUnit_prof();
   $_SESSION['flash']=$result;

   header('location: '.$_SERVER['HTTP_REFERER']);
          exit();
?>