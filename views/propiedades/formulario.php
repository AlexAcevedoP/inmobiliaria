<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">
    <?php if($propiedad->imagen){ ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
    <?php } ?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">

    <label for="departamento">Departamento:</label>
    <input type="text" id="departamento" name="propiedad[departamento]" placeholder="Departamento" value="<?php echo s($propiedad->departamento); ?>">

    <label for="municipio">Municipio:</label>
    <input type="text" id="municipio" name="propiedad[municipio]" placeholder="Municipio" value="<?php echo s($propiedad->municipio); ?>">

    <label for="tipo_propiedad">Tipo de Propiedad:</label>
    <select id="tipo_propiedad" name="propiedad[tipo_propiedad]">
        <option selected value="">--Seleccione--</option>
        <?php foreach($tiposPropiedad as $tipo): ?>
            <option value="<?php echo $tipo->id; ?>" <?php echo $propiedad->tipo_propiedad === $tipo->id ? 'selected' : ''; ?>>
                <?php echo $tipo->nombre; ?>
            </option>
        <?php endforeach; ?>
    </select>
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorId]" id="vendedor">
        <option selected value="">--Seleccione--</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?> value="<?php echo s($vendedor->id); ?>">
                <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
            </option>
        <?php } ?>
    </select>
</fieldset>

<fieldset>
    <legend>Galería de Imágenes</legend>

    <label for="imagenes">Subir Imágenes:</label>
    <input type="file" id="imagenes" name="imagenes[]" accept="image/jpeg, image/png" multiple>

    <?php if(isset($propiedad->id) && !empty($propiedad->imagenes())): ?>
        <!-- Mostrar la galería de imágenes solo si estamos actualizando una propiedad -->
        <div class="galeria-imagenes">
            <?php foreach ($propiedad->imagenes() as $imagen) { ?>
                <img src="/ruta/a/imagenes/<?php echo $imagen->image_path; ?>" class="imagen-small" alt="Imagen de la propiedad">
            <?php } ?>
        </div>
    <?php endif; ?>
</fieldset>