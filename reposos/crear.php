<?php
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="contenido">

<h2>Registrar Reposo</h2>

<form action="guardar.php" method="POST" class="formulario">

<div class="grid-form">

<div>
<label>Cédula del Empleado</label>
<input type="text" id="cedula" placeholder="Ej: 12345678">
<button type="button" class="btn btn-secundario" onclick="buscarEmpleado()">
Buscar
</button>
</div>

<div>
<label>Nombre y Apellido</label>
<input type="text" id="nombre" readonly>
<input type="hidden" name="empleado_id" id="empleado_id">
</div>

<div>
<label>Fecha Inicio</label>
<input type="date" name="fecha_inicio" required>
</div>

<div>
<label>Fecha Fin</label>
<input type="date" name="fecha_fin" required>
</div>

<div>
<label>Observación</label>
<input type="text" name="observacion">
</div>

</div>

<div class="acciones-form">
<button class="btn">Guardar Reposo</button>
<a href="index.php" class="btn btn-secundario">Cancelar</a>
</div>

</form>

</div>

<script>
function buscarEmpleado(){
    let cedula = document.getElementById('cedula').value;

    if(cedula === ''){
        alert('Ingrese la cédula');
        return;
    }

    fetch('buscar_empleado.php?cedula=' + cedula)
    .then(res => res.json())
    .then(data => {
        if(data.error){
            alert(data.error);
            document.getElementById('nombre').value = '';
            document.getElementById('empleado_id').value = '';
        }else{
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('empleado_id').value = data.id;
        }
    });
}
</script>

<?php include "../layout/footer.php"; ?>
