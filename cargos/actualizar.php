<?php
include "../config/conexion.php";

$id = $_POST['id'];
$nombre = strtoupper($_POST['nombre']);

$conexion->query("
UPDATE cargos SET nombre='$nombre' WHERE id=$id
");

header("Location: index.php");
