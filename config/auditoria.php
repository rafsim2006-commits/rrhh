<?php
function registrarAuditoria($conexion, $accion, $modulo, $registro_id = null) {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario_id'])) {
        return;
    }

    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conexion->prepare("
        INSERT INTO auditoria (usuario_id, accion, modulo, registro_id)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("issi", $usuario_id, $accion, $modulo, $registro_id);
    $stmt->execute();
}
