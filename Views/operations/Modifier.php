<?php
    require_once __DIR__ . '/../../Controller/controller.php';
    session_start();
    if ((!isset($_SESSION['role']) || $_SESSION['role'] != 1)&&!isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }

    ob_start();
    $admin=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

   $title="Modifier un utilisateur";
    
    $userName=$admin['firstName'].' '.$admin['lastName'];



    $id=$_GET['id'];

    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$id,false);


    //roles : 

    $roles=GetSimpleDb('SELECT * FROM userroles WHERE user_id='.$id.';');  
    
    $rolesArray=[];
    foreach($roles as $userRole){
        $rolesArray[]=$userRole['role_id'];
    }
?>
 
    
    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php require_once "../include/navBars/AdminNav.php";?>

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
                        <h1 class="h4 text-gray-900 mb-4">Modifier les informations d'un utilisateur</h1>
                    </div>
                    <form action="../../edit.php" class="user" method="POST">
                        <input type="hidden" name="id" value="<?=$data['id']?>">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="FirstName" name="firstName" placeholder="Prénom" value="<?=$data['firstName']?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="LastName" name="lastName" placeholder="Nom" value="<?=$data['lastName']?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <?php $today = date('Y-m-d'); ?>
                                    <label for="birthdate" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control form-control-user" id="birthdate" name="birthdate" min="1900-01-01" max="<?php echo $today; ?>" value="<?=$data['Birthdate']?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="cin" class="form-label">CIN (Carte d'Identité Nationale)</label>
                                    <input type="text" class="form-control form-control-user" id="cin" name="cin" 
                                        placeholder="Ex: AB12345" value="<?=$data['CIN']?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <input type="email" class="form-control form-control-user" id="InputEmail" name="email"
                                        placeholder="Adresse email" value="<?=$data['email']?>" required>
                                </div>     
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control form-control-user" id="InputSpeciality" name="speciality" placeholder="Spécialité"  value="<?=$data['speciality']?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="department" class="form-label">Département </label>
                                    <select class="form-control" id="department" name="department" >
                                        <option value="" disabled <?= $data['id_departement']==null?'selected':'';?>>Sélectionnez le département</option>
                                        <option value="1" <?= $data['id_departement']==1? 'selected':'';?>>Mathématiques et Informatique (MI)</option>
                                        <option value="2" <?= $data['id_departement']==2? 'selected':'';?>>Génie Civil Energétique et Environnement (GCEE)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                    <p class="h6 text-gray-800 mb-3">Affecter un rôle :</p>
                                    <div class="row">  
                                        <div class="col-md-6">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="roleTeacher" name="roles[0]" value="2" <?= in_array(2,$rolesArray)? 'checked':'';?>>
                                                    <label class="custom-control-label" for="roleTeacher">
                                                        <i class="fas fa-chalkboard-teacher mr-2"></i>Enseignant
                                                    </label>
                                                </div>
                                            </div>  
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="roleDeptHead" name="roles[1]" value="3" <?= in_array(3,$rolesArray)? 'checked':'';?> >
                                                <label class="custom-control-label" for="roleDeptHead">
                                                    <i class="fas fa-user-tie mr-2"></i>Chef de département
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="roleCoordinator" name="roles[2]" value="4" <?= in_array(4,$rolesArray)? 'checked':'';?>>
                                                <label class="custom-control-label" for="roleCoordinator">
                                                    <i class="fas fa-user mr-2"></i>Coordonnateur de filière
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 
                                <input type="submit" value="Modifier" class="btn btn-primary btn-user btn-block">

                                
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



   
        <?php require_once "../include/footer.php";?>







<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>