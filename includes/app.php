<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__.'../../vendor/autoload.php';

use App\Propiedad;


//almacenando la conexión en una variable
$db = conectaDB();

//instanciando la clase Propiedad
$propiedad = new Propiedad;


/**Pasamos el parámetro de la conexion a la clase
 * por medio del método stDB 
 */
$propiedad::setDB($db);