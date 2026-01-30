<?php
require_once "../config/auth.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

/* PAGINACIÓN */
$limite = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

/* FILTROS */
$direccion_id = $_GET['direccion_id'] ?? '';
$cargo_id     = $_GET['cargo_id'] ?? '';
$status       = $_GET['status'] ?? '';
$desde        = $_GET['desde'] ?? '';
$hasta        = $_GET['hasta'] ?? '';

$hayFiltro = false;
$where = "WHERE 1=1";

if ($direccion_id !== '') {
    $where .= " AND e.direccion_id = $direccion_id";
    $hayFiltro = true;
}
if ($cargo_id !== '') {
    $where .= " AND e.cargo_id = $cargo_id";
    $hayFiltro = true;
}
if ($status !== '') {
    $where .= " AND e.status = '$status'";
    $hayFiltro = true;
}
if ($desde !== '') {
    $where .= " AND e.fecha_ingreso >= '$desde'";
    $hayFiltro = true;
}
if ($hasta !== '') {
    $where .= " AND e.fecha_ingreso <= '$hasta'";
    $hayFiltro = true;
}

/* DATA SOLO SI HAY FILTROS */
$empleados = null;
$totalPaginas = 0;

if ($hayFiltro) {

    /* TOTAL */
    $totalSql = "SELECT COUNT(*) total FROM empleados e $where";
    $total = $conexion->query($totalSql)->fetch_assoc()['total'];
    $totalPaginas = ceil($total / $limite);

    /* CONSULTA */
    $sql = "
        SELECT 
            e.cedula,
            e.nombre,
            e.apellido,
            e.tipo,
            e.sueldo,
            e.fecha_ingreso,
            e.status,
            d.nombre AS direccion,
            c.nombre AS cargo
        FROM empleados e
        INNER JOIN direcciones d ON e.direccion_id = d.id
        INNER JOIN cargos c ON e.cargo_id = c.id
        $where
        ORDER BY e.apellido
        LIMIT $inicio, $limite
    ";

    $empleados = $conexion->query($sql);
}

/* COMBOS */
$direcciones = $conexion->query("SELECT id, nombre FROM direcciones ORDER BY nombre");
$cargos = $conexion->query("SELECT id, nombre FROM cargos ORDER BY nombre");
?>

<div class="content">

<div class="encabezado-modulo">
    <h2>Reporte de Empleados</h2>

    <?php if ($hayFiltro): ?>
        <a class="btn" href="empleados_pdf.php?<?= http_build_query($_GET) ?>">
            Imprimir PDF
        </a>
    <?php endif; ?>
</div>

<br><br>

<!-- FILTROS -->
<form method="GET" class="formulario">

    <div class="fila">
        <div class="grupo">
            <label>Dirección</label>
            <select name="direccion_id">
                <option value="">Todas</option>
                <?php while ($d = $direcciones->fetch_assoc()) { ?>
                    <option value="<?= $d['id'] ?>" <?= $direccion_id==$d['id']?'selected':'' ?>>
                        <?= $d['nombre'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="grupo">
            <label>Cargo</label>
            <select name="cargo_id">
                <option value="">Todos</option>
                <?php while ($c = $cargos->fetch_assoc()) { ?>
                    <option value="<?= $c['id'] ?>" <?= $cargo_id==$c['id']?'selected':'' ?>>
                        <?= $c['nombre'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="grupo">
            <label>Status</label>
            <select name="status">
                <option value="">Todos</option>
                <option value="ACTIVO" <?= $status=="ACTIVO"?'selected':'' ?>>Activo</option>
                <option value="REPOSO" <?= $status=="REPOSO"?'selected':'' ?>>Reposo</option>
                <option value="VACACIONES" <?= $status=="VACACIONES"?'selected':'' ?>>Vacaciones</option>
                <option value="RETIRADO" <?= $status=="RETIRADO"?'selected':'' ?>>Retirado</option>
            </select>
        </div>
    </div>

    <div class="fila">
        <div class="grupo">
            <label>Desde</label>
            <input type="date" name="desde" value="<?= $desde ?>">
        </div>

        <div class="grupo">
            <label>Hasta</label>
            <input type="date" name="hasta" value="<?= $hasta ?>">
        </div>
    </div>

    <button class="btn">Filtrar</button>
    <a href="empleados.php" class="btn btn-secundario">Limpiar</a>
</form>

<?php if ($hayFiltro): ?>

<table class="tabla">
<thead>
<tr>
    <th>Cédula</th>
    <th>Nombre</th>
    <th>Tipo</th>
    <th>Cargo</th>
    <th>Dirección</th>
    <th>Sueldo</th>
    <th>Fecha Ingreso</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
<?php while ($e = $empleados->fetch_assoc()): ?>
<tr>
    <td><?= $e['cedula'] ?></td>
    <td><?= $e['nombre'].' '.$e['apellido'] ?></td>
    <td><?= $e['tipo'] ?></td>
    <td><?= $e['cargo'] ?></td>
    <td><?= $e['direccion'] ?></td>
    <td><?= number_format($e['sueldo'],2) ?></td>
    <td><?= date("d/m/Y", strtotime($e['fecha_ingreso'])) ?></td>
   <td>
  <span class="status <?= $e['status'] ?>">
      <?= $e['status'] ?>
  </span>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- PAGINACIÓN -->
<div style="margin-top:15px;">
<?php if ($pagina > 1): ?>
<a class="btn btn-secundario"
   href="?<?= http_build_query(array_merge($_GET,['pagina'=>$pagina-1])) ?>">
   Anterior
</a>
<?php endif; ?>

<?php if ($pagina < $totalPaginas): ?>
<a class="btn btn-secundario"
   href="?<?= http_build_query(array_merge($_GET,['pagina'=>$pagina+1])) ?>">
   Siguiente
</a>
<?php endif; ?>
</div>

<?php endif; ?>

</div>

<?php include "../layout/footer.php"; ?>
