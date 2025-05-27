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



    $nbrofUnits = CounterValues('SELECT COUNT(*) FROM units WHERE id_filiere=?;',$Coord['id_filiere']);


    $profs=GetFromDb('SELECT * FROM utilisateurs u JOIN userroles r ON u.id=r.user_id WHERE r.role_id=2 AND u.id_departement=?;',$data['id_departement']);

    $units=GetFromDB('SELECT * FROM units WHERE id_filiere=? AND statut=0 LIMIT 5;',$Coord['id_filiere']);

  
    $vacataires=GetFromDb('SELECT * FROM utilisateurs u 
                                JOIN userroles r ON u.id=r.user_id 
                                JOIN vacataires v ON u.id = v.id_vacataire 
                                WHERE r.role_id=5 AND v.id_filiere=? LIMIT 5;',
                                $Coord['id_filiere']);

    $nbrofVac= CounterValues('SELECT COUNT(*) FROM vacataires WHERE id_filiere=?;',$Coord['id_filiere']);  
    
    $nbrofProfs=CounterValues('SELECT COUNT(DISTINCT p.id_professeur) FROM professeur p 
                                    JOIN units u ON p.id_unit=u.id
                                    JOIN userroles r ON p.id_professeur=r.user_id
                                    WHERE r.role_id=2 AND u.id_filiere=?;',
                                    $Coord['id_filiere']);


    $MyUnits = CounterValues('SELECT COUNT(*) FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=?;',$_SESSION['id']);           //  zedto db

    $minHours=100;

    $vol = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $_SESSION['id']);
    $volume = !empty($vol) ? $vol : 0;

    $progress = min(100, ($volume / $minHours) * 100);


    if ($volume < $minHours) {
        $color_class = 'danger';
    } elseif ($volume == $minHours) {
        $color_class = 'primary';
    } else {
        $color_class = 'success';
    }


    $messages=GetFromDb('SELECT * FROM notifications WHERE id_utilisateur=? AND is_read=0 LIMIT 5;',$_SESSION['id']);



?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/navBars/CoordNav.php";?>

   <?php require_once "../include/header.php";?>
   
                <!-- Begin Page Content -->
   <div class="container-fluid">
        <?php  displayFlashMessage(); ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bienvenue <?=$userName?></h1>
        </div>

            <!-- Content Row -->
               <div class="row">
                    <!-- Unités d'enseignement -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body d-flex align-items-center">
                                <div class="row no-gutters align-items-center w-100">
                                    <div class="col mr-2">
                                        <div class="text-sm font-weight-bold text-primary text-uppercase mb-2">
                                            Unités d'Enseignement du Filière
                                        </div>
                                        <div class="h4 mb-0 font-weight-bolder text-dark">
                                            <?= $nbrofUnits ?> <span class="text-muted small">Unités</span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-book-open fa-3x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professeurs + Vacataires stacked -->
                    <div class="col-xl-3 col-md-6 mb-4 d-flex flex-column justify-content-between">
                        <!-- Professeurs -->
                        <div class="card border-left-success shadow mb-2 py-2">
                            <div class="card-body py-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-sm font-weight-bold text-success text-uppercase mb-2">
                                            Nombre de Professeurs
                                        </div>
                                        <div class="h5 mb-0 font-weight-bolder text-dark"><?= $nbrofProfs ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Vacataires -->
                        <div class="card border-left-warning shadow py-2">
                            <div class="card-body py-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-sm font-weight-bold text-warning text-uppercase mb-2">
                                            Nombre de Vacataires
                                        </div>
                                        <div class="h5 mb-0 font-weight-bolder text-dark"><?= $nbrofVac ?> Vacataires</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-graduation-cap fa-2x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mes Unités -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body d-flex align-items-center">
                                <div class="row w-100 justify-content-between align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-sm font-weight-bold text-info text-uppercase mb-2">
                                            Mes Unités
                                        </div>
                                        <div class="h4 mb-0 font-weight-bolder text-dark">
                                            <?= $MyUnits ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-book-open-reader fa-3x text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mon Volume Horaire -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-<?= $color_class ?> shadow h-100 py-2">
                            <div class="card-body d-flex align-items-center">
                                <div class="row w-100 justify-content-between align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-sm font-weight-bold text-<?= $color_class ?> text-uppercase mb-2">
                                            Mon Volume Horaire
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 font-weight-bolder text-dark"><?= $volume ?> h</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm ml-2">
                                                    <div class="progress-bar bg-<?= $color_class ?>" role="progressbar"
                                                        style="width: <?= $progress ?>%" aria-valuenow="<?= $progress ?>"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="small text-muted mt-1">Minimum requis : <?= $minHours ?>h</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-<?= $color_class ?>"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                    
           
          <!-- Content Row -->

                    <div class="row">
                        <!-- User Validation Table -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Liste des Modules de Filière</h6>
                                    <a href="liste_ues_filiere.php">
                                        <i class="fas fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <table class="table table-hover align-middle text-center">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Code Module</th>
                                                <th>Intitulé</th>
                                                <th>Semestre</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($units as $unit){ 
                                            ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($unit['code_module']) ?></td>
                                                    <td><?= htmlspecialchars($unit['intitule']) ?></td>
                                                    <td><?= htmlspecialchars($unit['semestre']) ?></td>
                                                    <td> 
                                                        <a href="affecter_module_vacataire.php?unit_id=<?=$unit['id']?>" class="btn btn-primary btn-sm d-inline-flex align-items-center">
                                                            <i class="fas fa-user-plus pr-2"></i> Affecter
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <!-- Actualités Card -->
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
                                            <?php foreach ($messages as $message){?>
                                                    <tr>
                                                        <td><?= $message['title'] ?></td>
                                                        <td><?= $message['created_at'] ?></td>                                                            
                                                    </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>         
                                </div>
                            </div>

                            <!-- Vacataires Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Vacataires</h6>
                                    <div class="btn-group">
                                        <a href="creer_compte_vacataire.php" class="btn btn-sm btn-success">
                                            <i class="fas fa-plus"></i> Ajouter
                                        </a>
                                        <a href="liste_vacataires.php" class="btn btn-sm btn-primary">
                                            <i class="fas fa-arrow-up-right-from-square"></i> Liste
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table class="table table-hover align-middle text-center">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Vacataire</th>
                                                <th>Nb.UEs enseignées</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($vacataires as $vac){
                                                $nbrUnits = CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;',$vac['id']); ?>
                                                <tr>
                                                    <td><?= $vac['firstName'].' '.$vac['lastName'] ?></td>
                                                    <td><?= $nbrUnits ?></td>                                                            
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