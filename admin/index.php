<?php 
    // require '../includes/templates/header.php';

    require '../includes/funciones.php';    
    incluirTemplates('header');

?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Administrador de Bienes Raices</h1>

        <a href="propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
        <a href="propiedades/actualizar.php" class="boton boton-verde">Editar Propiedad</a>
        <a href="propiedades/eliminar.php" class="boton boton-verde">Eliminar Propiedad</a>
        <a href="propiedades/leer.php" class="boton boton-verde">Consultar Propiedad</a>

    </main>


<!--footer desde template php-->
<?php
    include '../includes/templates/footer.php';
?>