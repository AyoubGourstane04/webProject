<?php
   require_once __DIR__ . '/../Controller/controller.php';

    ob_start();
    session_start();  // nssiti hadi 
    $title="ENSAH | E-SERVICES";
    
    if (isset($_SESSION['signup_message'])) {
        echo "<div class='alert alert-info'>" . $_SESSION['signup_message'] . "</div>";
        unset($_SESSION['signup_message']);
    }
    



?>

    <div class="container">
    <?php  displayFlashMessage(); ?>

        <!-- Outer Row -->
        <div class="row justify-content-center ">

            <div class="col-xl-10 col-lg-12 col-md-9 ">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image" >
                                <img src="..\startbootstrap-sb-admin-2-gh-pages\img\Capture1.PNG" alt="logo" class="img-fluid h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Platforme eServices</h1>
                                    </div>
<!-- cette partie de php ces pour afficher erreur mot de pass ou email  -->
                                    <?php
                                    if (isset($_SESSION['login_error'])) {
                                    echo '<div class="alert alert-danger">' . $_SESSION['login_error'] . '</div>';
                                    unset($_SESSION['login_error']); // Supprimer le message après l'affichage
                                    }
                                     ?>
                                   <form class="user" action ="../seConnecter.php" method="POST" id="loginForm" novalidate>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                               name="email" id="loginEmail" aria-describedby="emailHelp"
                                                placeholder="Enter votre nom d'utilisateur... " required>
                                            <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" id="loginPassword" placeholder="Saisir votre mot de passe" minlength="8" required>
                                                <div class="invalid-feedback">Le mot de passe doit contenir au moins 8 caractères.</div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck"> Se rappeler moi</label>
                                            </div>
                                        </div> -->
                                        <input type="submit" value="Se connecter" class="btn btn-primary btn-user btn-block">
                                        <hr>
                                 
                                    </form>
                                   
                                    <!-- <div class="text-center">
                                        <a class="small" href="..\forgot-password.html">Mot de passe oublié ?</a>
                                    </div><br> -->
                                    <div class="text-center">
                                     Don't have an account? <a class="small" href="signup.php"> SignUp</a>
                                    </div><br>
                                    <div class="text-center">
                                        <p>Copyright © 2025 - Tous droits réservés</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        
        // Form submission validation
        loginForm.addEventListener('submit', function(event) {
            if (!loginForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Custom email validation
                const emailInput = document.getElementById('loginEmail');
                if (emailInput.validity.typeMismatch) {
                    emailInput.setCustomValidity('Veuillez entrer une adresse email valide');
                } else {
                    emailInput.setCustomValidity('');
                }
                
                // Custom password validation
                const passwordInput = document.getElementById('loginPassword');
                if (passwordInput.value.length < 8) {
                    passwordInput.setCustomValidity('Le mot de passe doit contenir au moins 8 caractères');
                } else {
                    passwordInput.setCustomValidity('');
                }
            }
            
            loginForm.classList.add('was-validated');
        }, false);
        
        // Real-time validation for email
        document.getElementById('loginEmail').addEventListener('input', function() {
            const emailInput = this;
            if (emailInput.validity.typeMismatch) {
                emailInput.setCustomValidity('Veuillez entrer une adresse email valide');
            } else {
                emailInput.setCustomValidity('');
            }
        });
        
        // Real-time validation for password
        document.getElementById('loginPassword').addEventListener('input', function() {
            const passwordInput = this;
            if (passwordInput.value.length < 8) {
                passwordInput.setCustomValidity('Le mot de passe doit contenir au moins 8 caractères');
            } else {
                passwordInput.setCustomValidity('');
            }
        });
    });
</script>

<?php 
    $content=ob_get_clean();

    include_once "layoutForm.php";
?>    