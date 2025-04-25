<?php
    session_start();
    if ((!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1)&&!isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }

    ob_start();
    $title="Ajouter un Enseignant";

    
    
?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/nav.php";?>

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
                        <h1 class="h4 text-gray-900 mb-4">Ajouter un Enseignant</h1>
                    </div>
                    <form action="../../create.php" class="user" method="POST">
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
                                placeholder="Ex: AB12345" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-user" id="InputEmail" name="email"
                                placeholder="Adresse email" required>
                        </div>     
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control form-control-user" id="InputSpeciality" name="speciality" placeholder="Spécialité" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="department" class="form-label">Département </label>
                            <select class="form-control" id="department" name="department" >
                                <option value="" disabled selected>Sélectionnez le département</option>
                                <option value="1">Mathématiques et Informatique (MI)</option>
                                <option value="2">Génie Civil Energétique et Environnement (GCEE)</option>
                            </select>
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