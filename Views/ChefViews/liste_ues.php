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
    <?php require_once "../include/navBars/ChefNav.php";?>

    <?php require_once "../include/header.php";?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Unités d'enseignement</h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">liste des unités d'enseignement</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Code Module</th> 
                                            <th>Intitulé</th>
                                            <th>Semestre</th>
                                            <th>Nombre de crédits</th>
                                            <th>Filière</th>
                                            <th>Departement</th>
                                            <th>Statut</th>
                                            <th>Professeur</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($units as $unit){ 
                                            $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$unit['departement_id'],false);
                                            $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
                                            $prof = GetFromDb("SELECT 
                                                                u.firstName,
                                                                u.lastName
                                                                FROM utilisateurs u
                                                                JOIN professeur p 
                                                                ON u.id=p.id_professeur
                                                                WHERE p.id_unit=?;",$unit['id'],false);
                                    ?>
                                        <tr>
                                            <td><?php echo $unit['code_module'];?></td>
                                            <td><?php echo $unit['intitule'];?></td>
                                            <td><?php echo $unit['semestre'];?></td>
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
                                            <td>
                                                <?php echo ($prof && isset($prof['firstName']) && isset($prof['lastName'])) ? $prof['firstName'].' '.$prof['lastName'] : '-'; ?>
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

