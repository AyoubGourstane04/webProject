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
        $pdo = dataBaseConnection();
        $priorityRoles = ['4', '3', '2'];
        $selectedRoleId = null;
            foreach ($priorityRoles as $roleId) {
                if (in_array($roleId, $formData['roles'])) {
                    $selectedRoleId = $roleId;
                    break;
                }
            }

        $conn=$pdo->prepare('INSERT INTO utilisateurs (
                                                        firstName,
                                                        lastName,
                                                        CIN,
                                                        Birthdate,
                                                        email,
                                                        password,
                                                        role_id,
                                                        speciality,
                                                        id_departement,
                                                    ) VALUES (?,?,?,?,?,?,?,?,?);
                                                    ');
    
    
    
        $conn->execute([$formData['firstName'],$formData['lastName'],$formData['cin'],$formData['birthdate'],$formData['email'],
                        $hashedPassword,$selectedRoleId,$formData['speciality'],$formData['department']]);
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

    function GetFromDb($query,$values){
        $pdo=dataBaseConnection();
        $stmt=$pdo->prepare($query);

        if (is_array($values)){
            $stmt->execute($values);
        }else{
            $stmt->execute([$values]);
        }

        $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
    } 

    function GetSimpleDb($query){
        $pdo=dataBaseConnection();
        $stmt=$pdo->query($query);
        $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } 






   
  