<?php

require 'vendor/autoload.php';

function autocargador($clase) {
    $archivo = 'classes/' . $clase . '.php';
    if (file_exists($archivo)) {
        require_once $archivo;
    } else {
        // Opcional: mostrar advertencia o lanzar una excepción
        trigger_error("No se pudo cargar la clase $clase ($archivo)", E_USER_WARNING);
    }
}

spl_autoload_register('autocargador');

?>