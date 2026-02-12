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
    'Africa'   => ['icon' => '🌍', 'desc' => 'Continente africano'],
    'Americas' => ['icon' => '🌎', 'desc' => 'Norte, Centro y Sudamérica'],
    'Asia'     => ['icon' => '🌏', 'desc' => 'Continente asiático'],
    'Europe'   => ['icon' => '🏰', 'desc' => 'Continente europeo'],
    'Oceania'  => ['icon' => '🏝️', 'desc' => 'Islas del Pacífico y Australia']
];

$regionSel = '';
$paises = null;
$error = '';

if (isset($_GET['region']) && !empty(trim($_GET['region']))) {
    $regionSel = htmlspecialchars(trim($_GET['region']));
    if (array_key_exists($regionSel, $regiones)) {
        $paises = obtenerPorRegion($regionSel);
        if ($paises === null) {
            $error = "No se pudieron cargar los datos de esta región.";
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
            <div class="logo">
                <span>✦</span> WorldExplorer
            </div>
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
        <section class="hero" style="padding-bottom: 20px;">
            <h2>Explorar por Región</h2>
            <p>Filtra los países según su continente.</p>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error" style="text-align:center; color:#ff4d4d;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (empty($regionSel) || $paises === null): ?>
            <div class="region-list">
                <?php foreach ($regiones as $nombre => $datos): ?>
                    <a href="regiones.php?region=<?php echo $nombre; ?>" class="region-strip">
                        <div class="region-name">
                            <span class="region-icon"><?php echo $datos['icon']; ?></span>
                            <div class="region-text">
                                <h3><?php echo traducirRegion($nombre); ?></h3>
                                <p><?php echo $datos['desc']; ?></p>
                            </div>
                        </div>
                        <div class="card-arrow" style="align-self: center;">→</div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align:center; margin-bottom:40px;">
                <h3 style="font-size:2rem;color:var(--accent-cyan); display:inline-block; border-bottom:2px solid var(--accent-cyan); padding-bottom:8px;">
                    <?php echo traducirRegion($regionSel); ?>
                </h3>
                <p style="margin-top:16px; color:var(--text-secondary);"><?php echo count($paises); ?> países en esta región</p>
                <a href="regiones.php" style="display:inline-block; margin-top:20px; color:white; background:rgba(255,255,255,0.1); padding:8px 16px; border-radius:20px; font-size:0.9rem;">
                    ← Elegir otra región
                </a>
            </div>

            <div class="country-grid">
                <?php foreach ($paises as $pais): ?>
                    <a href="detalle.php?code=<?php echo $pais['cca2'] ?? ''; ?>" class="country-item">
                        <img src="<?php echo $pais['flags']['png'] ?? ''; ?>" alt="Bandera" class="country-flag">
                        <div class="country-info">
                            <h3 style="font-size:1.2rem;"><?php echo nombreEspanol($pais); ?></h3>
                            <div class="country-details">
                                <span style="font-weight:600;color:var(--accent-cyan);"><?php echo obtenerCapital($pais); ?></span>
                                <span><?php echo formatearNumero($pais['population'] ?? 0); ?> habitantes</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>WorldExplorer — Tarea 9 DEWS — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
