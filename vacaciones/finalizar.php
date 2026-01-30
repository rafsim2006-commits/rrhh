<?php
include "../config/conexion.php";

$id = $_GET['id'];

/* BUSCAR */
$v = $conexion->query("
SELECT empleado_id FROM vacaciones WHERE id=$id
")->fetch_assoc();

/* ACTUALIZAR STATUS */
$conexion->query("
UPDATE empleados SET status='ACTIVO' WHERE id={$v['empleado_id']}
");

header("Location: index.php");
