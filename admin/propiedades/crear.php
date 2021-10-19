<?php

    require '../../includes/app.php'; 
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image; //Uso de la clase ImagenManager y asignar alias 'Imagen' para implementación ágil


    autenticado();

    $db = conectaDB();
    

    //Realizar el query
    $query = "SELECT * FROM vendedores";

    //Obtener los resultados
    $resultado = mysqli_query($db, $query);

    $errores = Propiedad::getErrores();
    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {
        
        /**Instanciar clase y asignar los valores contenidos en $_POST*/
        $propiedad = new Propiedad($_POST['propiedad']);

        
        /****** ----GENERAR ARCHIVOS----- ******/ 
        
        //generar nombre unico para la imagen
        $nombreImg = md5(uniqid(rand(), true) ) . $_FILES['propiedad']['name']['imagen'];
        
        
        //Realizar un resize a la archivo de imagen con intervention/image
        if ( $_FILES['propiedad']['tmp_name']['imagen'] ) {
            $imagen = Image::make( $_FILES['propiedad']['tmp_name']['imagen'] )->fit(800, 600);   
            //pasar nombre de la imagen al metodo de la clase
            $propiedad->setImagen($nombreImg);
        }
        
        $errores = $propiedad->validarAtributos();

        
        
        if(empty($errores)) {
            
            /****** ---- SUBIR ARCHIVOS ----- ******/    
            //crear directorio para almacenar imagenes
            if (!is_dir(DIR_IMAGENES)) {
                mkdir(DIR_IMAGENES);
            }

            //almacena el archivo en el servidor o ruta especificada
            $imagen->save(DIR_IMAGENES . $nombreImg);

            //guarda registro en la base de datos
            $propiedad->guardar();

        }
    }

    // include '../../includes/templates/header.php';   
    incluirTemplates('header', $inicio = false, $admin = true);
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear</h1>

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
        action="/admin/propiedades/crear.php"
        enctype="multipart/form-data">
        <!--enctype="multipart/form-data" atributo que permite leer archivos, info visible desde superglobal $_FILES-->

            <?php include '../../includes/templates/formulario_propiedades.php'?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<!--footer desde template php-->
<?php
    
    incluirTemplates('footer');
?>