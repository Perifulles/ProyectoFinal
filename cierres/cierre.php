<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require 'autoloader.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cierre de Reservas</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>

<button onclick="toggleCampos()" type="button" class="boton-anadir-pasante">🎛️ Mostrar/Ocultar Campos</button>

<div id="camposContainer" style="margin-top: 20px;">
    <form method="POST" style="margin-bottom: 20px;">
        <fieldset>
            <legend style="font-weight: bold; font-size:x-large">Selecciona los campos que deseas mostrar en el cierre:</legend>
            <button type="button" onclick="seleccionarTodos()" class="botonform"><b>Seleccionar Todos</b></button>
            <button type="button" onclick="deseleccionarTodos()" class="botonform" style="width:250px;"><b>No seleccionar ninguno</b></button>
            <div class="checkbox-group">
                <?php
                $campos = [
                    'ID Reserva' => 'id_reserva',
                    'Creación' => 'fecha_creacion',
                    'F. Entrada' => 'fecha_entrada',
                    'F. Actualizada' => 'fecha_actualizada',
                    'Origen' => 'origen',
                    'Usuario' => 'usuario',
                    'Anulada por' => 'anulada_por',
                    'Producto' => 'producto',
                    'Hora' => 'hora',
                    'Ocupación' => 'ocupacion',
                    'Nombre' => 'nombre',
                    'Apellido 1' => 'apellido1',
                    'Apellido 2' => 'apellido2',
                    'E-mail' => 'email',
                    'Teléfono' => 'telefono',
                    'Comentario' => 'comentario',
                    'ComentarioInt' => 'comentario_interno',
                    'Estado' => 'estado',
                    'Importe' => 'importe',
                    'Factura' => 'factura',
                    'Visa' => 'visa',
                    'Efectivo' => 'efectivo'
                ];

                $porDefecto = [
                    'id_reserva', 'producto', 'nombre', 'apellido1', 'apellido2',
                    'telefono', 'comentario', 'estado', 'importe', 'visa', 'efectivo'
                ];

                if (!isset($_POST['accion'])) {
                    $camposSeleccionados = $_SESSION['campos_cierre'] ?? $porDefecto;
                } else {
                    if ($_POST['accion'] !== 'reiniciar') {
                        $camposSeleccionados = $_POST['campos'] ?? $porDefecto;
                        $_SESSION['campos_cierre'] = $camposSeleccionados;
                    } else {
                        $camposSeleccionados = $porDefecto;
                        $_SESSION['campos_cierre'] = $camposSeleccionados;
                    }
                }

                foreach ($campos as $etiqueta => $campoBD) {
                    $checked = in_array($campoBD, $camposSeleccionados) ? 'checked' : '';
                    echo "<label style='display: inline-block; min-width: 160px; font-size: 1.1em; margin: 5px 5px;'>
                            <input type='checkbox' name='campos[]' value='$campoBD' $checked> $etiqueta
                        </label>";
                }
                ?>
            </div>
            <br>
            <button type="submit" name="accion" value="reiniciar" class="botonform"><b>Iniciar/Reiniciar ⚠️</b></button>
            <button type="submit" name="accion" value="mostrar" class="botonform"><b>Mostrar</b></button>
        </fieldset>
    </form>
</div>

<script>
    function seleccionarTodos() {
        document.querySelectorAll("input[type='checkbox'][name='campos[]']").forEach(cb => cb.checked = true);
    }

    function deseleccionarTodos() {
        document.querySelectorAll("input[type='checkbox'][name='campos[]']").forEach(cb => cb.checked = false);
    }

    function toggleCampos() {
        const container = document.getElementById('camposContainer');
        container.style.display = container.style.display === 'none' ? 'block' : 'none';
    }

    function toggleTotales() {
        const container = document.getElementById('totalesBox');
        container.style.display = container.style.display === 'none' ? 'block' : 'none';
    }
</script>

<?php
$Manager = new Model();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['accion'] === 'reiniciar') {
        unset($_SESSION['campos_cierre']);
        $Manager->init();
    }

    if (isset($_SESSION['campos_cierre'])) {
        $camposSeleccionados = $_SESSION['campos_cierre'];
    } else {
        $camposSeleccionados = $porDefecto;
    }

    echo '<button onclick="toggleTotales()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">🧮 Mostrar/Ocultar Totales</button>';
    $Manager->showTotales();
    

    $Manager->showCierre($camposSeleccionados);
} elseif (isset($_GET['desde']) && $_GET['desde'] === 'modificar') {
    // Mostrar cierre con todos los campos si se entra desde modificar
    $camposSeleccionados = array_values($campos); // Todos los campos
    $_SESSION['campos_cierre'] = $camposSeleccionados;

    echo '<button onclick="toggleTotales()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">🧮 Mostrar/Ocultar Totales</button>';
    $Manager->showTotales();
    $Manager->showCierre($camposSeleccionados);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'restaurar') {
    try {
        $Manager->restoreBackup();
        echo "<script>alert('Backup del cierre restaurado correctamente');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error al restaurar el backup: " . $e->getMessage() . "');</script>";
    }
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
    <a href="../index.php">
        <button class="boton-anadir-pasante" style="background-color: #0066cc;">🏠 Volver al Inicio</button>
    </a>
    <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que quieres restaurar el backup del cierre?')">
        <button type="submit" name="accion" value="restaurar" class="boton-anadir-pasante" style="background-color: #ff595e;">♻️ Restaurar Backup</button>
    </form>
</div>

</body>
</html>
