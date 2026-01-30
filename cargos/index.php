<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$cargos = $conexion->query("SELECT * FROM cargos ORDER BY nombre");
?>

<div class="contenido">
<h2>Cargos</h2>
<br>
<br>
<a href="crear.php" class="btn">Nuevo Cargo</a>

<table class="tabla">
<thead>
<tr>
    <th>Nombre</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php while($c = $cargos->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($c['nombre']) ?></td>
    <td>
        <a class="btn" href="editar.php?id=<?= $c['id'] ?>">Editar</a>
        <a class="btn btn-danger"
           href="eliminar.php?id=<?= $c['id'] ?>"
           onclick="return confirm('¿Seguro que desea eliminar este cargo?')">
           Eliminar
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<?php include "../layout/footer.php"; ?>
