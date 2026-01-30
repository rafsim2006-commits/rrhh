<?php
include "../config/conexion.php";

$empleado = $_POST['empleado_id'];
$inicio = $_POST['fecha_inicio'];
$fin = $_POST['fecha_fin'];
$obs = $_POST['observacion'];


if(empty($_POST['empleado_id'])){
    echo "<script>
        alert('Debe buscar y seleccionar un empleado válido');
        history.back();
    </script>";
    exit;
}
/* VALIDAR QUE NO TENGA VACACIONES ACTIVAS */
$existe = $conexion->query("
SELECT id FROM vacaciones
WHERE empleado_id=$empleado
AND fecha_fin >= CURDATE()
")->num_rows;

if($existe){
    echo "<script>alert('El empleado ya tiene vacaciones activas');history.back();</script>";
    exit;
}

/* GUARDAR */
$conexion->query("
INSERT INTO vacaciones (empleado_id, fecha_inicio, fecha_fin, observacion)
VALUES ($empleado,'$inicio','$fin','$obs')
");

/* CAMBIAR STATUS */
$conexion->query("
UPDATE empleados SET status='VACACIONES' WHERE id=$empleado
");

header("Location: index.php");
