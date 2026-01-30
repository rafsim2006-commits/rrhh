<?php
require_once "../config/auth.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$vacaciones = $conexion->query("
SELECT v.*, 
       CONCAT(e.nombre,' ',e.apellido) AS empleado,
       e.status
FROM vacaciones v
INNER JOIN empleados e ON v.empleado_id = e.id
ORDER BY v.fecha_inicio DESC
");
?>

<div class="contenido">

<div class="encabezado-modulo">
    <h2>Vacaciones</h2>
    <a href="crear.php" class="btn">Registrar Vacaciones</a>
</div>

<table class="tabla">
<tr>
    <th>Empleado</th>
    <th>Desde</th>
    <th>Hasta</th>
    <th>Status</th>
    <th>Acción</th>
</tr>

<?php while($v=$vacaciones->fetch_assoc()): ?>
<tr>
    <td><?= $v['empleado'] ?></td>
    <td><?= date('d/m/Y',strtotime($v['fecha_inicio'])) ?></td>
    <td><?= date('d/m/Y',strtotime($v['fecha_fin'])) ?></td>
    <td>
        <span class="status <?= $v['status'] ?>">
            <?= $v['status'] ?>
        </span>
    </td>
    <td>
        <?php if($v['status']=='VACACIONES'): ?>
        <a class="btn btn-secundario"
           href="finalizar.php?id=<?= $v['id'] ?>"
           onclick="return confirm('¿Finalizar vacaciones?')">
           Finalizar
        </a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>

</div>

<?php include "../layout/footer.php"; ?>
