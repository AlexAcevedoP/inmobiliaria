<?php

namespace Model;

class Imagen extends ActiveRecord {
    protected static $tabla = 'galeria';
    protected static $columnasDB = ['id', 'property_id', 'image_path'];

    public $id;
    public $property_id;
    public $image_path;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->property_id = $args['property_id'] ?? '';
        $this->image_path = $args['image_path'] ?? '';
    }
}