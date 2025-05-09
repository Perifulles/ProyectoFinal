<?php
session_start();
require_once 'autoloader.php';

$Manager = new Model();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_reserva'])) {
    $id = $_POST['id_reserva'];
    try {
        $Manager->eliminarReserva($id);
        $Manager->eliminarCliente($id);
        // Redirige de vuelta a cierre con el parámetro 'desde=modificar' para mostrar todo
        header("Location: cierre.php?desde=modificar");
        exit;
    } catch (Exception $e) {
        echo "Error al eliminar la reserva: " . $e->getMessage();
    }
} else {
    header("Location: cierre.php");
    exit;
}

