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
                if (!empty($fieldValue) && !preg_match('/^[A-Za-z]{2}\d{5}$/', $fieldValue)) {
                    return "CIN must be 2 letters followed by 5 digits";
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
    
        // Validate department :
        $validdepartments = ['1', '2'];
        if(isset($_POST['department'])){
            $sanitized['department'] = in_array($_POST['department'], $validdepartments) ? $_POST['department']: null;
        }
    
        // Validate roles :
        $validRoles = ['2', '3', '4'];
        $sanitized['roles'] = [];
        if (isset($_POST['roles']) && is_array($_POST['roles'])) {
            foreach ($_POST['roles'] as $role) {
                if (in_array($role, $validRoles)) {
                    $sanitized['roles'][] = htmlspecialchars($role);
                }
            }
        }

        foreach ($sanitized as $fieldName => $value) {
            if($fieldName!=='roles'){
                $error = checkemptiness($fieldName, $value);
                if ($error !== null) {
                    $errors[$fieldName] = $error;
                }
            }
        }
       
        return [
            'errors' => $errors,
            'data' => empty($errors) ? $sanitized : null
        ];
    }

   
    function sendEmail($password,$email){
        $to = $email;
        $subject = "Your New Account";
        $message = "Your temporary password: $password";
        mail($to, $subject, $message);
    }



    function propertyExists($pdo,$tableName,$property){
        $statment=$pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=? AND COLUMN_NAME=?;");
        $statment->execute([$tableName,$property]);
        return $statment->fetchColumn();
    }



    function HandleImageInput(){
        $fileName = null;
        if (!empty($_FILES['image']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png'];
            
            // Validate file
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                echo '<div class="alert alert-danger">File upload error: ' . $_FILES['image']['error'] . '</div>';
                return false;
            }
    
            if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                echo '<div class="alert alert-danger">Only JPG, PNG, or GIF files are allowed.</div>';
                return false;
            }
    
            // Generate safe filename
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('img_', true) . '.' . strtolower($extension);
            $uploadPath = '../resources/images/' . $fileName;
    
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                echo '<div class="alert alert-danger">Failed to save uploaded file.</div>';
            }
        }
        return $fileName;
    }






