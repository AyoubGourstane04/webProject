<?php
   require_once __DIR__ . '/../../Controller/controller.php';
   session_start();
   if ((!isset($_SESSION['role']) || $_SESSION['role'] != 1)&&!isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title="Enseignants";
    
    $userName=$data['firstName'].' '.$data['lastName'];

 


?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php require_once "../include/navBars/AdminNav.php";?>
    
   <?php require_once "../include/header.php";?>
   
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-4 text-gray-800"></h1> -->
                    <?php 
                        $header="Enseignants";
                        $role=2;
                        include_once "../include/tables.php";
                    ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



   
        <?php require_once "../include/footer.php";?>







<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>