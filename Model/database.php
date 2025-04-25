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
    $inputs=validateFormInputs(['firstName','lastName','cin','email','speciality','department']);

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
                                                        role_id,
                                                        speciality,
                                                        id_departement
                                                    ) VALUES (?,?,?,?,?,?,?,?,?);
                                                    ');
    
    
    
        $conn->execute([$formData['firstName'],$formData['lastName'],$formData['cin'],$formData['birthdate'],$formData['email'],
                        $hashedPassword,2,$formData['speciality'],$formData['department']]);
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
                $_SESSION['role_id']=$data['role_id'];
                $_SESSION['id']=$data['id'];
                $role=$_SESSION['role_id'];

                //this should be replaced by this in the future : 
                // header('location: dashboard.php?role_id=..&id=..');
            switch ($role) {
                    case '1'://admin
                        header('location: /webProject/Views/pages/admin.php');
                        break;
                    case '2'://enseignant
                        header('location: /webProject/Views/pages/professeur.php');
                        break;
                    case '3'://chef de departement
                        header('location: /webProject/Views/pages/chef.php');
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

    function GetSimpleDb($query){
        try {
            $pdo=dataBaseConnection();
            $stmt=$pdo->query($query);
            $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($data === false) {
                    return false;
                }
                return $data;
        } catch (Exception $e) {
            error_log("Error : " . $e->getMessage());
            return false;
        }  
    } 

    function EditUser($id, $firstName, $lastName, $birthdate, $cin, $email, $speciality, $departement, $role) {
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
            if (!empty($role)) {
                $updateFields[] = 'role_id = ?';
                $params[] = $role;
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
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            if ($stmt->rowCount() > 0) {
                return "User updated successfully.";
            } else {
                return "No changes made. Either the user was not found or the data is identical.";
            }
        } catch (PDOException $e) {
            return "Error updating user: " . $e->getMessage();
        }
    }

    function DeleteDb($id){
        try{
            $pdo = dataBaseConnection();
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $statment=$pdo->prepare('DELETE FROM utilisateurs WHERE id=?;');
            $statment->execute([$id]);

            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            if ($statment->rowCount() > 0) {
                return "User deleted successfully.";
            }else {
                return "No user found with the specified ID or no changes made.";
            }
            
        } catch (PDOException $e) {
            return "Error deleting user: " . $e->getMessage();
        }
    }
    




   
  