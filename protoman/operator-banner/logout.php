<?php
// Logout
session_name("banner");
session_start();
$_SESSION = array(); // Unset all of the session variables.
if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); }
header("Location: login.php"); // Redirecting To Home Page
?>
