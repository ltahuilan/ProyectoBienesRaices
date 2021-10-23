<?php

    use App\Vendedor;

    include '../../includes/app.php';

    autenticado();

    //validar id de vendedores
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //Redireccionar si no esta autenticado
    if (!$id) {
        header('Location: /admin');
    }

    //consultar datos de vendedor por su id
    $vendedor = Vendedor::getById($id);

    //consultando errores
    $errores = Vendedor::getErrores();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //asignar arreglo de datos en $_POST
        $args = [];
        $args = $_POST['vendedor'];
        
        //sincronizar objeto en momoria 
        $vendedor->sincronizar($args);

        $errores = $vendedor->validarAtributos();

        if (empty($errores)) {
            //guardar 
            $vendedor->guardar();            
        }
    }

    incluirTemplates('header', $inicio = false, $admin = true);

?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Vendedor(a)</h1>

        <?php 
        /**inyectar HTML */
        foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>
        <?php endforeach; ?>

        <a href="../index.php" class="boton boton-verde">Regresar</a>

        <form class="formulario" method="POST" >

            <?php include '../../includes/templates/formulario_vendedores.php'?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>

    </main>



<!--footer desde template php-->
<?php
    include '../../includes/templates/footer.php';
?>