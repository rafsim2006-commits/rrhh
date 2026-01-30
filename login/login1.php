<?php
session_start();
include "../config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['usuario'] ?? '';
    $clave   = $_POST['clave'] ?? '';

    $clave = md5($clave);

    $sql = $conexion->prepare(
        "SELECT * FROM usuarios 
         WHERE usuario=? AND clave=? AND status='ACTIVO'"
    );
    $sql->bind_param("ss", $usuario, $clave);
    $sql->execute();
    $res = $sql->get_result();

    if ($res->num_rows > 0) {
        $datos = $res->fetch_assoc();
        $_SESSION['usuario'] = $datos['usuario'];
        $_SESSION['rol'] = $datos['rol'];
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Usuario o clave incorrecta";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema RRHH</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>

<div class="login-box">

    <img src="../assets/img/logo_alcaldia.png" alt="Alcaldía de Guarenas">

    <h2>Sistema de Gestión Humana</h2>

    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>

</div>

</body>
</html>
