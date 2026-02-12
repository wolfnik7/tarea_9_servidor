<?php
/**
 * Página de detalle de un país.
 * 
 * Muestra información completa usando cURL.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 */
require_once 'functions.php';

$pais = null;
$error = '';

if (isset($_GET['code']) && !empty(trim($_GET['code']))) {
    $codigo = htmlspecialchars(trim($_GET['code']));
    $pais = obtenerPorCodigo($codigo);
    if ($pais === null) {
        $error = "No se pudo encontrar el país solicitado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pais ? nombreEspanol($pais) : 'Error'; ?> — WorldExplorer</title>
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
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero" style="padding-bottom: 20px;">
            <a href="javascript:history.back()" style="color:var(--accent-cyan); font-weight:600;">← Volver</a>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error" style="text-align:center; color:#ff4d4d;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($pais): ?>
            <div class="detail-hero">
                <img src="<?php echo $pais['flags']['svg'] ?? $pais['flags']['png']; ?>" 
                     alt="Bandera" class="flag-large">
                
                <div class="detail-content">
                    <span class="tag" style="font-size:1rem; border:1px solid var(--accent-cyan); color:var(--text-main); background:transparent;">Código: <?php echo $pais['cca2'] ?? ''; ?></span>
                    <h1 style="margin-top:16px;"><?php echo nombreEspanol($pais); ?></h1>
                    <p class="detail-subtitle"><?php echo $pais['name']['official'] ?? ''; ?></p>
                    
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-label">Capital</div>
                            <div class="stat-value"><?php echo obtenerCapital($pais); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Población</div>
                            <div class="stat-value"><?php echo formatearNumero($pais['population'] ?? 0); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Región</div>
                            <div class="stat-value"><?php echo traducirRegion($pais['region'] ?? ''); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Subregión</div>
                            <div class="stat-value"><?php echo $pais['subregion'] ?? '—'; ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Superficie</div>
                            <div class="stat-value"><?php echo isset($pais['area']) ? formatearNumero((int)$pais['area']) . ' km²' : '—'; ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Idiomas</div>
                            <div class="stat-value" style="font-size:1rem;"><?php echo obtenerIdiomas($pais); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Monedas</div>
                            <div class="stat-value" style="font-size:1rem;"><?php echo obtenerMonedas($pais); ?></div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Zona Horaria</div>
                            <div class="stat-value" style="font-size:0.9rem;"><?php echo implode(', ', $pais['timezones'] ?? ['—']); ?></div>
                        </div>
                    </div>

                    <?php if (isset($pais['maps']['googleMaps'])): ?>
                        <a href="<?php echo $pais['maps']['googleMaps']; ?>" target="_blank" 
                           style="display:inline-block; margin-top:32px; color:var(--accent-cyan); font-weight:700; border-bottom:1px dashed var(--accent-cyan);">
                           📍 Ver en Google Maps →
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>WorldExplorer — Tarea 9 DEWS — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
