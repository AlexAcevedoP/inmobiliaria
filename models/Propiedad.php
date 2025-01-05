<?php

namespace Model;

class Propiedad extends ActiveRecord
{ // extends es heredar

    protected static $tabla = 'propiedades';

    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId', 'departamento', 'municipio','barrio', 'tipo_propiedad', 'metros_cuadrados'];	

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
    public $barrio;
    public $tipo_propiedad;
    public $metros_cuadrados;

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
        $this->barrio = $args['barrio'] ?? '';
        $this->tipo_propiedad = $args['tipo_propiedad'] ?? '';
        $this->metros_cuadrados = $args['metros_cuadrados'] ?? '';
    }

public function imagenes() {
    return Imagen::where('property_id', $this->id);
}

// Método para eliminar las imágenes de la galería relacionadas con la propiedad actual
public function eliminarImagenes() {
    $imagenes = $this->imagenes();
    foreach ($imagenes as $imagen) {
        // Eliminar el archivo de imagen del servidor
        $archivoImagen = CARPETA_GALERIA . trim($imagen->image_path);

        if (file_exists($archivoImagen)) {
            if (unlink($archivoImagen)) {
                // Imagen eliminada correctamente
            } else {
                // Error al eliminar la imagen
            }
        } else {
            // Imagen no encontrada
        }

        // Eliminar el registro de la base de datos
        $imagen->eliminar();
    }
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
        // Validación de nuevos campos (deben ser obligatorios y solo letras)
        if (!$this->departamento) {
            self::$errores[] = 'El Departamento es obligatorio';
        } elseif (!preg_match('/^[\p{L}\s]+$/u', $this->departamento)) {
            self::$errores[] = 'El Departamento solo puede contener letras';
        }
        
        if (!$this->municipio) {
            self::$errores[] = 'El Municipio es obligatorio';
        } elseif (!preg_match('/^[\p{L}\s]+$/u', $this->municipio)) {
            self::$errores[] = 'El Municipio solo puede contener letras';
        }
        //debuguear($this->tipo_propiedad);
         // Validar campos adicionales solo si el tipo de propiedad no es "lote"
        if ($this->tipo_propiedad !== '3') {
            if (!$this->habitaciones) {
                self::$errores[] = 'El número de habitaciones es obligatorio';
            }
            if (!$this->wc) {
                self::$errores[] = 'El número de baños es obligatorio';
            }
            if (!$this->estacionamiento) {
                self::$errores[] = 'El número de estacionamientos es obligatorio';
            }
        } else {
            // Depuración: Verificar que el tipo de propiedad es "lote"
            error_log('Tipo de propiedad es lote, omitiendo validación de habitaciones, baños y estacionamiento.');
        }

        if (!$this->metros_cuadrados) {
            self::$errores[] = 'Los Metros Cuadrados son obligatorios';
        } elseif (!is_numeric($this->metros_cuadrados) || $this->metros_cuadrados <= 0) {
            self::$errores[] = 'Los Metros Cuadrados deben ser un número positivo';
        }
        


        return self::$errores;
    }
}
