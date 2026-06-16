<?php
session_start();
require 'conexion.php';

// Seguridad: Solo Gestión puede estar aquí
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'gestion') {
    header("Location: index.php");
    exit();
}

$mensaje = ""; // 1. Inicializamos la variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $boleta = $_POST['boleta'];
    $id_materia = $_POST['id_materia'];
    $nombre_materia = $_POST['nombre_materia'];
    $p1 = $_POST['p1'];
    $p2 = $_POST['p2'];
    $p3 = $_POST['p3'];

    try {
        // 1. Buscar el ID real del alumno usando su boleta
        $stmt_alumno = $conexion->prepare("SELECT id_usuario FROM Usuarios WHERE identificador = :boleta AND rol = 'alumno'");
        $stmt_alumno->execute([':boleta' => $boleta]);
        $alumno = $stmt_alumno->fetch(PDO::FETCH_ASSOC);

        if ($alumno) {
            $id_alumno = $alumno['id_usuario'];
            
            // 2. Insertar la materia y sus calificaciones en la base de datos
            $stmt = $conexion->prepare("INSERT INTO Materias (id_materia, nombre_materia, id_alumno, parcial_1, parcial_2, parcial_3) VALUES (:id_mat, :nom, :id_alum, :p1, :p2, :p3)");
            
            $stmt->execute([
                ':id_mat' => $id_materia,
                ':nom' => $nombre_materia,
                ':id_alum' => $id_alumno,
                ':p1' => $p1,
                ':p2' => $p2,
                ':p3' => $p3
            ]);
            
            // 3. Éxito: Guardamos el mensaje y le ponemos el botón
            $mensaje = "<h3>✅ Materia y calificaciones asignadas con éxito a la boleta $boleta.</h3>
                        <br><a href='gestion.php'><button>Asignar otra materia</button></a>";
        } else {
            // 4. Error: Alumno no encontrado
            $mensaje = "<h3>❌ Error: No se encontró ningún alumno registrado con esa boleta.</h3>
                        <br><a href='gestion.php'><button>Regresar al panel</button></a>";
        }

    } catch(PDOException $e) {
        // 5. Error de Base de Datos
        $mensaje = "<h3>❌ Error de Base de Datos: </h3><p>" . $e->getMessage() . "</p>
                    <br><a href='gestion.php'><button>Regresar al panel</button></a>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Calificaciones - SAES 2.0</title>
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