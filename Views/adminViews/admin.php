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
    $userName=$data['firstName'].' '.$data['lastName'];

    $users=GetSimpleDb('SELECT * FROM Newusers;');
 


?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/navBars/AdminNav.php";?>


   <?php require_once "../include/header.php";?>
   
                <!-- Begin Page Content -->
                <div class="container-fluid">

                <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Prenom</th>
                                    <th>Nom</th>
                                    <th>CIN</th>
                                    <th>Date de naissance</th>
                                    <th>Email</th>
                                    <th>Specialité</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php foreach($users as $info){ 
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
                                            <a href="..\operations\Ajouter.php?id=<?=$info['id'];?>" class="btn-icon-split-primary btn-sm"><i class="fas fa-user-plus"></i> Ajouter</a>
                                            <a href="..\operations\deleteTempUser.php?id=<?=$info['id'];?>" class="btn-icon-split-danger btn-sm" onclick="return confirm('Are You Sure ?')">Refuser</a>
                                            </td>
                                        </tr>
                                       <?php }?>
                                    </tbody>
                </table>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



   
        <?php require_once "../include/footer.php";?>







<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>