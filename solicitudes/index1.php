<?php
include "../config/conexion.php";

if($_POST){
    $cedula = $_POST['cedula'];

    $emp = $conexion->query("
    SELECT id,nombre,apellido,status
    FROM empleados
    WHERE cedula='$cedula'
    ")->fetch_assoc();

    if(!$emp){
        echo "<script>alert('Empleado no encontrado');</script>";
    }elseif($emp['status']=='RETIRADO'){
        echo "<script>alert('Empleado retirado');</script>";
    }else{
        session_start();
        $_SESSION['empleado_id'] = $emp['id'];
        $_SESSION['empleado_nombre'] = $emp['nombre'].' '.$emp['apellido'];
        header("Location: solicitar.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/css/sistema.css">
</head>
<body>

<div class="login-empleado">
<h3>Solicitud de Constancia</h3>

<form method="POST">
<input type="text" name="cedula" placeholder="Ingrese su cédula" required>
<button class="btn">Ingresar</button>
</form>
</div>

</body>
</html>
