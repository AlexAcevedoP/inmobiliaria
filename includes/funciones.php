<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . '/funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../public/imagenes/');
define('CARPETA_GALERIA', __DIR__ . '/../public/galeria/');


function incluirTemplate(string  $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

// Función para verificar si el usuario está autenticado
function estaAutenticado()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Iniciar la sesión solo si no está activa
    }

    if (!isset($_SESSION['login']) || !$_SESSION['login']) {
        header('Location: /login');
        exit; // Asegúrate de detener la ejecución después de redirigir
    }
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escapar / sanitizar el HTML
function s($html)
{
    $s = htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido
function validarTipoContenido($tipo)
{
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

//muestra los mensajes
function mostrarNotificacion($codigo)
{
    $mensaje = '';
    switch ($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje=false;
            break;
    }

    return $mensaje;
}

function validarORedireccionar( string $url){

    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: {$url}");
    }

    return $id;
}