<?php
// Iniciar la sesión para recordar quién entró
session_start();
require 'conexion.php'; // Traemos la conexión que ya hiciste

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identificador = $_POST['identificador'];
    $contrasena = $_POST['contrasena'];

    // Buscar al usuario en la base de datos
    $stmt = $conexion->prepare("SELECT * FROM Usuarios WHERE identificador = :identificador");
    $stmt->bindParam(':identificador', $identificador);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña cifrada coincide
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        
        // ¡Autenticación exitosa! Guardamos sus datos en la sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['nombre'] = $usuario['nombre_completo'];

        // Autorización: Redirigir dependiendo del rol
        if ($usuario['rol'] == 'directivo') {
            header("Location: admin.php");
        } elseif ($usuario['rol'] == 'gestion') {
            header("Location: gestion.php");
        } elseif ($usuario['rol'] == 'alumno') {
            header("Location: alumno.php");
        }
        exit();
    } else {
        echo "<h3>Credenciales incorrectas. <a href='index.php'>Volver a intentar</a></h3>";
    }
}
?>