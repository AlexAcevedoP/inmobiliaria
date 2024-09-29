<?php
namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    //tomar la ruta de la url y su funcion
    public function get($url, $fn) {
        $this->rutasGET[$url]=$fn;
    }
    public function post($url, $fn) {
        $this->rutasPOST[$url]=$fn;
    }
    public function comprobarRutas(){

        session_start();

        $auth = $_SESSION['login']?? null; // si esta autenticado es true y si no es null

        //arreglo de rutas protegidas
        $rutas_protegidas = ['/admin','/propiedades/crear','/propiedades/actualizar','/propiedades/eliminar','/vendedores/crear','/vendedores/actualizar','/vendedores/eliminar'];


        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        
        
        if($metodo === 'GET'){
            //leer la funcion asociada a cada ruta, si no existe la ruta asigna un null
            $fn = $this->rutasGET[$urlActual] ?? null;           
        }else{
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        //proteger las rutas
        if(in_array($urlActual, $rutas_protegidas)&& !$auth){
            header('Location: /');
        }

        if($fn){
            //la url existe y tiene una funcion asociada
            call_user_func($fn, $this);//No se sabe cual es la funcion que se va a ejecutar,llama a la funcion de la url visitada por el usuario
            
        }else{
            echo "Página no encontrada";
        }
    }
    //mostrar una vista
    public function render($view, $datos = []){//toma la vista que va a mostrar

        foreach($datos as $key => $value){
            $$key = $value;
        }

        ob_start();//va a almacenar en memoria las vistas que se va dando render
        include __DIR__ . "/views/$view.php";
        
        $contenido = ob_get_clean();//limpia la memoria

        include __DIR__ . "/views/layout.php";
    }
 }