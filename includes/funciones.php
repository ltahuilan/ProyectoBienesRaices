<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', 'funciones.php');
define('DIR_IMAGENES', '../../upload_img/');

function incluirTemplates (string $template, bool $inicio = false, bool $admin = false) {

    include TEMPLATES_URL . "/${template}.php";

};

function autenticado () {

    session_start();
    $auth = true;
    if (!$_SESSION['login']) {
        header('location: /');
        $auth = false;
    }

    return $auth ;
}

function debuguear ($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit;
}

function sanitizarHTML ($html) : string {
    $string = htmlspecialchars($html);
    return $string;
}

function tipoContenido ($tipo) {
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
}

function mostrarNotificacion ($codigo) {

    $mensaje = '';

    switch ($codigo) {
        case 1: 
            $mensaje = 'Registro creado correctamente';
        break;

        case 2:
            $mensaje = 'Registro actualizado correctamente';
        break;

        case 3:
            $mensaje = 'Registro eliminado correctamente';
        break;

        default:
            $mensaje = false;
    }

    return $mensaje;
}