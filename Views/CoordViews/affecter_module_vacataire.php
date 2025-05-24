<?php
   require_once __DIR__ . '/../../Controller/controller.php';
   session_start();
   if ((!isset($_SESSION['role']))&&!isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }

    ob_start();
   
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title="Affecter Unités";
    
    $userName=$data['firstName'].' '.$data['lastName'];

    $Ue_id=isset($_GET['unit_id'])?$_GET['unit_id']:null;


    $Coord=GetFromDb("SELECT * FROM coordinateurs WHERE id_coordinateur	=? ;",$_SESSION['id'],false);

    $departement=GetFromDb("SELECT * FROM filieres WHERE id	=? ;",$Coord['id_filiere'],false);

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
                                WHERE u.id_departement=? AND r.role_id=5 AND u.id!=? ;",[$data['id_departement'],$data['id']]);


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
                        <h1 class="h4 text-gray-900 mb-4">Affecter des unités d'enseignement au Vacataires</h1>
                    </div>
                    <form action="../../addUnit_prof.php" class="user" method="POST">
                       
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="semestre" class="form-label">Semestres</label>
                                    <select class="form-control" id="semestre" name="semestre" onchange="filterUnits()" >
                                        <option value="" selected>--Semestre--</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                            <option value="S4">S4</option>
                                            <option value="S5">S5</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
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
                                    <label for="prof" class="form-label">Vacataires</label>
                                    <select class="form-control" id="prof" name="prof" >
                                        <option value="" selected>Sélectionnez le Vacataire</option>
                                        <?php foreach($vacataires as $prof){  ?>
                                        <option value="<?= $prof['id']?>"><?php echo $prof['firstName'].' '.$prof['lastName'];?></option>

                                        <?php   }  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="unit" class="form-label">Unités</label>
                                    <select class="form-control" id="unit" name="unit" >
                                        <option value="" selected>Sélectionnez le Module</option>
                                        <?php 
                                          $units=GetFromDb("SELECT * FROM units WHERE id_filiere=? AND statut=0 ;",$Coord['id_filiere']);
                                        foreach($units as $unit){
                                        ?>
                                        <!-- <option value="<?=$unit['id']?>" data-semestre="<?= $unit['semestre']?>"><?=$unit['intitule']?></option> -->
                                         <option value="<?=$unit['id']?>" data-filiere="<?= $unit['id_filiere']?>" data-semestre="<?= $unit['semestre']?>" <?= ($Ue_id == $unit['id']) ? 'selected' : '' ?>>
                                                   <?=$unit['intitule']?>
                                            </option>
                                        <?php 
                                            }  
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" value="Affecter" class="btn btn-primary btn-user btn-block">
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

