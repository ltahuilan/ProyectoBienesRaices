<?php

    use App\Propiedad;
    use App\Vendedor;

    require '../includes/app.php';

    autenticado();

    /**===COMPROBAR EL QUERY STRING=== */
    $queryString = '';
    /**comprobar si el query string existe con if*/    
    // if(isset($_GET['resultado'])) {
    //     $queryString = $_GET['resultado'];
    // }

    /**comprobando que query string esta presente utilizando operador ternario
     */
    // isset($_GET['resultado']) ? $queryString = $_GET['resultado'] : $queryString = null;

    /**comprobando si el query string esta presente utilizando el operador coalescente ?? 
     */
    $queryString = $_GET['resultado'] ?? null;


    /*** consultando registros en la base de datos ***/

    $propiedades = Propiedad::getTodo();
    $vendedores = Vendedor::getTodo();


    /**==== ELIMINA PROPIEDAD ===== */

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        //validar id
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        if($id) {

            $tipo = $_POST['tipo'];

            if (tipoContenido($tipo)) {
                
                if ($tipo === 'propiedad') {
                    $propiedad = Propiedad::getById($id);    
                    $propiedad->eliminar();
                }else if ($tipo === 'vendedor') {
                    $vendedores = Vendedor::getById($id);
                    $vendedores->eliminar();
                }
            }          
        }        
    }

    incluirTemplates('header', $inicio = false, $admin = true);

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Administrador de Bienes Raices</h1>

    <?php $mensaje = mostrarNotificacion($queryString); ?>

    <?php if ($mensaje) : ?>
        <p class="alerta correcto"><?php echo sanitizarHTML($mensaje); ?></p>
    <?php endif; ?>


    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-verde">Nuevo Vendedor(a)</a>
    
    <h1>Propiedades</h1>

    <table class="tabla" id="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Descripcion</th>
                <th>Vendedor</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <!--Mostrar los resultados -->
        <?php foreach ($propiedades as $propiedad) : ?>
        <tbody>
            <tr>
                <td><?php echo $propiedad->id; ?></td>
                <td><?php echo $propiedad->titulo; ?></td>
                <td>$<?php echo $propiedad->precio; ?> </td>
                <td class="imagen-propiedad"><img src="/upload_img/<?php echo $propiedad->imagen; ?>" alt="imagen propiedad"></td>
                <td><?php echo $propiedad->descripcion; ?></td>
                    <?php                    
                        foreach ($vendedores as $vendedor) {
                            if ($propiedad->vendedorId === $vendedor->id) {
                                $nombreVendedor = $vendedor->nombre . ' ' . $vendedor->apellido;
                            }
                        }                    
                    ?>    
                <td><?php echo  $nombreVendedor; ?></td>
                <td class="boton-eliminar">
                    <form method="POST" class="w-100">
                        <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                        <input type="hidden" name="tipo" value="propiedad">
                        <input type="submit" value="Eliminar" class="boton boton-rojo-block">
                    </form>
                    
                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Editar</a>
                </td>
            </tr>
        </tbody>
        <?php endforeach ?>
    </table>

    <h1>Vendedores</h1>
    
    <table class="tabla" id="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <?php foreach ($vendedores as $vendedor) : ?>
        <tbody>
            <tr>
                <td><?php echo $vendedor->id; ?></td>
                <td><?php echo $vendedor->nombre . ' ' .$vendedor->apellido; ?></td>              
                <td><?php echo  $vendedor->telefono; ?></td>
                <td><?php echo $vendedor->email?></td>
                <td >

                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                    <input type="hidden" name="tipo" value="vendedor">
                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form>

                    <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Editar</a>

                </td>
            </tr>
        </tbody>
        <?php endforeach ?>
    </table>

    <!-- PASO 6: Cerrar la conexión -->
    <?php mysqli_close($db) ?>
    
</main>

<!--footer desde template php-->
<?php
    include '../includes/templates/footer.php';
?>