<?php
// Incluye el archivo config.php para cargar las variables de entorno
require_once __DIR__ . '/../../config.php';

// Función para conectar a la base de datos
function conectarDB() : mysqli {
    // Determinar el entorno
    $isLocal = ($_SERVER['SERVER_NAME'] === 'localhost');

    // Configuración de la base de datos
    $dbHost = $isLocal ? getenv('DB_HOST_LOCAL') : getenv('DB_HOST_PROD');
    $dbUser = $isLocal ? getenv('DB_USER_LOCAL') : getenv('DB_USER_PROD');
    $dbPass = $isLocal ? getenv('DB_PASS_LOCAL') : getenv('DB_PASS_PROD');
    $dbName = $isLocal ? getenv('DB_NAME_LOCAL') : getenv('DB_NAME_PROD');

    // Conectar a la base de datos
    $db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // Verificar si hay errores de conexión
    if ($db->connect_error) {
        echo "Error de conexión: " . $db->connect_error;
        exit;
    }

    return $db;
}