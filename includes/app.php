<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__.'../../vendor/autoload.php';

use App\ActiveRecord;


//almacenando la conexión en una variable
$db = conectaDB();

//instancir o crear objeto de la clase 
$propiedad = new ActiveRecord;


/**Pasamos el parámetro de la conexion a la clase
 * por medio del método stDB 
 */
$propiedad::setDB($db);