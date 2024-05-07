<?php
$modulo_buscador = limpiar_cadeda($_POST['modulo_buscador']);

$modulos = ["usuario", "categoria", "producto"];

if (in_array($modulo_buscador, $modulos)) {
} else {
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No podemos procesar la petición
        </div>';
}
