<?php
include "../config/conexion.php";

$ultimo = $conexion->query("
    SELECT IFNULL(MAX(id),0) ultimo
    FROM solicitudes
    WHERE status='PENDIENTE'
")->fetch_assoc()['ultimo'];

echo $ultimo;
