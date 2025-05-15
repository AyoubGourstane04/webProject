    
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
        <div class="sidebar-brand-icon">
            <img src="..\..\startbootstrap-sb-admin-2-gh-pages\img\logo2.png" alt="Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">E-service</div>
    </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-2">


    <!-- Nav Item - Accueil -->
    <li class="nav-item">
        <a class="nav-link" href="../adminViews/index.php">
            <!-- ../adminViews/admin.php -->
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
       Administrateur
    </div>
     <!-- Nav Items- Valider l'ajout -->
     <li class="nav-item">
        <a class="nav-link" href="admin.php"  data-target="#collapseCours"
            aria-expanded="false" aria-controls="collapseCours">
            <i class="fas fa-user-plus"></i>
            <span>Ajouter</span>
        </a>
    </li>

    <!-- Nav Items- Enseignants -->
    <li class="nav-item">
        <a class="nav-link" href="../adminViews/Enseignant.php"  data-target="#collapseCours"
            aria-expanded="false" aria-controls="collapseCours">
            <i class="fas fa-users"></i>
            <span>Enseignants</span>
        </a>
        <!-- <div id="collapseCours" class="collapse" aria-labelledby="headingCours" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Enseignants:</h6>
                <a class="collapse-item" href="#">List des Enseignants</a>
                <a class="collapse-item" href="..\operations\Modifier.php">Modifier</a>
            </div>
        </div> -->
    </li>

    <!-- Nav Item - chefs de departement -->
    <li class="nav-item">
        <a class="nav-link" href="../adminViews/chefs.php" data-target="#collapseRapports"
            aria-expanded="false" aria-controls="collapseRapports">
            <i class="fas fa-user-tie"></i>
            <span>Chefs de departement</span>
        </a>
        <!-- <div id="collapseRapports" class="collapse" aria-labelledby="headingRapports" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Chefs des departement</a>
                <a class="collapse-item" href="#">List des Chefs</a>
                <a class="collapse-item" href="#">Ajouter</a>
                <a class="collapse-item" href="#">Modifier</a>
            </div>
        </div> -->
    </li>

    <!-- Nav Item - coordinateurs des filiéres -->
    <li class="nav-item">
        <a class="nav-link" href="../adminViews/coordinateur.php" data-target="#collapseBibliotheque"
            aria-expanded="false" aria-controls="collapseBibliotheque">
            <i class="fas fa-user-tie"></i>
            <span>coordinateurs des filiéres</span>
        </a>
        <!-- <div id="collapseBibliotheque" class="collapse" aria-labelledby="headingBibliotheque" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">coordinateurs des filiéres </h6>
                <a class="collapse-item" href="#">List des Coordinateurs</a>
                <a class="collapse-item" href="#">Ajouter</a>
                <a class="collapse-item" href="#">Modifier</a>
            </div>
        </div> -->
    </li><br>
    <hr class="sidebar-divider d-none d-md-block">
    <br>
    <div class="text-center d-none d-md-inline">
             <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
</ul> 







