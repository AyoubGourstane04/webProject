<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="..\..\startbootstrap-sb-admin-2-gh-pages\img\logo2.png" alt="Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">E-service</div>
    </a>
    
    <!-- Divider -->
    <hr class="sidebar-divider my-2">


    <!-- Nav Item - Accueil -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Activités d'Enseignement
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
                <h6 class="collapse-header">Gestion Des Modules:</h6>
                <a class="collapse-item" href="UeList.php">Liste des Unités</a>
                <a class="collapse-item" href="demUe.php">Liste disponibles</a>
            </div>
        </div>
    </li>
  

    <!-- Modules assurés -->
    <li class="nav-item">
        <a class="nav-link" href="moduleAffec.php">                                            
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Modules assurés</span>
        </a>
    </li>

    <!-- Notes -->
    <li class="nav-item">
        <a class="nav-link" href="upload_notes.php">
            <i class="fas fa-upload"></i>
            <span>Uploader Notes</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Archives
    </div>

    <!-- Historique -->
    <li class="nav-item">
        <a class="nav-link" href="historique.php">
            <i class="fas fa-history"></i>
            <span>Historique</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block"><br>
    <div class="text-center d-none d-md-inline">
             <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

</ul>
