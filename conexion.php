<?php
// conexion.php
$host = 'localhost';
$dbname = 'saes2_db';
$username = 'root'; // Usuario por defecto de XAMPP
$password = ''; // XAMPP no tiene contraseña por defecto

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar PDO para que lance excepciones si hay errores
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error en la conexi
    ón a la base de datos: " . $e->getMessage());
}
?>