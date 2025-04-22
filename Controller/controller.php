<?php

 include_once __DIR__ . '/../Model/database.php';


  function create(){
    require_once __DIR__ . '/../Views/signup.php';
    if(createAccount()) 
      header('location: /webProject/Views/pages/admin.php');
  }

  function login(){
    session_start();
    seConnecte();
  }  

  function GetUsersById($id){
    $data=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$id);
    return $data;
  }
 
