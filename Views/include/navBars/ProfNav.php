<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="..\..\startbootstrap-sb-admin-2-gh-pages\img\logo2.png" alt="Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">E-service</div>
    </a>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Accueil -->
    <li class="nav-item">
        <a class="nav-link" href="../ProfViews/index.php">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Enseignant
    </div>

    <!-- Unités d'enseignement -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUE"
            aria-expanded="false" aria-controls="collapseUE">
            <i class="fas fa-book"></i>
            <span>Unités d'enseignement</span>
        </a>
        <div id="collapseUE" class="collapse" aria-labelledby="headingUE" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="../ProfViews/UeList.php">Liste disponibles</a>
                <a class="collapse-item" href="../ProfViews/demandeUE.php">Exprimer les souhaits</a>
                <a class="collapse-item" href="#">Calcul charge horaire</a>
                <a class="collapse-item" href="#">Notifications</a>
            </div>
        </div>
    </li>

    <!-- Modules assurés -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Modules assurés</span>
        </a>
    </li>

    <!-- Notes -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNotes"
            aria-expanded="false" aria-controls="collapseNotes">
            <i class="fas fa-clipboard-list"></i>
            <span>Notes</span>
        </a>
        <div id="collapseNotes" class="collapse" aria-labelledby="headingNotes" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Session normale</a>
                <a class="collapse-item" href="#">Rattrapage</a>
            </div>
        </div>
    </li>

    <!-- Historique -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-history"></i>
            <span>Historique</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

</ul>
