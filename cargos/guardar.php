<?php
include "../config/conexion.php";

$nombre = strtoupper(trim($_POST['nombre']));

if($nombre == ''){
    header("Location: crear.php");
    exit;
}

$conexion->query("INSERT INTO cargos (nombre) VALUES ('$nombre')");

header("Location: index.php");
