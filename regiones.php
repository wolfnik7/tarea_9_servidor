<?php
/**
 * Página de exploración por regiones.
 * 
 * Permite explorar los países organizados por regiones del mundo.
 * Utiliza file_get_contents() para obtener los datos de la API.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 * @package WorldExplorer
 */

require_once 'functions.php';

/** @var array Regiones disponibles con emojis y descripciones */
$regiones = [
    'Africa'   => ['emoji' => '🌍', 'desc' => 'El continente africano con más de 50 países'],
    'Americas' => ['emoji' => '🌎', 'desc' => 'América del Norte, Central y del Sur'],
    'Asia'     => ['emoji' => '🌏', 'desc' => 'El continente más grande y poblado'],
    'Europe'   => ['emoji' => '🏰', 'desc' => 'El viejo continente con rica historia'],
    'Oceania'  => ['emoji' => '🏝️', 'desc' => 'Islas y países del Pacífico']
];

$regionSeleccionada = '';
$paisesRegion = null;
$error = '';

if (isset($_GET['region']) && !empty(trim($_GET['region']))) {
    $regionSeleccionada = sanitizarEntrada($_GET['region']);

    if (array_key_exists($regionSeleccionada, $regiones)) {
        $paisesRegion = obtenerPaisesPorRegion($regionSeleccionada);

        if ($paisesRegion === null) {
            $error = "No se pudieron cargar los países de la región \"$regionSeleccionada\".";
        } else {
            // Ordenar por nombre
            usort($paisesRegion, function($a, $b) {
                return strcmp(
                    obtenerNombreEspanol($a),
                    obtenerNombreEspanol($b)
                );
            });
        }
    } else {
        $error = "La región especificada no es válida.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explorar países por regiones del mundo - WorldExplorer">
    <title>Regiones del Mundo — WorldExplorer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="bg-animation"></div>

    <header class="main-header">
        <div class="container">
            <div class="logo">
                <div class="logo-icon">🌍</div>
                <h1>World<span class="accent">Explorer</span></h1>
            </div>
            <nav class="main-nav">
                <a href="index.php">Inicio</a>
                <a href="buscar.php">Buscar</a>
                <a href="listado.php">Listado</a>
                <a href="comparar.php">Comparar</a>
                <a href="regiones.php" class="active">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-title">
            <a href="<?php echo $regionSeleccionada ? 'regiones.php' : 'index.php'; ?>" class="back-link">← Volver</a>
            <h2>🌐 Explorar por Regiones</h2>
            <p>Descubre los países organizados por regiones del mundo. Se utiliza <code>file_get_contents()</code> para la petición.</p>
        </section>

        <?php if ($error): ?>
            <div class="message message-error fade-in"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (empty($regionSeleccionada) || $paisesRegion === null): ?>
            <!-- Grid de regiones -->
            <div class="regions-grid fade-in">
                <?php foreach ($regiones as $nombre => $datos): ?>
                    <a href="regiones.php?region=<?php echo urlencode($nombre); ?>" class="region-card" id="region-<?php echo strtolower($nombre); ?>">
                        <div class="region-emoji"><?php echo $datos['emoji']; ?></div>
                        <h3><?php echo htmlspecialchars(traducirRegion($nombre)); ?></h3>
                        <p><?php echo htmlspecialchars($datos['desc']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Países de la región seleccionada -->
            <div class="message message-info fade-in">
                <?php echo $regiones[$regionSeleccionada]['emoji'] ?? '🌐'; ?>
                <strong><?php echo htmlspecialchars(traducirRegion($regionSeleccionada)); ?></strong> 
                — <?php echo count($paisesRegion); ?> países encontrados
            </div>

            <div class="countries-grid fade-in">
                <?php foreach ($paisesRegion as $pais): ?>
                    <a href="detalle.php?code=<?php echo urlencode($pais['cca2'] ?? ''); ?>" class="country-card" id="country-<?php echo htmlspecialchars($pais['cca2'] ?? ''); ?>">
                        <img src="<?php echo htmlspecialchars($pais['flags']['png'] ?? ''); ?>" 
                             alt="Bandera de <?php echo htmlspecialchars(obtenerNombreEspanol($pais)); ?>"
                             class="country-flag" loading="lazy">
                        <div class="country-card-body">
                            <h3><?php echo htmlspecialchars(obtenerNombreEspanol($pais)); ?></h3>
                            <div class="country-meta">
                                <span><strong>Capital:</strong> <?php echo htmlspecialchars(obtenerCapital($pais)); ?></span>
                                <span><strong>Población:</strong> <?php echo formatearPoblacion($pais['population'] ?? 0); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
        </div>
    </footer>
</body>
</html>
