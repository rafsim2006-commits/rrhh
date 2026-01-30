<?php
session_start();
include "../config/conexion.php";

$empleado = $_SESSION['empleado_id'];

/* VALIDAR SOLICITUD PENDIENTE */
$pendiente = $conexion->query("
SELECT id FROM solicitudes
WHERE empleado_id=$empleado
AND status='PENDIENTE'
")->num_rows;

if($pendiente){
    echo "<script>
        alert('Ya tiene una solicitud pendiente');
        history.back();
    </script>";
    exit;
}

/* GUARDAR */
$conexion->query("
INSERT INTO solicitudes (empleado_id)
VALUES ($empleado)
");

echo "<script>
alert('Solicitud exitosa. Puede pasar por la Dirección de Gestión Humana en dos días a retirar.');
location.href='estado.php';
</script>";
