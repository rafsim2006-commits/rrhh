<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
require_once "../config/conexion.php";

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$rol = $_POST['rol'];
$status = $_POST['status'];

$sql = $conexion->prepare("
    UPDATE usuarios 
    SET nombre=?, usuario=?, rol=?, status=?
    WHERE id=?
");
$sql->bind_param("sssii", $nombre, $usuario, $rol, $status, $id);
$sql->execute();

header("Location: index.php");
