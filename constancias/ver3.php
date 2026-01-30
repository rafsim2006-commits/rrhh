<?php
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$id = (int)($_GET['id'] ?? 0);

$sql = "
SELECT 
    e.cedula,
    e.nombre,
    e.apellido,
    e.sueldo,
    e.fecha_ingreso,
    c.nombre AS cargo,
    d.nombre AS direccion
FROM solicitudes s
INNER JOIN empleados e ON s.empleado_id = e.id
LEFT JOIN cargos c ON e.cargo_id = c.id
LEFT JOIN direcciones d ON e.direccion_id = d.id
WHERE s.id=$id
LIMIT 1
";

$emp = $conexion->query($sql)->fetch_assoc();

if(!$emp){
    die('Solicitud no encontrada');
}
?>

<div class="contenido">
<div style="background:#fff;padding:40px;box-shadow:0 8px 20px rgba(0,0,0,.1)">

<div style="text-align:center">
<img src="/rrhh/assets/img/logo_alcaldia.png" height="90"><br><br>
<strong>ALCALDÍA DEL MUNICIPIO AMBROSIO PLAZA</strong><br>
<strong>DIRECCIÓN DE GESTIÓN HUMANA</strong>
</div>

<br>
<p style="text-align:center;font-weight:bold">CONSTANCIA DE TRABAJO</p>

<p style="text-align:justify">
Quien suscribe, la Dirección de Gestión Humana, hace constar que el(la) ciudadano(a)
<strong><?= $emp['nombre'].' '.$emp['apellido'] ?></strong>,
titular de la cédula <strong>V-<?= $emp['cedula'] ?></strong>,
presta servicios como <strong><?= $emp['cargo'] ?></strong>,
adscrito(a) a <strong><?= $emp['direccion'] ?></strong>,
desde <strong><?= date('d/m/Y',strtotime($emp['fecha_ingreso'])) ?></strong>,
devengando un sueldo mensual de <strong>Bs. <?= number_format($emp['sueldo'],2,',','.') ?></strong>.
</p>

<br>
<p style="text-align:center">
Constancia que se expide a solicitud de la parte interesada.
</p>

<br><br>
<p style="text-align:right">
<strong>Dirección de Gestión Humana</strong>
</p>

</div>
</div>

<?php include "../layout/footer.php"; ?>
