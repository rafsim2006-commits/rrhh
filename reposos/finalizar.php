<?php
include "../config/conexion.php";

$id = $_GET['id'];

$r = $conexion->query("
SELECT empleado_id FROM reposos WHERE id=$id
")->fetch_assoc();

/* VOLVER A ACTIVO */
$conexion->query("
UPDATE empleados SET status='ACTIVO' WHERE id={$r['empleado_id']}
");

header("Location: index.php");
