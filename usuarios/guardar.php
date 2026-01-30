<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
require_once "../config/conexion.php";

$nombre  = trim($_POST['nombre']);
$usuario = trim($_POST['usuario']);
$clave   = $_POST['clave'];
$rol     = $_POST['rol'];

/* VALIDACIONES BÁSICAS */
if ($nombre == "" || $usuario == "" || $clave == "" || $rol == "") {
    die("Datos incompletos");
}

/* VERIFICAR SI EL USUARIO YA EXISTE */
$check = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ?");
$check->bind_param("s", $usuario);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    die("❌ El usuario ya existe");
}

/* CIFRAR CLAVE */
$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

/* INSERTAR USUARIO */
$sql = $conexion->prepare("
    INSERT INTO usuarios (nombre, usuario, clave, rol, status)
    VALUES (?, ?, ?, ?, 1)
");

$sql->bind_param("ssss", $nombre, $usuario, $clave_hash, $rol);

if ($sql->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Error al guardar usuario";
}
