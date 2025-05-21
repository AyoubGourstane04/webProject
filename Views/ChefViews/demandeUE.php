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

    $unit_id=$_GET['id'];

    $unit=GetFromDb('SELECT * FROM units WHERE id=?;',$unit_id,false);


    if($_SERVER['REQUEST_METHOD']=='POST'){
    
        $demande=!empty($_POST['demande']) ? htmlspecialchars(trim($_POST['demande'])) : null;
        $Id_Unit=$unit_id;
        $prof_id=$_SESSION['id'];
        insertTempUnit($prof_id,$Id_Unit,$demande);
    }


?>




    
    
    <!-- Page Wrapper -->
    <div id="wrapper">

   <?php require_once "../include/navBars/ChefNav.php";?>

   <?php require_once "../include/header.php";?>
   
                <!-- Begin Page Content -->
                <div class="container-fluid">
                <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Demande</th>
                                    <th>Valider</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $unit['intitule'];?></td>
                                    <form method="POST">   
                                    <td>                                
                                        <div class="form-floating">
                                        <textarea class="form-control" placeholder="Ecrivez votre demande" id="floatingTextarea" name="demande"></textarea>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="submit" value="Demander" class="btn btn-primary">
                                    </td>
                                    </form>
                                </tr>   
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