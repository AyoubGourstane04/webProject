<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title='Choix et Demandes';
    $userName=$data['firstName'].' '.$data['lastName'];

    $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$data['id_departement'],false);

    $choix = GetFromDb("SELECT p.firstName,p.lastName,p.id,u.intitule,t.demande,t.id_unit
                               FROM utilisateurs p 
                               JOIN tempunits t 
                               ON p.id=t.id_prof 
                               JOIN units u 
                               ON u.id=t.id_unit  
                               WHERE p.id_departement=? ;",$data['id_departement']);


?>

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php require_once "../include/navBars/ChefNav.php";?>

    <?php require_once "../include/header.php";?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                    <?php  displayFlashMessage(); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">
                        Les choix des Professeurs
                    </h1>
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Prenom</th>
                                    <th>Nom</th>
                                    <th>Unité</th>
                                    <th>Demande</th>
                                    <!-- <th>Année Univérsitaire</th> -->
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php foreach($choix as $choice){
                                    ?>
                                        <tr>
                                            <td><?php echo $choice['firstName'];?></td>
                                            <td><?php echo $choice['lastName'];?></td>
                                            <td><?php echo $choice['intitule'];?></td>
                                            <td><?php echo $choice['demande'];?></td>
                                            <!-- <td>
                                                <select id="Au" class="form-control form-control-sm w-auto" name="Au" required style="height: 28px;">
                                                <option value="">Sélectionnez l'année universitaire</option>
                                                    <?php
                                                        $currentYear = date('Y');
                                                        $currentMonth = date('n');
                                                        if ($currentMonth >= 9) {
                                                            $lastAcademicStart = $currentYear;
                                                        } else {
                                                            $lastAcademicStart = $currentYear - 1;
                                                        }

                                                        for ($i = $lastAcademicStart - 5; $i <= $lastAcademicStart; $i++) {
                                                            $nextYear = $i + 1;
                                                            echo "<option value=\"$i-$nextYear\">$i-$nextYear</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </td> -->
                                            <td>
                                                <!-- <a href="operations/valider_choix.php?id_prof=<?=$choice['id']?>&id_unit=<?=$choice['id_unit']?>" class="btn btn-success btn-sm"> <i class="fa-solid fa-circle-check"></i> Valider</a> -->
                                                <form method="POST" action="operations/valider_choix.php" class="d-inline-flex">
                                                <input type="hidden" name="id_prof" value="<?= $choice['id'] ?>">
                                                <input type="hidden" name="id_unit" value="<?= $choice['id_unit'] ?>">
                                                <select name="Au" class="form-control form-control-sm mr-2" required style="height: 28px; width: auto;">
                                                    <option value="" class ="text-center">--- A.U ---</option>
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
                                                <button type="submit" class="btn btn-success btn-sm ml-2">
                                                    <i class="fa-solid fa-circle-check"></i> Valider
                                                </button>
                                            </form>
                                                <a href="operations/refuser_choix.php?id_prof=<?=$choice['id']?>&id_unit=<?=$choice['id_unit']?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-circle-xmark"></i> Décliner</a>
                                            </td>
                                        </tr>
                                       <?php }?>
                                    </tbody>
                    </table>
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

