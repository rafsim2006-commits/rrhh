<?php
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$empleado = null;
$error = "";

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

        /* VALIDAR RETIRADO */
        if ($empleado['status'] == 'RETIRADO') {

            $error = "El trabajador se encuentra retirado.";
            $empleado = null;

        } else {

            /* VALIDAR SOLICITUD PENDIENTE */
            $pendiente = $conexion->query("
                SELECT id 
                FROM solicitudes 
                WHERE empleado_id = {$empleado['id']} 
                AND status = 'PENDIENTE'
            ");

            if ($pendiente->num_rows > 0) {

                $error = "Existe una constancia pendiente por entregar.";
                $empleado = null;

            } else {

                /* GUARDAR CONSTANCIA EMITIDA */
               $conexion->query("
    INSERT INTO solicitudes 
    (empleado_id, status, origen, entregado_at)
    VALUES ({$empleado['id']}, 'ENTREGADA', 'ADMIN', NOW())
");
            }
        }
    }
}
?>

<div class="content">
    <h2>Emitir Constancia de Trabajo</h2>

    <form method="POST" class="formulario">
        <div class="grupo">
            <label>Nro. de Cédula</label>
            <input type="text" name="cedula" required>
        </div>
        <button class="btn">Emitir</button>
    </form>

    <?php if ($error) { ?>
        <p style="color:red; margin-top:20px;"><?php echo $error; ?></p>
    <?php } ?>

    <?php if ($empleado) { ?>
    <div style="background:#fff; padding:40px; margin-top:30px; box-shadow:0 8px 20px rgba(0,0,0,0.1);">

        <div style="text-align:center;">
            <img src="/rrhh/assets/img/logo_alcaldia.png" height="90"><br><br>
            <strong>ALCALDÍA DEL MUNICIPIO AMBROSIO PLAZA</strong><br>
            <strong>DIRECCIÓN DE GESTIÓN HUMANA</strong>
        </div>

        <br><br>

        <p style="text-align:center; font-weight:bold;">
            CONSTANCIA DE TRABAJO
        </p>

        <br>

        <p style="text-align:justify;">
            Quien suscribe, la Dirección de Gestión Humana de la Alcaldía del Municipio
            Ambrosio Plaza, hace constar que el(la) ciudadano(a)
            <strong><?php echo $empleado['nombre']." ".$empleado['apellido']; ?></strong>,
            titular de la cédula de identidad <strong>V-<?php echo $empleado['cedula']; ?></strong>,
            presta sus servicios en esta institución desempeñando el cargo de
            <strong><?php echo $empleado['cargo']; ?></strong>, adscrito(a) a la
            <strong><?php echo $empleado['direccion']; ?></strong>, desde el
            <strong><?php echo date("d/m/Y", strtotime($empleado['fecha_ingreso'])); ?></strong>,
            devengando un sueldo mensual de
            <strong>Bs. <?php echo number_format($empleado['sueldo'],2); ?></strong>.
        </p>

        <br>

        <p style="text-align:justify;">
            Constancia que se expide a solicitud de la parte interesada.
        </p>

        <br><br>

        <p style="text-align:center;">
            _______________________________<br>
            <strong>DIRECCIÓN DE GESTIÓN HUMANA</strong>
        </p>

    </div>
    <?php } ?>
</div>

<?php include "../layout/footer.php"; ?>
