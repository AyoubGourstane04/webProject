<?php

 function dataBaseConnection(){
        try{
            $pdo=new PDO('mysql:host=localhost;bdname=EserviceBD;port=3306;charset=UTF-8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $pdo;
    }


  function createAccount(){
    $firstName =htmlspecialchars($_POST['firstName']);
    $lastName =htmlspecialchars($_POST['lastName']);
    $email =htmlspecialchars($_POST['email']);
    $password =$_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     $pdo = databaseConnection();
    $conn=$pdo->prepare('INSERT INTO liste (firstName,lastName,age,login,password) VALUES (?,?,?,?,?);');
    $conn->execute([$firstName,$lastName,$email,$hashedPasswor]);


    }