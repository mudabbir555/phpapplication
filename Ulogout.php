<?php
session_start();

session_unset();


header("location: Ulogin.php");
exit;

$_SESSION['loggedin'] = false;
session_destroy();
?>