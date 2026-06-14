<?php
session_start();
require 'conexion.php';

// Seguridad: Solo Gestión puede estar aquí
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'gestion') {
    header("Location: index.php");
    exit();
}

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
            echo "<h3>✅ Materia y calificaciones asignadas con éxito a la boleta $boleta.</h3>";
        } else {
            echo "<h3>❌ Error: No se encontró ningún alumno registrado con esa boleta.</h3>";
        }
        echo "<br><a href='gestion.php'>Regresar al panel</a>";

    } catch(PDOException $e) {
        echo "<h3>❌ Error de Base de Datos: </h3>" . $e->getMessage();
        echo "<br><a href='gestion.php'>Regresar al panel</a>";
    }
}
?>