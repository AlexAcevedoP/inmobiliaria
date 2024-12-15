<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad->titulo; ?></h1>


    <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen de la propiedad">

    <div class="resumen-propiedad">
    <p class="precio">$<?php echo number_format($propiedad->precio); ?>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad->wc; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $propiedad->estacionamiento; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                <p><?php echo $propiedad->habitaciones; ?></p>
            </li>
        </ul>

        <p><strong>Departamento:</strong> <?php echo $propiedad->departamento; ?></p>
        <p><strong>Municipio:</strong> <?php echo $propiedad->municipio; ?></p>
        <p><strong>Tipo de Propiedad:</strong> <?php echo $propiedad->tipo_propiedad; ?></p>
        <p><strong>Área:</strong> <?php echo $propiedad->metros_cuadrados; ?> m²</p>

        <p><?php echo nl2br($propiedad->descripcion); ?></p>

        <div class="galeria-imagenes">
        <h2>Galería de Imágenes</h2>
        <?php 
        $imagenes = $propiedad->imagenes();
        if ($imagenes) {
            foreach ($imagenes as $imagen) { ?>
                <img loading="lazy" src="/galeria/<?php echo $imagen->image_path; ?>" alt="imagen de la galería">
            <?php }
        } else { ?>
            <p>No hay imágenes adicionales para esta propiedad.</p>
        <?php } ?>
    </div>
    </div>
</main>