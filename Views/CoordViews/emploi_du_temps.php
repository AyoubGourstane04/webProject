<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role'])&&!isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title=$data['firstName'].' '.$data['lastName'];
    $userName=$data['firstName'].' '.$data['lastName'];
    
    $Coord=GetFromDb("SELECT * FROM coordinateurs WHERE id_coordinateur	=? ;",$_SESSION['id'],false);




?>

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php require_once "../include/navBars/CoordNav.php";?>

    <?php require_once "../include/header.php";?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Charger Emploi du temps</h1>
                    </div>
                    <form action="operations/ajouter_Emploi.php?id_coord=<?=$_SESSION['id']?>&id_filiere=<?=$Coord['id_filiere']?>" class="user" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">
                                        <i class="fas fa-file-import me-2"></i> Importer l'emploi du temps
                                    </label>
                                    <input class="form-control-primary btn btn-primary" type="file" name="emploi_file" id="formFile" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="semestre" class="form-label">Semestre</label>
                                <select class="form-control" id="semestre" name="semestre">
                                    <option value="" selected>Sélectionnez le semestre</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="S4">S4</option>
                                        <option value="S5">S5</option>
                                </select>
                            </div>
                        </div>

                        <input type="submit" value="Valider" class="btn btn-primary btn-user btn-block">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <?php require_once "../include/footer.php";?>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    
    


<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>

