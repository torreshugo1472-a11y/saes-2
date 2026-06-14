<?php
session_start();
// Autorización Estricta: Si no ha iniciado sesión o no es directivo, lo pateamos al Login
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'directivo') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Directivo - SAES 2.0</title>
</head>
<body>
    <h2>Bienvenido, Directivo <?php echo $_SESSION['nombre']; ?></h2>
    <a href="logout.php">Cerrar Sesión</a>
    <hr>
    
    <h3>Dar de alta a un nuevo usuario de Gestión</h3>
    <form action="alta_gestion.php" method="POST">
        <label>ID de Gestión (Ej. GEST01):</label><br>
        <input type="text" name="identificador" required><br><br>
        
        <label>Nombre Completo:</label><br>
        <input type="text" name="nombre_completo" required><br><br>
        
        <label>Correo Electrónico:</label><br>
        <input type="email" name="correo" required><br><br>
        
        <label>Contraseña (Obligatorio: Mayúscula, minúscula, número y símbolo):</label><br>
        <input type="password" name="contrasena" required><br><br>
        
        <button type="submit">Registrar Personal de Gestión</button>
    </form>
</body>
</html>