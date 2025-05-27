<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title="Importer Notes";
    $userName=$data['firstName'].' '.$data['lastName'];



?>

<!-- Page Wrapper -->
<div id="wrapper">
<?php require_once "../include/navBars/ProfNav.php";?>

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
                                <h1 class="h4 text-gray-900 mb-4">Uploader les Notes</h1>
                            </div>
                            <form action="../operations/ImportNotes.php?id_prof=<?=$_SESSION['id']?>" class="user" method="POST" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="semestre" class="form-label">Semestre</label>
                                            <select class="form-control" id="semestre" name="semestre" onchange="filterUnits()" >
                                                <option value="" selected>Semestre</option>
                                                    <option value="S1">S1</option>
                                                    <option value="S2">S2</option>
                                                    <option value="S3">S3</option>
                                                    <option value="S4">S4</option>
                                                    <option value="S5">S5</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-9">
                                        <label for="unit" class="form-label">Module</label>
                                        <select class="form-control" id="unit" name="unit" >
                                            <option value="" selected>Sélectionnez l' U.E</option>
                                            <?php 
                                            $units=GetFromDb('SELECT * FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=?;',$_SESSION['id']);
                                            foreach($units as $unit){
                                            ?>
                                                <option value="<?=$unit['id']?>" data-semestre="<?= $unit['semestre']?>">
                                                    <?=$unit['intitule']?>
                                                </option>
                                            <?php 
                                                }  
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <label for="Au" class="form-label">Année Universitaire</label>
                                        <select id="Au"  class="form-control" name="Au" required>
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
                                    <div class="col-sm-6">
                                        <label for="session" class="form-label">Session</label>
                                        <select class="form-control" id="session" name="session" required>
                                            <option value="" selected>--Sélectionnez la Session--</option>
                                                <option value="normale">Normale</option>
                                                <option value="rattrapage">Rattrapage</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="form-group row mb-4">
                                    <div class="col-12">
                                        <label class="form-label fw-bold mb-3">Importer le fichier des Notes </label>
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-file-upload fa-3x text-primary mb-3"></i>
                                                    <div class="custom-file-upload">
                                                        <input type="file" class="d-none" name="Note_file" id="formFile" required>
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

     
            <!-- </div> -->
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

    <script>
function filterUnits() {
    const semestreFilter = document.getElementById('semestre').value;
    const unitOptions = document.getElementById('unit').options;
    
    for (let i = 0; i < unitOptions.length; i++) {
        const option = unitOptions[i];
        if (option.value === "") {
            option.style.display = "";
            continue;
        }
        
        const semestreMatch = semestreFilter === "" || option.getAttribute('data-semestre') === semestreFilter;        
        if (semestreMatch) {
            option.style.display = "";
        } else {
            option.style.display = "none";
        }
    }
    
    // Reset the selected value if it's now hidden
    if (document.getElementById('unit').options[document.getElementById('unit').selectedIndex].style.display === "none") {
        document.getElementById('unit').selectedIndex = 0;
    }
}
</script>







<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>
