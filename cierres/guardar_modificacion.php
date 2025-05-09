<?php
require_once __DIR__ . '/vendor/autoload.php';
require 'autoloader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_reserva']);

    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $importe = $_POST['importe'] ?? '';
    $visa = floatval($_POST['visa'] ?? 0);
    $efectivo = floatval($_POST['efectivo'] ?? 0);

    $Manager = new Model();

    // Actualiza la tabla clientes
    $Manager->actualizarCliente($id, $nombre, $apellido1, $apellido2, $telefono, $email);

    // Actualiza la tabla reservas
    $Manager->actualizarReserva($id, $importe, $visa, $efectivo);

    // Redirige de nuevo a la lista
    header("Location: cierre.php?desde=modificar");
    exit;

} else {
    echo "Acceso no permitido.";
}
