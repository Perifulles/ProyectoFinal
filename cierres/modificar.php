<?php
require_once __DIR__ . '/vendor/autoload.php';
require 'autoloader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_reserva'])) {
    $id = intval($_POST['id_reserva']);
    $Manager = new Model();
    $reserva = $Manager->getReservaPorId($id);
    $cliente = $Manager->getClientePorId($id);

    if (!$reserva) {
        echo "<p>Error: No se encontró la reserva.</p>";
        exit;
    }
} else {
    echo "<p>Error: No se ha proporcionado un ID de reserva válido.</p>";
    exit;
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Modificar Reserva</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .formulario-edicion {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
        }

        .formulario-edicion h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .formulario-edicion label {
            display: block;
            margin-bottom: 8px;
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
        position: fixed; /* Fija el botón en la pantalla */
        top: 1px; /* Posición desde la parte superior */
        left: 20px; /* Posición desde la izquierda */
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
        z-index: 1000; /* Asegura que esté por encima de otros elementos */
    }

        .boton-anadir-pasante:hover {
            background-color: #004c99;
        }
    </style>
</head>
<body>
    <form method="POST" action="guardar_modificacion.php" class="formulario-edicion">
        <h2>Modificar Reserva #<?= htmlspecialchars($id ?? '') ?></h2>
        <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($id ?? '') ?>">

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

        <label>Importe:</label>
        <input type="text" name="importe" value="<?= htmlspecialchars($reserva['importe'] ?? '') ?>">

        <label>Visa:</label>
        <input type="text" name="visa" value="<?= htmlspecialchars($reserva['visa'] ?? '') ?>">

        <label>Efectivo:</label>
        <input type="text" name="efectivo" value="<?= htmlspecialchars($reserva['efectivo'] ?? '') ?>">

        <input type="submit" value="Guardar Cambios">
    </form>

    <a href="cierre.php" class="boton-anadir-pasante">🔙 Volver</a>
</body>
</html>
