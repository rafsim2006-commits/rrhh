<?php
require_once "../config/auth.php";
require_once "../config/solo_admin.php";
include "../config/conexion.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$direcciones = $conexion->query("SELECT id, nombre FROM direcciones ORDER BY nombre");
$cargos = $conexion->query("SELECT id, nombre FROM cargos ORDER BY nombre");
?>

<div class="content">
    <h2>Nuevo Empleado</h2>

    <div class="contenedor-formulario">
        <form action="guardar.php" method="POST" class="formulario">

            <div class="fila">
                <div class="grupo">
                    <label>Cédula</label>
                    <input type="text" name="cedula" required>
                </div>

                <div class="grupo">
                    <label>Nombre</label>
                    <input type="text" name="nombre" required>
                </div>

                <div class="grupo">
                    <label>Apellido</label>
                    <input type="text" name="apellido" required>
                </div>
            </div>

            <div class="fila">
                <div class="grupo">
                    <label>Tipo</label>
                    <select name="tipo" required>
                        <option value="">Seleccione</option>
                        <option value="OBRERO">Obrero</option>
                        <option value="EMPLEADO">Empleado</option>
                        <option value="CONTRATADO">Contratado</option>
                    </select>
                </div>

                <div class="grupo">
                    <label>Dirección</label>
                    <select name="direccion_id" required>
                        <option value="">Seleccione</option>
                        <?php while ($d = $direcciones->fetch_assoc()) { ?>
                            <option value="<?php echo $d['id']; ?>">
                                <?php echo $d['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="grupo">
                    <label>Cargo</label>
                    <select name="cargo_id" required>
                        <option value="">Seleccione</option>
                        <?php while ($c = $cargos->fetch_assoc()) { ?>
                            <option value="<?php echo $c['id']; ?>">
                                <?php echo $c['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="fila">
                <div class="grupo">
                    <label>Sueldo</label>
                    <input type="number" step="0.01" name="sueldo" required>
                </div>

                <div class="grupo">
                    <label>Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" required>
                </div>

                <div class="grupo">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="ACTIVO">Activo</option>
                        <option value="REPOSO">Reposo</option>
                        <option value="VACACIONES">Vacaciones</option>
                        <option value="RETIRADO">Retirado</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn">Guardar Empleado</button>
            <a href="index.php" class="btn btn-secundario">Cancelar</a>

        </form>
    </div>
</div>

<?php include "../layout/footer.php"; ?>
