<div class="sidebar">

    <!-- DASHBOARD -->
    <a href="/rrhh/index.php">🏠 Dashboard</a>

    <!-- MÓDULOS ADMINISTRATIVOS -->
<?php if ($_SESSION['rol'] === 'ADMIN'): ?>
    <a href="/rrhh/empleados/index.php">👥 Empleados</a>
    <a href="/rrhh/direcciones/index.php">🏢 Direcciones</a>
    <a href="/rrhh/cargos/index.php">💼 Cargos</a>
     <a href="/rrhh/usuarios/index.php">👤 Usuarios</a>
<?php endif; ?>

<li><a href="/rrhh/vacaciones/index.php">Vacaciones</a></li>
<li><a href="/rrhh/reposos/index.php">Reposos</a></li>

<!-- REPORTES -->
<a href="/rrhh/reportes/empleados.php">📊 Reportes</a>

    <!-- CONSTANCIAS (SOLO ADMIN / RRHH) -->
    <hr>
    <strong style="padding:10px; display:block; font-size:12px;">GESTIÓN HUMANA</strong>

    <a href="/rrhh/constancias/emitir.php">🖨 Emitir Constancia</a>
    <a href="/rrhh/constancias/solicitudes.php">📥 Solicitudes de Constancia</a>

    <!-- SALIR -->
    <hr>
    <a href="/rrhh/login/logout.php">🚪 Cerrar sesión</a>

</div>
