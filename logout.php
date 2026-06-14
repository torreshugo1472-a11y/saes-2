<?php
session_start();
session_destroy(); // Destruimos los datos del usuario actual
header("Location: index.php"); // Lo regresamos al login
exit();
?>