<?php
session_start();
// Autorización Estricta: Si no ha iniciado sesión o no es de Gestión, lo pateamos
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'gestion') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Gestión - SAES 2.0</title>
</head>
<body>
    <h2>Bienvenido, Área de Gestión (<?php echo $_SESSION['nombre']; ?>)</h2>
    <a href="logout.php">Cerrar Sesión</a>
    <hr>
    
    <h3>Inscribir a un Nuevo Alumno</h3>
    <form action="alta_alumno.php" method="POST" enctype="multipart/form-data">
        <label>Boleta (10 dígitos):</label><br>
        <input type="text" name="identificador" required><br><br>
        
        <label>Nombre Completo:</label><br>
        <input type="text" name="nombre_completo" required><br><br>

        <label>Edad:</label><br>
        <input type="number" name="edad" required><br><br>
        
        <label>Contraseña (Regla escolar: Mayúscula, minúscula, número y símbolo):</label><br>
        <input type="password" name="contrasena" required><br><br>

        <label>Foto de Perfil (La subiremos a la nube más adelante):</label><br>
        <input type="file" name="foto_perfil" accept="image/*"><br><br>
        
        <button type="submit">Registrar Alumno</button>
    </form>
</body>
<hr>
    <h3>Asignar Materia y Calificaciones a un Alumno</h3>
    <form action="asignar_calificacion.php" method="POST">
        <label>Boleta del Alumno:</label><br>
        <input type="text" name="boleta" required><br><br>
        
        <label>ID de la Materia (Ej. MAT01):</label><br>
        <input type="text" name="id_materia" required><br><br>
        
        <label>Nombre de la Materia (Ej. Computación en la Nube):</label><br>
        <input type="text" name="nombre_materia" required><br><br>
        
        <label>Parcial 1:</label> 
        <input type="number" step="0.1" name="p1" value="0" required><br><br>
        
        <label>Parcial 2:</label> 
        <input type="number" step="0.1" name="p2" value="0" required><br><br>
        
        <label>Parcial 3:</label> 
        <input type="number" step="0.1" name="p3" value="0" required><br><br>
        
        <button type="submit">Guardar Calificaciones</button>
    </form>
</html>