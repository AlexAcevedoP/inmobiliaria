<!-- FILE: views/paginas/listado.php -->
<?php
require_once __DIR__ . '/../../includes/config/database.php';
$db = conectarDB();

// Obtener los valores del formulario
$precio = $_GET['precio'] ?? '';
$habitaciones = $_GET['habitaciones'] ?? '';
$wc = $_GET['wc'] ?? '';
$estacionamiento = $_GET['estacionamiento'] ?? '';
$municipio = $_GET['municipio'] ?? '';
$departamento = $_GET['departamento'] ?? '';
$metros_min = $_GET['metros_min'] ?? '';
$metros_max = $_GET['metros_max'] ?? '';

// Construir la consulta SQL
$query = "SELECT * FROM propiedades WHERE 1=1";

if ($precio) {
    $query .= " AND precio <= " . intval($precio);
}

if ($habitaciones) {
    $query .= " AND habitaciones = " . intval($habitaciones);
}

if ($wc) {
    $query .= " AND wc = " . intval($wc);
}

if ($estacionamiento) {
    $query .= " AND estacionamiento = " . intval($estacionamiento);
}

if ($municipio) {
    $query .= " AND municipio LIKE '%" . $db->escape_string($municipio) . "%'";
}

if ($departamento) {
    $query .= " AND departamento LIKE '%" . $db->escape_string($departamento) . "%'";
}
if ($metros_min) {
    $query .= " AND metros_cuadrados >= " . intval($metros_min);
}

if ($metros_max) {
    $query .= " AND metros_cuadrados <= " . intval($metros_max);
}

$resultado = $db->query($query);

$propiedades = [];
if ($resultado->num_rows) {
    while ($propiedad = $resultado->fetch_object()) {
        $propiedades[] = $propiedad;
    }
}
?>

<!-- Formulario de Filtro -->
<form  method="GET" class="formulario-filtro" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
    <div class="campo">
        <label for="precio">Precio Máximo:</label>
        <input type="number" id="precio" name="precio" placeholder="Ej. 500000">
    </div>

    <div class="campo">
        <label for="habitaciones">Habitaciones:</label>
        <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3">
    </div>

    <div class="campo">
        <label for="wc">Baños:</label>
        <input type="number" id="wc" name="wc" placeholder="Ej. 2">
    </div>

    <div class="campo">
        <label for="estacionamiento">Estacionamiento:</label>
        <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 1">
    </div>

    <div class="campo">
        <label for="municipio">Municipio:</label>
        <input type="text" id="municipio" name="municipio" placeholder="Ej. Medellín">
    </div>

    <div class="campo">
        <label for="departamento">Departamento:</label>
        <input type="text" id="departamento" name="departamento" placeholder="Ej. Antioquia">
    </div>

    <div class="campo">
        <label for="metros_min">Metros Cuadrados (Desde):</label>
        <input type="number" id="metros_min" name="metros_min" placeholder="Ej. 50">
    </div>

    <div class="campo">
        <label for="metros_max">Metros Cuadrados (Hasta):</label>
        <input type="number" id="metros_max" name="metros_max" placeholder="Ej. 200">
    </div>

    <input type="submit" value="Buscar" class="boton-verde">
</form>

<!-- Resultados de la Búsqueda -->
<div class="contenedor-anuncios">
    <?php foreach ($propiedades as $propiedad): ?>
        <div class="anuncio">
            <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">

            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo; ?></h3>
                <p><?php echo nl2br($propiedad->descripcion); ?></p>
                <p class="precio">$<?php echo number_format($propiedad->precio, 0, ',', '.'); ?></p>
                <span class="metros-cuadrados"><?php echo $propiedad->metros_cuadrados; ?> m²</span>
            </p>
           
               
                

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="/build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad->wc; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="/build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?php echo $propiedad->estacionamiento; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="/build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?php echo $propiedad->habitaciones; ?></p>
                    </li>                    
                </ul>

                <a href="/propiedad?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div><!--.contenido-anuncio-->
        </div><!--anuncio-->
    <?php endforeach; ?>
</div> <!--.contenedor-anuncios-->