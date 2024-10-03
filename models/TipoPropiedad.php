<?php

namespace Model;

class TipoPropiedad extends ActiveRecord {
    protected static $tabla = 'tipo_propiedad';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}