<?php
require_once __DIR__ . '/../../includes/funciones.php';
require_once __DIR__ . '/../../models/Blog.php';

use Model\Blog;

estaAutenticado();

//incluirTemplate('header');

$blog = new Blog;
$errores = Blog::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog = new Blog($_POST['blog']);

    // Subir la imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    if ($_FILES['blog']['tmp_name']['imagen']) {
        move_uploaded_file($_FILES['blog']['tmp_name']['imagen'], CARPETA_IMAGENES . $nombreImagen);
        $blog->imagen = $nombreImagen;
    }

    // Validar los datos
    //$errores = $blog->validar();

    // Si no hay errores, guardar la entrada
    if (empty($errores)) {        
        $blog->guardar();
        header('Location: /blog?resultado=1');
        exit;
    }
}
?>

<main class="contenedor seccion">
    <h1>Crear Entrada de Blog</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" action="/blog/crear" method="POST" enctype="multipart/form-data">

        <?php include_once __DIR__ . '/../../includes/templates/formulario_blog.php'; ?>

        <input type="submit" value="Crear Entrada" class="boton boton-verde">
    </form>
</main>
