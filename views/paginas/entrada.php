<?php
require_once __DIR__ . '/../../includes/config/database.php';
require_once __DIR__ . '/../../includes/funciones.php';

$db = conectarDB();

// Obtener el ID de la entrada
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /blog');
}

// Consultar la entrada
$query = "SELECT * FROM blog WHERE id = {$id}";
$resultado = mysqli_query($db, $query);

if ($resultado->num_rows === 0) {
    header('Location: /blog');
}

$entrada = mysqli_fetch_assoc($resultado);

//incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1><strong><?php echo $entrada['titulo']; ?></strong></h1>

    <picture>
        <source srcset="/imagenes/<?php echo $entrada['imagen']; ?>" type="image/webp">
        <source srcset="/imagenes/<?php echo $entrada['imagen']; ?>" type="image/jpeg">
        <img loading="lazy" src="/imagenes/<?php echo $entrada['imagen']; ?>" alt="Texto Entrada Blog">
    </picture>

    <p class="informacion-meta">Escrito el: <span><?php echo $entrada['fecha']; ?></span> por: <span><?php echo $entrada['autor']; ?></span></p>

    <div class="resumen-propiedad">
        <p><?php echo $entrada['contenido']; ?></p>
    </div>
</main>
