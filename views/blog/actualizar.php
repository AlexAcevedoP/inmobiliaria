<!-- filepath: /c:/Users/Alex/Documents/bienesRaices/views/blog/actualizar.php -->
<?php
require_once __DIR__ . '/../../includes/funciones.php';
require_once __DIR__ . '/../../models/Blog.php';

use Model\Blog;

estaAutenticado();

$errores = Blog::getErrores();
$entrada = $entrada ?? new Blog;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entrada = new Blog($_POST['blog']);

    // Subir la imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    if ($_FILES['blog']['tmp_name']['imagen']) {
        move_uploaded_file($_FILES['blog']['tmp_name']['imagen'], CARPETA_IMAGENES . $nombreImagen);
        $entrada->imagen = $nombreImagen;
    }

    // Validar los datos
    $errores = $entrada->validar();

    // Si no hay errores, guardar la entrada
    if (empty($errores)) {
        $entrada->guardar();
        header('Location: /admin?resultado=2');
        exit;
    }
}
?>

<main class="contenedor seccion">
    <h1>Actualizar Entrada de Blog</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" action="/blog/actualizar?id=<?php echo $entrada->id; ?>" method="POST" enctype="multipart/form-data">
        <?php include_once __DIR__ . '/../../includes/templates/formulario_blog.php'; ?>
        <input type="submit" value="Actualizar Entrada" class="boton boton-verde">
    </form>
</main>
