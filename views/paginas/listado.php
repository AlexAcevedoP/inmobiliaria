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
$barrio = $_GET['barrio'] ?? '';

// Construir la consulta SQL
$query = "SELECT * FROM propiedades WHERE 1=1";

if ($precio) {
    $query .= " AND precio <= " . intval($precio);
}

if ($habitaciones) {
    $query .= " AND habitaciones >= " . intval($habitaciones);
}

if ($wc) {
    $query .= " AND wc >= " . intval($wc);
}

if ($estacionamiento) {
    $query .= " AND estacionamiento >= " . intval($estacionamiento);
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

if ($barrio) {
    $query .= " AND barrio LIKE '%" . $db->escape_string($barrio) . "%'";
}

// Ejecutar la consulta
$resultado = $db->query($query);

$propiedades = [];
if ($resultado->num_rows) {
    while ($propiedad = $resultado->fetch_object()) {
        $propiedades[] = $propiedad;
    }
}
?>

<main class="contenedor seccion">
    <h1>Listado de Propiedades</h1>

    <form class="formulario" method="GET">
        <fieldset class="filtros" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;">
            <legend>Filtrar por:</legend>

            <div style="grid-column: span 1;">
                <label for="precio">Precio hasta:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo s($precio); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($habitaciones); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($wc); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($estacionamiento); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="municipio">Municipio:</label>
                <input type="text" id="municipio" name="municipio" placeholder="Municipio" value="<?php echo s($municipio); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="departamento">Departamento:</label>
                <input type="text" id="departamento" name="departamento" placeholder="Departamento" value="<?php echo s($departamento); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="metros_min">Metros Cuadrados Mínimos:</label>
                <input type="number" id="metros_min" name="metros_min" placeholder="Ej: 50" min="1" value="<?php echo s($metros_min); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="metros_max">Metros Cuadrados Máximos:</label>
                <input type="number" id="metros_max" name="metros_max" placeholder="Ej: 200" min="1" value="<?php echo s($metros_max); ?>">
            </div>

            <div style="grid-column: span 1;">
                <label for="barrio">Barrio:</label>
                <input type="text" id="barrio" name="barrio" placeholder="Barrio" value="<?php echo s($barrio); ?>">
            </div>

            <div style="grid-column: span 5; justify-self: center;">
                <input type="submit" value="Buscar" class="boton boton-verde">
            </div>
        </fieldset>
    </form>

    <div class="contenedor-anuncios">
        <?php foreach ($propiedades as $propiedad) : ?>
            <div class="anuncio">
                <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">

                <div class="contenido-anuncio">
                    <h3><?php echo $propiedad->titulo; ?></h3>
                    <p><?php echo $propiedad->descripcion; ?></p>
                    <p class="precio"><?php echo $propiedad->precio; ?></p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                            <p><?php echo $propiedad->wc; ?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p><?php echo $propiedad->estacionamiento; ?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                            <p><?php echo $propiedad->habitaciones; ?></p>
                        </li>
                    </ul>

                    <a href="/propiedad?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">

                        Ver Propiedad
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>