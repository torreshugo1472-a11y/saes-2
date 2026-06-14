<?php
require 'conexion.php';

$identificador = 'ADMIN01';
$nombre = 'Director SAES';
$contrasena_plana = 'Admin.1234!'; // Cumple con mayúscula, minúscula, número y especial
$rol = 'directivo';
$cargo = 'Director General';

// Encriptamos la contraseña por seguridad
$contrasena_cifrada = password_hash($contrasena_plana, PASSWORD_DEFAULT);

try {
    $stmt = $conexion->prepare("INSERT INTO Usuarios (identificador, nombre_completo, contrasena, rol, cargo) VALUES (:id, :nom, :pass, :rol, :cargo)");
    $stmt->execute([':id' => $identificador, ':nom' => $nombre, ':pass' => $contrasena_cifrada, ':rol' => $rol, ':cargo' => $cargo]);
    echo "¡Administrador creado con éxito! Ya puedes iniciar sesión.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>