<?php
/**
 * Country Detail Page
 * Aurora Design
 */
require_once 'functions.php';

$pais = null;
$error = '';

if (isset($_GET['code']) && !empty(trim($_GET['code']))) {
    $codigo = htmlspecialchars(trim($_GET['code']));
    $pais = obtenerPorCodigo($codigo);
    if ($pais === null) {
        $error = "Could not locate country data.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail — WorldExplorer</title>
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
                <a href="regiones.php">Regions</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero" style="padding-bottom: 20px;">
            <a href="javascript:history.back()" style="color:var(--accent-cyan); font-weight:600;">← Back to Map</a>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($pais): ?>
            <div class="detail-hero">
                <img src="<?php echo $pais['flags']['svg'] ?? $pais['flags']['png']; ?>" 
                     alt="National Flag" class="flag-large">
                
                <div class="detail-content">
                    <span class="tag" style="font-size:1rem; border:1px solid var(--accent-cyan); color:var(--text-main); background:transparent;">Code: <?php echo $pais['cca2'] ?? ''; ?></span>
                    <h1 style="margin-top:16px;"><?php echo nombreEspanol($pais); ?></h1>
                    <p class="detail-subtitle"><?php echo $pais['name']['official'] ?? ''; ?></p>
                    
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-label">Capital City</div>
                            <div class="stat-value"><?php echo obtenerCapital($pais); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Population</div>
                            <div class="stat-value"><?php echo formatearNumero($pais['population'] ?? 0); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Region</div>
                            <div class="stat-value"><?php echo traducirRegion($pais['region'] ?? ''); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Subregion</div>
                            <div class="stat-value"><?php echo $pais['subregion'] ?? '—'; ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Land Area</div>
                            <div class="stat-value"><?php echo isset($pais['area']) ? formatearNumero((int)$pais['area']) . ' km²' : '—'; ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Languages</div>
                            <div class="stat-value" style="font-size:1rem;"><?php echo obtenerIdiomas($pais); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Currencies</div>
                            <div class="stat-value" style="font-size:1rem;"><?php echo obtenerMonedas($pais); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Timezones</div>
                            <div class="stat-value" style="font-size:0.9rem;"><?php echo explode(',', implode(', ', $pais['timezones'] ?? []))[0]; ?>...</div>
                        </div>
                    </div>

                    <?php if (isset($pais['maps']['googleMaps'])): ?>
                        <a href="<?php echo $pais['maps']['googleMaps']; ?>" target="_blank" 
                           style="display:inline-block; margin-top:32px; color:var(--accent-cyan); font-weight:700; border-bottom:1px dashed var(--accent-cyan);">
                           View Satellite Map →
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>WorldExplorer Project — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
