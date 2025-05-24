
<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title='Mes Modules';
    $userName=$data['firstName'].' '.$data['lastName'];

    $units=GetFromDb('SELECT * FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=?;',$_SESSION['id']);


?>

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php require_once "../include/navBars/CoordNav.php";?>

    <?php require_once "../include/header.php";?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
       
   <?php 
    if (isset($_SESSION['AddMessage'])){
        $notification = $_SESSION['AddMessage'];
        unset($_SESSION['AddMessage']);
        $alertType = $notification['success'] ? 'alert-success' : 'alert-danger';
    ?>
    <div class="container mt-3 d-flex justify-content-center">
        <div id="notification-toast" class="alert <?= $alertType ?> d-flex align-items-center justify-content-between w-100" style="max-width: 600px;">
            <span><?= htmlspecialchars($notification['message']) ?></span>
            <button type="button" class="btn-close ms-3" aria-label="Close" onclick="document.getElementById('notification-toast').remove()"></button>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('notification-toast');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
<?php } ?>
       
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Mes Unités</h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">liste des unités</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Code Module</th>
                                            <th rowspan="2">Intitulé</th>
                                            <th rowspan="2">Semestre</th>
                                            <th rowspan="2">Filière</th>
                                            <th rowspan="2">Département</th>
                                            <th colspan="5">Volume Horaire</th>
                                            <th rowspan="2">Volume Total</th>
                                            <th rowspan="2">Operation</th>
                                        </tr>
                                        <tr>
                                            <th>Cours</th>
                                            <th>TD</th>
                                            <th>TP</th>
                                            <th>Autre</th>
                                            <th>Évaluation</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($units as $unit){ 
                                            $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$unit['departement_id'],false);
                                            $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
                                            $hours=GetFromDb('SELECT * FROM volumehorraire WHERE id_unit=?;',$unit['id'],false);   
                                            $cours = $hours['Cours'] ?? 0;
                                            $td = $hours['TD'] ?? 0;
                                            $tp = $hours['TP'] ?? 0;
                                            $autre = $hours['Autre'] ?? 0;
                                            $evaluation = $hours['Evaluation'] ?? 0; 
                                            $VolumeTotal = $hours['VolumeTotal'] ?? 0; 
                                    ?>
                                        <tr>
                                            <td><?php echo $unit['code_module'];?></td>
                                            <td><?php echo $unit['intitule'];?></td>
                                            <td><?php echo $unit['semestre'];?></td>
                                            <td>
                                                <?php echo ($filiere && isset($filiere['label'])) ? $filiere['label'] : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo ($department && isset($department['departement_name'])) ? $department['departement_name'] : ''; ?>
                                            </td>
                                            <td><?php echo $cours;?></td>
                                            <td><?php echo $td;?></td>
                                            <td><?php echo $tp;?></td>
                                            <td><?php echo $autre;?></td>
                                            <td><?php echo $evaluation;?></td>
                                            <td><?php echo $VolumeTotal;?></td>
                                            <td> <a href="suprimermodule.php?id_unite=<?=$unit['id']?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette Unité ?')">Supprimer</a>  </td>                                      
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

