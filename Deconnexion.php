<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: Views/login.php");
exit();



// session_start();

// unset($_SESSION['role'],$_SESSION['id'],$_SESSION['force_password_change']);

// session_destroy();

// header("Location: Views/login.php");
// exit();  
