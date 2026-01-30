<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
</head>
<body>

<h2>➕ Crear Usuario</h2>

<form action="guardar.php" method="POST">

    <label>Nombre completo</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Usuario</label><br>
    <input type="text" name="usuario" required><br><br>

    <label>Clave</label><br>
    <input type="password" name="clave" required><br><br>

    <label>Rol</label><br>
    <select name="rol" required>
        <option value="">Seleccione un rol</option>
        <option value="ADMIN">Administrador</option>
        <option value="USUARIO">Usuario</option>
    </select><br><br>

    <button type="submit">Guardar</button>
</form>

</body>
</html>
