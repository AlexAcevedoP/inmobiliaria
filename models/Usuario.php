<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar() {
        if (!$this->email) {
            self::$errores[] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$errores[] = 'El password es obligatorio';
        }

        return self::$errores;
    }

    public function existeUsuario() {
        // Revisar si un usuario existe
        $email = self::$db->escape_string(strtolower(trim($this->email)));
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $email . "' LIMIT 1"; 

        $resultado = self::$db->query($query);

        // Depurar la consulta y el resultado
        

        if (!$resultado->num_rows) {
            self::$errores[] = 'El usuario no existe';
            return false;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado) {
        $usuario = $resultado->fetch_object();
        
        $autenticado = password_verify($this->password, $usuario->password); // Toma la contraseña que se va a comparar y la de la base de datos

        if (!$autenticado) {
            self::$errores[] = 'El password es incorrecto';
        }
        return $autenticado;
    }

    public function autenticar() {
        session_start();

        // Llenar el arreglo de session
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }

    // Método para crear un nuevo usuario administrador
    public function crearUsuario() {
        // Validar el usuario
        $this->validar();

        if (empty(self::$errores)) {
            // Hashear el password
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);

            // Crear el usuario en la base de datos
            return $this->guardar();
        }

        return false;
    }
}