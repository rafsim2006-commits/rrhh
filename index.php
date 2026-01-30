<?php
include "config/conexion.php";
include "layout/header.php";
include "layout/sidebar.php";

/* EMPLEADOS */
$totalEmpleados = $conexion->query("
    SELECT COUNT(*) total 
    FROM empleados
")->fetch_assoc()['total'];

$activos = $conexion->query("
    SELECT COUNT(*) total 
    FROM empleados 
    WHERE status = 'ACTIVO'
")->fetch_assoc()['total'];

$reposo = $conexion->query("
    SELECT COUNT(*) total 
    FROM empleados 
    WHERE status = 'REPOSO'
")->fetch_assoc()['total'];

$vacaciones = $conexion->query("
    SELECT COUNT(*) total 
    FROM empleados 
    WHERE status = 'VACACIONES'
")->fetch_assoc()['total'];

$retirados = $conexion->query("
    SELECT COUNT(*) total 
    FROM empleados 
    WHERE status = 'RETIRADO'
")->fetch_assoc()['total'];

/* SOLICITUDES DE CONSTANCIA */
$solicitudesPendientes = $conexion->query("
    SELECT COUNT(*) total 
    FROM solicitudes 
    WHERE status = 'PENDIENTE'
")->fetch_assoc()['total'];
?>



<div class="content">
    <h2>Dashboard</h2>

    <div class="cards">

        <div class="card">
            <h3>Total Empleados</h3>
            <p><?php echo $totalEmpleados; ?></p>
        </div>

        <div class="card">
            <h3>Activos</h3>
            <p><?php echo $activos; ?></p>
        </div>

        <div class="card">
            <h3>Reposo</h3>
            <p><?php echo $reposo; ?></p>
        </div>

        <div class="card">
            <h3>Vacaciones</h3>
            <p><?php echo $vacaciones; ?></p>
        </div>

        <div class="card">
            <h3>Retirados</h3>
            <p><?php echo $retirados; ?></p>
        </div>

        <div class="card">
            <h3>Solicitudes de Constancia</h3>
            <p><?php echo $solicitudesPendientes; ?> pendientes</p>
            <a href="/rrhh/constancias/solicitudes.php">Ver solicitudes</a>
        </div>

    </div>
</div>

<audio id="sonidoAlerta" preload="auto">
    <source src="/rrhh/assets/sounds/alerta.mp3" type="audio/mpeg">
</audio>

<script>
let audioDesbloqueado = false;
const audio = document.getElementById('sonidoAlerta');

function desbloquearAudio() {
    if (!audioDesbloqueado) {
        audio.play().then(() => {
            audio.pause();
            audio.currentTime = 0;
            audioDesbloqueado = true;
            console.log('🔊 Audio desbloqueado');
        }).catch(() => {});
    }
}

// cualquier interacción sirve
document.addEventListener('click', desbloquearAudio);
document.addEventListener('keydown', desbloquearAudio);
</script>
<script>
let ultimoId = null;

function revisarSolicitudes(){
    fetch('/rrhh/ajax/solicitudes_count.php')
        .then(res => res.text())
        .then(id => {
            id = parseInt(id);

            // Primera carga: guardar referencia
            if (ultimoId === null) {
                ultimoId = id;
                return;
            }

            // Si aparece una nueva solicitud (INCLUSO LA PRIMERA)
            if (id > ultimoId) {
                document.getElementById('sonidoAlerta').play();
                alert('📢 Nueva solicitud de constancia recibida');

                ultimoId = id;
                location.reload();
            }
        });
}

// primera consulta inmediata
revisarSolicitudes();

// luego cada 10 segundos
setInterval(revisarSolicitudes, 10000);
</script>





<?php include "layout/footer.php"; ?>
