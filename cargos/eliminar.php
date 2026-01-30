<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";

$id = $_GET['id'];

/* VALIDAR USO */
$uso = $conexion->query("
SELECT id FROM empleados WHERE cargo_id=$id
")->num_rows;

if($uso > 0){
    echo "<script>
        alert('No se puede eliminar. Cargo asignado a empleados.');
        history.back();
    </script>";
    exit;
}

$conexion->query("DELETE FROM cargos WHERE id=$id");

header("Location: index.php");
