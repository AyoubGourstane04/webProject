<?php

session_start();

unset($_SESSION['role'],$_SESSION['id'],$_SESSION['force_password_change']);

session_destroy();

header("Location: Views/login.php");
exit();