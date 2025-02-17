<main class="contenedor seccion contenido-centrado">
<h1><strong><?php echo $propiedad->titulo; ?></strong></h1>


    <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen de la propiedad">

    <div class="resumen-propiedad">
        <p class="precio">$<?php echo number_format($propiedad->precio); ?> </p>

        <?php if ($propiedad->tipo_propiedad !== '3') : ?>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
                <?php if ($propiedad->tipo_propiedad !== '4' && $propiedad->tipo_propiedad !== '5') : ?>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

        
        <p><strong>Municipio:</strong> <?php echo $propiedad->municipio; ?></p>
        <p><strong>Departamento:</strong> <?php echo $propiedad->departamento; ?></p>
        <p><strong>Barrio:</strong> <?php echo $propiedad->barrio; ?></p>
        <p><strong>Tipo de Propiedad:</strong> <?php echo $propiedad->tipo_propiedad; ?></p>
        <p><strong>Área:</strong> <?php echo $propiedad->metros_cuadrados; ?> m²</p>
        <p>
            <strong>Precio por metro cuadrado:</strong> <?php echo number_format($propiedad->precio / $propiedad->metros_cuadrados, 2); ?>
        </p> 

        <p><?php echo nl2br($propiedad->descripcion); ?></p>

        <div class="galeria-imagenes">
            <h2>Galería de Imágenes</h2>
            <div class="galeria-grid">
                <?php 
                $imagenes = $propiedad->imagenes();
                if ($imagenes) {
                    foreach ($imagenes as $index => $imagen) { ?>
                        <img class="miniatura" loading="lazy" src="/galeria/<?php echo $imagen->image_path; ?>" alt="imagen de la galería" data-index="<?php echo $index; ?>">
                    <?php }
                } else { ?>
                    <p>No hay imágenes adicionales para esta propiedad.</p>
                <?php } ?>
            </div>
        </div>
    </div>


</main>
    <!-- Contenedor para la imagen ampliada -->
    <div id="imagen-ampliada" class="imagen-ampliada">
    <span class="cerrar">&times;</span>
    <img class="imagen-ampliada-contenido" id="imagen-ampliada-contenido">
    <a class="prev" id="prev">&#10094;</a>
    <a class="next" id="next">&#10095;</a>
</div>

<!-- Incluir el Botón de WhatsApp Flotante -->
<?php include __DIR__ . '/../../includes/templates/whatsapp.php'; ?>