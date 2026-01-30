<?php
require_once "../config/auth.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$reposos = $conexion->query("
SELECT r.*, 
       CONCAT(e.nombre,' ',e.apellido) empleado,
       e.status
FROM reposos r
INNER JOIN empleados e ON r.empleado_id = e.id
ORDER BY r.fecha_inicio DESC
");
?>

<div class="contenido">

<div class="encabezado-modulo">
    <h2>Reposos</h2>
    <a href="crear.php" class="btn">Registrar Reposo</a>
</div>

<table class="tabla">
<tr>
    <th>Empleado</th>
    <th>Desde</th>
    <th>Hasta</th>
    <th>Status</th>
    <th>Acción</th>
</tr>

<?php while($r=$reposos->fetch_assoc()): ?>
<tr>
    <td><?= $r['empleado'] ?></td>
    <td><?= date('d/m/Y',strtotime($r['fecha_inicio'])) ?></td>
    <td><?= date('d/m/Y',strtotime($r['fecha_fin'])) ?></td>
    <td>
        <span class="status <?= $r['status'] ?>">
            <?= $r['status'] ?>
        </span>
    </td>
    <td>
        <?php if($r['status']=='REPOSO'): ?>
        <a class="btn btn-secundario"
           href="finalizar.php?id=<?= $r['id'] ?>"
           onclick="return confirm('¿Finalizar reposo?')">
           Finalizar
        </a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>

</div>

<?php include "../layout/footer.php"; ?>
