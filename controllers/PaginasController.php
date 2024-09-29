<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::get(3);
        $inicio = true; //para mostrar el header solo en el inicio
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {

        $id = validarORedireccionar('/propiedades');

        //buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {

        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router){

        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];


            //crear una nueva instancia de PHPMailer
            $mail = new PHPMailer();

            //configurar SMTP (protocolo para el envio de emails)
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '2919f1b5c4d823';
            $mail->Password = 'a06d6e34269047';
            $mail->SMTPSecure = 'lts';
            $mail->Port = 2525;

            //configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            //habilitar html
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';


            //definir el contenido
            $contenido = '<html>';
            $contenido .= '<p> Tienes un mensaje nuevo </p>';
            $contenido .= '<p> Nombre: ' . $respuestas['nombre'] . ' </p>';

            //mostrar de forma condicional los campos de email o telefono
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p> Eligió ser contactado por teléfono</p>';
                $contenido .= '<p> Teléfono: ' . $respuestas['telefono'] . ' </p>';
                $contenido .= '<p> Fecha de contacto: ' . $respuestas['fecha'] . ' </p>';
                $contenido .= '<p> Hora: ' . $respuestas['hora'] . ' </p>';
            } else {
                $contenido .= '<p> Eligió ser contactado por email</p>';
                $contenido .= '<p> Email: ' . $respuestas['email'] . ' </p>';
            }

            $contenido .= '<p> Mensaje: ' . $respuestas['mensaje'] . ' </p>';
            $contenido .= '<p> Vende o compra: ' . $respuestas['tipo'] . ' </p>';
            $contenido .= '<p> Precio o presupuesto: $' . $respuestas['precio'] . ' </p>';
            $contenido .= '<p> Prefiere ser contactado por: ' . $respuestas['contacto'] . ' </p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = "Esto es un texto alternativo son html";

            //enviar el email
            if ($mail->send()) {
                $mensaje = "Mensaje enviado";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje'=>$mensaje
        ]);
    }
}
