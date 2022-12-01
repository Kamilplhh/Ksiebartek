<?php
session_start();
unset($_SESSION['valid']);
unset($_SESSION["username"]);
unset($_SESSION["password"]);
echo '<script>alert("Wylogowywanie...")</script>';
echo '<script> location.replace("index.php") </script>';
?>