
            <fieldset>
                <legend>Imformación General</legend>

                <div class="grupo">
                    <label for="titulo">Titulo:</label>
                    <input 
                        type="text"
                        id="titulo"
                        name="propiedad[titulo]"
                        placeholder="Titulo de propiedad"
                        value="<?php echo sanitizarHTML($propiedad->titulo); ?>">
                </div>

                <div class="grupo">
                    <label for="precio">Precio:</label>
                    <input
                        type="text"
                        id="precio"
                        name="propiedad[precio]"
                        placeholder="Precio de propiedad"
                        value="<?php echo sanitizarHTML($propiedad->precio); ?>">                    
                </div>

                <?php if ($propiedad->imagen) : ?>
                    <img src="/upload_img/<?php echo $propiedad->imagen?>" alt="" class="imagen-thumb">
                <?php endif; ?>

                <div class="grupo">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">                    
                </div>

                <div class="grupo">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="propiedad[descripcion]" placeholder="Descripcion de la propiedad"><?php echo sanitizarHTML($propiedad->descripcion); ?></textarea>
                </div>

            </fieldset>

            <fieldset>
                <legend>Características</legend>

                <div class="grupo">
                    <label for="habitaciones">Número de Habitaciones:</label>
                    <input
                        type="number"
                        id="habitaciones"
                        name="propiedad[habitaciones]"
                        min="1" max="20"
                        placeholder="Ej.: 3"
                        value="<?php echo sanitizarHTML($propiedad->habitaciones); ?>">
                </div>

                <div class="grupo">
                    <label for="wc">Número de Baños:</label>
                    <input
                        type="number"
                        id="wc"
                        name="propiedad[wc]"
                        min="1" max="20"
                        placeholder="Ej.: 3"
                        value="<?php echo sanitizarHTML($propiedad->wc); ?>">
                </div>

                <div class="grupo">
                    <label for="estacionamiento">Número de Estacionamientos:</label>
                    <input
                        type="number"
                        id="estacionamiento"
                        name="propiedad[estacionamiento]"
                        min="0" max="20"
                        placeholder="A partir de 0"
                        value="<?php echo sanitizarHTML($propiedad->estacionamiento); ?>">
                </div>
            </fieldset>

            <fieldset>
                <legend>Vendedores</legend>
                <div class="grupo">
                    <select name="propiedad[vendedorId]" >
                        <option value="">-- Seleccionar --</option>

                        <option value="1">Luis Tahuilan</option>

                    </select>
                </div>
            </fieldset>