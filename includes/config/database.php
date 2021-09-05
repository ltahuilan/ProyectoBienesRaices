<?php 

/**Conexion a la base de datos
 * se utiliza exit para que en caso de la conexion tenga error
 */

function conectaDB () : mysqli {
    $db = mysqli_connect('localhost', 'root', 'root', 'bienes_raices');

    if(!$db) {
        echo 'conexion incorrecta';
        exit;
    }

    return $db;
};