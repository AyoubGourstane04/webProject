<?php
  include_once "..\include\functionsNeed.php";

 function dataBaseConnection(){
        try{
            $pdo=new PDO('mysql:host=localhost;bdname=EserviceDB;port=3306;charset=UTF-8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $pdo;
    }



  function createAccount(){
    $inputs=validateFormInputs(['firstName','lastName','cin','email','speciality','department','roles']);
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
        $pdo = databaseConnection();
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
                        $hashedPassword,$formData['roles'],$formData['speciality'],$formData['department'],]);
            return true;
    }catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
   
    }

  
  


