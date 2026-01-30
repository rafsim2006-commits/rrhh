<?php
session_start();
include "../config/conexion.php";

if(!isset($_SESSION['empleado_id'])){
    header("Location: index.php");
    exit;
}
?>

<div class="contenido">

<h2>Bienvenido <?= $_SESSION['empleado_nombre'] ?></h2>

<a href="guardar.php" class="btn">
Solicitar Constancia de Trabajo
</a>

<br><br>

<a href="estado.php" class="btn btn-secundario">
Ver estado de mis solicitudes
</a>

</div>
