<?php

    include '../../includes/config/database.php';
    $db = conectaDB();
    // var_dump($db);

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_SERVER);
    // echo "</pre>";
    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {
        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedor = $_POST['vendedor'];
        
        /**Inserta valores en la DB */
        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedorId)
        VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedor') ";

        $resultado = mysqli_query($db, $query);

        if($resultado) {
            echo ('Datos almacenados correctamente');
        }
    }

    // include '../../includes/templates/header.php';
    require '../../includes/funciones.php';    
    incluirTemplates('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear</h1>

        <a href="../index.php" class="boton boton-verde">Regresar</a>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
            <fieldset>
                <legend>Imformación General</legend>

                <div class="grupo">
                    <label for="titulo">Titulo:</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Titulo de propiedad">
                </div>

                <div class="grupo">
                    <label for="precio">Precio:</label>
                    <input type="text" id="precio" name="precio" placeholder="Precio de propiedad">                    
                </div>

                <div class="grupo">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" accept="image/jpeg, image/png">                    
                </div>
                <div class="grupo">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripcion de la propiedad"></textarea>
                </div>

            </fieldset>

            <fieldset>
                <legend>Características</legend>

                <div class="grupo">
                    <label for="habitaciones">Número de Habitaciones:</label>
                    <input type="number" id="habitaciones" name="habitaciones" min="1" max="20" placeholder="Ej.: 3">
                </div>

                <div class="grupo">
                    <label for="wc">Número de Baños:</label>
                    <input type="number" id="wc" name="wc" min="1" max="20" placeholder="Ej.: 3">
                </div>

                <div class="grupo">
                    <label for="estacionamiento">Número de Estacionamientos:</label>
                    <input type="number" id="estacionamiento" name="estacionamiento" min="1" max="20" placeholder="Ej.: 3">
                </div>
            </fieldset>

            <fieldset>
                <legend>Vendedores</legend>
                <div class="grupo">
                    <select name="vendedor">
                        <option disabled selected>-- Seleccionar --</option>
                        <option value="1">Luis</option>
                        <option value="2">Lourdes</option>
                    </select>
                </div>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<!--footer desde template php-->
<?php
    
    incluirTemplates('footer');
?>