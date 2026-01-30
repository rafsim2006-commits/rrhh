<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

/* PAGINACIÓN */
$por_pagina = 10;
$pagina = $_GET['pagina'] ?? 1;
$inicio = ($pagina - 1) * $por_pagina;

/* TOTAL */
$total = $conexion->query("SELECT COUNT(*) total FROM empleados")->fetch_assoc()['total'];
$paginas = ceil($total / $por_pagina);

/* LISTADO */
$empleados = $conexion->query("
SELECT e.*, d.nombre direccion, c.nombre cargo
FROM empleados e
LEFT JOIN direcciones d ON e.direccion_id=d.id
LEFT JOIN cargos c ON e.cargo_id=c.id
ORDER BY e.id DESC
LIMIT $inicio, $por_pagina
");
?>

<div class="contenido">

<div class="encabezado-modulo">
    <h2>Empleados</h2>
    <a href="crear.php" class="btn">Nuevo Empleado</a>
</div>

<table class="tabla">
<tr>
    <th>Cédula</th>
    <th>Nombre</th>
    <th>Dirección</th>
    <th>Cargo</th>
    <th>Status</th>
    <th>Acciones</th>
</tr>

<?php while($e=$empleados->fetch_assoc()): ?>
<tr>
    <td><?= $e['cedula'] ?></td>
    <td><?= $e['nombre'].' '.$e['apellido'] ?></td>
    <td><?= $e['direccion'] ?></td>
    <td><?= $e['cargo'] ?></td>
    <td>
        <span class="status <?= $e['status'] ?>">
            <?= $e['status'] ?>
        </span>
    </td>
    <td>
        <a class="btn btn-secundario" href="editar.php?id=<?= $e['id'] ?>">Editar</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<!-- PAGINACIÓN -->
<div class="paginacion">
<?php for($i=1;$i<=$paginas;$i++): ?>
    <a class="<?= $i==$pagina?'activo':'' ?>"
       href="?pagina=<?= $i ?>">
       <?= $i ?>
    </a>
<?php endfor; ?>
</div>

</div>

<?php include "../layout/footer.php"; ?>
