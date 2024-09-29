<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

// Incluir el archivo de funciones
require_once __DIR__ . '/../includes/funciones.php';

class PropiedadController{

    public static function index(Router $router){//pasar el objeto de la instacia del index

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;    

        $router->render('propiedades/admin' , [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores

        ]);
    }

    public static function crear(Router $router){
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crea una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);
        
            /** SUBIDA DE ARCHIVOS */
        
            // Generar un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
            //Setear la imagen
            //Realizar resize a la imgen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            //Validar
            $errores = $propiedad->validar();
        
            if (empty($errores)) {
        
                // Subir la imagen
                //move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
        
                // Crear carpeta
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
        
                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES  . $nombreImagen);
        
                //Guardar en la base de datos
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear',[
            'propiedad'=>$propiedad,
            'vendedores'=>$vendedores,
            'errores'=>$errores
        ]);
    }

    public static function actualizar(Router $router){
       $id = validarORedireccionar('/admin');

       $propiedad = Propiedad::find($id);
       $errores = Propiedad::getErrores();
       $vendedores = Vendedor::all();


        //Metodo post para actualizar
       if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Asignar los atributos
        $args = $_POST['propiedad'];

      $propiedad->sincronizar($args);
      
      //Validacion
      $errores = $propiedad->validar();
        
        //Subida de archivos
         // Generar un nombre único
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Setear la imagen
    //Realizar resize a la imgen con intervention
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        if(empty($errores)) {
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
            //almacenar la imagen
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
       
          $propiedad->guardar();
        }
    }


       $router -> render('/propiedades/actualizar',[
            'propiedad'=> $propiedad,
            'errores'=> $errores,
            'vendedores' => $vendedores
       ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
    
                $tipo = $_POST['tipo'];
                
                if(validarTipoContenido($tipo)){
                     
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }                        
            }        
        }

    }
}
