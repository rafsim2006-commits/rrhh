<?php
include "../config/conexion.php";

$empleado = $_POST['empleado_id'];
$inicio = $_POST['fecha_inicio'];
$fin = $_POST['fecha_fin'];
$obs = $_POST['observacion'];

if(empty($empleado)){
    echo "<script>alert('Debe buscar un empleado válido');history.back();</script>";
    exit;
}

if($inicio > $fin){
    echo "<script>alert('Fechas inválidas');history.back();</script>";
    exit;
}

/* GUARDAR */
$conexion->query("
INSERT INTO reposos (empleado_id, fecha_inicio, fecha_fin, observacion)
VALUES ($empleado,'$inicio','$fin','$obs')
");

/* CAMBIAR STATUS */
$conexion->query("
UPDATE empleados SET status='REPOSO' WHERE id=$empleado
");

header("Location: index.php");
