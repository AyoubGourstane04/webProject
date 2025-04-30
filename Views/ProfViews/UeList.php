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

    $units=GetFromDb("SELECT * FROM units WHERE departement_id=? ;",$data['id_departement']);



?>

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php require_once "../include/navBars/ProfNav.php";?>

    <?php require_once "../include/header.php";?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Unités d'enseignement disponible</h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">liste des unités d'enseignement disponible</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id</th> 
                                            <th>Nom</th>
                                            <th>Description</th>
                                            <th>Volume Horraire</th>
                                            <th>Nombre de crédits</th>
                                            <th>Filière</th>
                                            <th>Departement</th>
                                            <th>Statut</th>
                                            <th>Demander</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($units as $unit){ 
                                            $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$unit['departement_id'],false);
                                            $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
                                    ?>
                                        <tr>
                                            <td><?php echo $unit['id'];?></td>
                                            <td><?php echo $unit['unit_name'];?></td>
                                            <td><?php echo $unit['description'];?></td>
                                            <td><?php echo $unit['Hours'];?></td>
                                            <td><?php echo $unit['credits'];?></td>
                                            <td>
                                                <?php echo ($filiere && isset($filiere['label'])) ? $filiere['label'] : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo ($department && isset($department['departement_name'])) ? $department['departement_name'] : ''; ?>
                                            </td>
                                            <td><?php if($unit['statut']==0){
                                                            echo'Non Réservé';
                                                        }else{
                                                            echo 'Réservé';
                                                        }
                                                ?>    
                                            </td>
                                            <td class="text-center">
                                                <?php if($unit['statut']==0){?>
                                                    <a href="demandeUE.php?id=<?php echo $unit['id'];?>" class="btn btn-primary btn-circle">+</a>
                                                <?php }else{?>
                                                    <button class="btn btn-danger btn-circle" disabled>x</button>
                                                <?php }?>
                                            </td>
                                        </tr>
                                       <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <?php require_once "../include/footer.php";?>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div> -->




<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>

