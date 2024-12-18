<?php

namespace Model;

class Blog extends ActiveRecord {
    protected static $tabla = 'blog';
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'autor', 'contenido', 'imagen'];

    public $id;
    public $titulo;
    public $fecha;
    public $autor;
    public $contenido;
    public $imagen;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = date('Y-m-d'); // Capturar la fecha automáticamente
        $this->autor = $args['autor'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar() {
        if (!$this->titulo) {
            self::$errores[] = "El título es obligatorio";
        }
        if (!$this->autor) {
            self::$errores[] = "El autor es obligatorio";
        }
        if (!$this->contenido) {
            self::$errores[] = "El contenido es obligatorio";
        }
        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
}