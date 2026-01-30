<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";

$id = $_POST['id'];

$cedula = $_POST['cedula'];
$nombre = strtoupper($_POST['nombre']);
$apellido = strtoupper($_POST['apellido']);
$cargo = $_POST['cargo_id'];
$direccion = $_POST['direccion_id'];
$fecha = $_POST['fecha_ingreso'];
$sueldo = $_POST['sueldo'];
$status = $_POST['status'];

$conexion->query("
UPDATE empleados SET
cedula='$cedula',
nombre='$nombre',
apellido='$apellido',
cargo_id=$cargo,
direccion_id=$direccion,
fecha_ingreso='$fecha',
sueldo=$sueldo,
status='$status'
WHERE id=$id
");

header("Location: index.php");
