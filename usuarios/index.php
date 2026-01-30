<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
require_once "../config/conexion.php";

$resultado = $conexion->query("SELECT * FROM usuarios");
?>

<h2>👤 Usuarios del Sistema</h2>
<a href="crear.php">➕ Nuevo Usuario</a>

<table border="1" width="100%">
    <tr>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Status</th>
        <th>Acciones</th>
    </tr>

<?php while($u = $resultado->fetch_assoc()): ?>
<tr>
    <td><?= $u['nombre'] ?></td>
    <td><?= $u['usuario'] ?></td>
    <td><?= $u['rol'] ?></td>
    <td><?= $u['status'] ? 'Activo' : 'Inactivo' ?></td>
    <td>
        <a href="editar.php?id=<?= $u['id'] ?>">✏️ Editar</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
