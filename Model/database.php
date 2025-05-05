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

        foreach($roles as $roleId){
            $stmt=$pdo->prepare('INSERT INTO userroles (user_id,role_id) VALUES (?,?);');
            $stmt->execute([$user_id,$roleId]);
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

        $pdo=dataBaseConnection();
        $statment=$pdo->prepare("SELECT * FROM utilisateurs WHERE email=? ;");
        $statment->execute([$email]);
        $data=$statment->fetch(PDO::FETCH_ASSOC);

        if($statment->rowCount()>=1){
            if(password_verify($password,$data['password'])){

                    if ($data['must_change_password']) {
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['force_password_change'] = true;
                        header('Location: /webProject/Views/change_password.php');
                        exit();
                    }
                

                $stmt = $pdo->prepare('SELECT * FROM userroles WHERE user_id = ?;');
                $stmt->execute([$data['id']]);
                $roleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($roleData)) {
                    $_SESSION['id'] = $roleData[0]['user_id'];
                }

                $validRoles = ['1', '2', '3', '4'];

                $roleIds = array_column($roleData, 'role_id');

                $filteredRoles = array_intersect($validRoles, $roleIds);

                if (in_array('1', $filteredRoles)) {
                    $role = '1';
                } elseif (!empty($filteredRoles)) {
                    $role = max($filteredRoles);
                } else {
                    $role = null;
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
                        header('location: /webProject/Views/pages/coordinateur.php');
                        break;  
                    case '5'://vacataire
                        header('location: /webProject/Views/pages/vacataire.php');
                        break;        
                    default:
                        header("Location: /webProject/Views/login.php");
                        break;
                }
                    exit();
            }        
        }else{
            throw new Exception("L'utilisateur n'existe pas!");
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



   
  