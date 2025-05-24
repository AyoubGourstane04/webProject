<?php
    require_once '../../../Controller/controller.php';

    $id_prof=isset($_POST['id_prof'])?intval($_POST['id_prof']):null;
    $id_unit=isset($_POST['id_unit'])?intval($_POST['id_unit']):null;
    $annee=isset($_POST['Au'])?htmlspecialchars($_POST['Au']):'';

    session_start();
    
    $result=validate_choice_action($id_prof,$id_unit,$annee);
    $_SESSION['flash']=$result;
        
        header('location: '.$_SERVER['HTTP_REFERER']);
            exit();


   

?>