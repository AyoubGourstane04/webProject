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

  $profs=GetFromDb('SELECT * FROM utilisateurs u JOIN userroles r ON u.id=r.user_id WHERE r.role_id=2 AND u.id_departement=? LIMIT 5;',$data['id_departement']);

  $units=GetFromDB('SELECT * FROM units WHERE departement_id=? LIMIT 5;',$data['id_departement']);

  $filieres=GetSimpleDb('SELECT * FROM filieres');


    $pdo=dataBaseConnection();

    $unitCounts = [];

    $fils = [1 => 'CP', 2 => 'GI', 3 => 'GC', 4 => 'GEE', 5 => 'GEER', 6 => 'GM', 7 => 'ID', 8 => 'TDIA'];
    foreach ($fils as $fil_id => $acronym) {
        $sql = $pdo->prepare("SELECT COUNT(*) as count FROM units WHERE id_filiere = ? and departement_id=?;");
        $sql->execute([$fil_id,$data['id_departement']]);
        $unitCounts[$fil_id] = $sql->fetchColumn();
    }

    $demandes=GetFromDB('SELECT * FROM units u JOIN tempunits t ON u.id=t.id_unit WHERE u.departement_id=?;',$data['id_departement']);


?>
  
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php require_once "../include/navBars/ChefNav.php";?>
    <?php require_once "../include/header.php";?>
   <!-- Begin Page Content -->
   <div class="container-fluid">
        <!-- Page Heading<i class="fas fa-download fa-sm text-white-50"></i> -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bienvenue <?=$userName?></h1>
        <!-- <a href="operations/Generate_Repport.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-chart-line fa-sm text-white-50 pr-2"></i>Générer des Rapports</a>-->
        </div>
        <!-- Content Row -->
        <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Nombre d'unités d'enseignement</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$nbrofUnits?> Unités</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Nombre des professeurs</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$nbrofProfs?> Professeurs</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Nombres des filières</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$nbrofFile?> filières</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
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
                                                    <?php foreach($profs as $prof){
                                                       $nbrUnits = CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;',$prof['id']);  
                                                       $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $prof['id']);
                                                       $volume_horr= !empty($vol_horr)?$vol_horr:0;
                                                       $rowClass=($volume_horr<$minHours)?'table-danger':'';
                                                    ?>
                                                    <tr class="<?=$rowClass?>">
                                                        <td><?= htmlspecialchars($prof['firstName']) ?></td>
                                                        <td><?= htmlspecialchars($prof['lastName']) ?></td>
                                                        <td><?= $nbrUnits ?></td>
                                                        <td><?= $volume_horr ?></td>
                                                    </tr>
                                                    <?php } ?>
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
                                </div>
                            <div class="col-xl-4 col-lg-5">
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