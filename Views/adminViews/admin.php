<?php
    require_once __DIR__ . '/../../Controller/controller.php';

    session_start();
    if ((!isset($_SESSION['role']) || $_SESSION['role'] != 1) && !isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }


    ob_start();

    $data = GetFromDb("SELECT * FROM utilisateurs WHERE id=?;", $_SESSION['id'], false);
    $title = 'Ajouter Utilisateurs';
    $userName = $data['firstName'] . ' ' . $data['lastName'];



    $users = GetSimpleDb('SELECT * FROM Newusers;');
?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php require_once "../include/navBars/AdminNav.php"; ?>
        <?php require_once "../include/header.php"; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
                <?php  displayFlashMessage(); ?>


            <!-- Card with title and action -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Utilisateurs en attente d'ajout</h6>
                </div>
                <div class="card-body">
                    <!-- Table Container -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>CIN</th>
                                <th>Date de Naissance</th>
                                <th>Email</th>
                                <th>Spécialité</th>
                                <th>Opérations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $info) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($info['id']) ?></td>
                                    <td><?= htmlspecialchars($info['firstName']) ?></td>
                                    <td><?= htmlspecialchars($info['lastName']) ?></td>
                                    <td><?= htmlspecialchars($info['CIN']) ?></td>
                                    <td><?= htmlspecialchars($info['Birthdate']) ?></td>
                                    <td><?= htmlspecialchars($info['email']) ?></td>
                                    <td><?= htmlspecialchars($info['speciality']) ?></td>
                                    <td class="text-nowrap">
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="Ajouter.php?id=<?= $info['id']; ?>" 
                                            class="btn btn-success btn-sm px-2">
                                                <i class="fas fa-user-plus me-1"></i> Ajouter
                                            </a>
                                            <a href="..\operations\deleteTempUser.php?id=<?= $info['id']; ?>" 
                                            class="btn btn-danger btn-sm px-2"
                                            onclick="return confirm('Êtes-vous sûr de vouloir refuser cet utilisateur ?')">
                                                <i class="fas fa-xmark me-1"></i> Refuser
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (empty($users)) : ?>
                        <p class="text-center text-muted mt-3">Aucun utilisateur en attente.</p>
                    <?php endif; ?>
                </div>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php require_once "../include/footer.php"; ?>

<?php
    $content = ob_get_clean();
    include_once "../dashboards.php";
?>
