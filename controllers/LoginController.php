<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;

class LoginController {

    public static function login(Router $router) {
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una nueva instancia con los datos del formulario
            $auth = new Usuario($_POST);

            // Validar los datos
            $errores = $auth->validar();

            if (empty($errores)) {
                // Verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                // Depurar el resultado de la consulta
                //debuguear($resultado);

                if (!$resultado) {
                    $errores = Usuario::getErrores();
                } else {
                    // Verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);

                    // Depurar el resultado de la verificación de la contraseña
                   // debuguear($autenticado);

                    if ($autenticado) {
                        // Autenticar al usuario
                        $auth->autenticar();
                    } else {
                        // Password incorrecto, mensaje de error
                        $errores = Usuario::getErrores();
                    }
                }
            }
        }

        // Renderizar la vista de login con los errores
        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout() {
        session_start();
        
        $_SESSION = [];

        header('Location: /');
    }
}