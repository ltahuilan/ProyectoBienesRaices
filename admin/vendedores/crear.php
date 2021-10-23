<?php 

use App\Vendedor;

include '../../includes/app.php';

autenticado();

$vendedor = new Vendedor;

$errores = Vendedor::getErrores();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    //paso de parametros desde arreglo $_POST al constructor
    $vendedor = new Vendedor($_POST['vendedor']);

    $errores = $vendedor->validarAtributos();

    if (empty($errores)) {
        $vendedor->guardar();
    }
}

incluirTemplates('header', $inicio = false, $admin = true);

?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear Vendedor(a)</h1>

        <?php 
        /**inyectar HTML */
        foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>
        <?php endforeach; ?>

        <a href="../index.php" class="boton boton-verde">Regresar</a>

        <form class="formulario" method="POST" action="/admin/vendedores/crear.php">

            <?php include '../../includes/templates/formulario_vendedores.php'?>

            <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
        </form>

    </main>
    

<?php include '../../includes/templates/footer.php';?>