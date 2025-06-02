<?php
    function GeneratePassword($length=12){
        $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
        $password='';
        $size=strlen($chars)-1;
        for($i=0;$i<$length;$i++){
            $password.=$chars[random_int(0,$size)];
        }
        return $password;
    }

    function checkemptiness($fieldName, $fieldValue) {
        switch ($fieldName) {
            case 'firstName':
            case 'lastName':
                if (empty($fieldValue)) {
                    return 'Le champ ' . $fieldName . ' est obligatoire';
                }
                break;
    
            case 'email':
                if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
                    return "Invalid email format";
                }
                break;
    
            case 'department':
                if (empty($fieldValue)) {
                    return "Department selection is invalid";
                }
                break;
    
            case 'birthdate':
                if (!empty($fieldValue) && !strtotime($fieldValue)) {
                    return "Invalid birthdate format";
                }
                break;
    
            case 'cin':
                if (!empty($fieldValue) && !preg_match('/^[A-Za-z]{1,2}[0-9]{4,6}$/', $fieldValue)) {
                    return "CIN must be 2 letters followed by 4 to 6 digits";
                }
                break;
        }
    
        return null;
    }
 
    function validateFormInputs($requiredFields = []) {
        $errors = [];
        $sanitized = [];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field])) {
                $errors[$field] = "le champ '$field' est obligatoire";
            }
        }
    
        if (!empty($errors)) {
            return ['errors' => $errors, 'data' => null];
        }
        //sanitize the inputs :
        $sanitized['firstName'] = !empty($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : null;
        $sanitized['lastName'] = !empty($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : null;
        $sanitized['birthdate'] = !empty($_POST['birthdate']) ? htmlspecialchars(trim($_POST['birthdate'])) : null;
        $sanitized['cin'] = !empty($_POST['cin']) ? htmlspecialchars(trim($_POST['cin'])) : null;
        $sanitized['email'] = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : null;
        $sanitized['speciality'] = !empty($_POST['speciality']) ? htmlspecialchars(trim($_POST['speciality'])) : null;
        
        // HandleRoleInsert($_POST['roles']);
        
    
        // Validate department :
        $validdepartments = ['1', '2'];
        if(isset($_POST['department'])){
            $sanitized['department'] = in_array($_POST['department'], $validdepartments) ? $_POST['department']: null;
        }


        foreach ($sanitized as $fieldName => $value) {
                $error = checkemptiness($fieldName, $value);
                if ($error !== null) {
                    $errors[$fieldName] = $error;
                }
        }
       
        return [
            'errors' => $errors,
            'data' => empty($errors) ? $sanitized : null
        ];
    }


    function sendEmail($password, $email){
        $to = $email;
        $subject = "Your New Account";
        $message = "Your temporary password: $password";
        $headers = "From: ayoubgourstan@gmail.com";
    
        if(mail($to, $subject, $message, $headers)){
            echo "Email sent successfully.";
        } else {
            echo "Email sending failed.";
        }
    }

    function validateRoles($roles){
        $validRoles = ['1','2', '3', '4','5'];
        $sanitizedRoles = isset($roles) && is_array($roles)? array_values(array_intersect($validRoles,$roles)):[];
        
        if (empty($sanitizedRoles)) {
            throw new Exception("Au moins un rôle doit être sélectionné.");
        }else{
            return $sanitizedRoles;
        }
    }

    function checkPassword($password){
        if (strlen($password) < 8) {
            return "Le mot de passe doit contenir au moins 8 caractères.";
        }
    
        if (!preg_match('/[A-Za-z]/', $password)) {
            return "Le mot de passe doit contenir au moins une lettre.";
        }
    
        if (!preg_match('/[0-9]/', $password)) {
            return "Le mot de passe doit contenir au moins un chiffre.";
        }
    
        if (!preg_match('/[\W_]/', $password)) {
            return "Le mot de passe doit contenir au moins un caractère spécial.";
        }
    
        return true;
    }
    
    function displayFlashMessage() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $alertType = $flash['success'] ? 'alert-success' : 'alert-danger';
            echo '<div class="container mt-3 d-flex justify-content-center">
                    <div id="notification-toast" class="alert '.$alertType.' d-flex align-items-center justify-content-between w-100" style="max-width: 600px;">
                        <span>'.$flash['message'].'</span>
                        <button type="button" class="btn btn-sm btn-light border ms-3" style="line-height: 1;" aria-label="Close" onclick="document.getElementById(\'notification-toast\').remove()">&times;</button>

                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        const toast = document.getElementById(\'notification-toast\');
                        if (toast) {
                            toast.style.opacity = \'0\';
                            setTimeout(() => toast.remove(), 500);
                        }
                    }, 3000);
                </script>';
            unset($_SESSION['flash']);
        }
    }
    

    
?>









   



