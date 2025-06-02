<?php
    ob_start();
    $title="ENSAH | REGISTER";
    // session_start(); 


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
                            <form action="../insert.php" class="user" method="POST" id="signupForm" enctype="multipart/form-data" novalidate>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="FirstName" name="firstName" placeholder="Prénom" required>
                                    <div class="invalid-feedback">Veuillez entrer votre prénom.</div>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="LastName" name="lastName" placeholder="Nom" required>
                                    <div class="invalid-feedback">Veuillez entrer votre nom.</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <?php $today = date('Y-m-d'); ?>
                                    <label for="birthdate" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control form-control-user" id="birthdate" name="birthdate" min="1900-01-01" max="<?php echo $today; ?>" required>
                                    <div class="invalid-feedback">Veuillez entrer une date de naissance valide.</div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="cin" class="form-label">CIN (Carte d'Identité Nationale)</label>
                                    <input type="text" class="form-control form-control-user" id="cin" name="cin" 
                                        placeholder="Ex: AB123456" required>
                                    <div class="invalid-feedback">Format CIN invalide (ex: AB12345).</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <input type="email" class="form-control form-control-user" id="Email" name="email"
                                        placeholder="Adresse email" required>
                                    <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
                                </div>     
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control form-control-user" id="Speciality" name="speciality" placeholder="Spécialité" required><br>
                                    <div class="invalid-feedback">Veuillez entrer votre spécialité.</div>
                                </div>


                                <input type="submit" value="Inscription" class="btn btn-primary btn-user btn-block">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('signupForm');
        
        // Add event listener for form submission
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Add custom validation here if needed
            validateCIN();
            validateBirthdate();
            
            form.classList.add('was-validated');
        }, false);
        
        // Custom validation functions
        function validateCIN() {
            const cinInput = document.getElementById('cin');
            const cinPattern = /^[A-Za-z]{1,2}[0-9]{4,6}$/;
            
            if (!cinPattern.test(cinInput.value)) {
                cinInput.setCustomValidity('Format CIN invalide (ex: AB12345)');
            } else {
                cinInput.setCustomValidity('');
            }
        }
        
        function validateBirthdate() {
            const birthdateInput = document.getElementById('birthdate');
            const birthdate = new Date(birthdateInput.value);
            const today = new Date();
            const minAgeDate = new Date();
            minAgeDate.setFullYear(today.getFullYear() - 16); // Minimum age 16 years
            
            if (birthdate > minAgeDate) {
                birthdateInput.setCustomValidity('Vous devez avoir au moins 16 ans');
            } else {
                birthdateInput.setCustomValidity('');
            }
        }
        
        // Add event listeners for real-time validation
        document.getElementById('cin').addEventListener('input', validateCIN);
        document.getElementById('birthdate').addEventListener('change', validateBirthdate);
    });
</script>

<?php 
    $content=ob_get_clean();

    include_once "layoutForm.php";
?>    