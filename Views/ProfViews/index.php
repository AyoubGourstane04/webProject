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

    $nbrofUnits = CounterValues('SELECT COUNT(*) FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=?;',$_SESSION['id']);           //  zedto db
    
    if($semesterFilter){
        $units=GetFromDb('SELECT * FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=? AND u.semestre=? LIMIT 10;',[$_SESSION['id'],$semesterFilter]);
    }else{
        $units=GetFromDb('SELECT * FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=? LIMIT 8;',$_SESSION['id']);
    }

    $messages=GetFromDb('SELECT * FROM notifications WHERE id_utilisateur=? AND is_read=0 LIMIT 5;',$_SESSION['id']);

    $minHours = 100;
    $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $_SESSION['id']);
    $volume_horr = !empty($vol_horr) ? $vol_horr : 0;

    $progress = min(100, ($volume_horr / $minHours) * 100);


    if ($volume_horr < $minHours) {
        $color_class = 'danger';
    } elseif ($volume_horr == $minHours) {
        $color_class = 'primary';
    } else {
        $color_class = 'success';
    }

    
?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/navBars/ProfNav.php";?>

   <?php require_once "../include/header.php";?>
   
                <!-- Begin Page Content -->
   <div class="container-fluid">
        <?php  displayFlashMessage(); ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bienvenue <?=$userName?></h1>
        </div>
                    <div class="row">
                        <!-- Nombre d'unités d'enseignement -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body d-flex align-items-center">
                                    <div class="row no-gutters align-items-center w-100">
                                        <div class="col mr-2">
                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-2">
                                                Nombre d'unités d'enseignement
                                            </div>
                                            <div class="h4 mb-0 font-weight-bolder text-dark"><?= $nbrofUnits ?> <span class="text-muted small">Unités</span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book-open fa-3x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mon Volume Horaire -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-<?= $color_class ?> shadow h-100 py-2">
                                <div class="card-body d-flex align-items-center">
                                    <div class="row no-gutters align-items-center w-100">
                                        <div class="col mr-2">
                                            <div class="text-sm font-weight-bold text-<?= $color_class ?> text-uppercase mb-2">
                                                Mon Volume Horaire
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 font-weight-bolder text-dark"><?= $volume_horr ?> h</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm ml-2">
                                                        <div class="progress-bar bg-<?= $color_class ?>" role="progressbar"
                                                            style="width: <?= $progress ?>%" aria-valuenow="<?= $progress ?>" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="small text-muted mt-1">Minimum requis : <?= $minHours ?>h</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-3x text-<?= $color_class ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                                <!-- User Validation Table -->
                                <div class="col-xl-8 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Mes Modules</h6>
                                            <a href="moduleAffec.php">
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
                                        <a href="notificationProf.php">
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
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
                                                                if(!$message['is_read']){
                                                    ?>
                                                        <tr>
                                                            <td><?= $message['title'] ?></td>
                                                            <td><?= $message['created_at'] ?></td>                                                            
                                                        </tr>
                                                    <?php        }  
                                                            } ?>
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