<?php
if($_SESSION['rol'] !== 'ADMIN'){
    header("Location: /rrhh/index.php");
    exit;
}
