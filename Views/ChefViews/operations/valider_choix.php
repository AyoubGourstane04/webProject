<?php
 require_once '../../../Controller/controller.php';

 $id_prof=isset($_POST['id_prof'])?intval($_POST['id_prof']):null;
 $id_unit=isset($_POST['id_unit'])?intval($_POST['id_unit']):null;
 $anne=isset($_POST['Au'])?htmlspecialchars($_POST['Au']):'';

 validate_choice_action($id_prof,$id_unit,$anne);

   

?>