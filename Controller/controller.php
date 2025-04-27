<?php

 include_once __DIR__ . '/../Model/database.php';


  function create($id){
    $result=createAccount();
    if($result){
      DeleteDb('newusers',$id);
      header('location: Views/adminViews/admin.php');
      exit();
    }
    
  }

  function login(){
    session_start();
    seConnecte();
  }  


  function edit(){

   $id = !empty($_POST['id']) ? htmlspecialchars($_POST['id']) : null;
   $firstName = !empty($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : null;
   $lastName = !empty($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : null;
   $birthdate = !empty($_POST['birthdate']) ? htmlspecialchars(trim($_POST['birthdate'])) : null;
   $cin = !empty($_POST['cin']) ? htmlspecialchars(trim($_POST['cin'])) : null;
   $email = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : null;
   $speciality = !empty($_POST['speciality']) ? htmlspecialchars(trim($_POST['speciality'])) : null;
   $departement = !empty($_POST['departement']) ? htmlspecialchars($_POST['departement']) : null;
   $roles = validateRoles($_POST['roles']);

   try {
        $result = EditUser($id, $firstName, $lastName, $birthdate, $cin, $email, $speciality, $departement, $roles);
          if ($result === true || $result === "User updated successfully.") {
            header('location: Views/adminViews/admin.php');
            exit();
          }else{
               throw new Exception($result);
            }
     }catch (Exception $e) {
         echo "An error occurred: " . $e->getMessage();
      }
  
  }


  function delete($id){
    try {
        $result = DeleteDb('utilisateurs',$id);
        $roleResult=DeleteRoleFromDB($id);
          if ($result && $roleResult) {
            header('location: '.$_SERVER['HTTP_REFERER']);
            exit();
          } else {
            throw new Exception("Failed to delete user or roles.");
        }
      } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
      }
  }

  function insertNewUser(){
    $firstName = !empty($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : null;
    $lastName = !empty($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : null;
    $birthdate = !empty($_POST['birthdate']) ? htmlspecialchars(trim($_POST['birthdate'])) : null;
    $cin = !empty($_POST['cin']) ? htmlspecialchars(trim($_POST['cin'])) : null;
    $email = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : null;
    $speciality = !empty($_POST['speciality']) ? htmlspecialchars(trim($_POST['speciality'])) : null;

    try {
        $result=insertUser($firstName,$lastName,$birthdate,$cin,$email,$speciality);

        if ($result === true) {
            session_start();
            $_SESSION['signup_message'] = "Attendez la validation de votre compte!";

            header('location: Views/signup.php');
            exit();
          }else{
              throw new Exception($result);
            }
   }catch (Exception $e) {
       echo "An error occurred: " . $e->getMessage();
    }
  }

  
  function deleteTempUser($id){
    try {
      $result = DeleteDb('newusers',$id);
        if ($result === true || $result === "User deleted successfully.") {
          header('location: '.$_SERVER['HTTP_REFERER']);
          exit();
        }else{
             throw new Exception($result);
          }
   }catch (Exception $e) {
       echo "An error occurred: " . $e->getMessage();
    } 
  }


  

 
