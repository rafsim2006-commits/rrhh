<?php
$conexion = new mysqli("localhost", "root", "", "rrhh_cartas");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}



?>
