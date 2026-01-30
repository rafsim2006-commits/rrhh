<?php
include "../config/conexion.php";

$error = "";
$exito = "";

if (isset($_POST['cedula'])) {

    $cedula = trim($_POST['cedula']);

    $sql = "
        SELECT 
            e.id,
            e.cedula,
            e.nombre,
            e.apellido,
            e.status
        FROM empleados e
        WHERE e.cedula = '$cedula'
        LIMIT 1
    ";

    $res = $conexion->query($sql);

    if ($res->num_rows == 0) {

        $error = "La cédula no se encuentra registrada.";

    } else {

        $empleado = $res->fetch_assoc();

        if ($empleado['status'] == 'RETIRADO') {

            $error = "El trabajador se encuentra retirado y no puede solicitar constancia.";

        } else {

            /* VALIDAR SI YA TIENE SOLICITUD PENDIENTE */
            $valida = $conexion->query("
                SELECT id FROM solicitudes_constancia 
                WHERE empleado_id = {$empleado['id']} 
                AND status = 'PENDIENTE'
            ");

            if ($valida->num_rows > 0) {

                $error = "Ya existe una solicitud pendiente para esta cédula.";

            } else {

                /* GUARDAR SOLICITUD */
                $conexion->query("
                    INSERT INTO solicitudes_constancia 
                    (empleado_id, fecha_solicitud)
                    VALUES ({$empleado['id']}, CURDATE())
                ");

                $exito = "Solicitud exitosa. Puede pasar por la Dirección de Gestión Humana en dos días a retirar.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Constancia</title>
    <link rel="stylesheet" href="/rrhh/assets/css/sistema.css">
</head>
<body>

<div class="content" style="max-width:500px;margin:auto;">
    <div style="text-align:center; margin-bottom:20px;">
    <img src="/rrhh/assets/img/logo_alcaldia.png" height="90">
</div>

<h2 style="text-align:center;">Solicitud de Constancia de Trabajo</h2>
    <form method="POST" class="formulario">

        <div class="grupo">
            <label>Nro. de Cédula</label>
            <input type="text" name="cedula" required>
        </div>

        <button class="btn">Solicitar</button>

    </form>

    <?php if ($error) { ?>
        <p style="color:red;margin-top:15px;"><?php echo $error; ?></p>
    <?php } ?>

    <?php if ($exito) { ?>
        <p style="color:green;margin-top:15px;"><?php echo $exito; ?></p>
    <?php } ?>

</div>

</body>
</html>
