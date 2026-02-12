<?php
/**
 * Regions Explorer
 * Aurora Design
 */
require_once 'functions.php';

$regiones = [
    'Africa'   => ['icon' => '🌍', 'desc' => 'The African Continent'],
    'Americas' => ['icon' => '🌎', 'desc' => 'North, Central & South America'],
    'Asia'     => ['icon' => '🌏', 'desc' => 'The Asian Continent'],
    'Europe'   => ['icon' => '🏰', 'desc' => 'The European Continent'],
    'Oceania'  => ['icon' => '🏝️', 'desc' => 'Pacific Islands & Australia']
];

$regionSel = '';
$paises = null;
$error = '';

if (isset($_GET['region']) && !empty(trim($_GET['region']))) {
    $regionSel = htmlspecialchars(trim($_GET['region']));
    if (array_key_exists($regionSel, $regiones)) {
        $paises = obtenerPorRegion($regionSel);
        if ($paises === null) {
            $error = "Failed to load region data.";
        } else {
            usort($paises, function($a, $b) {
                return strcmp(nombreEspanol($a), nombreEspanol($b));
            });
        }
    } else {
        $error = "Invalid region selected.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regions — WorldExplorer</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <span>✦</span> WorldExplorer
            </div>
            <nav>
                <a href="index.php">Home</a>
                <a href="buscar.php">Search</a>
                <a href="listado.php">Discover</a>
                <a href="comparar.php">Compare</a>
                <a href="regiones.php" class="active">Regions</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero" style="padding-bottom: 20px;">
            <h2>Explore by Region</h2>
            <p>Filter nations by their continental location.</p>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
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
                <p style="margin-top:16px; color:var(--text-secondary);"><?php echo count($paises); ?> nations in this region</p>
                <a href="regiones.php" style="display:inline-block; margin-top:20px; color:white; background:rgba(255,255,255,0.1); padding:8px 16px; border-radius:20px; font-size:0.9rem;">
                    ← Choose another region
                </a>
            </div>

            <div class="country-grid">
                <?php foreach ($paises as $pais): ?>
                    <a href="detalle.php?code=<?php echo $pais['cca2'] ?? ''; ?>" class="country-item">
                        <img src="<?php echo $pais['flags']['png'] ?? ''; ?>" alt="Flag" class="country-flag">
                        <div class="country-info">
                            <h3 style="font-size:1.2rem;"><?php echo nombreEspanol($pais); ?></h3>
                            <div class="country-details">
                                <span style="font-weight:600;color:var(--accent-cyan);"><?php echo obtenerCapital($pais); ?></span>
                                <span><?php echo formatearNumero($pais['population'] ?? 0); ?> people</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>WorldExplorer Project — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
