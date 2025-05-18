<?php
   require_once __DIR__ . '/../../../Controller/controller.php';

   $dept_id=$_GET['id_dept'];
   $fil_id=$_GET['id_fil'];

    CreerVacataire($dept_id,$fil_id);

?>