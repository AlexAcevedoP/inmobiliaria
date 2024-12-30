<?php
// Ruta donde se guardarán las imágenes
$targetDir = __DIR__ . '/../public/imagenes/';
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Verificar si el archivo es una imagen real
$check = getimagesize($_FILES["file"]["tmp_name"]);
if ($check !== false) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Devolver la URL de la imagen subida
        echo json_encode(['location' => '/imagenes/' . basename($_FILES["file"]["name"])]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al subir la imagen.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'El archivo no es una imagen.']);
}
?>