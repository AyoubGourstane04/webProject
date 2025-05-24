<?php
 require_once '../../../Controller/controller.php';

 $id_prof=$_GET['id_prof'];
 $id_unit=$_GET['id_unit'];

 
    session_start();
    
    $result=refuse_choice_action($id_prof,$id_unit);;
    $_SESSION['flash']=$result;
        
        header('location: '.$_SERVER['HTTP_REFERER']);
            exit();


?>