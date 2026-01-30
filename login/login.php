<?php
session_start();
require_once "../config/conexion.php";

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = $_POST['clave'] ?? '';

    if ($usuario === '' || $clave === '') {
        $error = "Debe ingresar usuario y contraseña";
    } else {

        $sql = $conexion->prepare(
            "SELECT * FROM usuarios 
             WHERE usuario = ? AND status = 'ACTIVO'"
        );
        $sql->bind_param("s", $usuario);
        $sql->execute();
        $res = $sql->get_result();

        if ($res->num_rows === 1) {

            $datos = $res->fetch_assoc();

            // ✅ VALIDAR CLAVE CORRECTAMENTE
            if (password_verify($clave, $datos['clave'])) {

                $_SESSION['usuario_id'] = $datos['id'];
                $_SESSION['usuario']    = $datos['usuario'];
                $_SESSION['rol']        = $datos['rol'];

                header("Location: ../index.php");
                exit;

            } else {
                $error = "Usuario o clave incorrecta";
            }

        } else {
            $error = "Usuario o clave incorrecta";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema RRHH</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>

<div class="login-box">

    <img src="../assets/img/logo_alcaldia.png" alt="Alcaldía de Guarenas">

    <h2>Sistema de Gestión Humana</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>

</div>

</body>
</html>
