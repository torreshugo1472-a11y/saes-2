<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SAES 2.0 - Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Bienvenido al SAES 2.0</h2>
    <form action="login.php" method="POST">
        <label>Identificador (Boleta o ID):</label><br>
        <input type="text" name="identificador" required><br><br>
        
        <label>Contraseña:</label><br>
        <input type="password" name="contrasena" required><br><br>
        
        <button type="submit">Entrar</button>
    </form>
</body>
</html>