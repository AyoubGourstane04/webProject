<?php
 require_once __DIR__ . '/../../Controller/controller.php';
 session_start();
 if ((!isset($_SESSION['role']))&&!isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
  }
  ob_start();
  
  $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);
  $title=$data['firstName'].' '.$data['lastName'];
  $userName=$title;

  $minHours=100;

  $nbrofProfs=CounterValues('SELECT COUNT(*) FROM utilisateurs u JOIN userroles r ON u.id=r.user_id WHERE r.role_id=2 AND u.id_departement=?;',$data['id_departement']);

  $nbrofFile= CounterValues('SELECT COUNT(*) FROM filieres WHERE id_departement=?;',$data['id_departement']);

  $nbrofUnits = CounterValues('SELECT COUNT(*) FROM units WHERE departement_id=?;',$data['id_departement']);

  $profs=GetFromDb('SELECT * FROM utilisateurs u JOIN userroles r ON u.id=r.user_id WHERE r.role_id=2 OR r.role_id=5 AND u.id_departement=? LIMIT 5;',$data['id_departement']);

  $units=GetFromDB('SELECT * FROM units WHERE departement_id=? AND statut=0 LIMIT 5;',$data['id_departement']);

  $filieres=GetSimpleDb('SELECT * FROM filieres');

  $MyUnits = CounterValues('SELECT COUNT(*) FROM units u JOIN professeur p ON u.id=p.id_unit WHERE p.id_professeur=?;',$_SESSION['id']);           //  zedto db



    $pdo=dataBaseConnection();

    $unitCounts = [];

    $fils = [1 => 'CP', 2 => 'GI', 3 => 'GC', 4 => 'GEE', 5 => 'GEER', 6 => 'GM', 7 => 'ID', 8 => 'TDIA'];
    foreach ($fils as $fil_id => $acronym) {
        $sql = $pdo->prepare("SELECT COUNT(*) as count FROM units WHERE id_filiere = ? and departement_id=?;");
        $sql->execute([$fil_id,$data['id_departement']]);
        $unitCounts[$fil_id] = $sql->fetchColumn();
    }

    $demandes=GetFromDB('SELECT * FROM units u JOIN tempunits t ON u.id=t.id_unit WHERE u.departement_id=?;',$data['id_departement']);


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
    <?php require_once "../include/navBars/ChefNav.php";?>
    <?php require_once "../include/header.php";?>
   <!-- Begin Page Content -->
   <div class="container-fluid">
        <?php  displayFlashMessage(); ?>

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
                                        Unités d'Enseignement du Département
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

                <!-- Professeurs + Filières stacked -->
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
                    <!-- Filières -->
                    <div class="card border-left-warning shadow py-2">
                        <div class="card-body py-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-sm font-weight-bold text-warning text-uppercase mb-2">
                                        Nombre de Filières
                                    </div>
                                    <div class="h5 mb-0 font-weight-bolder text-dark"><?= $nbrofFile ?></div>
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
                                            <h6 class="m-0 font-weight-bold text-primary">Liste des Enseignats</h6>
                                            <a href="liste_professeurs.php">
                                                <i class="fas fa-arrow-up-right-from-square"></i>
                                            </a>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <table class="table table-hover align-middle text-center">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Prénom</th>
                                                        <th>Nom</th>
                                                        <th>Nb.UEs enseignées</th>
                                                        <th>Volume Horraire</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                       $underMinRows = [];
                                                       $otherRows = [];

                                                        foreach ($profs as $prof) {
                                                            $nbrUnits = CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;', $prof['id']);  
                                                            $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $prof['id']);
                                                            $volume_horr = !empty($vol_horr) ? $vol_horr : 0;
                                                            $rowClass = ($volume_horr < $minHours) ? 'table-danger' : '';

                                                            $rowHtml = "<tr class=\"$rowClass\">
                                                                            <td>" . htmlspecialchars($prof['firstName']) . "</td>
                                                                            <td>" . htmlspecialchars($prof['lastName']) . "</td>
                                                                            <td>$nbrUnits</td>
                                                                            <td>$volume_horr</td>
                                                                        </tr>";

                                                            if ($volume_horr < $minHours) {
                                                                $underMinRows[] = $rowHtml;
                                                            } else {
                                                                $otherRows[] = $rowHtml;
                                                            }
                                                        }
                                                            echo implode('', $underMinRows) . implode('', $otherRows);
                                                    ?>
                                                </tbody>
                                            </table>                                  
                                        </div>
                                    </div>
                                </div>


                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">UEs par Filière</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                       <?php
                                            // $colors = ['text-primary', 'text-success', 'text-info', 'text-warning', 'text-danger', 'text-secondary', 'text-dark', 'text-muted'];
                                            $colors = ['#1f77b4','#2ca02c','#17becf','#ff7f0e','#d62728','#9467bd','#e377c2','#7f7f7f'];
                                            $colorCount = count($colors);
                                            $i = 0;
                                            foreach ($filieres as $fil) {
                                                $colorClass = $colors[$i % $colorCount];
                                                echo '<span class="mr-2">
                                                        <i class="fas fa-circle" style="color : ' .$colorClass. '" ></i> ' . htmlspecialchars($fil['acronym']) . '
                                                    </span>';
                                                $i++;
                                            }
                                        ?>
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
                                            <h6 class="m-0 font-weight-bold text-primary">Liste Des UEs</h6>
                                            <a href="liste_ues.php">
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
                                                        <th>filière</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($units as $unit){
                                                            $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
                                                    ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($unit['code_module']) ?></td>
                                                            <td><?= htmlspecialchars($unit['intitule']) ?></td>
                                                            <td><?= htmlspecialchars($unit['semestre']) ?></td>
                                                            <td>
                                                                <?php echo ($filiere && isset($filiere['label'])) ? $filiere['label'] : ''; ?>
                                                            </td>
                                                             <td> 
                                                                <a href="affecter_ue_professeur.php?unit_id=<?=$unit['id']?>&fil_id=<?=$unit['id_filiere']?>&semestre=<?=$unit['semestre']?>" class="btn btn-primary btn-sm d-inline-flex align-items-center">
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
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Demandes des UEs</h6>
                                        <a href="liste_choix_professeurs.php">
                                                <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                         <table class="table table-hover align-middle text-center">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Professeur</th>
                                                        <th>Module</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($demandes as $demande){
                                                        $prof = GetFromDb("SELECT 
                                                                            firstName,
                                                                            lastName FROM utilisateurs
                                                                            WHERE id=?;",$demande['id_prof'],false);     
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $prof['firstName'].' '.$prof['lastName']?></td>
                                                            <td><?= htmlspecialchars($demande['intitule']) ?></td>                                                            
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


<!-- hna ghir ta3 dik licon ta3 k pie chart -->
<style>
    .dropdown-toggle[aria-expanded="true"] .icon-down {
    display: none;
    }
    .dropdown-toggle[aria-expanded="true"] .icon-up {
        display: inline-block !important;
    }

    .dropdown-toggle[aria-expanded="false"] .icon-down {
        display: inline-block;
    }
    .dropdown-toggle[aria-expanded="false"] .icon-up {
        display: none;
    }
</style>

    <script>
        const roleChartData = {
            labels: ["CP","GI","GC","GEE","GEER","GM","ID","TDIA"],
            data: [
                <?= $unitCounts[1] ?>,
                <?= $unitCounts[2] ?>,
                <?= $unitCounts[3] ?>,
                <?= $unitCounts[4] ?>,
                <?= $unitCounts[5] ?>,
                <?= $unitCounts[6] ?>,
                <?= $unitCounts[7] ?>,
                <?= $unitCounts[8] ?>
            ]
        };
    </script>


            

<?php
  $content=ob_get_clean();
  include_once "../dashboards.php";
?>