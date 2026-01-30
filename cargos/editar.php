<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$id = $_GET['id'];
$cargo = $conexion->query("SELECT * FROM cargos WHERE id=$id")->fetch_assoc();
?>

<div class="contenido">

<h2>Editar Cargo</h2>

<form action="actualizar.php" method="POST" class="formulario">
<input type="hidden" name="id" value="<?= $cargo['id'] ?>">

<label>Nombre del Cargo</label>
<input type="text" name="nombre" value="<?= $cargo['nombre'] ?>" required>

<div class="acciones-form">
<button class="btn">Actualizar</button>
<a href="index.php" class="btn btn-secundario">Cancelar</a>
</div>

</form>

</div>

<?php include "../layout/footer.php"; ?>
