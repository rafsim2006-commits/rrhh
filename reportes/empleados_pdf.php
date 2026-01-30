<?php
require "../libs/tcpdf/tcpdf.php";
include "../config/conexion.php";

/* FILTROS */
$direccion_id = $_GET['direccion_id'] ?? '';
$cargo_id     = $_GET['cargo_id'] ?? '';
$status       = $_GET['status'] ?? '';

$where = "WHERE 1=1";

if($direccion_id != ''){
    $where .= " AND e.direccion_id = $direccion_id";
}
if($cargo_id != ''){
    $where .= " AND e.cargo_id = $cargo_id";
}
if($status != ''){
    $where .= " AND e.status = '$status'";
}

$pdf = new TCPDF('L','mm','A4',true,'UTF-8',false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

/* LOGO */
$pdf->Image('../assets/img/logo.jpg', 15, 10, 30);

/* ENCABEZADO */
$pdf->SetFont('helvetica','B',12);
$pdf->Cell(0,8,'ALCALDÍA DEL MUNICIPIO AMBROSIO PLAZA',0,1,'C');
$pdf->Cell(0,8,'DIRECCIÓN DE GESTIÓN HUMANA',0,1,'C');

$pdf->Ln(10);

$pdf->SetFont('helvetica','B',9);
$pdf->Cell(0,10,'REPORTE DE EMPLEADOS',0,1,'C');
$pdf->Ln(5);

$html = '
<table border="1" cellpadding="4">
<tr style="font-weight:bold;">
    <th>CÉDULA</th>
    <th>NOMBRE</th>
    <th>CARGO</th>
    <th>DIRECCIÓN</th>
    <th>FECHA INGRESO</th>
    <th>SUELDO</th>
    <th>STATUS</th>
</tr>
';

$sql = "
SELECT e.cedula,
       CONCAT(e.nombre,' ',e.apellido) AS nombre,
       c.nombre AS cargo,
       d.nombre AS direccion,
       e.fecha_ingreso,
       e.sueldo,
       e.status
FROM empleados e
INNER JOIN cargos c ON e.cargo_id = c.id
INNER JOIN direcciones d ON e.direccion_id = d.id
$where
ORDER BY e.nombre
";

$res = $conexion->query($sql);

while($r = $res->fetch_assoc()){
    $html .= "
    <tr>
        <td>{$r['cedula']}</td>
        <td>{$r['nombre']}</td>
        <td>{$r['cargo']}</td>
        <td>{$r['direccion']}</td>
        <td>".date('d/m/Y',strtotime($r['fecha_ingreso']))."</td>
        <td>".number_format($r['sueldo'],2)."</td>
        <td>{$r['status']}</td>
    </tr>
    ";
}

$html .= '</table>';

$pdf->writeHTML($html,true,false,true,false,'');
$pdf->Output('reporte_empleados.pdf','I');
