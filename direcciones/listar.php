<?php
include "../config/conexion.php";
$res = $conexion->query("SELECT * FROM direcciones");
?>

<h3>Direcciones</h3>
<a href="crear.php">Nueva Dirección</a>

<?php while($d = $res->fetch_assoc()) { ?>
<p><?= $d['nombre'] ?></p>
<?php } ?>
