<?php
session_start();
require 'conexion.php';

// Autorización: Si no es alumno, lo rebotamos al Login
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'alumno') {
    header("Location: index.php");
    exit();
}

$id_alumno = $_SESSION['id_usuario'];

// Traer los datos personales del alumno
$stmt = $conexion->prepare("SELECT * FROM Usuarios WHERE id_usuario = :id");
$stmt->execute([':id' => $id_alumno]);
$alumno = $stmt->fetch(PDO::FETCH_ASSOC);

// Traer las materias y calificaciones que le haya asignado Gestión
$stmt_materias = $conexion->prepare("SELECT * FROM Materias WHERE id_alumno = :id");
$stmt_materias->execute([':id' => $id_alumno]);
$materias = $stmt_materias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - SAES 2.0</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Bienvenido al SAES 2.0, <?php echo htmlspecialchars($alumno['nombre_completo']); ?></h2>
    <p>Boleta: <?php echo htmlspecialchars($alumno['identificador']); ?></p>
    <a href="logout.php">Cerrar Sesión</a>
    <hr>

    <h3>Tu Foto de Perfil</h3>
    <p>Archivo actual guardado: <strong><?php echo htmlspecialchars($alumno['foto_perfil']); ?></strong></p>
    
    <form action="subir_foto.php" method="POST" enctype="multipart/form-data">
        <label for="foto">Selecciona tu nueva foto:</label><br><br>
        <input type="file" name="foto" id="foto" accept="image/*" required><br><br>
        <button type="submit">Subir a la Nube ☁️</button>
    </form>

    <hr>
    <h3>Boleta de Calificaciones</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Materia</th>
            <th>Parcial 1</th>
            <th>Parcial 2</th>
            <th>Parcial 3</th>
            <th>Promedio Final (Automático)</th>
        </tr>
        
        <?php if(count($materias) > 0): ?>
            <?php foreach($materias as $materia): 
                // ⚙️ LÓGICA MATEMÁTICA: Promedio Automático
                $suma = $materia['parcial_1'] + $materia['parcial_2'] + $materia['parcial_3'];
                $promedio = $suma / 3;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($materia['nombre_materia']); ?></td>
                <td><?php echo htmlspecialchars($materia['parcial_1']); ?></td>
                <td><?php echo htmlspecialchars($materia['parcial_2']); ?></td>
                <td><?php echo htmlspecialchars($materia['parcial_3']); ?></td>
                <td><strong><?php echo number_format($promedio, 2); ?></strong></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Aún no tienes materias asignadas por el área de Gestión.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>