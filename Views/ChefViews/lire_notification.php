<?php
    require_once __DIR__ . '/../../Controller/controller.php';
    session_start();

    // Sécurité : redirection si utilisateur non connecté
    if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }


    $id_notification = isset($_GET['id_not'])? $_GET['id_not']:null;

    markAsRead($id_notification);



    ob_start();

    // Récupération des informations utilisateur pour afficher le nom
    $data = GetFromDb("SELECT firstName, lastName FROM utilisateurs WHERE id=?;", $_SESSION['id'], false);
    $userName = $data['firstName'] . ' ' . $data['lastName'];
    $title ="Notification";
    // Récupération des notifications de l'utilisateur
    $notifications = GetFromDb('SELECT * FROM notifications WHERE id=?;',$id_notification,false);
    $total = count($notifications);
?>

<div id="wrapper">
    <?php require_once "../include/navBars/ChefNav.php"; ?>
    <?php require_once "../include/header.php"; ?>

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Notification</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-info text-white">
                <h6 class="m-0 fw-bold">📌 <?= htmlspecialchars($notifications['title']) ?></h6>
            </div>
            <div class="card-body">
                <p class="text-muted">🕒 Reçue le : <?= $notifications['created_at'] ?></p>
                <hr>
                <p class="mb-4"><?= nl2br($notifications['message']) ?></p>
                <a href="notificationProf.php" class="btn btn-secondary">⬅️ Retour</a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once "../dashboards.php";
?>
