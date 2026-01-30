<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$direcciones = $conexion->query("SELECT * FROM direcciones ORDER BY nombre");
?>

<div class="contenido">
<h2>Direcciones</h2>
<br>
<br>
<a href="crear.php" class="btn">Nueva Dirección</a>

<table class="tabla">
<thead>
<tr>
    <th>Nombre</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php while($d = $direcciones->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($d['nombre']) ?></td>
    <td>
        <a class="btn" href="editar.php?id=<?= $d['id'] ?>">Editar</a>
        <a class="btn btn-danger"
           href="eliminar.php?id=<?= $d['id'] ?>"
           onclick="return confirm('¿Seguro que desea eliminar esta dirección?')">
           Eliminar
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<?php include "../layout/footer.php"; ?>
