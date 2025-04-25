<?php

 include_once __DIR__ . '/../Model/database.php';


  function create(){
    createAccount();
    header('location: Views/pages/admin.php');
    exit();
     
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
   $role = !empty($_POST['role']) ? htmlspecialchars($_POST['role']) : null;

   try {
        $result = EditUser($id, $firstName, $lastName, $birthdate, $cin, $email, $speciality, $departement, $role);
          if ($result === true || $result === "User updated successfully.") {
            header('location: Views/pages/admin.php');
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
      $result = DeleteDb($id);
        if ($result === true || $result === "User deleted successfully.") {
          header('location: ../pages/admin.php');
          exit();
        }else{
             throw new Exception($result);
          }
   }catch (Exception $e) {
       echo "An error occurred: " . $e->getMessage();
    }
    
  }
  

 
