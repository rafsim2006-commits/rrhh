<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: /rrhh/login.php");
    exit;
}
