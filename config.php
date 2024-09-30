<?php
// Función para cargar variables de entorno desde un archivo .env
function loadEnv($path) {
    // Verifica si el archivo .env existe
    if (!file_exists($path)) {
        throw new Exception("El archivo .env no existe");
    }

    // Lee el archivo .env línea por línea.
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignora las líneas que comienzan con un comentario (#)
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Divide cada línea en nombre y valor usando el signo '=' como delimitador
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name); // Elimina espacios en blanco alrededor del nombre
        $value = trim($value); // Elimina espacios en blanco alrededor del valor

        // Verifica si la variable de entorno no está ya definida en $_SERVER o $_ENV
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            // Define la variable de entorno usando putenv
            putenv(sprintf('%s=%s', $name, $value));
            // También la agrega a los arrays $_ENV y $_SERVER
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Llama a la función loadEnv con la ruta al archivo .env
loadEnv(__DIR__ . '/.env');