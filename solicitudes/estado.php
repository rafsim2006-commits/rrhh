<?php
require_once "../config/conexion.php";

$cedula = trim($_POST['cedula'] ?? '');

if ($cedula == '') {
    header("Location: index.php");
    exit;
}

$sql = $conexion->prepare("
    SELECT id, nombre, apellido, status
    FROM empleados
    WHERE cedula = ?
");

if(!$sql){
    die("Error en la consulta: ".$conexion->error);
}

$sql->bind_param("s", $cedula);

$sql->execute();
$empleado = $sql->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Estado de Solicitud</title>
    <link rel="stylesheet" href="../assets/css/sistema.css">

    <style>
        body{
            background:#f4f6f9;
            font-family: Arial;
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
            padding:30px;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,.15);
            text-align:center;
        }
        .logo img{
            max-width:150px;
            margin-bottom:15px;
        }
        .ok{color:green;font-weight:bold;}
        .error{color:red;font-weight:bold;}
        .warning{color:#e67e22;font-weight:bold;}
        a.btn{
            display:inline-block;
            margin-top:15px;
            padding:10px 20px;
            background:#007bff;
            color:#fff;
            border-radius:5px;
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="contenedor">
<div class="card">

<div class="logo">
    <img src="../assets/img/logo_alcaldia.png">
</div>

<?php if (!$empleado): ?>
    <p class="error">❌ Cédula no registrada en el sistema</p>
    <a href="index.php" class="btn">Volver</a>

<?php elseif ($empleado['status'] == 'RETIRADO'): ?>
    <p class="error">❌ No puede solicitar constancia</p>
    <p>El trabajador se encuentra retirado</p>
    <a href="index.php" class="btn">Volver</a>

<?php else: ?>

    <h3><?= $empleado['nombre']." ".$empleado['apellido'] ?></h3>

    <?php
    $q = $conexion->prepare("
        SELECT id FROM solicitudes 
        WHERE empleado_id = ? AND status = 'PENDIENTE'
    ");
    $q->bind_param("i", $empleado['id']);
    $q->execute();
    $pendiente = $q->get_result()->num_rows;
    ?>

    <?php if ($pendiente > 0): ?>
        <p class="warning">⏳ Ya tiene una constancia pendiente por entregar</p>
        <a href="index.php" class="btn">Volver</a>
    <?php else: ?>
        <p class="ok">✅ Puede realizar la solicitud</p>
        <form action="solicitar.php" method="POST">
            <input type="hidden" name="empleado_id" value="<?= $empleado['id'] ?>">
            <button class="btn">Solicitar Constancia</button>
        </form>
    <?php endif; ?>

<?php endif; ?>

</div>
</div>
</body>
</html>
