<?php
require "../libs/tcpdf/tcpdf.php";
include "../config/conexion.php";

$id = $_GET['id'] ?? 0;

$sql = "
SELECT 
    e.cedula,
    e.nombre,
    e.apellido,
    e.sueldo,
    e.fecha_ingreso,
    c.nombre AS cargo,
    d.nombre AS direccion
FROM solicitudes_constancia s
INNER JOIN empleados e ON s.empleado_id = e.id
INNER JOIN cargos c ON e.cargo_id = c.id
INNER JOIN direcciones d ON e.direccion_id = d.id
WHERE s.id = $id
LIMIT 1
";

$emp = $conexion->query($sql)->fetch_assoc();

/* ===========================
   CONFIGURACIÓN PDF
   =========================== */
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

/* QUITAR HEADER Y FOOTER TCPDF */
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

/* MÁRGENES */
$pdf->SetMargins(25, 25, 25);
$pdf->AddPage();

/* LOGO (USA JPG SIN TRANSPARENCIA) */
$pdf->Image('../assets/img/logo.jpg', 85, 15, 40);
$pdf->Ln(35);

/* ENCABEZADO */
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 8, 'ALCALDÍA DEL MUNICIPIO AMBROSIO PLAZA', 0, 1, 'C');
$pdf->Cell(0, 8, 'DIRECCIÓN DE GESTIÓN HUMANA', 0, 1, 'C');

$pdf->Ln(10);

/* TÍTULO */
$pdf->Cell(0, 8, 'CONSTANCIA DE TRABAJO', 0, 1, 'C');
$pdf->Ln(10);

/* CONTENIDO JUSTIFICADO (HTML CONTROLADO) */
$pdf->SetFont('helvetica', '', 11);

$html = '
<style>
p {
    text-align: justify;
    line-height: 1.6;
}
</style>

<p>
Quien suscribe, la Dirección de Gestión Humana de la Alcaldía del Municipio Ambrosio Plaza,
hace constar que el(la) ciudadano(a)
<strong>'.$emp['nombre'].' '.$emp['apellido'].'</strong>,
titular de la cédula de identidad
<strong>V-'.$emp['cedula'].'</strong>,
presta sus servicios desempeñando el cargo de
<strong>'.$emp['cargo'].'</strong>,
adscrito(a) a la
<strong>'.$emp['direccion'].'</strong>,
desde el
<strong>'.date("d/m/Y", strtotime($emp['fecha_ingreso'])).'</strong>,
devengando un sueldo mensual de
<strong>Bs. '.number_format($emp['sueldo'],2).'</strong>.
</p>

<p>
Constancia que se expide a solicitud de la parte interesada.
</p>
';

$pdf->writeHTML($html, true, false, true, false, '');

/* FIRMA */
$pdf->Ln(20);
$pdf->Cell(0, 8, '_______________________________', 0, 1, 'C');
$pdf->Cell(0, 8, 'DIRECCIÓN DE GESTIÓN HUMANA', 0, 1, 'C');

$pdf->Output('constancia_trabajo.pdf', 'I');
