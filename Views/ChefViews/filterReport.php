<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);
    

    $title='Générer Rapports';
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
                      <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Générer des Rapports</h1>
                        </div>
                        <form action="ReportsPage.php" class="user" method="POST">
                        
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="type" class="form-label">Type de rapport</label>
                                        <select id="type"  class="form-control" name="type">
                                        <option value="" selected>Tous</option>
                                        <option value="1">Unités d'Enseignement</option>
                                        <option value="2">Enseignants</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="filiere" class="form-label">Filière</label>
                                        <select class="form-control" id="filiere" name="filiere">
                                            <option value="" selected>Tous</option>
                                            <?php 
                                            $filieres=GetFromDb("SELECT * FROM filieres WHERE id_departement=? ;",$data['id_departement']);
                                            foreach($filieres as $filiere){
                                            ?>
                                            <option value="<?= $filiere['id']?>"><?=$filiere['acronym']?></option>
                                            <?php    
                                                    }  
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="semestre" class="form-label">Semestre</label>
                                        <select class="form-control" id="semestre" name="semestre">
                                            <option value="" selected>Tous</option>
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
                                        <option value="">Année Universitaire</option>
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
                                <input type="submit" value="Générer Rapport" class="btn btn-primary btn-user btn-block">
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

    


<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>

