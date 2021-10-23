<?php 

    include 'includes/app.php';
    
    incluirTemplates('header');
?>

    <main class="contenedor seccion">

        <h1>Casas y Depas en Venta</h1>

        <?php 
            require 'includes/templates/anuncios.php';  
        ?>
        
    </main>


<!--footer desde template php-->
<?php
    incluirTemplates('footer');
?>