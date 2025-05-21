<?php

    session_start();
    if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
        header("Location: /webProject/Views/login.php");
        exit();
    }

    ob_start();
    
    $title="Changer mot de passe";

?>

<body class="bg-gradient-primary d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Changer votre Mot de passe</h1>
                        </div>
                        <form class="user" method="POST" action="../NewPassword.php" onsubmit="return PassLimit();">
                            <div class="form-group">
                                <input type="password" name="new_password" id="new_password" class="form-control form-control-user"
                                    placeholder="Entrez votre nouveau mot de passe" required>
                                    <small id="Error" class="text-danger"></small>
                            </div>
                            <div class="form-group mt-4">
                                <input type="submit" value="Changer mot de passe" class="btn btn-primary btn-user btn-block">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

<script>
    function PassLimit() {
    const password = document.getElementById("new_password").value;
    const errorPass = document.getElementById("Error");
    const minPassChar = 8;

    // Regex tests
    const hasLetter = /[A-Za-z]/.test(password);
    const hasDigit = /[0-9]/.test(password);
    const hasSpecial = /[\W_]/.test(password);

    if (password.length < minPassChar) {
        errorPass.textContent = `Le mot de passe doit contenir au moins ${minPassChar} caractères.`;
        return false;
    }
    if (!hasLetter) {
        errorPass.textContent = "Le mot de passe doit contenir au moins une lettre.";
        return false;
    }
    if (!hasDigit) {
        errorPass.textContent = "Le mot de passe doit contenir au moins un chiffre.";
        return false;
    }
    if (!hasSpecial) {
        errorPass.textContent = "Le mot de passe doit contenir au moins un caractère spécial.";
        return false;
    }

    errorPass.textContent = "";
    return true;
}

</script>


</html>


<?php
    $content=ob_get_clean();

    include_once "layoutForm.php";

?>