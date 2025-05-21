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
$title = "Historique";

// Récupération des historiques liés aux unités enseignées par ce professeur
$historique = GetFromDb("
    SELECT 
        h.id AS historique_id,
        u.intitule AS module,
        u.semestre,
        f.label AS filiere,
        h.annee,
        h.date_cr
    FROM historiques h
    JOIN units u ON h.id_unite = u.id
    JOIN filieres f ON u.id_filiere = f.id
    JOIN professeur p ON u.id = p.id_unit
    WHERE h.id_utilisateur = ?
    ORDER BY h.date_cr DESC
;", $_SESSION['id']);

?>

<!-- Page Wrapper -->
<div id="wrapper">
    <?php require_once "../include/navBars/CoordNav.php"; ?>
    <?php require_once "../include/header.php"; ?>

    <!-- Contenu principal -->
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Historique</h1>

        <div class="container">
            <h2 class="mb-3">Liste des actions passées</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-info text-center">
                        <tr>
                            <th>#</th>
                            <th>Module</th>
                            <th>Filière</th>
                            <th>Semestre</th>
                            <th>Année Universitaire</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historique as $his): ?>
                            <tr>
                                <td class="text-center"><?= $his['historique_id'] ?></td>
                                <td class="text-center"><?= htmlspecialchars($his['module']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($his['filiere']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($his['semestre']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($his['annee']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($his['date_cr']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($historique)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Aucun historique trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
    <?php require_once "../include/footer.php"; ?>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
$content = ob_get_clean();
require_once "../dashboards.php";
?>
