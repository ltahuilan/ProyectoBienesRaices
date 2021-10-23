
        <fieldset>
            <legend>Información General</legend>

            <div class="grupo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Ingresa Nombre vendedor" value="<?php echo $vendedor->nombre; ?>">
            </div>
            <div class="grupo">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Ingresa Apellido vendedor" value="<?php echo $vendedor->apellido; ?>">
            </div>
        </fieldset>

        <fieldset>
            <legend>Información adicional</legend>
            <div class="grupo">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="vendedor[telefono]" placeholder="Ingresa Teléfono vendedor a 10 dígitos" value="<?php echo $vendedor->telefono; ?>">
            </div>
            <div class="grupo">
                <label for="email">Email:</label>
                <input type="email" id="email" name="vendedor[email]" placeholder="Ingresa Email vendedor" value="<?php echo $vendedor->email; ?>">
            </div>

        </fieldset>