<?php
include "../config/conexion.php";

$id = $_GET['id'];

$conexion->query("UPDATE empleados SET status='RETIRADO' WHERE id=$id");

header("Location: index.php");
