<?php
// solicitudes/index.php
require_once "../config/auth.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Solicitud de Constancia</title>
    <link rel="stylesheet" href="../assets/css/sistema.css">

    <style>
        body{
            background:#f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
        }

        .contenedor{
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-solicitud{
            background:#fff;
            width: 100%;
            max-width: 450px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: center;
        }

        .logo{
            margin-bottom: 15px;
        }

        .logo img{
            max-width: 160px;
            height: auto;
        }

        h2{
            margin-bottom: 10px;
            color:#333;
        }

        p{
            margin-bottom: 15px;
            color:#555;
        }

        input[type="text"]{
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border:1px solid #ccc;
            font-size: 16px;
        }

        button{
            width: 100%;
            padding: 10px;
            background:#007bff;
            color:#fff;
            border:none;
            border-radius: 5px;
            font-size: 16px;
            cursor:pointer;
        }

        button:hover{
            background:#0056b3;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <div class="card-solicitud">

        <!-- LOGO SOLO AQUÍ -->
        <div class="logo">
            <img src="../assets/img/logo_alcaldia.png" alt="Alcaldía">
        </div>

        <h2>Solicitud de Constancia</h2>
        <p>Ingrese su cédula para continuar</p>

        <form action="estado.php" method="POST">
            <input type="text" name="cedula" placeholder="Ej: 12345678" required>
            <button type="submit">Ingresar</button>
        </form>

    </div>
</div>

</body>
</html>
