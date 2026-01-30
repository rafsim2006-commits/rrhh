<?php
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$empleado = null;
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
            e.sueldo,
            e.fecha_ingreso,
            e.status,
            c.nombre AS cargo,
            d.nombre AS direccion
        FROM empleados e
        INNER JOIN cargos c ON e.cargo_id = c.id
        INNER JOIN direcciones d ON e.direccion_id = d.id
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
            $empleado = null;
        } else {

            /* VALIDAR SOLICITUD PENDIENTE */
            $validar = $conexion->query("
                SELECT id FROM solicitudes 
                WHERE empleado_id = {$empleado['id']} 
                AND status = 'PENDIENTE'
            ");

            if ($validar->num_rows > 0) {
                $error = "Ya existe una solicitud pendiente para este trabajador.";
                $empleado = null;
            } else {

                /* GUARDAR SOLICITUD */
                $conexion->query("
                    INSERT INTO solicitudes
                    (empleado_id, fecha_solicitud) 
                    VALUES ({$empleado['id']}, CURDATE())
                ");

                $exito = "Solicitud exitosa. Puede pasar por la Dirección de Gestión Humana en dos días a retirar.";
            }
        }
    }
}
?>

<div class="content">
    <h2>Solicitud de Constancia de Trabajo</h2>

    <form method="POST" class="formulario">
        <div class="grupo">
            <label>Nro. de Cédula</label>
            <input type="text" name="cedula" required>
        </div>
        <button class="btn">Solicitar</button>
    </form>

    <?php if ($error) { ?>
        <p style="color:red; margin-top:20px;"><?php echo $error; ?></p>
    <?php } ?>

    <?php if ($exito) { ?>
        <p style="color:green; margin-top:20px;"><?php echo $exito; ?></p>
    <?php } ?>

    <?php if ($empleado) { ?>
    <div style="background:#fff; padding:40px; margin-top:30px;">
        <div style="text-align:center;">
            <img src="/rrhh/assets/img/logo_alcaldia.png" height="90"><br><br>
            <strong>ALCALDÍA DEL MUNICIPIO AMBROSIO PLAZA</strong><br>
            <strong>DIRECCIÓN DE GESTIÓN HUMANA</strong>
        </div>

        <br>

        <p style="text-align:justify;">
            El ciudadano(a) <strong><?php echo $empleado['nombre']." ".$empleado['apellido']; ?></strong>,
            titular de la cédula <strong>V-<?php echo $empleado['cedula']; ?></strong>,
            desempeña el cargo de <strong><?php echo $empleado['cargo']; ?></strong>,
            adscrito(a) a la <strong><?php echo $empleado['direccion']; ?></strong>,
            desde el <strong><?php echo date("d/m/Y", strtotime($empleado['fecha_ingreso'])); ?></strong>,
            devengando un sueldo mensual de <strong>Bs. <?php echo number_format($empleado['sueldo'],2); ?></strong>.
        </p>
    </div>
    <?php } ?>
</div>

<?php include "../layout/footer.php"; ?>
