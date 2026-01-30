<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="contenido">

<h2>Nueva Dirección</h2>

<form action="guardar.php" method="POST" class="formulario">

<div class="grid-form">

<div>
<label>Nombre de la Dirección</label>
<input type="text"
       name="nombre"
       placeholder="Ej: DIRECCIÓN DE GESTIÓN HUMANA"
       required>
</div>

</div>

<div class="acciones-form">
<button class="btn">Guardar</button>
<a href="index.php" class="btn btn-secundario">Cancelar</a>
</div>

</form>

</div>

<?php include "../layout/footer.php"; ?>
