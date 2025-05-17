<?php
session_start(); // Asegúrate de iniciar la sesión al principio del archivo
require_once __DIR__ . '/vendor/autoload.php';
require 'autoloader.php';


?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Modificar Reserva</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 0;
            overflow: auto;
        }

        .formulario-edicion {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        .formulario-edicion h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .formulario-edicion label {
            display: block;
            margin-bottom: 8px;
            margin-top: 10px;
            font-weight: bold;
            color: #555;
        }

        .formulario-edicion input[type="text"],
        .formulario-edicion input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .formulario-edicion input[type="text"]:focus,
        .formulario-edicion input[type="email"]:focus {
            border-color: #0066cc;
            outline: none;
        }

        .formulario-edicion input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .formulario-edicion input[type="submit"]:hover {
            background-color: #004c99;
        }

        .boton-anadir-pasante {
            position: fixed;
            top: 1px;
            left: 20px;
            padding: 12px 20px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            z-index: 1000;
        }

        .boton-anadir-pasante:hover {
            background-color: #004c99;
        }
    </style>
</head>
<body>
    <form method="POST" action="crear_reserva.php" class="formulario-edicion">
        <h2>Crear reserva<?= htmlspecialchars($id ?? '') ?></h2>
        <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($id ?? '') ?>">

        <label>ID Cliente:</label>
        <input type="text" name="id_cliente" value="<?= htmlspecialchars($cliente['id_cliente'] ?? rand(1,60000)) ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($cliente['nombre'] ?? '') ?>">

        <label>Apellido 1:</label>
        <input type="text" name="apellido1" value="<?= htmlspecialchars($cliente['apellido1'] ?? '') ?>">

        <label>Apellido 2:</label>
        <input type="text" name="apellido2" value="<?= htmlspecialchars($cliente['apellido2'] ?? '') ?>">

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($cliente['telefono'] ?? '') ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email'] ?? '') ?>">

        <label>Comentario:</label>
        <input type="text" name="comentario" value="<?= htmlspecialchars($reserva['comentario'] ?? '') ?>">

        <label>Comentario interno:</label>
        <input type="text" name="comentario_interno" value="<?= htmlspecialchars($reserva['comentario_interno'] ?? '') ?>">

        <label>Importe:</label>
        <input type="text" name="importe" value="<?= htmlspecialchars($reserva['importe'] ?? '') ?>">

        <label>Visa:</label>
        <input type="text" name="visa" value="<?= htmlspecialchars($reserva['visa'] ?? 0) ?>">

        <label>Efectivo:</label>
        <input type="text" name="efectivo" value="<?= htmlspecialchars($reserva['efectivo'] ?? 0) ?>">

        <input type="submit" value="Guardar Cambios">
    </form>

    <a href="cierre.php?desde=modificar" class="boton-anadir-pasante">🔙 Volver</a>
</body>
</html>