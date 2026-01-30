<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <meta charset="UTF-8">
    <title>Sistema RRHH</title>

    <!-- CSS PRINCIPAL -->
    <link rel="stylesheet" href="/rrhh/assets/css/sistema.css">
</head>
<body>

<div class="header">
    <h1>Sistema RRHH</h1>

    <div class="user">
        <?php echo $_SESSION['usuario'] ?? 'Usuario'; ?>
    </div>
</div>

<div class="container">
