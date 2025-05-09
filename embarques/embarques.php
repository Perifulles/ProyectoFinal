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
    <title>Listado de Pasajeros</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>
<button onclick="toggleCampos()" type="button" class="boton-anadir-pasante">🎛️ Mostrar/Ocultar Campos</button>

<div id="camposContainer" style="margin-top: 20px;">
    <form method="POST" style="margin-bottom: 20px;">
        <fieldset>
            <legend style="font-weight: bold; font-size:x-large">Selecciona los campos que deseas mostrar:</legend>
            <button type="button" onclick="seleccionarTodos()" class=botonform><b>Seleccionar Todos</b></button>
            <button type="button" onclick="deseleccionarTodos()" class="botonform" style="width:250px;"><b>No seleccionar ninguno</b></button>
            <div class="checkbox-group">
                <?php
                $campos = [
                    'Id' => 'id',
                    'Creación' => 'creacion',
                    'F. Entrada' => 'f_entrada',
                    'F. Actualizada' => 'f_actualizada',
                    'Nº Noches' => 'n_noches',
                    'Origen' => 'origen',
                    'Usuario' => 'usuario',
                    'Anulada por' => 'anulada_por',
                    'Producto' => 'producto',
                    'Hora' => 'hora',
                    'Ocupación' => 'ocupacion',
                    'Nombre' => 'nombre',
                    'Apellido 1' => 'apellido_1',
                    'Apellido 2' => 'apellido_2',
                    'E-mail' => 'e_mail',
                    'Teléfono' => 'telefono',
                    'Comentario' => 'comentario',
                    'ComentarioInt' => 'comentario_interno',
                    'Estado' => 'estado',
                    'Importe' => 'importe',
                    'Factura' => 'factura',
                    'Adultos' => 'adultos',
                    'Niños' => 'ninos',
                    'Senior' => 'senior',
                    'Gratis' => 'gratis'
                ];

                $porDefecto = [
                    'id', 'producto', 'nombre', 'apellido_1',
                    'apellido_2', 'telefono', 'comentario', 'comentario_interno',
                    'estado', 'adultos', 'ninos', 'gratis'
                ];

                if (!isset($_POST['accion'])) {
                    if (isset($_SESSION['campos'])) {
                        $camposSeleccionados = $_SESSION['campos'];
                    } else {
                        $camposSeleccionados = $porDefecto;
                    }
                } else {
                    if ($_POST['accion'] !== 'reiniciar') {
                        $camposSeleccionados = isset($_POST['campos']) ? $_POST['campos'] : $porDefecto;
                        $_SESSION['campos'] = $camposSeleccionados;
                    } else {
                        $camposSeleccionados = $porDefecto;
                        $_SESSION['campos'] = $camposSeleccionados;
                    }
                }

                foreach ($campos as $etiqueta => $campoBD) {
                    $checked = in_array($campoBD, $camposSeleccionados) ? 'checked' : '';
                    echo "<label style='display: inline-block; min-width: 160px; font-size: 1.1em; margin: 5px, 5px;'>
                            <input type='checkbox' name='campos[]' value='$campoBD' $checked> $etiqueta
                        </label>";
                }
                ?>
            </div>
            <br>
            <button type="submit" name="accion" value="reiniciar" class="botonform"><b>Iniciar/Reiniciar ⚠️</b></button>
            <button type="submit" name="accion" value="nuevosCampos" class="botonform"><b>Mostrar</b></button>
        </fieldset>
    </form>
</div>

<script>
    function seleccionarTodos() {
        const checkboxes = document.querySelectorAll("input[type='checkbox'][name='campos[]']");
        checkboxes.forEach(cb => cb.checked = true);
    }

    function deseleccionarTodos() {
        const checkboxes = document.querySelectorAll("input[type='checkbox'][name='campos[]']");
        checkboxes.forEach(cb => cb.checked = false);
    }

    function toggleCampos() {
        const container = document.getElementById('camposContainer');
        container.style.display = (container.style.display === 'none') ? 'block' : 'none';
    }

    function toggleContarPersonas() {
        const container = document.getElementById('contarPersonasContainer');
        container.style.display = (container.style.display === 'none') ? 'block' : 'none';
    }
</script>

<div class="container-fluid">
    <?php
    function reiniciar() {
        $Manager = new Model();
        unset($_SESSION['campos']);
        $Manager->init();

        echo '<button onclick="toggleContarPersonas()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">👥 Mostrar/Ocultar Información del barco</button>';
        echo '<div id="contarPersonasContainer" style="display:none;">';
        $Manager->showContarPersonas();
        echo '</div>';

        $Manager->showAllPasajeros();
        $Manager->showBalance();
    }

    function nuevosCampos() {
        $Manager = new Model();

        echo '<button onclick="toggleContarPersonas()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">👥 Mostrar/Ocultar Información del barco</button>';
        echo '<div id="contarPersonasContainer" style="display:none;">';
        $Manager->showContarPersonas();
        echo '</div>';

        $Manager->showAllPasajeros();
        $Manager->showBalance();
    }

    $Manager = new Model();
    echo "<br><br><br>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Manager = new Model();

        if (isset($_POST['accion'])) {
            if ($_POST['accion'] === 'reiniciar') {
                reiniciar();
            } elseif ($_POST['accion'] === 'nuevosCampos') {
                nuevosCampos();
            }
        } elseif (isset($_POST['Checkid'])) {
            $Manager->checkPasageros();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'insertarPasante') {
        $Manager = new Model();
        $Manager->pasante();

        echo '<button onclick="toggleContarPersonas()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">👥 Mostrar/Ocultar Información del barco</button>';
        echo '<div id="contarPersonasContainer" style="display:none;">';
        $Manager->showContarPersonas();
        echo '</div>';

        $Manager->showAllPasajeros();
        $Manager->showBalance();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] === 'restaurar') {
        try {
            $Manager->restoreBackup();
            echo "<script>alert('Backup restaurado correctamente');</script>";

            echo '<button onclick="toggleContarPersonas()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">👥 Mostrar/Ocultar Información del barco</button>';
            echo '<div id="contarPersonasContainer" style="display:none;">';
            $Manager->showContarPersonas();
            echo '</div>';

            $Manager->showAllPasajeros();
            $Manager->showBalance();
        } catch (Exception $e) {
            echo "<script>alert('Error al restaurar el backup: " . $e->getMessage() . "');</script>";
        }
    }
    $lista = isset($_GET['lista']) ? intval($_GET['lista']) : 1;
    ?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="nuevo_pasante.php">
            <button class="boton-anadir-pasante">➕ Añadir Pasante</button>
        </a>
        <a href="../index.php">
            <button class="boton-anadir-pasante" style="background-color: #0066cc ;">🏠 Volver al Inicio</button>
        </a>
        <a href="?lista=<?= $lista ?>&accion=restaurar" onclick="return confirm('¿Estás seguro de que quieres restaurar el backup de esta lista?')">
            <button class="boton-anadir-pasante" style="background-color: #ff595e;">♻️ Restaurar Backup</button>
        </a>
    </div>
</div>
</body>
</html>
