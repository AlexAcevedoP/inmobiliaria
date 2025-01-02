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

    public static function crear(Router $router) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['login']) || !$_SESSION['login']) {
            header('Location: /login');
            exit;
        }
    
        $errores = Blog::getErrores();
        $entrada = new Blog;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $entrada = new Blog($_POST['blog']);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['blog']['tmp_name']['imagen']) {
                move_uploaded_file($_FILES['blog']['tmp_name']['imagen'], CARPETA_IMAGENES . $nombreImagen);
                $entrada->imagen = $nombreImagen;
            }
    
            $errores = $entrada->validar();
    
            if (empty($errores)) {
                $entrada->guardar();
                header('Location: /admin?resultado=1');
                exit;
            }
        }
    
        $router->render('blog/crear', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $entrada = Blog::find($id);
        $errores = Blog::getErrores();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['blog'];
            $entrada->sincronizar($args);
            $errores = $entrada->validar();
    
            if (empty($errores)) {
                $entrada->guardar();
                header('Location: /admin?resultado=2');
                exit;
            }
        }
    
        $router->render('blog/actualizar', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    // Método para eliminar una entrada de blog
    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $entrada = Blog::find($id);
            $entrada->eliminar();
            header('Location: /admin?resultado=3');
            exit;
        }
    }

    // Método para mostrar una entrada específica del blog
    public static function mostrar(Router $router) {
        $id = validarORedireccionar('/blog');
        $entrada = Blog::find($id);
        $errores = []; // Definir la variable $errores

        // Renderizar la vista de la entrada del blog
        $router->render('blog/mostrar', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }
}