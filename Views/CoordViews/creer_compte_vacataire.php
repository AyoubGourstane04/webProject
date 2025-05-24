<?php
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title='Ajouter Vacatires';
    $userName=$data['firstName'].' '.$data['lastName'];

    $dept_id=$data['id_departement'];
    $Coord=GetFromDb("SELECT * FROM coordinateurs WHERE id_coordinateur	=? ;",$_SESSION['id'],false);
    $filiere=$Coord['id_filiere'];




?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/navBars/CoordNav.php";?>

   <?php require_once "../include/header.php";?>
   
 <!-- Begin Page Content -->
                <div class="container-fluid">
                <div class="container">
                        <?php  displayFlashMessage(); ?>


<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Ajouter un Vacataire</h1>
                    </div>
                    <form action="operations/ajouter_vacataire.php?id_dept=<?=$dept_id?>&id_fil=<?=$filiere?>" class="user" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" id="FirstName" name="firstName" placeholder="Prénom" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-user" id="LastName" name="lastName" placeholder="Nom" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <?php $today = date('Y-m-d'); ?>
                            <label for="birthdate" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control form-control-user" id="birthdate" name="birthdate" min="1900-01-01" max="<?php echo $today; ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="cin" class="form-label">CIN (Carte d'Identité Nationale)</label>
                            <input type="text" class="form-control form-control-user" id="cin" name="cin" 
                                placeholder="Ex: AB123456" required>
                        </div>
                    </div><br>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="email" class="form-control form-control-user" id="InputEmail" name="email"
                                placeholder="Adresse email" required>
                        </div>     
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-user" id="InputSpeciality" name="speciality" placeholder="Spécialité"  required>
                        </div>
                    </div>

                   
                    
                    
                    <input type="submit" value="Ajouter" class="btn btn-primary btn-user btn-block">
 
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


   
        <?php require_once "../include/footer.php";?>




   







<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>