<?php 
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    

    ob_start();
    
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title='Professeurs';
    $userName=$data['firstName'].' '.$data['lastName'];

    $minHours=100;

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
                                WHERE u.id_departement=? AND r.role_id=2 OR r.role_id=5;",$data['id_departement']);
?>

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php require_once "../include/navBars/ChefNav.php";?>

    <?php require_once "../include/header.php";?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">
                        Professeurs appartennant au departement 
                        <?php echo ($department && isset($department['departement_name'])) ? $department['departement_name'] : ''; ?>
                    </h1>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                           <h6 class="m-0 font-weight-bold text-primary"> 
                                Professeurs appartennant au departement 
                                <?php echo ($department && isset($department['departement_name'])) ? $department['departement_name'] : ''; ?>
                            </h6>
                            <form method="post" action="operations/Export_prof.php">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel"></i> Exporter Excel
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id</th> 
                                            <th>Prénom</th>
                                            <th>Nom</th>
                                            <th>CIN</th>
                                            <th>Date de naissance</th>
                                            <th>Email</th>
                                            <th>Spécialité</th>
                                            <th>Volume Horraire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $underMinRows = [];
                                            $otherRows = [];

                                            foreach ($professeurs as $prof) {
                                                $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;',$prof['id']);
                                                $volume_horr= !empty($vol_horr)?$vol_horr:0;
                                                $rowClass=($volume_horr<$minHours)?'table-danger':'';    
                                                $rowHtml = "<tr class=\"$rowClass\">
                                                        <td>" . htmlspecialchars($prof['id']) . "</td>
                                                        <td>" . htmlspecialchars($prof['firstName']) . "</td>
                                                        <td>" . htmlspecialchars($prof['lastName']) . "</td>
                                                        <td>" . htmlspecialchars($prof['CIN']) . "</td>
                                                        <td>" . htmlspecialchars($prof['Birthdate']) . "</td>
                                                        <td>" . htmlspecialchars($prof['email']) . "</td>
                                                        <td>" . htmlspecialchars($prof['speciality']) . "</td>
                                                        <td>$volume_horr</td>
                                                    </tr>";
                                                

                                                if ($volume_horr < $minHours) {
                                                    $underMinRows[] = $rowHtml;
                                                } else {
                                                    $otherRows[] = $rowHtml;
                                                }
                                            }
                                                echo implode('', $underMinRows) . implode('', $otherRows);
                                        ?>
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
    <?php require_once "../include/footer.php";?>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    


<?php
    $content=ob_get_clean();
    include_once "../dashboards.php";

?>

