<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol = $_SESSION['rol'] ?? '';
?>

<div class="sidebar">

    <!-- DASHBOARD -->
    <a href="/rrhh/index.php">🏠 Dashboard</a>

    <!-- MÓDULOS ADMINISTRATIVOS (SOLO ADMIN) -->
    <?php if ($rol === 'ADMIN'): ?>
        <a href="/rrhh/empleados/index.php">👥 Empleados</a>
        <a href="/rrhh/direcciones/index.php">🏢 Direcciones</a>
        <a href="/rrhh/cargos/index.php">💼 Cargos</a>
        <a href="/rrhh/usuarios/index.php">👤 Usuarios</a>
    <?php endif; ?>

    <!-- MÓDULOS GENERALES -->
    <a href="/rrhh/vacaciones/index.php">🏖 Vacaciones</a>
    <a href="/rrhh/reposos/index.php">🩺 Reposos</a>

    <!-- CONSTANCIAS (ADMIN Y USUARIO) -->
    <hr>
    <strong style="padding:10px; display:block; font-size:12px;">
        CONSTANCIAS
    </strong>

    <a href="/rrhh/constancias/emitir.php">🖨 Emitir Constancia</a>
    <a href="/rrhh/constancias/solicitudes.php">📥 Solicitudes de Constancia</a>

    <!-- REPORTES -->
    <hr>
    <a href="/rrhh/reportes/empleados.php">📊 Reportes</a>

    <!-- SALIR -->
    <hr>
    <a href="/rrhh/login/logout.php">🚪 Cerrar sesión</a>

</div>
