<?php
session_start(); // Starting Session
// Estado de Sesion
echo "Loged in: " . $_SESSION['loggedin'] . "<br>";
echo "Type: " . $_SESSION['type'] . "<br>";
echo "Email: " . $_SESSION['login_email'] . "<br>";
echo "Hashed Password: " . $_SESSION['login_password'];
?>