<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Model\Imagen;
use Model\TipoPropiedad; // Importar la clase TipoPropiedad
use Model\Blog;
use Intervention\Image\ImageManagerStatic as Image;

// Incluir el archivo de funciones
require_once __DIR__ . '/../includes/funciones.php';

class PropiedadController
{

    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $entradas = Blog::all();
        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores,
            'entradas' => $entradas
        ]);
    }

    public static function crear(Router $router)
    {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        // Obtener los tipos de propiedad desde la base de datos
        $tiposPropiedad = TipoPropiedad::all();
        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una nueva instancia con los datos del formulario
            $propiedad = new Propiedad($_POST['propiedad']);

             // Burlar la validación para tipo de propiedad "lote"
             if ($propiedad->tipo_propiedad === '3') {
                $propiedad->habitaciones = 1;
                $propiedad->wc = 1;
                $propiedad->estacionamiento = 1;
            }
            // Burlar la validación solo del campo habitaciones para "bodega" y "local comercial"
            if ($propiedad->tipo_propiedad === '4' || $propiedad->tipo_propiedad === '5') {
                $propiedad->habitaciones = 1;
            }

            /** SUBIDA DE ARCHIVOS */

            // Procesar la imagen principal
            $nombreImagenPrincipal = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagenPrincipal);
            }

            // Procesar las imágenes de la galería
            $nombreImagenesGaleria = [];
            if (!empty($_FILES['imagenes']['name'][0])) {
                foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                    $nombreImagenGaleria = md5(uniqid(rand(), true)) . ".jpg";
                    $nombreImagenesGaleria[] = $nombreImagenGaleria;
                    $imageGaleria = Image::make($tmp_name)->fit(800, 600);
                    $imageGaleria->save(CARPETA_GALERIA . $nombreImagenGaleria);
                }
            }

            // Validar los datos
            $errores = $propiedad->validar();

            if (empty($errores)) {
                // Crear carpeta para las imágenes si no existe
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                if (!is_dir(CARPETA_GALERIA)) {
                    mkdir(CARPETA_GALERIA);
                }

                // Guardar la imagen principal en el servidor
                if (isset($image)) {
                    $image->save(CARPETA_IMAGENES . $nombreImagenPrincipal);
                }

                // Guardar la propiedad en la base de datos
                $propiedad->guardar();

                // Guardar las imágenes de la galería en la base de datos
                foreach ($nombreImagenesGaleria as $nombreImagenGaleria) {
                    $imagen = new Imagen(['property_id' => $propiedad->id, 'image_path' => $nombreImagenGaleria]);
                    $imagen->guardar();
                }

                // Redireccionar después de guardar todas las imágenes
                header('Location: /admin?resultado=2');
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'tiposPropiedad' => $tiposPropiedad, // Pasar los tipos de propiedad a la vista
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $errores = Propiedad::getErrores();
        $vendedores = Vendedor::all();
        $tiposPropiedad = TipoPropiedad::all(); // Obtener los tipos de propiedad desde la base de datos

        // Método POST para actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar los atributos
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);

            // Validar los datos
            $errores = $propiedad->validar();

            // Subida de archivos
            // Generar un nombre único para la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Realizar resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            // Procesar las imágenes de la galería
            $nombreImagenesGaleria = [];
            if (!empty($_FILES['imagenes']['name'][0])) {

                // Eliminar las imágenes anteriores
                $propiedad->eliminarImagenes();

                foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                    $nombreImagenGaleria = md5(uniqid(rand(), true)) . ".jpg";
                    $nombreImagenesGaleria[] = $nombreImagenGaleria;
                    $imageGaleria = Image::make($tmp_name)->fit(800, 600);
                    $imageGaleria->save(CARPETA_GALERIA . $nombreImagenGaleria);
                }
            }

            if (empty($errores)) {
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }

                // Guardar la propiedad en la base de datos
                $propiedad->guardar();

                // Guardar las imágenes de la galería en la base de datos
                foreach ($nombreImagenesGaleria as $nombreImagenGaleria) {
                    $imagen = new Imagen(['property_id' => $propiedad->id, 'image_path' => $nombreImagenGaleria]);
                    $imagen->guardar();
                }

                // Redireccionar al usuario después de actualizar
                header('Location: /admin?resultado=2');
            }
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores,
            'tiposPropiedad' => $tiposPropiedad // Pasar los tipos de propiedad a la vista
        ]);
    }

    public static function eliminar()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            $propiedad = Propiedad::find($id);

            if ($propiedad) {
                // Eliminar las imágenes asociadas a la propiedad
                $propiedad->eliminarImagenes();

                // Eliminar la propiedad de la base de datos
                $propiedad->eliminar();
            }
        }
    }
}
}
