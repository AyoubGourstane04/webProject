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





</div>
<!-- /.container-fluid -->





   


            </div>
            <!-- End of Main Content -->



   
        <?php require_once "../include/footer.php";?>







<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>