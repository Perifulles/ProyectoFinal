<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'autoloader.php';

// Establece la variable de sesión para desplazarse a #tablaCierre al volver
$_SESSION['scroll_to'] = 'tablaCierre';

$Manager = new Model();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoge los datos del formulario
    $idCliente = $_POST['id_cliente'] ?? 999;
    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $comentario = $_POST['comentario'] ?? '';
    $comentario_interno = $_POST['comentario_interno'] ?? '';
    $importe = $_POST['importe'] ?? 0;
    $visa = $_POST['visa'] ?? 0;
    $efectivo = $_POST['efectivo'] ?? 0;
    $idReserva = $idCliente;
    $origen = "CIERRE";

    try {

        // Inserta los datos en la tabla `reserva` vinculados al cliente
        $Manager->crearCliente($idCliente, $nombre, $apellido1, $apellido2, $telefono, $email);
        $Manager->crearReserva( $idCliente, $idReserva, $origen, $comentario, $comentario_interno, $importe, $visa, $efectivo);

        // Redirige de vuelta a la página de cierre con un mensaje de éxito
        $_SESSION['mensaje_exito'] = 'Reserva creada exitosamente.';
        header("Location: cierre.php?desde=modificar");
        exit;
    } catch (Exception $e) {
        $error = "Error al crear la reserva: " . $e->getMessage();
    }
} else {
    // Si no se envió el formulario, redirige a nueva_reserva.php
    header("Location: nueva_reserva.php");
    exit;
}
?>