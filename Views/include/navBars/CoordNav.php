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

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

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
        Gestion de la Filière
    </div>

    <!-- Nav Item - Gestion des Modules (Unités d'Enseignement) Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseModules"
            aria-expanded="true" aria-controls="collapseModules">
            <i class="fas fa-fw fa-book-open"></i> <!-- Icon for modules/courses -->
            <span>Modules</span>
        </a>
        <div id="collapseModules" class="collapse" aria-labelledby="headingModules" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion des Modules:</h6>
                <a class="collapse-item" href="creer_descriptif_module.php">Créer/Gérer Descriptif</a>
                <a class="collapse-item" href="liste_ues_filiere.php">Lister les Modules</a>
                <a class="collapse-item" href="definir_groupes_td_tp.php">Définir Groupes TD/TP</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Gestion des Vacataires Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVacataires"
            aria-expanded="true" aria-controls="collapseVacataires">
            <i class="fas fa-fw fa-user-tie"></i> <!-- Icon for part-time/guest lecturers -->
            <span>Vacataires</span>
        </a>
        <div id="collapseVacataires" class="collapse" aria-labelledby="headingVacataires" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion des Vacataires:</h6>
                <a class="collapse-item" href="creer_compte_vacataire.php">Créer Compte Vacataire</a>
                <a class="collapse-item" href="affecter_module_vacataire.php">Affecter Module(s)</a>
                <!-- Optional: <a class="collapse-item" href="lister_vacataires.php">Lister Vacataires</a> -->
            </div>
        </div>
    </li>

    <!-- Nav Item - Affectations & Emploi du Temps Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAffectationsEDT"
            aria-expanded="true" aria-controls="collapseAffectationsEDT">
            <i class="fas fa-fw fa-calendar-check"></i> <!-- Icon for schedules/assignments -->
            <span>Affectations & EDT</span>
        </a>
        <div id="collapseAffectationsEDT" class="collapse" aria-labelledby="headingAffectationsEDT" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Suivi et Planification:</h6>
                <a class="collapse-item" href="consulter_affectations.php">Consulter Affectations</a>
                <a class="collapse-item" href="emploi_du_temps.php">Charger Emploi du Temps</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Outils & Archives
    </div>

    <!-- Nav Item - Historique -->
    <li class="nav-item">
        <a class="nav-link" href="historique_filiere.php">
            <i class="fas fa-fw fa-history"></i>
            <span>Historique</span></a>
    </li>

     <!-- Nav Item - Import/Export -->
     <li class="nav-item">
        <a class="nav-link" href="import_export_filiere.php">
            <i class="fas fa-fw fa-file-excel"></i>
            <span>Import/Export Excel</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
<!-- End of Sidebar -->