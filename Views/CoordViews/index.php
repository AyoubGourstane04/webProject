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

    $units=GetFromDB('SELECT * FROM units WHERE id_filiere=? LIMIT 5;',$Coord['id_filiere']);

  
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
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Unités d'Enseignement du Filière</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $nbrofUnits ?> Unités</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
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
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                           Nbr.Professeurs</div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $nbrofProfs ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chalkboard-teacher fa-lg text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Filières -->
                        <div class="card border-left-warning shadow py-2 ">
                                <div class="card-body py-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                               Nbr. Vacataires</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?=$nbrofVac?> Vacataires</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-graduation-cap fa-lg text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mes unités</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $MyUnits ?></div>
                                    </div>
                                    <div class="col-auto">
                                    <i class="fas fa-book-open-reader fa-2x text-gray-300"></i>
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
                                        <div class="text-xs font-weight-bold text-<?= $color_class ?> text-uppercase mb-1">Mon Volume Horaire</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $volume ?> h</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-<?= $color_class ?>" role="progressbar"
                                                            style="width: <?= $progress ?>%" aria-valuenow="<?= $progress ?>" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="small text-muted">Minimum requis : <?= $minHours ?>h</div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                                        <th>filière</th>
                                                        <th>Professeur</th>
                                                        <th>Statut</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($units as $unit){
                                                        $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
                                                        $prof = GetFromDb("SELECT 
                                                                            u.firstName,
                                                                            u.lastName
                                                                            FROM utilisateurs u
                                                                            JOIN professeur p 
                                                                            ON u.id=p.id_professeur
                                                                            WHERE p.id_unit=?;",$unit['id'],false);     
                                                    ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($unit['code_module']) ?></td>
                                                            <td><?= htmlspecialchars($unit['intitule']) ?></td>
                                                            <td><?= htmlspecialchars($unit['semestre']) ?></td>
                                                            <td>
                                                                <?php echo ($filiere && isset($filiere['label'])) ? $filiere['label'] : ''; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo ($prof && isset($prof['firstName']) && isset($prof['lastName'])) ? $prof['firstName'].' '.$prof['lastName'] : '-'; ?>
                                                            </td>
                                                            <td><?php if($unit['statut']==0){
                                                                            echo' <a href="affecter_module_vacataire.php?unit_id='.$unit['id'].'" class="btn btn-primary btn-sm d-inline-flex align-items-center">
                                                                                        <i class="fas fa-user-plus pr-2"></i> Affecter
                                                                                  </a>';
                                                                        }else{
                                                                           echo '<button class="btn btn-secondary btn-sm d-inline-flex align-items-center" disabled>
                                                                                     <i class="fas fa-lock pr-2"></i>Réservé
                                                                                 </button>';
                                                                        }
                                                                ?>    
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>                                    
                                        </div>
                                    </div>
                                </div>


                        <!-- Pie Chart -->
                        <!-- <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4"> -->
                                <!-- Card Header - Dropdown -->
                                <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">UEs par Filière</h6>
                                </div> -->

                                <!-- Card Body -->
                                <!-- <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                       <?php
                                            //$colors = ['text-primary', 'text-success', 'text-info', 'text-warning', 'text-danger', 'text-secondary', 'text-dark', 'text-muted'];
                                            $colors = ['#1f77b4','#2ca02c','#17becf','#ff7f0e','#d62728','#9467bd','#8c564b','#7f7f7f'];
                                            $colorCount = count($colors);
                                            $i = 0;

                                            //<i class="fas fa-circle ' . $colorClass . '"></i> ' . htmlspecialchars($fil['acronym']) . '
                                            foreach ($filieres as $fil) {
                                                $colorClass = $colors[$i % $colorCount];
                                                echo '<span class="mr-2">
                                                        <i class="fas fa-circle" style="color : '. $colorClass .'" ></i> ' . htmlspecialchars($fil['acronym']) . '
                                                    </span>';
                                                $i++;
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Content Row -->
                    <!-- <div class="row"> -->
                          <!-- User Validation Table -->
                                <!-- <div class="col-xl-8 col-lg-7">
                                    <div class="card shadow mb-4"> -->
                                        <!-- Card Header -->
                                        <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Liste Des UEs</h6>
                                            <a href="liste_ues.php">
                                                <i class="fas fa-arrow-up-right-from-square"></i>
                                            </a>
                                        </div> -->
                                        <!-- Card Body -->
                                        <!-- <div class="card-body">
                                           <table class="table table-hover align-middle text-center">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Code Module</th>
                                                        <th>Intitulé</th>
                                                        <th>Semestre</th>
                                                        <th>filière</th>
                                                        <th>Professeur</th>
                                                        <th>Statut</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($units as $unit){
                                                        $filiere = GetFromDb("SELECT * FROM filieres WHERE id=? ;",$unit['id_filiere'],false);
                                                        $prof = GetFromDb("SELECT 
                                                                            u.firstName,
                                                                            u.lastName
                                                                            FROM utilisateurs u
                                                                            JOIN professeur p 
                                                                            ON u.id=p.id_professeur
                                                                            WHERE p.id_unit=?;",$unit['id'],false);     
                                                    ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($unit['code_module']) ?></td>
                                                            <td><?= htmlspecialchars($unit['intitule']) ?></td>
                                                            <td><?= htmlspecialchars($unit['semestre']) ?></td>
                                                            <td>
                                                                <?php echo ($filiere && isset($filiere['label'])) ? $filiere['label'] : ''; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo ($prof && isset($prof['firstName']) && isset($prof['lastName'])) ? $prof['firstName'].' '.$prof['lastName'] : '-'; ?>
                                                            </td>
                                                            <td><?php if($unit['statut']==0){
                                                                            echo' <a href="affecter_ue_professeur.php?unit_id='.$unit['id'].'" class="btn btn-primary btn-sm d-inline-flex align-items-center">
                                                                                        <i class="fas fa-user-plus pr-2"></i> Affecter
                                                                                  </a>';
                                                                        }else{
                                                                           echo '<button class="btn btn-secondary btn-sm d-inline-flex align-items-center" disabled>
                                                                                     <i class="fas fa-lock pr-2"></i>Réservé
                                                                                 </button>';
                                                                        }
                                                                ?>    
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>                              
                                        </div>
                                    </div>
                                </div> -->
                            <div class="col-xl-4 col-lg-5">
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
                                                            $nbrUnits = CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;',$vac['id']);  

                                                    ?>
                                                        <tr>
                                                            <td><?php echo $vac['firstName'].' '.$vac['lastName']?></td>
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


<!-- hna ghir ta3 dik licon ta3 k pie chart -->
<!-- <style>
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
</style> -->

    <!-- <script>
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
    </script> -->


            

<?php
  $content=ob_get_clean();
  include_once "../dashboards.php";
?>