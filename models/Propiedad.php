<?php

namespace Model;

class Propiedad extends ActiveRecord
{ // extends es heredar

    protected static $tabla = 'propiedades';

    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;
    //nuevos campos en la base de datos
    public $departamento;
    public $municipio;
    public $tipo_propiedad;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
        //nuevos campos en el costructor
        $this->departamento = $args['departamento'] ?? '';
        $this->municipio = $args['municipio'] ?? '';
        $this->tipo_propiedad = $args['tipo_propiedad'] ?? '';
    }

    public function validar()
    {
        //validacion backend de los campos del formulario con respecto a la DB
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if (!$this->precio) {
            self::$errores[] = 'El Precio es Obligatorio';
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
        }

        if (!$this->habitaciones) {
            self::$errores[] = 'El Número de habitaciones es obligatorio';
        }

        if (!$this->wc) {
            self::$errores[] = 'El Número de Baños es obligatorio';
        }

        if (!$this->estacionamiento) {
            self::$errores[] = 'El Número de lugares de Estacionamiento es obligatorio';
        }

        if (!$this->vendedorId) {
            self::$errores[] = 'Elige un vendedor';
        }

        if (!$this->imagen) {
            self::$errores[] = 'La Imagen es Obligatoria';
        }
        //validación de nuevos campos ( deben ser obligatorios)
        if(!$this->departamento) {
            self::$errores[] = 'El Departamento es obligatorio';
        }

        if(!$this->municipio) {
            self::$errores[] = 'El Municipio es obligatorio';
        }

        if(!$this->tipo_propiedad) {
            self::$errores[] = 'El Tipo de Propiedad es obligatorio';
        }

        return self::$errores;
    }
}
