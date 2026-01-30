<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$id = $_GET['id'];

$empleado = $conexion->query("
SELECT * FROM empleados WHERE id=$id
")->fetch_assoc();

$direcciones = $conexion->query("SELECT * FROM direcciones");
$cargos = $conexion->query("SELECT * FROM cargos");
?>

<div class="contenido">

<h2>Editar Empleado</h2>

<form action="actualizar.php" method="POST" class="formulario">
<input type="hidden" name="id" value="<?= $empleado['id'] ?>">

<div class="grid-form">

<div>
<label>Cédula</label>
<input type="text" name="cedula" value="<?= $empleado['cedula'] ?>" readonly>
</div>

<div>
<label>Nombres</label>
<input type="text" name="nombre" value="<?= $empleado['nombre'] ?>" required>
</div>

<div>
<label>Apellidos</label>
<input type="text" name="apellido" value="<?= $empleado['apellido'] ?>" required>
</div>

<div>
<label>Dirección</label>
<select name="direccion_id" required>
<?php while($d=$direcciones->fetch_assoc()): ?>
<option value="<?= $d['id'] ?>" <?= $empleado['direccion_id']==$d['id']?'selected':'' ?>>
<?= $d['nombre'] ?>
</option>
<?php endwhile; ?>
</select>
</div>

<div>
<label>Cargo</label>
<select name="cargo_id" required>
<?php while($c=$cargos->fetch_assoc()): ?>
<option value="<?= $c['id'] ?>" <?= $empleado['cargo_id']==$c['id']?'selected':'' ?>>
<?= $c['nombre'] ?>
</option>
<?php endwhile; ?>
</select>
</div>

<div>
<label>Fecha Ingreso</label>
<input type="date" name="fecha_ingreso" value="<?= $empleado['fecha_ingreso'] ?>">
</div>

<div>
<label>Sueldo</label>
<input type="number" name="sueldo" value="<?= $empleado['sueldo'] ?>" step="0.01">
</div>

<div>
<label>Status</label>
<select name="status">
<option value="ACTIVO" <?= $empleado['status']=='ACTIVO'?'selected':'' ?>>ACTIVO</option>
<option value="VACACIONES" <?= $empleado['status']=='VACACIONES'?'selected':'' ?>>VACACIONES</option>
<option value="REPOSO" <?= $empleado['status']=='REPOSO'?'selected':'' ?>>REPOSO</option>
<option value="RETIRADO" <?= $empleado['status']=='RETIRADO'?'selected':'' ?>>RETIRADO</option>
</select>
</div>

</div>

<div class="acciones-form">
<button class="btn">Actualizar</button>
<a href="index.php" class="btn btn-secundario">Cancelar</a>
</div>

</form>

</div>

<?php include "../layout/footer.php"; ?>
