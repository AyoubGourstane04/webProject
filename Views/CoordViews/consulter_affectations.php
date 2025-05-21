<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title=$data['firstName'].' '.$data['lastName'];
    $userName=$data['firstName'].' '.$data['lastName'];
    
    $Coord=GetFromDb("SELECT * FROM coordinateurs WHERE id_coordinateur	=? ;",$_SESSION['id'],false);

    $units=GetFromDb("SELECT * FROM units WHERE id_filiere=? AND statut=1 ;",$Coord['id_filiere']);


?>

    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/navBars/CoordNav.php";?>


   <?php require_once "../include/header.php";?>
   
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Title -->
                    <h1 class="h3 mb-4 text-gray-800">Liste des affectations</h1>

                    <!-- Export Button -->
                    <div class="mb-4">
                        <a href="operations/Export_affectations.php" class="btn btn-success">
                            <i class="fas fa-file-export"></i> Exporter vers Excel
                        </a>
                    </div>

                <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Code Module</th> 
                                    <th>Intitulé</th>
                                    <th>Semestre</th>
                                    <th>Departement</th>
                                    <th>Enseignant Responsable</th>
                                </tr>
                            </thead>
                            <tbody>

                                    <?php foreach($units as $unit){ 
                                            $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$unit['departement_id'],false);
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
                                            <td>
                                                <?php echo ($department && isset($department['departement_name'])) ? $department['departement_name'] : ''; ?>
                                            </td>

                                            <td>
                                                <?php echo ($prof && isset($prof['firstName']) && isset($prof['lastName'])) ? $prof['firstName'].' '.$prof['lastName'] : '-'; ?>
                                            </td>
                                        </tr>
                                       <?php }?>
                                    </tbody>
                </table>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



   
        <?php require_once "../include/footer.php";?>







<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>