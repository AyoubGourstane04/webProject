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
                    <h1 class="h4 text-gray-900 mb-4">Definir Groupes TD/TP</h1>
                </div>
                <form action="operations/ajouter_td_tp.php?id_coord=<?=$_SESSION['id']?>&id_filiere=<?=$Coord['id_filiere']?>" class="user" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="type" class="form-label">Types</label>
                            <select class="form-control" id="type" name="type">
                                <option value="" selected>Sélectionnez le Type des Groupes </option>
                                    <option value="TD">TD</option>
                                    <option value="TP">TP</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="semestre" class="form-label">Semestres</label>
                            <select class="form-control" id="semestre" name="semestre">
                                <option value="" selected>Sélectionnez le semestre</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="S4">S4</option>
                                    <option value="S5">S5</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="AU" class="form-label">Année Universitaire</label>
                            <select id="AU"  class="form-control" name="AU" required>
                            <option value="">-- Sélectionnez l'année universitaire--</option>
                            <?php
                                $currentYear = date('Y');
                                $currentMonth = date('n');
                                $lastAcademicStart = ($currentMonth >= 9) ? $currentYear : $currentYear - 1;
                                $defaultAcademicYear = "$lastAcademicStart-" . ($lastAcademicStart + 1);

                                for ($i = $lastAcademicStart - 5; $i <= $lastAcademicStart; $i++) {
                                    $nextYear = $i + 1;
                                    $value = "$i-$nextYear";
                                    $selected = ($value === $defaultAcademicYear) ? 'selected' : '';
                                    echo "<option value=\"$value\" $selected>$value</option>";
                                }
                            ?>
                            </select>

                        </div>
                    </div>
                   
                    <div class="form-group row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold mb-3">Importer le fichier des groupes </label>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-file-upload fa-3x text-primary mb-3"></i>
                                        <div class="custom-file-upload">
                                            <input type="file" class="d-none" name="Groupe_file" id="formFile" required>
                                            <label for="formFile" class="btn btn-outline-primary px-4 py-2 rounded-pill">
                                                <i class="fas fa-folder-open me-2"></i> Choisir un fichier
                                            </label>
                                            <div class="small text-muted mt-2" id="fileName">Aucun fichier sélectionné</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="submit" value="Valider" class="btn btn-primary btn-user btn-block">
                </form>

            </div>
        </div>
    </div>
</div>
```

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


<script>
    // Display selected file name
    document.getElementById('formFile').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : "Aucun fichier sélectionné";
        document.getElementById('fileName').textContent = fileName;
    });
</script>

<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>
