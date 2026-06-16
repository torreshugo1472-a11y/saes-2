<?php
session_start();
require 'conexion.php';

// Autorización estricta: Si alguien sin sesión o que no sea Gestión intenta meterse, lo pateamos
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'gestion') {
    header("Location: index.php");
    exit();
}

$mensaje = ""; // 1. Inicializamos la variable que guardará nuestra respuesta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $boleta = $_POST['identificador']; // La boleta de 10 dígitos
    $nombre_completo = $_POST['nombre_completo'];
    $edad = $_POST['edad'];
    $contrasena_plana = $_POST['contrasena'];

    // 🛡️ REGLA DE SEGURIDAD (La política estricta de la escuela)
    $tiene_mayuscula = preg_match('@[A-Z]@', $contrasena_plana);
    $tiene_minuscula = preg_match('@[a-z]@', $contrasena_plana);
    $tiene_numero    = preg_match('@[0-9]@', $contrasena_plana);
    $tiene_especial  = preg_match('@[^\w]@', $contrasena_plana); 

    // 2. Guardamos el error en $mensaje
    if (!$tiene_mayuscula || !$tiene_minuscula || !$tiene_numero || !$tiene_especial || strlen($contrasena_plana) < 8) {
        $mensaje = "<h3>⚠️ Error de Seguridad: La contraseña del alumno no cumple con los requisitos.</h3>
                    <br><a href='gestion.php'><button>Volver al panel</button></a>";
    } else {
        // ☁️ PREPARANDO EL TERRENO PARA AZURE BLOB STORAGE
        $nombre_foto = 'default.png'; // Foto por defecto
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
            $nombre_foto = basename($_FILES['foto_perfil']['name']); 
        }

        // Encriptamos la contraseña del alumno
        $contrasena_cifrada = password_hash($contrasena_plana, PASSWORD_DEFAULT);
        $rol = 'alumno';

        try {
            // Guardamos todo en la base de datos local
            $stmt = $conexion->prepare("INSERT INTO Usuarios (identificador, nombre_completo, contrasena, edad, foto_perfil, rol) VALUES (:id, :nom, :pass, :edad, :foto, :rol)");
            
            $stmt->execute([
                ':id' => $boleta, 
                ':nom' => $nombre_completo, 
                ':pass' => $contrasena_cifrada, 
                ':edad' => $edad,
                ':foto' => $nombre_foto,
                ':rol' => $rol
            ]);
            
            // 3. Todo salió bien, guardamos el éxito en $mensaje
            $mensaje = "<h3>✅ Alumno inscrito con éxito en el SAES 2.0.</h3>
                        <br><a href='gestion.php'><button>Inscribir otro alumno</button></a>";
        } catch(PDOException $e) {
            // 4. Si la base de datos falla, también lo guardamos en $mensaje
            $mensaje = "<h3>❌ Error al registrar en la base de datos: </h3><p>" . $e->getMessage() . "</p>
                        <br><a href='gestion.php'><button>Regresar al panel</button></a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Alumno - SAES 2.0</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div style='text-align: center; margin-top: 50px;'>
        <?php 
            if(!empty($mensaje)) {
                echo $mensaje;
            }
        ?>
    </div>
</body>
</html>