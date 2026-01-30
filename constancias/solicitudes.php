<?php
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

/* -------------------------
   FILTROS Y PAGINACIÓN
--------------------------*/
$limite = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$inicio = ($pagina - 1) * $limite;

$statusFiltro = $_GET['status'] ?? '';

$where = "WHERE 1=1";
if ($statusFiltro == 'PENDIENTE' || $statusFiltro == 'ENTREGADA') {
    $where .= " AND s.status = '$statusFiltro'";
}

/* -------------------------
   MARCAR COMO ENTREGADA
--------------------------*/
if (isset($_GET['entregar'])) {
    $id = (int)$_GET['entregar'];

    $conexion->query("
        UPDATE solicitudes 
        SET status='ENTREGADA', entregado_at=NOW()
        WHERE id=$id
    ");

    header("Location: solicitudes.php");
    exit;
}

/* -------------------------
   TOTAL PARA PAGINACIÓN
--------------------------*/
$total = $conexion->query("
    SELECT COUNT(*) total
    FROM solicitudes s
    INNER JOIN empleados e ON s.empleado_id = e.id
    $where
")->fetch_assoc()['total'];

$paginas = ceil($total / $limite);

/* -------------------------
   CONSULTA PRINCIPAL
--------------------------*/
$solicitudes = $conexion->query("
    SELECT s.*, 
           CONCAT(e.nombre,' ',e.apellido) empleado,
           e.cedula
    FROM solicitudes s
    INNER JOIN empleados e ON s.empleado_id = e.id
    $where
    ORDER BY s.created_at DESC
    LIMIT $inicio,$limite
");
?>

<div class="contenido">

<h2>Solicitudes de Constancias</h2>

<form method="GET" style="margin-bottom:15px">
    <select name="status">
        <option value="">-- Todas --</option>
        <option value="PENDIENTE" <?= $statusFiltro=='PENDIENTE'?'selected':'' ?>>Pendientes</option>
        <option value="ENTREGADA" <?= $statusFiltro=='ENTREGADA'?'selected':'' ?>>Entregadas</option>
    </select>
    <button class="btn">Filtrar</button>
</form>

<div class="tabla-responsive">
<table class="tabla">
<tr>
    <th>Fecha</th>
    <th>Cédula</th>
    <th>Empleado</th>
    <th>Status</th>
    <th>Acciones</th>
</tr>

<?php while($s = $solicitudes->fetch_assoc()): ?>
<tr>
    <td><?= date('d/m/Y', strtotime($s['created_at'])) ?></td>
    <td><?= $s['cedula'] ?></td>
    <td><?= $s['empleado'] ?></td>
    <td>
        <span class="status <?= $s['status']=='PENDIENTE'?'VACACIONES':'ACTIVO' ?>">
            <?= $s['status'] ?>
        </span>
    </td>
    <td>
        <a class="btn btn-secundario" href="../constancias/ver.php?id=<?= $s['id'] ?>">Ver</a>
        <a class="btn" href="../constancias/pdf.php?id=<?= $s['id'] ?>">PDF</a>

        <?php if($s['status']=='PENDIENTE'): ?>
            <a class="btn btn-success" href="?entregar=<?= $s['id'] ?>">Entregar</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>

<!-- PAGINACIÓN -->
<div style="margin-top:15px">
<?php for($i=1;$i<=$paginas;$i++): ?>
    <a class="btn <?= $i==$pagina?'btn-secundario':'' ?>" href="?pagina=<?= $i ?>&status=<?= $statusFiltro ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>
</div>

</div>

<?php include "../layout/footer.php"; ?>
