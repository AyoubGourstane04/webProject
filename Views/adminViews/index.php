<?php
 require_once __DIR__ . '/../../Controller/controller.php';
 session_start();
 if ((!isset($_SESSION['role']) || $_SESSION['role'] != 1)&&!isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
  }
  ob_start();
  
  $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);
  $title=$data['firstName'].' '.$data['lastName'];
  $userName=$title;
  $nbrofUsers= getCount('utilisateurs');
  $pdo=dataBaseConnection();
  $statment = $pdo->query('SELECT COUNT(*) FROM utilisateurs u JOIN userroles r ON u.id=r.user_id WHERE r.role_id=2;');
  $nbrofProfs= $statment->fetchColumn();
  
  $stmt = $pdo->query('SELECT COUNT(*) FROM departement WHERE id!=3;');
  $nbrofDept= $stmt->fetchColumn();

  $nbrofFile= getCount('filieres');

  $New_users=GetSimpleDb('SELECT * FROM Newusers;');



  $roleCounts = [];

    $roles = [2 => 'Enseignants', 4 => 'Coordonnateurs', 3 => 'Chefs', 5 => 'Vacataires'];
    foreach ($roles as $roleId => $label) {
        $sql = $pdo->prepare("SELECT COUNT(DISTINCT user_id) as count FROM userroles WHERE role_id = ?");
        $sql->execute([$roleId]);
        $roleCounts[$roleId] = $sql->fetchColumn();
    }


    $users = GetFromDb('SELECT * FROM utilisateurs WHERE id!=?;', 1);


    $userIds = array_column($users, 'id');
    $placeholders = implode(',', array_fill(0, count($userIds), '?'));

    $rolesRaw = GetFromDb(
        "SELECT ur.user_id, r.role_label
        FROM userroles ur
        JOIN role r ON r.id = ur.role_id
        WHERE ur.user_id IN ($placeholders)", 
        $userIds
    );

    $userRoles = [];
    foreach ($rolesRaw as $row) {
        $userRoles[$row['user_id']][] = $row['role_label'];
    }

?>
  
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php require_once "../include/navBars/AdminNav.php";?>
    <?php require_once "../include/header.php";?>
   <!-- Begin Page Content -->
   <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?=$userName?></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>
        <!-- Content Row -->
        <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Nombre d'utilisateurs</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$nbrofUsers?> Utilisateurs</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
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
        <!-- Earnings (Monthly) Card Example.. -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Nombre des départements</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$nbrofDept?> Départements</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-building fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
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
                                            <h6 class="m-0 font-weight-bold text-primary">Liste des utilisateurs en attente d'ajout</h6>
                                            <a href="admin.php">
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
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($New_users as $info){ ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($info['firstName']) ?></td>
                                                        <td><?= htmlspecialchars($info['lastName']) ?></td>
                                                        <td>
                                                            <a href="..\operations\Ajouter.php?id=<?= $info['id']; ?>" 
                                                            class="btn btn-success btn-sm me-1">
                                                                <i class="fas fa-user-plus"></i> Ajouter
                                                            </a>
                                                            <a href="..\operations\deleteTempUser.php?id=<?= $info['id']; ?>" 
                                                            class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir refuser cet utilisateur ?')">
                                                                <i class="fas fa-xmark"></i> Refuser
                                                            </a>
                                                        </td>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Répartition des Rôles</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-angle-down icon-down"></i>
                                                <i class="fas fa-angle-up icon-up" style="display: none;"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="Enseignant.php">Enseignants</a>
                                            <a class="dropdown-item" href="chefs.php">Chefs de départements</a>
                                            <a class="dropdown-item" href="coordinateur.php">Coordonnateurs de filières</a>
                                            <a class="dropdown-item" href="Vacataires.php">Vacataires</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-1">
                                            <i class="fas fa-circle text-primary"></i> Enseignants
                                        </span>
                                        <span class="mr-1">
                                            <i class="fas fa-circle text-success"></i> Coordonnateur de filières
                                        </span><br>
                                        <span class="mr-1">
                                            <i class="fas fa-circle text-info"></i> Chefs de départements
                                        </span>
                                        <span class="mr-1">
                                            <i class="fas fa-circle text-warning"></i> Vacataires
                                        </span>
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
                                            <h6 class="m-0 font-weight-bold text-primary">Liste Des Utilisateurs</h6>
                                            <!-- <a href="admin.php">
                                                <i class="fas fa-arrow-up-right-from-square"></i>
                                            </a> -->
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                           <table class="table table-hover align-middle text-center">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Prénom</th>
                                                        <th>Nom</th>
                                                        <th>CIN</th>
                                                        <th>Rôle(s)</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($users as $user): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($user['firstName']) ?></td>
                                                            <td><?= htmlspecialchars($user['lastName']) ?></td>
                                                            <td><?= htmlspecialchars($user['CIN']) ?></td>
                                                            <td>
                                                                <?= htmlspecialchars(implode(' / ', $userRoles[$user['id']] ?? ['Aucun rôle'])) ?>
                                                            </td>
                                                            <td>
                                                                <a href="..\operations\Modifier.php?id=<?= $user['id']; ?>" class="btn btn-primary btn-sm d-inline-flex align-items-center">
                                                                    <i class="fas fa-pencil-alt me-2"></i> Modifier
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
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
            labels: ["Enseignants", "Coordonnateurs", "Chefs", "Vacataires"],
            data: [
                <?= $roleCounts[2] ?>,
                <?= $roleCounts[4] ?>,
                <?= $roleCounts[3] ?>,
                <?= $roleCounts[5] ?>
            ]
        };
    </script>


            

<?php
  $content=ob_get_clean();
  include_once "../dashboards.php";
?>