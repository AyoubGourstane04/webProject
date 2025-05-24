<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title='Rapport';
    $userName=$data['firstName'].' '.$data['lastName'];
    $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$data['id_departement'],false);


    //hadchi ta3 data d rapport : 
        $fil_id = !empty($_POST['filiere']) ? $_POST['filiere'] : null;
        $semestre = !empty($_POST['semestre']) ? $_POST['semestre'] : null;
        $annee = !empty($_POST['Au']) ? $_POST['Au'] : null;
        $type = !empty($_POST['type']) ? $_POST['type'] : 'all';

        $query='SELECT p.id_professeur,p.id_unit FROM professeur p 
                JOIN units t ON p.id_unit = t.id WHERE p.anneeUniversitaire=? AND t.departement_id=? AND 1=1';


        $param=[$annee,$data['id_departement']];

        if($fil_id){
                $query.=' AND t.id_filiere=?';
                $param[]=$fil_id;
            }

        if($semestre){
                $query.=' AND t.semestre=?';
                $param[]=$semestre;
            }

            $RepportData=GetFromDb($query,$param);

      $minHours=100;      

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
                <?php
                    switch ($type) {
                        case 2:
                            ?>
                           <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">Répartition des Enseignants</h3>
                                    <div class="d-flex gap-2">
                                        <form method="post" action="operations/Report_pdf.php">
                                            <input type="hidden" name="filiere" value="<?= $fil_id ?>">
                                            <input type="hidden" name="semestre" value="<?= $semestre ?>">
                                            <input type="hidden" name="Au" value="<?= $annee ?>">
                                            <input type="hidden" name="type" value="<?= $type ?>">
                                            <button type="submit" class="btn btn-primary btn-sm mr-2">
                                                <i class="fas fa-file-pdf"></i> Exporter PDF
                                            </button>
                                        </form>
                                        <form method="post" action="operations/Report_excel.php">
                                            <input type="hidden" name="filiere" value="<?= $fil_id ?>">
                                            <input type="hidden" name="semestre" value="<?= $semestre ?>">
                                            <input type="hidden" name="Au" value="<?= $annee ?>">
                                            <input type="hidden" name="type" value="<?= $type ?>">                                            
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-file-excel"></i> Exporter Excel
                                            </button>
                                        </form>
                                    </div>                                
                                </div>
                                <div class="card-body">
                                       <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Prénom</th>
                                                <th>Departement</th>
                                                <th>Nb.UEs Enseigné</th>
                                                <th>Année Univ.</th>
                                                <th>Volume Horraire Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($RepportData as $row){
                                                    $prof=GetFromDb('SELECT * FROM utilisateurs WHERE id=? AND 	id_departement=? ;',[$row['id_professeur'],$data['id_departement']],false);
                                                    $nbrUnits=CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;',$row['id_professeur']);  
                                                    $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $row['id_professeur']);
                                                    $volume_horr= !empty($vol_horr)?$vol_horr:0;
                                                    $rowClass=($volume_horr<$minHours)?'table-danger':'';
                                                    $annee = CounterValues('SELECT anneeUniversitaire FROM professeur WHERE id_professeur=? AND id_unit=? ;',[$row['id_professeur'],$row['id_unit']]);
                                            ?>
                                                <tr class="<?=$rowClass?>">
                                                    <td><?= $prof['lastName'] ?></td>
                                                    <td><?= $prof['firstName'] ?></td>
                                                    <td><?= $department['departement_name']?></td>
                                                    <td><?= $nbrUnits ?></td>
                                                    <td><?= $annee ?></td>
                                                    <td><?= $volume_horr ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php
                            break;
                        
                        case 1:
                          ?>
                          <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">Liste des Unités d'Enseignement</h3>
                                    <div class="d-flex gap-2">
                                        <form method="post" action="operations/Report_pdf.php">
                                            <input type="hidden" name="filiere" value="<?= $fil_id ?>">
                                            <input type="hidden" name="semestre" value="<?= $semestre ?>">
                                            <input type="hidden" name="Au" value="<?= $annee ?>">
                                            <input type="hidden" name="type" value="<?= $type ?>">                         
                                            <button type="submit" class="btn btn-primary btn-sm mr-2">
                                                <i class="fas fa-file-pdf"></i> Exporter PDF
                                            </button>
                                        </form>
                                        <form method="post" action="operations/Report_excel.php">
                                            <input type="hidden" name="filiere" value="<?= $fil_id ?>">
                                            <input type="hidden" name="semestre" value="<?= $semestre ?>">
                                            <input type="hidden" name="Au" value="<?= $annee ?>">
                                            <input type="hidden" name="type" value="<?= $type ?>">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-file-excel"></i> Exporter Excel
                                            </button>
                                        </form>
                                    </div>                                
                                </div>
                                <div class="card-body">
                                  <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>Code Module</th>
                                                <th>Intitulé</th>
                                                <th>Filière</th>
                                                <th>Semestre</th>
                                                <th>Responsable</th>
                                                <th>Année Univ.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($RepportData as $row){
                                                        $unit=GetFromDb('SELECT * FROM units WHERE id=?;',$row['id_unit'],false);
                                                        $prof = GetFromDb('SELECT * FROM utilisateurs WHERE id=?;',$row['id_professeur'],false);
                                                        $filiere = GetFromDb('SELECT * FROM filieres WHERE id=?', $unit['id_filiere'],false);
                                                        $annee = CounterValues('SELECT anneeUniversitaire FROM professeur WHERE id_professeur=? AND id_unit=? ;',[$row['id_professeur'],$row['id_unit']]);
                                            ?>
                                                <tr>
                                                    <td><?= $unit['code_module'] ?></td>
                                                    <td><?= $unit['intitule'] ?></td>
                                                    <td><?= $filiere['label'] ?></td>
                                                    <td><?= $unit['semestre'] ?></td>
                                                    <td><?php echo $prof['firstName'].' '.$prof['lastName']; ?></td>
                                                    <td><?= $annee?></td>
                                                </tr>
                                            <?php }?> 
                                        </tbody>
                                    </table>
                                </div>
                          </div>

                          <?php
                            break;
                        default :
                           ?>
                             <div class="container-fluid">
                                <div class="d-flex justify-content-end mb-4 gap-2">
                                    <form method="post" action="operations/Report_pdf.php">
                                        <input type="hidden" name="filiere" value="<?= $fil_id ?>">
                                        <input type="hidden" name="semestre" value="<?= $semestre ?>">
                                        <input type="hidden" name="Au" value="<?= $annee ?>">
                                        <input type="hidden" name="type" value="<?= $type ?>">                         
                                        <button type="submit" class="btn btn-primary btn-sm mr-2">
                                            <i class="fas fa-file-pdf"></i> Exporter PDF
                                        </button>
                                    </form>
                                    <form method="post" action="operations/Report_excel.php">
                                        <input type="hidden" name="filiere" value="<?= $fil_id ?>">
                                        <input type="hidden" name="semestre" value="<?= $semestre ?>">
                                        <input type="hidden" name="Au" value="<?= $annee ?>">
                                        <input type="hidden" name="type" value="<?= $type ?>">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-file-excel"></i> Exporter Excel
                                        </button>
                                    </form>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h3 class="mb-0">1. Répartition des Enseignants</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped text-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Departement</th>
                                                        <th>Nb.UEs Enseigné</th>
                                                        <th>Volume Horraire Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($RepportData as $row){
                                                        $prof=GetFromDb('SELECT * FROM utilisateurs WHERE id=? AND id_departement=? ;',[$row['id_professeur'],$data['id_departement']],false);
                                                        $nbrUnits=CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;',$row['id_professeur']);  
                                                        $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $row['id_professeur']);
                                                        $volume_horr= !empty($vol_horr)?$vol_horr:0;
                                                        $rowClass=($volume_horr<$minHours)?'table-danger':'';
                                                    ?>
                                                    <tr class="<?=$rowClass?>">
                                                        <td><?= $prof['lastName'] ?></td>
                                                        <td><?= $prof['firstName'] ?></td>
                                                        <td><?= $department['departement_name']?></td>
                                                        <td><?= $nbrUnits ?></td>
                                                        <td><?= $volume_horr ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">2. Liste des Unités d'Enseignement</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped text-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Code Module</th>
                                                        <th>Intitulé</th>
                                                        <th>Filière</th>
                                                        <th>Semestre</th>
                                                        <th>Responsable</th>
                                                        <th>Année Univ.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($RepportData as $row){
                                                        $unit=GetFromDb('SELECT * FROM units WHERE id=?;',$row['id_unit'],false);
                                                        $prof = GetFromDb('SELECT * FROM utilisateurs WHERE id=?;',$row['id_professeur'],false);
                                                        $filiere = GetFromDb('SELECT * FROM filieres WHERE id=?', $unit['id_filiere'],false);
                                                        $annee = CounterValues('SELECT anneeUniversitaire FROM professeur WHERE id_professeur=? AND id_unit=? ;',[$row['id_professeur'],$row['id_unit']]);
                                                    ?>
                                                    <tr>
                                                        <td><?= $unit['code_module'] ?></td>
                                                        <td><?= $unit['intitule'] ?></td>
                                                        <td><?= $filiere['label'] ?></td>
                                                        <td><?= $unit['semestre'] ?></td>
                                                        <td><?php echo $prof['firstName'].' '.$prof['lastName']; ?></td>
                                                        <td><?= $annee?></td>
                                                    </tr>
                                                    <?php }?> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                            <?php 
                               break;
                            
                    }
                 ?>
    
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

