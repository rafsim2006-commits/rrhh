<?php
include "../config/conexion.php";

$cedula = $_GET['cedula'];

$empleado = $conexion->query("
SELECT id, CONCAT(nombre,' ',apellido) nombre, status
FROM empleados
WHERE cedula='$cedula'
")->fetch_assoc();

if(!$empleado){
    echo json_encode(['error'=>'Empleado no encontrado']);
    exit;
}

if($empleado['status']=='RETIRADO'){
    echo json_encode(['error'=>'Empleado retirado']);
    exit;
}

if($empleado['status']=='VACACIONES'){
    echo json_encode(['error'=>'Empleado está en vacaciones']);
    exit;
}

echo json_encode([
    'id' => $empleado['id'],
    'nombre' => $empleado['nombre']
]);
