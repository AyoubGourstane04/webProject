<?php
   require_once __DIR__ . '/../../Controller/controller.php';
   session_start();
   if ((!isset($_SESSION['role']))&&!isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }

    ob_start();
   
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title="Ajouter Une UE";
    
    $userName=$data['firstName'].' '.$data['lastName'];

    $Coord=GetFromDb("SELECT * FROM coordinateurs WHERE id_coordinateur	=? ;",$_SESSION['id'],false);

    $departement=GetFromDb("SELECT * FROM filieres WHERE id	=? ;",$Coord['id_filiere'],false);


?>


    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php require_once "../include/navBars/CoordNav.php";?>

   <?php require_once "../include/header.php";?>
   
    <!-- Hna ila bgha i importi l UE machi idekhelha bidih -->
    <div class="container mt-3 d-flex justify-content-end">
        <form action="operations/importUE.php?id_filiere=<?=$Coord['id_filiere']?>&id_dept=<?=$departement['id_departement']?>" method="POST" enctype="multipart/form-data">
            <label class="btn btn-primary mb-0" style="cursor: pointer;">
                <i class="fas fa-file-import"></i>  Importer l'Unité d'Enseignement
                <input type="file" name="UeFile" hidden onchange="this.form.submit()">
            </label>
        </form>
    </div>


 <!--Notification ta3 les erreurs oula success  mn hna -->
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
    <!--7tal hna-->
   
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
                        <h1 class="h4 text-gray-900 mb-4">Ajouter Une Unité d'Enseignement</h1>
                    </div>
                    <form action="operations/ajouterUE.php?id_filiere=<?=$Coord['id_filiere']?>&id_dept=<?=$departement['id_departement']?>" class="user" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <label for="code_module" class="form-label">Code De Module</label>
                            <input type="text" class="form-control form-control-user" id="code_module" name="code_module" placeholder="Code de module" required>
                        </div>
                        <div class="col-sm-9">
                            <label for="intitule" class="form-label">Intitulé</label>
                            <input type="text" class="form-control form-control-user" id="intitule" name="intitule" placeholder="Intitulé" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="speciality" class="form-label">Spécialité</label>
                            <input type="text" class="form-control form-control-user" id="speciality" name="speciality" placeholder="Spécialité" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="credit" class="form-label">Crédit</label>
                            <input type="number" class="form-control form-control-user" id="credits" name="credits" min="0" step="0.01"
                                placeholder="Crédit" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="semestre" class="form-label">Semestre</label>
                            <select class="form-control" id="semestre" name="semestre" >
                                <option value="" selected>Sélectionnez le semestre</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="S4">S4</option>
                                    <option value="S5">S5</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group">
                                    <p class="h6 text-gray-800 mb-4">Volume Horraire</p>
                                    <div class="row">  
                                        <div class="col-md-4">
                                            <label for="CM" class="form-label">Cours Magistraux</label>
                                            <input type="number" class="form-control form-control-user" name="CM" id="CM" min="0" value="0">
                                        </div>  
                                        <div class="col-md-4">
                                            <label for="TD" class="form-label">Travaux Dirigés</label>
                                            <input type="number" class="form-control form-control-user" name="TD" id="TD" min="0" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="TP" class="form-label">Travaux Pratiques</label>
                                            <input type="number" class="form-control form-control-user" name="TP" id="TP" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                         <div class="col-md-6">
                                            <label for="autre" class="form-label">Autre</label>
                                            <input type="number" class="form-control form-control-user" name="autre" id="autre" min="0" value="0">
                                        </div>  
                                        <div class="col-md-6">
                                            <label for="evaluation" class="form-label">Evaluation</label>
                                            <input type="number" class="form-control form-control-user" name="evaluation" id="evaluation" min="0" value="0">
                                        </div>
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