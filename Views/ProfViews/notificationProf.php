<?php
require_once __DIR__ . '/../../Controller/controller.php';
session_start();

// Sécurité : redirection si utilisateur non connecté
if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
}

ob_start();

// Récupération des informations utilisateur pour afficher le nom
$data = GetFromDb("SELECT firstName, lastName FROM utilisateurs WHERE id=?;", $_SESSION['id'], false);
$userName = $data['firstName'] . ' ' . $data['lastName'];
$title ="Notification";
// Récupération des notifications de l'utilisateur
$notifications = GetFromDb("SELECT * FROM notifications WHERE id_utilisateur=? ORDER BY created_at DESC;", $_SESSION['id']);
$total = count($notifications);
?>

<!-- Page Wrapper -->
<div id="wrapper">
    <?php require_once "../include/navBars/ProfNav.php"; ?>
    <?php require_once "../include/header.php"; ?>

    <!-- Contenu principal -->
    <div class="container-fluid">
       

        <!-- Bloc Notifications -->
        <div class="container">
            <h2 class="mb-3">Notifications</h2>

            <div class="alert alert-success d-inline-block mb-4">
                ✅ Nombre total d'éléments trouvés : <?= $total ?>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-info text-center">
                        <tr>
                            <th>Envoyé par</th>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notifications as $notif): ?>
                            <tr class="<?= $notif['is_read'] ? '' : 'table-light' ?>">
                                <td class="text-center">e-Services</td>
                                <td>
                                    <?= htmlspecialchars($notif['title']) ?><br>
                                    <?php if (!$notif['is_read']): ?>
                                        <span class="badge bg-primary mt-1">Non lu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($notif['created_at']) ?></td>
                                <td class="text-center">
                                    <a href="lire_notification.php?id_not=<?= $notif['id'] ?>" class="text-primary fw-bold">Lire</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require_once "../include/footer.php"; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
$content = ob_get_clean();
include_once "../dashboards.php";
?>
