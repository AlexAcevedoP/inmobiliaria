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
<!-- Incluir TinyMCE -->
<script src="https://cdn.tiny.cloud/1/m8tg3yjjb6yn4my3xak3dunp4hugmou60xaa6glf2p0zkou3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#contenido',
    plugins: 'image code',
    toolbar: 'undo redo | link image | code',
    // Configuración para subir imágenes
    images_upload_url: '/upload.php',
    automatic_uploads: true,
    file_picker_types: 'image',
    images_upload_handler: function (blobInfo, success, failure) {
      var xhr, formData;

      xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', '/upload.php');

      xhr.onload = function() {
        var json;

        if (xhr.status != 200) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }

        success(json.location);
      };

      formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());

      xhr.send(formData);
    }
  });
</script>