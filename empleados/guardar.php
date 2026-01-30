<?php
include "../config/conexion.php";

/* DATOS */
$cedula        = $_POST['cedula'];
$nombre        = strtoupper($_POST['nombre']);
$apellido      = strtoupper($_POST['apellido']);
$direccion_id  = $_POST['direccion_id'];
$cargo_id      = $_POST['cargo_id'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$sueldo        = $_POST['sueldo'];
$status        = $_POST['status'] ?? 'ACTIVO';

/* VALIDAR CÉDULA DUPLICADA */
$existe = $conexion->query("
SELECT id FROM empleados WHERE cedula='$cedula'
")->num_rows;

if($existe > 0){
    echo "<script>
        alert('El empleado ya existe (cédula duplicada)');
        history.back();
    </script>";
    exit;
}

/* GUARDAR EMPLEADO */
$conexion->query("
INSERT INTO empleados
(cedula,nombre,apellido,direccion_id,cargo_id,fecha_ingreso,sueldo,status)
VALUES
('$cedula','$nombre','$apellido',$direccion_id,$cargo_id,'$fecha_ingreso','$sueldo','$status')
");

header("Location: index.php");
