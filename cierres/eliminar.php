<?php
session_start();
require_once 'autoloader.php';

$Manager = new Model();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_reserva'])) {
    $id = $_POST['id_reserva'];
    try {
        $Manager->eliminarReserva($id);
        $Manager->eliminarCliente($id);
        // Establece una variable de sesión para indicar que se debe desplazar a #tablaCierre
        $_SESSION['scroll_to'] = 'tablaCierre';
        // Redirige de vuelta a cierre con el parámetro 'desde=modificar'
        header("Location: ./cierre.php?desde=modificar");
        exit;
    } catch (Exception $e) {
        echo "Error al eliminar la reserva: " . $e->getMessage();
    }
} else {
    // Redirige de vuelta a cierre si no se proporciona un ID válido
    header("Location: ./cierre.php?desde=modificar");
    exit;
}

