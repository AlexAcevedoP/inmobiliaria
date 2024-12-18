<?php
require_once __DIR__ . '/../../includes/config/database.php';
$db = conectarDB();

$query = "SELECT * FROM blog";
$resultado = mysqli_query($db, $query);

require_once __DIR__ . '/../../includes/funciones.php';

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Nuestro Blog</h1>

    <?php while ($entrada = mysqli_fetch_assoc($resultado)) : ?>
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="/imagenes/<?php echo $entrada['imagen']; ?>" type="image/webp">
                    <source srcset="/imagenes/<?php echo $entrada['imagen']; ?>" type="image/jpeg">
                    <img loading="lazy" src="/imagenes/<?php echo $entrada['imagen']; ?>" alt="Texto Entrada Blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="/entrada?id=<?php echo $entrada['id']; ?>">
                    <h4><?php echo $entrada['titulo']; ?></h4>
                    <p>Escrito el: <span><?php echo $entrada['fecha']; ?></span> por: <span><?php echo $entrada['autor']; ?></span></p>

                    <p>
                        <?php echo substr($entrada['contenido'], 0, 100); ?>...
                    </p>
                </a>
            </div>
        </article>
    <?php endwhile; ?>
</main>
