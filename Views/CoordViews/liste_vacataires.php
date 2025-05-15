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

    $units=GetFromDb("SELECT * FROM units WHERE id_filiere=? AND statut=1 ;",$Coord['id_filiere']);
    $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$Coord['id_filiere'],false);

    $vacataires = GetFromDb("SELECT 
                                u.id,
                                u.firstName,
                                u.lastName,
                                u.CIN,
                                u.Birthdate,
                                u.email,
                                u.speciality 
                                FROM utilisateurs u
                                JOIN userroles r 
                                ON u.id=r.user_id 
                                WHERE r.role_id=? AND u.id!=? ;",[5,$Coord['id_coordinateur']]);


?>


    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php require_once "../include/navBars/CoordNav.php";?>

    <?php require_once "../include/header.php";?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">
                        Vacataires appartennant au filière <?=$filiere['label']?>
                    </h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                           <h6 class="m-0 font-weight-bold text-primary"> 
                                Vacataires appartennant au filière <?=$filiere['label']?>
                            </h6>
                            <form method="post" action="operations/Export_vacataire.php">
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
                                            <th>id</th> 
                                            <th>Prénom</th>
                                            <th>Nom</th>
                                            <th>CIN</th>
                                            <th>Date de naissance</th>
                                            <th>Email</th>
                                            <th>Spécialité</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($vacataires as $vacataire){ ?>
                                        <tr>
                                            <td><?php echo $vacataire['id'];?></td>
                                            <td><?php echo $vacataire['firstName'];?></td>
                                            <td><?php echo $vacataire['lastName'];?></td>
                                            <td><?php echo $vacataire['CIN'];?></td>
                                            <td><?php echo $vacataire['Birthdate'];?></td>
                                            <td><?php echo $vacataire['email'];?></td>
                                            <td><?php echo $vacataire['speciality'];?></td>         
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

