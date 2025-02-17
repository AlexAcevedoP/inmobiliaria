<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;

class UsuarioController {
    public static function crear(Router $router) {
        $usuario = new Usuario;
        $errores = Usuario::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una nueva instancia con los datos del formulario
            $usuario = new Usuario($_POST['usuario']);

            // Validar los datos
            $errores = $usuario->validar();

            if (empty($errores)) {
                // Crear el usuario en la base de datos
                if ($usuario->crearUsuario()) {
                    // Redireccionar después de crear el usuario
                    header('Location: /admin?resultado=1');
                } else {
                    $errores[] = 'Error al crear el usuario';
                }
            }
        }

        $router->render('usuarios/crear', [
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }
}