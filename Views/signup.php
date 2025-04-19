<!-- <?php
    // ob_start();
?> -->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ENSAH | REGISTER</title>

    <!-- Custom fonts for this template-->
    <link href="..\startbootstrap-sb-admin-2-gh-pages\vendor\fontawesome-free\css\all.min.css" rel="stylesheet" type="text/css">    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="..\startbootstrap-sb-admin-2-gh-pages\css\sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

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
                            <form class="user" method="POST" action="#">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="FirstName" name="firstName" placeholder="Prénom" >
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="LastName" name="lastName" placeholder="Nom" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="birthdate" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control form-control-user" id="birthdate" name="birthdate" >
                                </div>
                                <div class="col-sm-6">
                                    <label for="cin" class="form-label">CIN (Carte d'Identité Nationale)</label>
                                    <input type="text" class="form-control form-control-user" id="cin" name="cin" 
                                        placeholder="Ex: AB12345">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="InputEmail" name="email"
                                    placeholder="Adresse email" >
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="InputSpeciality" name="speciality" placeholder="Spécialité" >
                                </div>
                                <div class="col-sm-6">
                                    <label for="department" class="form-label">Département :</label>
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

    <!-- Bootstrap core JavaScript-->
    <script src="..\startbootstrap-sb-admin-2-gh-pages\vendor\jquery\jquery.min.js"></script>
    <script src="..\startbootstrap-sb-admin-2-gh-pages\vendor\bootstrap\js\bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="..\startbootstrap-sb-admin-2-gh-pages\vendor\jquery-easing\jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="..\startbootstrap-sb-admin-2-gh-pages\js\sb-admin-2.min.js"></script>

</body>

</html>
<!-- 
<?php 
    // $content=ob_get_clean();

    // include_once "Views/layout.php";
?>     -->