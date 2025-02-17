<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Registrar errores en un archivo de registro
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../error_log.txt');
?>

<main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>

        <?php 
            $limite = 10;
            include 'listado.php';
        ?>
    </main>
    
<!-- Incluir el Botón de WhatsApp Flotante -->
<?php include __DIR__ . '/../../includes/templates/whatsapp.php'; ?>