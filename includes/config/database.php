<?php 

/**Conexion a la base de datos
 * se utiliza exit para que en caso de la conexion tenga error
 */

function conectaDB () : mysqli {
    $db = mysqli_connect('localhost', 'root', 'root', 'bienes_raices');
    mysqli_set_charset($db, "utf8");

    if(!$db) {
        echo 'conexion incorrecta';
        exit;
    }

    return $db;
};