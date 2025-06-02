<?php
  require_once __DIR__ . '/../include/functionsNeed.php';


    function dataBaseConnection(){
        try{
            $pdo=new PDO('mysql:host=localhost;dbname=EserviceDB;port=3306;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $pdo;
    }


  function createAccount(){
    $inputs=validateFormInputs(['firstName','lastName','cin','email','birthdate','speciality','department']);

    if (!empty($inputs['errors'])) {
        foreach ($inputs['errors'] as $field => $error) {
            echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($field).': '.htmlspecialchars($error).'</div>';
        }
        return false;
    } 

    $formData = $inputs['data'];
    $password =GeneratePassword();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   

    try{
        $pdo = dataBaseConnection();

        $conn=$pdo->prepare('INSERT INTO utilisateurs (
                                                        firstName,
                                                        lastName,
                                                        CIN,
                                                        Birthdate,
                                                        email,
                                                        password,
                                                        speciality,
                                                        id_departement
                                                    ) VALUES (?,?,?,?,?,?,?,?);
                                                    ');
    
    
    
        $conn->execute([$formData['firstName'],$formData['lastName'],$formData['cin'],$formData['birthdate'],$formData['email'],
                        $hashedPassword,$formData['speciality'],$formData['department']]);

        $user_id=$pdo->lastInsertId();

        $roles = validateRoles($_POST['roles']);
        $departement=$formData['department'];

        foreach($roles as $roleId){
            $stmt=$pdo->prepare('INSERT INTO userroles (user_id,role_id) VALUES (?,?);');
            $stmt->execute([$user_id,$roleId]);
        }

        //filieres if the user is a coordinateur :
        if (in_array(4, $roles)){
            $filiere_id = isset($_POST['filiere']) ? htmlspecialchars($_POST['filiere']) : null;
        
            if ($filiere_id){
                $result = changeTable('INSERT INTO coordinateurs (id_coordinateur, id_filiere) VALUES (?, ?);', [$user_id, $filiere_id]);
                if (!$result){
                    echo '<div class="alert alert-danger">Erreur lors de l\'affectation de la filière au coordonnateur.</div>';
                    return false;
                }
            }else{
                echo '<div class="alert alert-danger">Une filière doit être sélectionnée pour un Coordonnateur.</div>';
                return false;
            }
        }                      
        
        //sending the Email :
         sendEmail($password,$formData['email']);
            return true;
    }catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
    }



    function seConnecte(){
        $email=$_POST['email'];
        $password=$_POST['password'];

        session_start();
        
        $pdo=dataBaseConnection();
        $statment=$pdo->prepare("SELECT * FROM utilisateurs WHERE email=? ;");
        $statment->execute([$email]);
        $data=$statment->fetch(PDO::FETCH_ASSOC);

        if($statment->rowCount()>=1){
            if(password_verify($password,$data['password'])){
                $stmt = $pdo->prepare('SELECT * FROM userroles WHERE user_id = ?;');
                $stmt->execute([$data['id']]);
                $roleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($roleData)) {
                    $_SESSION['id'] = $roleData[0]['user_id'];
                }

                $validRoles = ['1', '2', '3', '4','5'];

                $roleIds = array_column($roleData, 'role_id');

                $filteredRoles = array_intersect($validRoles, $roleIds);

                if (in_array('1', $filteredRoles)) {
                    $role = '1';
                } elseif (!empty($filteredRoles)) {
                    $role = max($filteredRoles);
                } else {
                    $role = null;
                }

                    if ($data['must_change_password']) {
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['force_password_change'] = true;
                        $_SESSION['role'] = $role;
                        header('Location: /webProject/Views/change_password.php');
                        exit();
                    }
                $_SESSION['role'] = $role;
                

                

            switch ($role) {
                    case '1'://admin
                        header('location: /webProject/Views/adminViews/index.php');
                        break;
                    case '2'://enseignant
                        header('location: /webProject/Views/ProfViews/index.php');
                        break;
                    case '3'://chef de departement
                        header('location: /webProject/Views/ChefViews/index.php');
                        break;
                    case '4'://coordinateur de filiere
                        header('location: /webProject/Views/CoordViews/index.php');
                        break;  
                    case '5'://vacataire
                        header('location: /webProject/Views/vacViews/index.php');
                        break;        
                    default:
                        header("Location: /webProject/Views/login.php");
                        break;
                }
                    exit();
                  
                }else {  //hadi ila kan ghalt l mot de pass
                $_SESSION['login_error'] = 'Mot de passe incorrect!';
                header('Location: /webProject/Views/login.php');
                exit();
                }                    
            }else {  // nssiti ila kan ghalt l email
                $_SESSION['login_error'] = 'L\'utilisateur n\'existe pas!';
                header('Location: /webProject/Views/login.php');
                exit();
            }
}

    function GetFromDb($query,$values,$fetchAll=true){
        try {
            $pdo=dataBaseConnection();
            $stmt=$pdo->prepare($query);

            if (is_array($values)){
                $stmt->execute($values);
            }else{
                $stmt->execute([$values]);
            }
            if($fetchAll){
                $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $data=$stmt->fetch(PDO::FETCH_ASSOC);
            }
            
                if ($data === false) {
                    return false;
                }

                return $data;

       
        } catch (Exception $e) {
            error_log("Error : " . $e->getMessage());
            return false;
        } 
    }

    function GetSimpleDb($query,$fetchAll=true){
        try {
            $pdo=dataBaseConnection();
            $stmt=$pdo->query($query);
            if($fetchAll){
                $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $data=$stmt->fetch(PDO::FETCH_ASSOC);
            }
                if ($data === false) {
                    return false;
                }
                return $data;
        } catch (Exception $e) {
            error_log("Error : " . $e->getMessage());
            return false;
        }  
    } 

    function EditUser($id, $firstName, $lastName, $birthdate, $cin, $email, $speciality, $departement, $roles) {
        try {
            $pdo = dataBaseConnection();

            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $updateFields = [];
            $params = [];
    
            if (!empty($firstName)) {
                $updateFields[] = 'firstName = ?';
                $params[] = $firstName;
            }
            if (!empty($lastName)) {
                $updateFields[] = 'lastName = ?';
                $params[] = $lastName;
            }
            if (!empty($birthdate)) {
                $updateFields[] = 'Birthdate = ?';
                $params[] = $birthdate;
            }
            if (!empty($cin)) {
                $updateFields[] = 'CIN = ?';
                $params[] = $cin;
            }
            if (!empty($email)) {
                $updateFields[] = 'email = ?';
                $params[] = $email;
            }
            if (!empty($speciality)) {
                $updateFields[] = 'speciality = ?';
                $params[] = $speciality;
            }
            if (!empty($departement)) {
                $updateFields[] = 'id_departement = ?';
                $params[] = $departement;
            }

            if (count($updateFields) > 0) {
                $updateQuery = 'UPDATE utilisateurs SET ' . implode(', ', $updateFields) . ' WHERE id = ?';
                $params[] = $id;
    
                $stmt = $pdo->prepare($updateQuery);
                $stmt->execute($params);
            }
                $roles = validateRoles($_POST['roles']);

                $existingRoles =GetFromDb('SELECT role_id FROM userroles WHERE user_id=?;',$id);

                $existingRoleIds = array_column($existingRoles, 'role_id');

                $rolesToRemove = array_diff($existingRoleIds, $roles);

                if(!empty($rolesToRemove)){
                    $placeholders=implode(',', array_fill(0, count($rolesToRemove), '?'));
                    $statment=$pdo->prepare('DELETE FROM userroles WHERE user_id=? AND role_id IN ('.$placeholders.');');
                    $statment->execute(array_merge([$id],$rolesToRemove));
                }

                foreach($roles as $roleId){
                    if (!in_array($roleId,$existingRoleIds)){
                        $sql=$pdo->prepare('INSERT INTO userroles (role_id,user_id) VALUES (?,?);');
                        $sql->execute([$roleId,$id]);
                    }
                }

            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            if ($stmt->rowCount() > 0) {
                return "User updated successfully.";
            } else {
                return header('location: /webProject/Views/adminViews/admin.php');
            }

            
        } catch (PDOException $e) {
            return "Error updating user: " . $e->getMessage();
        }
    }


    function DeleteDb($tableName,$id){
        try{
            $pdo = dataBaseConnection();
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $statment=$pdo->prepare('DELETE FROM '.$tableName.' WHERE id=?;');
            $statment->execute([$id]);

            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            if ($statment->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No user found with the specified ID or no changes made.");
            }
            
        } catch (PDOException $e) {
            return "Error deleting user: " . $e->getMessage();
        }
    }
    

    function insertUser($firstName,$lastName,$birthdate,$cin,$email,$speciality){
        try{
            $pdo = dataBaseConnection();
    
            $conn=$pdo->prepare('INSERT INTO newusers (
                                                            firstName,
                                                            lastName,
                                                            CIN,
                                                            Birthdate,
                                                            email,                                                    
                                                            speciality
                                                        ) VALUES (?,?,?,?,?,?);
                                                        ');
        
        
        
            $conn->execute([$firstName,$lastName,$cin,$birthdate,$email,$speciality]);
                return true;
        }catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    
    }


    function DeleteRoleFromDB($user_id){
        try{
            $pdo = dataBaseConnection();
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $statment=$pdo->prepare('DELETE FROM userroles WHERE user_id=?;');
            $statment->execute([$user_id]);

            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            if ($statment->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No user found with the specified ID or no changes made.");
            }
            
        } catch (PDOException $e) {
            return "Error deleting roles: " . $e->getMessage();
        }
    }



    function NewPassword($new_password){
        $isValid=checkPassword($new_password);
        if($isValid===true){
            try{
                $hashedPassword=password_hash($new_password, PASSWORD_DEFAULT);
                $pdo = dataBaseConnection();
                
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
                $statment=$pdo->prepare('UPDATE utilisateurs SET password=?,must_change_password=0 WHERE id=?;');
                $statment->execute([$hashedPassword,$_SESSION['id']]);
    
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
                if ($statment->rowCount() > 0) {
                    return true;
                } else {
                    throw new Exception("Aucune modification détectée ou utilisateur introuvable.");
                }
                
            } catch (PDOException $e) {
                return "Erreur lors de la mise à jour : " . $e->getMessage();
            }
        }else {
            echo "<div class='alert alert-danger'>$isValid</div>";
            return false;
        }
    }

    function changeTable($query,$values){
        try{
            $pdo = dataBaseConnection();
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $statment=$pdo->prepare($query);
            
            if (is_array($values)){
                $statment->execute($values);
            }else{
                $statment->execute([$values]);
            }
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            return true;

        } catch (PDOException $e) {
            echo "Error Changing the table : " . $e->getMessage();
            return false;
        }
    }


    function getCount($tableName){
        try{
            $pdo = dataBaseConnection();
            $statment=$pdo->query('SELECT COUNT(*) FROM '.$tableName);
            if($statment){
                $count=$statment->fetchColumn();
                return $count;
            }

        } catch (PDOException $e) {
            echo "Error Getting the count : " . $e->getMessage();
            return -1;
        }
    }
       
    function Counter($query){
        try{
            $pdo = dataBaseConnection();
            $statment=$pdo->query($query);
            if($statment){
                $count=$statment->fetchColumn();
                return $count;
            }

        } catch (PDOException $e) {
            echo "Error Getting the count : " . $e->getMessage();
            return -1;
        }
    }

    function CounterValues($query,$values){
        try{
            $pdo=dataBaseConnection();
            $stmt=$pdo->prepare($query);

            if (is_array($values)){
                $stmt->execute($values);
            }else{
                $stmt->execute([$values]);
            }
            if($stmt){
                $count=$stmt->fetchColumn();
                return $count;
            }
        } catch (PDOException $e) {
            echo "Error Getting the count : " . $e->getMessage();
            return -1;
        }
    }


    function insertUnit($codeModule,$intitule,$semestre,$credits,$speciality,$dept_id,$filiere_id){
         try{
            $pdo = dataBaseConnection();
            $statment=$pdo->prepare('INSERT INTO units (code_module,
                                                   intitule,
                                                   semestre,
                                                   credits,
                                                   speciality,
                                                   departement_id,
                                                   id_filiere)
                                                   VALUES(?,?,?,?,?,?,?);');
           $statment->execute([$codeModule,$intitule,$semestre,$credits,$speciality,$dept_id,$filiere_id]);
           if($statment){
             $unit_id=$pdo->lastInsertId();
             return $unit_id;
           }

        } catch (PDOException $e) {
            echo "Error inserting the unit : " . $e->getMessage();
            return -1;
        }
    }

  
    function AddVacataire($dept_id,$fil_id){
        $firstName = !empty($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : null;
        $lastName = !empty($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : null;
        $birthdate = !empty($_POST['birthdate']) ? htmlspecialchars(trim($_POST['birthdate'])) : null;
        $cin = !empty($_POST['cin']) ? htmlspecialchars(trim($_POST['cin'])) : null;
        $email = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : null;
        $speciality = !empty($_POST['speciality']) ? htmlspecialchars(trim($_POST['speciality'])) : null;

        $password =GeneratePassword();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        try{
            $pdo = dataBaseConnection();
            $statment=$pdo->prepare('INSERT INTO utilisateurs (
                                                        firstName,
                                                        lastName,
                                                        CIN,
                                                        Birthdate,
                                                        email,
                                                        password,
                                                        speciality,
                                                        id_departement
                                                    ) VALUES (?,?,?,?,?,?,?,?);');
           $statment->execute([$firstName,$lastName,$cin,$birthdate,$email,$hashedPassword,$speciality,$dept_id]);
           if($statment){
             $vacId=$pdo->lastInsertId();

             $result=changeTable('INSERT INTO userroles (user_id,role_id) VALUES (?,?);',[$vacId,5]);
             if($result){
                $valid=changeTable('INSERT INTO vacataires (id_vacataire,id_filiere) VALUES (?,?);',[$vacId,$fil_id]);
                if($valid){
                        sendEmail($password,$email);

                        return true;
                }
             }

           }

        } catch (PDOException $e) {
            echo "Error inserting the Vacataire : " . $e->getMessage();
            return false;
        }
       
    }












 