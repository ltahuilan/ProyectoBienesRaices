<?php

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image; //Uso de la clase ImagenManager y asignar alias 'Imagen' para implementación ágil

require '../../includes/app.php';

   autenticado();

    //validar id de propiedad
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /admin');
    }


    //consulta para obtener los registros de propiedades
    
    $propiedad = Propiedad::getById($id);

    //consulta para obtener los registros de vendedores
    $queryVendedores = mysqli_query($db, "SELECT * FROM vendedores");

    $errores = Propiedad::getErrores();   
    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {

        $args = [];
        /**Asignar los atributos
         * estructura definida en atributo name="" de etiquetas <input>
         * ayuda a evitar asignar de forma individual*/         
        // isset($_POST['titulo']) ? $args['titulo'] = $_POST['titulo'] : NULL;
        $args = $_POST['propiedad'];
        
        /**Acceso al método sincronizar() se pasa el arreglo como argumento*/
        $propiedad->sincronizar($args);
        
        $errores = $propiedad->validarAtributos();            
            
        if(empty($errores)) {

            /****** ----GENERAR ARCHIVOS----- ******/             
            
            //Verifica que exista una nueva imagen en el directorio temporal
            if ( $_FILES['propiedad']['tmp_name']['imagen'] ) {

                /**Si existe una nueva imagen realizar procedimiento */
                
                //generar nombre unico para la imagen
                $nombreImg = md5(uniqid(rand(), true) ) . $_FILES['propiedad']['name']['imagen'];
                
                //Realizar un resize a la archivo de imagen con intervention/image
                $imagen = Image::make( $_FILES['propiedad']['tmp_name']['imagen'] )->fit(800, 600);

                //pasar nombre de la imagen al metodo de la clase
                $propiedad->setImagen($nombreImg);

                /**Almacenar archivos */
                $imagen->save(DIR_IMAGENES . $nombreImg);

            }

            $propiedad->editar();

        }
    }

    // include '../../includes/templates/header.php'; 
    incluirTemplates('header', $inicio = false, $admin = true);
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Propiedad</h1>

        <?php 
        /**inyectar HTML */
        foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>
        <?php endforeach; ?>

        <a href="../index.php" class="boton boton-verde">Regresar</a>

        <form
        class="formulario" method="POST"        
        enctype="multipart/form-data">
        <!--enctype="multipart/form-data" atributo que permite leer archivos, info visible desde superglobal $_FILES-->

            <?php include '../../includes/templates/formulario_propiedades.php'?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>

    </main>

<!--footer desde template php-->
<?php
    
    incluirTemplates('footer');
?>