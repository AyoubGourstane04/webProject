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

    $semesterFilter = isset($_GET['semestre']) && $_GET['semestre'] !== '' ? $_GET['semestre'] : null;

    if($semesterFilter){
        $units=GetFromDb('SELECT * FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=? AND u.semestre=? LIMIT 10;',[$_SESSION['id'],$semesterFilter]);
    }else{
        $units=GetFromDb('SELECT * FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=? LIMIT 8;',$_SESSION['id']);
    }

    $messages=GetFromDb('SELECT * FROM notifications WHERE id_utilisateur=?;',$_SESSION['id']);


?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/navBars/VacNav.php";?>

   <?php require_once "../include/header.php";?>
   
                <!-- Begin Page Content -->
   <div class="container-fluid">
        <?php  displayFlashMessage(); ?>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bienvenue <?=$userName?></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>
                    <div class="row">
                                <!-- User Validation Table -->
                                <div class="col-xl-8 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Mes Modules</h6>
                                            <a href="Vac_Eus.php">
                                                <i class="fas fa-arrow-up-right-from-square"></i>
                                            </a>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <form method="GET" class="mb-3 d-flex align-items-center justify-content-end gap-2">
                                                <label for="semestre" class="form-label"><i class="fas fa-filter mr-2 mt-1"></i></label>
                                                <select name="semestre" id="semestre" class="form-control form-control-sm w-auto" onchange="this.form.submit()">
                                                    <option value="">semestre</option>
                                                    <option value="S1" <?= (isset($_GET['semestre']) && $_GET['semestre'] == 'S1') ? 'selected' : '' ?>>S1</option>
                                                    <option value="S2" <?= (isset($_GET['semestre']) && $_GET['semestre'] == 'S2') ? 'selected' : '' ?>>S2</option>
                                                    <option value="S3" <?= (isset($_GET['semestre']) && $_GET['semestre'] == 'S3') ? 'selected' : '' ?>>S3</option>
                                                    <option value="S4" <?= (isset($_GET['semestre']) && $_GET['semestre'] == 'S4') ? 'selected' : '' ?>>S4</option>
                                                    <option value="S3" <?= (isset($_GET['semestre']) && $_GET['semestre'] == 'S5') ? 'selected' : '' ?>>S5</option>
                                                </select>
                                            </form>

                                            <table class="table table-hover align-middle text-center">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Code Module</th>
                                                        <th>Intitulé</th>
                                                        <th>Semestre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($units as $unit){
                                                    ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($unit['code_module']) ?></td>
                                                            <td><?= htmlspecialchars($unit['intitule']) ?></td>
                                                            <td><?= htmlspecialchars($unit['semestre']) ?></td>
                                                           
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>                                    
                                        </div>
                                    </div>
                                </div>

                             <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Actualités</h6>
                                    </div>

                                    <div class="card-body">
                                         <table class="table table-hover align-middle text-center">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Messages</th>
                                                        <th>Date et Heure</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($messages as $message){
                                                    ?>
                                                        <tr>
                                                            <td><?= $message['title'] ?></td>
                                                            <td><?= $message['created_at'] ?></td>                                                            
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>         
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