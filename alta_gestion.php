<?php
session_start();
require 'conexion.php';

// Verificación estricta: Si un intruso intenta entrar aquí directamente, lo bloqueamos
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'directivo') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identificador = $_POST['identificador'];
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $contrasena_plana = $_POST['contrasena'];

    // 🛡️ REGLA DE SEGURIDAD DEL PROYECTO: Validar la contraseña
    $tiene_mayuscula = preg_match('@[A-Z]@', $contrasena_plana);
    $tiene_minuscula = preg_match('@[a-z]@', $contrasena_plana);
    $tiene_numero    = preg_match('@[0-9]@', $contrasena_plana);
    $tiene_especial  = preg_match('@[^\w]@', $contrasena_plana); // Busca símbolos

    if (!$tiene_mayuscula || !$tiene_minuscula || !$tiene_numero || !$tiene_especial || strlen($contrasena_plana) < 8) {
        echo "<h3>⚠️ Error de Seguridad</h3>";
        echo "<p>La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.</p>";
        echo "<a href='admin.php'>Volver al panel</a>";
    } else {
        // Si pasó la prueba, la encriptamos para no guardarla en texto plano
        $contrasena_cifrada = password_hash($contrasena_plana, PASSWORD_DEFAULT);
        $rol = 'gestion';

        try {
            $stmt = $conexion->prepare("INSERT INTO Usuarios (identificador, nombre_completo, correo, contrasena, rol) VALUES (:id, :nom, :correo, :pass, :rol)");
            
            $stmt->execute([
                ':id' => $identificador, 
                ':nom' => $nombre_completo, 
                ':correo' => $correo, 
                ':pass' => $contrasena_cifrada, 
                ':rol' => $rol
            ]);
            
            echo "<h3>✅ Usuario de Gestión registrado con éxito.</h3>";
            echo "<a href='admin.php'>Regresar al panel</a>";
        } catch(PDOException $e) {
            echo "<h3>❌ Error al registrar en la base de datos: </h3>" . $e->getMessage();
            echo "<br><a href='admin.php'>Regresar al panel</a>";
        }
    }
}
?>