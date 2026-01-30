<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
require_once "../config/conexion.php";

$id = $_GET['id'];
$u = $conexion->query("SELECT * FROM usuarios WHERE id=$id")->fetch_assoc();
?>

<h2>✏️ Editar Usuario</h2>

<form action="actualizar.php" method="POST">
    <input type="hidden" name="id" value="<?= $u['id'] ?>">
    <input type="text" name="nombre" value="<?= $u['nombre'] ?>" required>
    <input type="text" name="usuario" value="<?= $u['usuario'] ?>" required>

    <select name="rol">
        <option value="ADMIN" <?= $u['rol']=='ADMIN'?'selected':'' ?>>Administrador</option>
        <option value="USUARIO" <?= $u['rol']=='USUARIO'?'selected':'' ?>>Usuario</option>
    </select>

    <select name="status">
        <option value="1" <?= $u['status']==1?'selected':'' ?>>Activo</option>
        <option value="0" <?= $u['status']==0?'selected':'' ?>>Inactivo</option>
    </select>

    <button type="submit">Actualizar</button>
</form>
