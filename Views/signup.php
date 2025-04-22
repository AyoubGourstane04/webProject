<?php
    ob_start();
    $title="ENSAH | REGISTER";
?>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">
                    <img src="..\startbootstrap-sb-admin-2-gh-pages\img\Capture1.PNG" alt="logo" class="img-fluid h-100">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créez un compte !</h1>
                            </div>
                            <form action="../create.php" class="user" method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="FirstName" name="firstName" placeholder="Prénom" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="LastName" name="lastName" placeholder="Nom" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <?php $today = date('Y-m-d'); ?>
                                    <label for="birthdate" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control form-control-user" id="birthdate" name="birthdate" min="1900-01-01" max="<?php echo $today; ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="cin" class="form-label">CIN (Carte d'Identité Nationale)</label>
                                    <input type="text" class="form-control form-control-user" id="cin" name="cin" 
                                        placeholder="Ex: AB12345" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <input type="email" class="form-control form-control-user" id="InputEmail" name="email"
                                        placeholder="Adresse email" required>
                                </div>     
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control form-control-user" id="InputSpeciality" name="speciality" placeholder="Spécialité" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="department" class="form-label">Département </label>
                                    <select class="form-control" id="department" name="department" >
                                        <option value="" disabled selected>Sélectionnez le département</option>
                                        <option value="1">Mathématiques et Informatique (MI)</option>
                                        <option value="2">Génie Civil Energétique et Environnement (GCEE)</option>
                                    </select>
                                </div>
                            </div>
                                <div class="form-group">
                                    <p class="h6 text-gray-800 mb-3">Sélectionnez ses rôle(s) :</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="roleTeacher" name="roles[]" value="2" checked>
                                                <label class="custom-control-label" for="roleTeacher">
                                                    <i class="fas fa-chalkboard-teacher mr-2"></i>Enseignant
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="roleDeptHead" name="roles[]" value="3">
                                                <label class="custom-control-label" for="roleDeptHead">
                                                    <i class="fas fa-user-tie mr-2"></i>Chef de département
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="roleCoordinator" name="roles[]" value="4">
                                                <label class="custom-control-label" for="roleCoordinator">
                                                    <i class="fas fa-tasks mr-2"></i>Coordonnateur de filière
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <input type="submit" value="Inscription" class="btn btn-primary btn-user btn-block">

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php 
    $content=ob_get_clean();

    include_once "layoutForm.php";
?>    