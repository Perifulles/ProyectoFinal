<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require 'autoloader.php'; // Asegúrate que la clase Model está incluida aquí

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// --- INICIO DE LÓGICA UNIFICADA ---

// Instanciar el Manager al principio, ya que se usa en varias partes
$Manager = new Model(); // Asumiendo que tu clase se llama Model

// Definición de campos y campos por defecto
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

// Inicializar variables para determinar qué mostrar y qué campos usar
$mostrarResultados = false;
$camposSeleccionados = $porDefecto; // Valor inicial por defecto

// --- Manejo de Acciones (POST/GET) y determinación de $camposSeleccionados ---

// 1. Manejar acción 'restaurar' primero si existe (es una acción separada)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'restaurar') {
    try {
        $Manager->restoreBackup();
        // Guardar mensaje para mostrar después del HTML si es necesario, o usar JS como antes
        $_SESSION['mensaje_backup'] = 'Backup del cierre restaurado correctamente';
        $_SESSION['mostrar_cierre_post_restore'] = true;
    } catch (Exception $e) {
        $_SESSION['mensaje_backup'] = 'Error al restaurar el backup: ' . $e->getMessage();
    }
    // Redirigir para evitar reenvío del formulario al recargar (Patrón Post-Redirect-Get)
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// 2. Determinar $camposSeleccionados y manejar otras acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion === 'reiniciar') {
        $Manager->init(); // Llama a la inicialización del Manager
        unset($_SESSION['campos_cierre']); // Elimina la preferencia guardada
        $camposSeleccionados = $porDefecto; // Usa los campos por defecto para esta petición
        $mostrarResultados = true; // Muestra los resultados después de reiniciar
    } elseif ($accion === 'mostrar') {
        $camposSeleccionados = $_POST['campos'] ?? $porDefecto; // Toma los campos del form o usa defecto
        $_SESSION['campos_cierre'] = $camposSeleccionados; // Guarda la selección en la sesión
        $mostrarResultados = true; // Muestra los resultados
    }
    // Nota: Si hubiera otras acciones POST que no sean 'restaurar', se manejarían aquí.
    // Si no es 'reiniciar' ni 'mostrar', podría cargar desde sesión o usar defecto.
    // Pero como solo hay 'reiniciar' y 'mostrar' que afecten $camposSeleccionados directamente,
    // no necesitamos un 'else' complejo aquí para determinar $camposSeleccionados.
    // Si la acción POST no fue reconocida explícitamente aquí, $camposSeleccionados
    // se determinará por la lógica GET/Sesión más abajo.

}
// 3. Manejar caso GET 'modificar'
elseif (isset($_GET['desde']) && $_GET['desde'] === 'modificar') {
    $camposSeleccionados = $porDefecto; // Forzar campos por defecto
    $_SESSION['campos_cierre'] = $camposSeleccionados; // Guardar este estado por si acaso
    $mostrarResultados = true; // Muestra los resultados en modo modificar
}
// 4. Caso por defecto (GET normal, carga inicial o POST sin acción reconocida arriba)
else {
    // Carga los campos desde la sesión si existen, si no, usa los por defecto
    $camposSeleccionados = $_SESSION['campos_cierre'] ?? $porDefecto;
    // No se establece $mostrarResultados = true aquí, solo se muestran al cargar si hay acción previa
}

// Si viene de restaurar backup, mostrar cierre automáticamente
if (isset($_SESSION['mostrar_cierre_post_restore']) && $_SESSION['mostrar_cierre_post_restore'] === true) {
    $mostrarResultados = true;
    unset($_SESSION['mostrar_cierre_post_restore']); // Limpia la bandera
}


// --- FIN DE LÓGICA UNIFICADA ---

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cierre de Reservas</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>

<?php
// Mostrar mensajes (ej. del backup) si existen y luego limpiarlos
if (isset($_SESSION['mensaje_backup'])) {
    echo "<script>alert('" . addslashes($_SESSION['mensaje_backup']) . "');</script>";
    unset($_SESSION['mensaje_backup']);
}
?>

<button onclick="toggleCampos()" type="button" class="boton-anadir-pasante">🎛️ Mostrar/Ocultar Campos</button>

<div id="camposContainer" style="margin-top: 20px;">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="margin-bottom: 20px;">
        <fieldset>
            <legend style="font-weight: bold; font-size:x-large">Selecciona los campos que deseas mostrar en el cierre:</legend>
            <button type="button" onclick="seleccionarTodos()" class="botonform"><b>Seleccionar Todos</b></button>
            <button type="button" onclick="deseleccionarTodos()" class="botonform" style="width:250px;"><b>No seleccionar ninguno</b></button>
            <div class="checkbox-group">
                <?php
                // Usar $camposSeleccionados determinado en la lógica unificada para marcar checkboxes
                foreach ($campos as $etiqueta => $campoBD) {
                    // Comprobar si el campo actual debe estar marcado
                    $checked = in_array($campoBD, $camposSeleccionados) ? 'checked' : '';
                    echo "<label style='display: inline-block; min-width: 160px; font-size: 1.1em; margin: 5px 5px;'>
                            <input type='checkbox' name='campos[]' value='$campoBD' $checked> " . htmlspecialchars($etiqueta) . "
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
        const container = document.getElementById('totalesBox'); // Asegúrate que el div de totales tenga id="totalesBox"
        if (container) {
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
        }
    }
</script>

<?php
// --- SECCIÓN PARA MOSTRAR RESULTADOS ---
// Mostrar la sección de totales y cierre si la bandera $mostrarResultados es true
if ($mostrarResultados) {
    echo '<button onclick="toggleTotales()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">🧮 Mostrar/Ocular Totales</button>';

    // Muestra los totales (asumiendo que showTotales() genera el HTML necesario, incluyendo el div con id="totalesBox")
    $Manager->showTotales();

    // Muestra la tabla de cierre con los campos seleccionados apropiados
    // $camposSeleccionados ya tiene el valor correcto según la acción realizada (o sesión/default)
    $Manager->showCierre($camposSeleccionados);
}
// --- FIN SECCIÓN PARA MOSTRAR RESULTADOS ---
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
    <a href="../index.php">
        <button class="boton-anadir-pasante" style="background-color: #0066cc;">🏠 Volver al Inicio</button>
    </a>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return confirm('¿Estás seguro de que quieres restaurar el backup del cierre?')">
        <button type="submit" name="accion" value="restaurar" class="boton-anadir-pasante" style="background-color: #ff595e;">♻️ Restaurar Backup</button>
    </form>
</div>

</body>
</html>