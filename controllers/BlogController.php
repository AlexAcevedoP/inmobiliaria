<?php

namespace Controllers;

use MVC\Router;
use Model\Blog;

class BlogController {
    // Método para mostrar todas las entradas del blog
    public static function index(Router $router) {
        $entradas = Blog::all();
        $router->render('blog/index', [
            'entradas' => $entradas
        ]);
    }

    // Método para crear una nueva entrada de blog
    public static function crear(Router $router) {
        // Verificar si el usuario está autenticado
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Iniciar la sesión solo si no está activa
        }
        if (!isset($_SESSION['login']) || !$_SESSION['login']) {
            header('Location: /login'); // Redirigir al login si no está autenticado
            exit;
        }

        $errores = Blog::getErrores();
        $entrada = new Blog;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $entrada = new Blog($_POST['blog']);

            // Subir la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['blog']['tmp_name']['imagen']) {
                move_uploaded_file($_FILES['blog']['tmp_name']['imagen'], CARPETA_IMAGENES . $nombreImagen);
                $entrada->imagen = $nombreImagen;
            }

            $errores = $entrada->validar();

            if (empty($errores)) {
                $entrada->guardar();
                header('Location: /admin?resultado=2'); // Redirigir después de guardar
                exit; // Asegúrate de detener la ejecución después de redirigir
            }
        }

        // Renderizar la vista de creación de blog
        $router->render('blog/crear', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    // Método para mostrar una entrada específica del blog
    public static function mostrar(Router $router) {
        $id = validarORedireccionar('/blog');
        $entrada = Blog::find($id);

        // Renderizar la vista de la entrada del blog
        $router->render('blog/mostrar', [
            'entrada' => $entrada
        ]);
    }
}