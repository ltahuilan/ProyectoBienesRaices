<?php

define('TEMPLATES_URL', __DIR__.'/templates');
define('FUNCIONES_URL', 'funciones.php');
define('DIR_IMAGENES', '../../upload_img/');

function incluirTemplates (string $template, bool $inicio = false, bool $admin = false) {

    include TEMPLATES_URL . "/${template}.php";

};

function autenticado () {

    session_start();
    
    if (!$_SESSION['login']) {
        header('location: /');
    }
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
