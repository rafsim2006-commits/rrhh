<?php
session_start();
include "../config/conexion.php";

$empleado = $_SESSION['empleado_id'];

$sol = $conexion->query("
SELECT * FROM solicitudes
WHERE empleado_id=$empleado
ORDER BY created_at DESC
");
?>

<div class="contenido">

<h2>Mis Solicitudes</h2>

<div class="tabla-responsive">
<table class="tabla">
<tr>
<th>Fecha</th>
<th>Status</th>
</tr>

<?php while($s=$sol->fetch_assoc()): ?>
<tr>
<td><?= date('d/m/Y',strtotime($s['created_at'])) ?></td>
<td>
<span class="status <?= $s['status']=='PENDIENTE'?'VACACIONES':'ACTIVO' ?>">
<?= $s['status'] ?>
</span>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>
