<?php 

    $users=GetSimpleDb('SELECT * FROM utilisateurs WHERE role_id!=1;');
       
  
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
                    <h1 class="h3 mb-2 text-gray-800">List des Enseignants</h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Enseignants</h6>
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
                                            <th>Role</th>
                                            <th>Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($users as $info){ 
                                            $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$info['id_departement'],false);

                                            $role = GetFromDb("SELECT * FROM role WHERE id=? ;",$info['role_id'],false);
                                    ?>
                                        <tr>
                                            <td><?php echo $info['id'];?></td>
                                            <td><?php echo $info['firstName'];?></td>
                                            <td><?php echo $info['lastName'];?></td>
                                            <td><?php echo $info['CIN'];?></td>
                                            <td><?php echo $info['Birthdate'];?></td>
                                            <td><?php echo $info['email'];?></td>
                                            <td><?php echo $info['speciality'];?></td>
                                            <td>
                                                <?php echo ($department && isset($department['departement_name'])) ? $department['departement_name'] : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo ($role && isset($role['role_label'])) ? $role['role_label'] : ''; ?>
                                            </td>
                                            <td>
                                            <a href="..\operations\Modifier.php?id=<?=$info['id'];?>" class="btn-icon-split-primary btn-sm">Modifier</a>
                                            <a href="..\operations\Supprimer.php?id=<?=$info['id'];?>" class="btn-icon-split-danger btn-sm" onclick="return confirm('Are You Sure ?')">Supprimer</a>
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

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

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





