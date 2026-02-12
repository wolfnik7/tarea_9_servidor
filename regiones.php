<?php
/**
 * Página de exploración por regiones.
 * 
 * Muestra países por región usando file_get_contents().
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 */

require_once 'functions.php';

$regiones = [
    'Africa'   => ['emoji' => '🌍', 'desc' => 'Continente africano'],
    'Americas' => ['emoji' => '🌎', 'desc' => 'Norte, Centro y Sur América'],
    'Asia'     => ['emoji' => '🌏', 'desc' => 'Continente asiático'],
    'Europe'   => ['emoji' => '🏰', 'desc' => 'Continente europeo'],
    'Oceania'  => ['emoji' => '🏝️', 'desc' => 'Islas del Pacífico']
];

$regionSel = '';
$paises = null;
$error = '';

if (isset($_GET['region']) && !empty(trim($_GET['region']))) {
    $regionSel = htmlspecialchars(trim($_GET['region']));
    if (array_key_exists($regionSel, $regiones)) {
        $paises = obtenerPorRegion($regionSel);
        if ($paises === null) {
            $error = "No se pudieron cargar los países de esa región.";
        } else {
            usort($paises, function($a, $b) {
                return strcmp(nombreEspanol($a), nombreEspanol($b));
            });
        }
    } else {
        $error = "Región no válida.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regiones — WorldExplorer</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🌍 World<span>Explorer</span></h1>
            <nav>
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
            <a href="<?php echo $regionSel ? 'regiones.php' : 'index.php'; ?>" class="back-link">← Volver</a>
            <h2>🌐 Regiones</h2>
            <p>Países por región usando <code>file_get_contents()</code>.</p>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (empty($regionSel) || $paises === null): ?>
            <div class="regions-grid">
                <?php foreach ($regiones as $nombre => $datos): ?>
                    <a href="regiones.php?region=<?php echo $nombre; ?>" class="region-card">
                        <div class="region-emoji"><?php echo $datos['emoji']; ?></div>
                        <h3><?php echo traducirRegion($nombre); ?></h3>
                        <p><?php echo $datos['desc']; ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mensaje-info">
                <?php echo $regiones[$regionSel]['emoji']; ?>
                <strong><?php echo traducirRegion($regionSel); ?></strong>
                — <?php echo count($paises); ?> países
            </div>

            <div class="countries-grid">
                <?php foreach ($paises as $pais): ?>
                    <a href="detalle.php?code=<?php echo $pais['cca2'] ?? ''; ?>" class="country-card">
                        <img src="<?php echo $pais['flags']['png'] ?? ''; ?>" alt="Bandera" class="country-flag">
                        <div class="country-card-body">
                            <h3><?php echo nombreEspanol($pais); ?></h3>
                            <div class="country-meta">
                                <span><strong>Capital:</strong> <?php echo obtenerCapital($pais); ?></span>
                                <span><strong>Población:</strong> <?php echo formatearNumero($pais['population'] ?? 0); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
