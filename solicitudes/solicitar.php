<?php
require_once "../config/conexion.php";

$empleado_id = intval($_POST['empleado_id'] ?? 0);

if ($empleado_id <= 0) {
    header("Location: index.php");
    exit;
}

/* Guardar solicitud */
$insert = $conexion->prepare("
    INSERT INTO solicitudes (empleado_id, status, origen)
    VALUES (?, 'PENDIENTE', 'EMPLEADO')
");

if(!$insert){
    die("Error al guardar la solicitud: ".$conexion->error);
}

$insert->bind_param("i", $empleado_id);
$insert->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Solicitud Exitosa</title>
    <link rel="stylesheet" href="../assets/css/sistema.css">

    <style>
        body{
            background:#f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
        }
        .contenedor{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .card{
            background:#fff;
            max-width:500px;
            width:100%;
            padding:35px;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,.15);
            text-align:center;
        }
        .logo img{
            max-width:150px;
            margin-bottom:20px;
        }
        .titulo{
            color:#2c3e50;
            margin-bottom:10px;
        }
        .mensaje{
            font-size:16px;
            color:#555;
            margin-bottom:20px;
            line-height:1.5;
        }
        .ok{
            color:#27ae60;
            font-weight:bold;
            font-size:18px;
            margin-bottom:15px;
        }
        .btn{
            display:inline-block;
            padding:10px 25px;
            background:#007bff;
            color:#fff;
            border-radius:5px;
            text-decoration:none;
            font-size:16px;
        }
        .btn:hover{
            background:#0056b3;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <div class="card">

        <div class="logo">
            <img src="../assets/img/logo_alcaldia.png" alt="Alcaldía">
        </div>

        <h2 class="titulo">Solicitud de Constancia</h2>

        <p class="ok">✅ Solicitud exitosa</p>

        <p class="mensaje">
            Su solicitud ha sido registrada correctamente.<br><br>
            Puede pasar por la <strong>Dirección de Gestión Humana</strong>
            en un lapso de <strong>dos (2) días hábiles</strong> para retirar
            su constancia de trabajo.
        </p>

        <a href="index.php" class="btn">Finalizar</a>

    </div>
</div>

</body>
</html>
