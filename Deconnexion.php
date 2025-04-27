<?php

session_start();

unset($_SESSION['role'],$_SESSION['id']);

session_destroy();

header("Location: Views/login.php");
exit();