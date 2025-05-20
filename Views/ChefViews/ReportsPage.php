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
    // $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$data['id_departement'],false);


    //hadchi ta3 data d rapport : 
        $fil_id = !empty($_POST['filiere']) ? $_POST['filiere'] : null;
        $semestre = !empty($_POST['semestre']) ? $_POST['semestre'] : null;
        $annee = !empty($_POST['Au']) ? $_POST['Au'] : null;
        $type = !empty($_POST['type']) ? $_POST['type'] : 'all';

        $query='SELECT p.id_prof,p.id_unit FROM professeur p 
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
            print_r($RepportData);

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
                        if($type==='all'){
                    ?>
                                                
                        <h3>1. Répartition des Enseignants</h3>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Departement</th>
                                        <th>Nb.UEs Enseigné</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($RepportData as $row){
                                            $prof=GetFromDb('SELECT * FROM utilisateurs WHERE id=? AND 	id_departement=? ;',[$row['id_prof'],$data['id_departement']],false);
                                            $nbrUnits=CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;',$row['id_prof']);                                        
                                    ?>
                                        <tr>
                                            <td><?= $row['lastName'] ?></td>
                                            <td><?= $row['firstName'] ?></td>
                                            <td><?= $nbrUnits ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <hr class="my-5">

                            <h3>2. Liste des Unités d'Enseignement</h3>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Intitulé</th>
                                        <th>Responsable</th>
                                        <th>Filière</th>
                                        <th>Semestre</th>
                                        <th>Année Univ.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php foreach ($unitsData as $row): ?>
                                        <tr>
                                            <td><?= $row['intitule'] ?></td>
                                            <td><?= $row['responsable'] ?></td>
                                            <td><?= $row['filiere'] ?></td>
                                            <td><?= $row['semestre'] ?></td>
                                            <td><?= $row['annee_universitaire'] ?></td>
                                        </tr>
                                    <?php endforeach; ?> -->
                                </tbody>
                            </table>


                    <?php

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

