<?php
    ob_start();
    $title="ENSAH | REGISTER";
 
        session_start();
        if (isset($_SESSION['signup_message'])) {
            echo "<div class='alert alert-info'>" . $_SESSION['signup_message'] . "</div>";
            unset($_SESSION['signup_message']);
        }


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
                            <form action="../insert.php" class="user" method="POST" enctype="multipart/form-data">
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
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control form-control-user" id="InputSpeciality" name="speciality" placeholder="Spécialité" required>
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