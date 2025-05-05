<?php
    ob_start();
    $title="ENSAH | E-SERVICES";

?>

    <div class="container">

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
                                    <form class="user" action ="../seConnecter.php" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                               name="email" id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter votre nom d'utilisateur... ">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" id="exampleInputPassword" placeholder="Saisir votre mot de passe">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck"> Se rappeler moi</label>
                                            </div>
                                        </div>
                                        <input type="submit" value="Se connecter" class="btn btn-primary btn-user btn-block">
                                        <hr>
                                 
                                    </form>
                                   
                                    <div class="text-center">
                                        <a class="small" href="..\forgot-password.html">Mot de passe oublié ?</a>
                                    </div><br>
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

<?php 
    $content=ob_get_clean();

    include_once "layoutForm.php";
?>    