<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title='Modules de Département';
    $userName=$data['firstName'].' '.$data['lastName'];

    $units=GetFromDb("SELECT * FROM units WHERE departement_id=? ;",$data['id_departement']);

    $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$data['id_departement'],false);

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
                    <h1 class="h3 mb-2 text-gray-800">Unités d'enseignement de Département <?=$department['departement_name']?></h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                         <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des unités d'enseignement</h6>
                            <form method="post" action="operations/ExportUE.php">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel"></i> Exporter Excel
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                       <tr>
                                            <th rowspan="2">Code Module</th>
                                            <th rowspan="2">Intitulé</th>
                                            <th rowspan="2">Semestre</th>
                                            <th rowspan="2">Nombre de crédits</th>
                                            <th colspan="5">Volume Horaire</th>
                                            <th rowspan="2">Volume Total</th>
                                            <th rowspan="2">Filière</th>
                                            <th rowspan="2">Statut</th>
                                            <th rowspan="2">Professeur</th>
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
                                            $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
                                            $prof = GetFromDb("SELECT 
                                                                u.firstName,
                                                                u.lastName
                                                                FROM utilisateurs u
                                                                JOIN professeur p 
                                                                ON u.id=p.id_professeur
                                                                WHERE p.id_unit=?;",$unit['id'],false);
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
                                            <td><?php echo $unit['credits'];?></td>
                                            <td><?php echo $cours;?></td>
                                            <td><?php echo $td;?></td>
                                            <td><?php echo $tp;?></td>
                                            <td><?php echo $autre;?></td>
                                            <td><?php echo $evaluation;?></td>
                                            <td><?php echo $VolumeTotal;?></td>
                                            <td>
                                                <?php echo ($filiere && isset($filiere['label'])) ? $filiere['label'] : ''; ?>
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

