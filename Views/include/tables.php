<?php 

    $roleData=GetSimpleDb('SELECT * FROM role WHERE id='.$role.';',false);
    
    $roles=GetSimpleDb('SELECT * FROM userroles WHERE role_id='.$role.';');
    $users = [];
    foreach($roles as $data){
        $user=GetSimpleDb('SELECT * FROM utilisateurs WHERE id='.$data['user_id'].';',false);
        if($user){
            $users[]=$user;
        }
    }
?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?= $header ?></h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary"><?= 'liste des '.$header ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Prenom</th>
                                            <th>Nom</th>
                                            <th>CIN</th>
                                            <th>Date de naissance</th>
                                            <th>Email</th>
                                            <th>Specialité</th>
                                            <th>Departement</th>
                                            <?php if($role == 5 || $role == 4){?>
                                            <th>Filière</th>
                                            <?php }?>
                                            <th>Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($users as $user){ 
                                            $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$user['id_departement'],false);
                                            if($role == 5){
                                                $filiere = GetFromDb("SELECT f.label FROM vacataires v JOIN filieres f ON v.id_filiere = f.id WHERE id_vacataire=? ;",$user['id'],false);
                                            }
                                            if($role == 4){
                                                $filiereC = GetFromDb("SELECT f.label FROM coordinateurs c JOIN filieres f ON c.id_filiere = f.id WHERE 	id_coordinateur=? ;",$user['id'],false);
                                            }
                                            
                                          
                                    ?>
                                        <tr>
                                            <td><?php echo $user['id'];?></td>
                                            <td><?php echo $user['firstName'];?></td>
                                            <td><?php echo $user['lastName'];?></td>
                                            <td><?php echo $user['CIN'];?></td>
                                            <td><?php echo $user['Birthdate'];?></td>
                                            <td><?php echo $user['email'];?></td>
                                            <td><?php echo $user['speciality'];?></td>
                                            <td>
                                                <?php echo ($department && isset($department['departement_name'])) ? $department['departement_name'] : ''; ?>
                                            </td>
                                        <?php if($role == 5){?>
                                            <td><?php echo $filiere['label'];?></td>
                                        <?php }?>
                                        <?php if($role == 4){?>
                                            <td><?php echo $filiereC['label'];?></td>
                                        <?php }?>
                                            <td>
                                            <a href="Modifier.php?id=<?=$user['id'];?>" class="btn-icon-split-primary btn-sm">Modifier</a>
                                            <a href="..\operations\Supprimer.php?id=<?=$user['id'];?>" class="btn-icon-split-danger btn-sm" onclick="return confirm('Are You Sure ?')">Supprimer</a>
                                            </td>
                                        </tr>
                                       <?php }?>
                                    </tbody>
                                </table>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>





