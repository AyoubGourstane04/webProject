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
    // ces trois lignes pour afficher l erreur  de mot de passe ou email
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


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
            header('location: '.$_SERVER['HTTP_REFERER']);
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

            header('location: Views/login.php');
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

 function changePassword(){

  $new_password= !empty($_POST['new_password']) ? htmlspecialchars(trim($_POST['new_password'])) : null;
  if($new_password){
        try {
            if(NewPassword($new_password)){
              unset($_SESSION['force_password_change']);
              header("Location: /webProject/Views/login.php");
              exit();
            }
        }catch (Exception $e) {
          echo "<div class='alert alert-danger'>Une erreur s'est produite : " . $e->getMessage() . "</div>";
        } 
  }else{
    echo "<div class='alert alert-danger'>Veuillez entrer un nouveau mot de passe.</div>";
  }
 
 }

 function insertTempUnit($userId,$unitId,$demande){
  try {
    $result = changeTable('INSERT INTO tempunits (id_prof,id_unit,demande) VALUES (?,?,?);',[$userId,$unitId,$demande]);
      if ($result === true ) {
        header('location: '.$_SERVER['HTTP_REFERER']);
        exit();
      }else{
           throw new Exception($result);
        }
 }catch (Exception $e) {
     echo "An error adding the temporary unit: " . $e->getMessage();
  } 
 }



 function addUnit_prof(){
  $unitId = !empty($_POST['unit']) ? htmlspecialchars(trim($_POST['unit'])) : null;
  $profId = !empty($_POST['prof']) ? htmlspecialchars(trim($_POST['prof'])) : null;

  try {
    $hours=GetFromDb('SELECT * FROM volumehorraire WHERE id_unit=?;',$unitId,false);
    $result = changeTable('INSERT INTO professeur (id_professeur,id_unit,Volume_horr) VALUES (?,?,?);',[$profId,$unitId,$hours['VolumeTotal']]);
      if ($result === true ) {
        $update = changeTable('UPDATE units SET statut=? WHERE id=?;',[1,$unitId]);
        if ($update === true ) {
          header('location: '.$_SERVER['HTTP_REFERER']);
          exit();
        }else{
             throw new Exception($update);
          }

      }else{
           throw new Exception($result);
        }
  }catch (Exception $e) {
       echo "Erreur lors de l'affectaion d'unité au professeur : " . $e->getMessage();
  } 

 }


 function validate_choice_action($id_prof,$id_unit){
  try {
    $hours=GetFromDb('SELECT * FROM volumehorraire WHERE id_unit=?;',$unitId);
    $result = changeTable('INSERT INTO professeur (id_professeur,id_unit,Volume_horr) VALUES (?,?,?);',[$profId,$unitId,$hours['VolumeTotal']]);
      if ($result === true ) {
        $update = changeTable('UPDATE units SET statut=? WHERE id=?;',[1,$id_unit]);
        if ($update === true) {
          $delete = changeTable('DELETE FROM tempunits WHERE id_prof=? AND id_unit=?;',[$id_prof,$id_unit]);
          if($delete === true){
            header('location: ../liste_ues.php');
            exit();
          }else{
            throw new Exception($delete);
          }
        }else{
             throw new Exception($update);
          }
      }else{
           throw new Exception($result);
        }
  }catch (Exception $e) {
       echo "Erreur lors de l'affectaion d'unité au professeur : " . $e->getMessage();
  } 
     

 }
 
 function refuse_choice_action($id_prof,$id_unit){
  try {
          $delete = changeTable('DELETE FROM tempunits WHERE id_prof=?,id_unit=?;',[$id_prof,$id_unit]);
          if($delete === true){
            header('location: Views/ChefViews/liste_ues.php');
            exit();
          }else{
            throw new Exception($delete);
          }
  }catch (Exception $e) {
       echo "Erreur lors de la suppression : " . $e->getMessage();
  } 

 }

 function getFiliere(){
    if(!isset($_GET['department_id'])){
      echo json_encode([]);
      exit;
    }
    
    $id_departement=htmlspecialchars($_GET['department_id']);
    $filieres=GetFromDb('SELECT * FROM filieres WHERE id_departement=? ;',$id_departement);

    echo json_encode($filieres);
 }

function addUnit($filiere_id,$dept_id){
  //these will be inserted in the units table :
  $codeModule=isset($_POST['code_module'])?htmlspecialchars($_POST['code_module']):null;
  $intitule=isset($_POST['intitule'])?htmlspecialchars($_POST['intitule']):null;
  $speciality=isset($_POST['speciality'])?htmlspecialchars($_POST['speciality']):null;
  $credits=isset($_POST['credits'])?htmlspecialchars($_POST['credits']):null;
  $semestre=isset($_POST['semestre'])?htmlspecialchars($_POST['semestre']):null;
  //these have their own table Volume Horraire : 
  $CM=isset($_POST['CM'])?htmlspecialchars($_POST['CM']):null;
  $TD=isset($_POST['TD'])?htmlspecialchars($_POST['TD']):null;
  $TP=isset($_POST['TP'])?htmlspecialchars($_POST['TP']):null;
  $autre=isset($_POST['autre'])?htmlspecialchars($_POST['autre']):null;
  $evaluation=isset($_POST['evaluation'])?htmlspecialchars($_POST['evaluation']):null;

  //inserting in the unit table : 
      try {
        $unit_id = insertUnit($codeModule, $intitule, $semestre, $credits, $speciality, $dept_id, $filiere_id);
        if ($unit_id != -1) {
            $result = changeTable('INSERT INTO volumehorraire (id_unit,Cours,TD,TP,Autre,Evaluation) VALUES(?,?,?,?,?,?);', [$unit_id, $CM, $TD, $TP, $autre, $evaluation]);
            if ($result === true) {
                return ['success' => true, 'message' => 'Unité ajoutée avec succès!'];
            }
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
    } 
    
    return ['success' => false, 'message' => 'Erreur inconnue'];
  }

  function CreerVacataire($dept_id){
    if(AddVacataire($dept_id)){
      header('location: '.$_SERVER['HTTP_REFERER']);
      exit();
    }
  }







  

 
