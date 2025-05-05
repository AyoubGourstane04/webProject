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

    $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$data['id_departement'],false);

    $professeurs = GetFromDb("SELECT 
                                u.id,
                                u.firstName,
                                u.lastName,
                                u.CIN,
                                u.Birthdate,
                                u.email,
                                u.speciality 
                                FROM utilisateurs u
                                JOIN userroles r 
                                ON u.id=r.user_id 
                                WHERE u.id_departement=? AND r.role_id=2 AND u.id!=? ;",[$data['id_departement'],$data['id']]);
        
    $units=GetFromDb("SELECT * FROM units WHERE departement_id=? ;",$data['id_departement']);

?>

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php require_once "../include/navBars/ChefNav.php";?>

    <?php require_once "../include/header.php";?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Affecter des unités d'enseignement au professeurs</h1>
                    </div>
                    <form action="../../addUnit_prof.php" class="user" method="POST">
                       
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="unit" class="form-label">Unités</label>
                                    <select class="form-control" id="unit" name="unit" >
                                        <option value="" selected>Sélectionnez l' U.E</option>
                                        <?php foreach($units as $unit){
                                                 if($unit['statut']==0){
                                        ?>
                                        <option value="<?= $unit['id']?>"><?=$unit['unit_name']?></option>

                                        <?php 
                                                    }
                                                }  
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="prof" class="form-label">Professeurs</label>
                                    <select class="form-control" id="prof" name="prof" >
                                        <option value="" selected>Sélectionnez le professeur</option>
                                        <?php foreach($professeurs as $prof){  ?>
                                        <option value="<?= $prof['id']?>"><?php echo $prof['firstName'].' '.$prof['lastName'];?></option>

                                        <?php   }  ?>
                                    </select>
                                </div>
                            </div>
                                <input type="submit" value="Affecter" class="btn btn-primary btn-user btn-block">
                    </form>
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

