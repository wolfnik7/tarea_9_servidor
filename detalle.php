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
        $error = "No se encontró el país con código \"$codigo\".";
    }
} else {
    $error = "No se especificó un código de país.";
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
            <h1>🌍 World<span>Explorer</span></h1>
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
        <section class="page-title">
            <a href="javascript:history.back()" class="back-link">← Volver</a>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($pais): ?>
            <div class="country-detail">
                <div class="detail-flag">
                    <img src="<?php echo $pais['flags']['svg'] ?? $pais['flags']['png']; ?>" 
                         alt="Bandera de <?php echo nombreEspanol($pais); ?>">
                </div>
                <div class="detail-info">
                    <h2><?php echo nombreEspanol($pais); ?></h2>
                    <p class="detail-subtitle"><?php echo $pais['name']['official'] ?? ''; ?></p>

                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="label">Capital</div>
                            <div class="value"><?php echo obtenerCapital($pais); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Región</div>
                            <div class="value"><?php echo traducirRegion($pais['region'] ?? ''); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Subregión</div>
                            <div class="value"><?php echo $pais['subregion'] ?? 'N/A'; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Población</div>
                            <div class="value"><?php echo formatearNumero($pais['population'] ?? 0); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Área</div>
                            <div class="value"><?php echo isset($pais['area']) ? formatearNumero((int)$pais['area']) . ' km²' : 'N/A'; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Zona horaria</div>
                            <div class="value"><?php echo implode(', ', $pais['timezones'] ?? ['N/A']); ?></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="label">Idiomas</div>
                            <div class="value"><?php echo obtenerIdiomas($pais); ?></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="label">Monedas</div>
                            <div class="value"><?php echo obtenerMonedas($pais); ?></div>
                        </div>
                    </div>

                    <?php if (isset($pais['maps']['googleMaps'])): ?>
                        <a href="<?php echo $pais['maps']['googleMaps']; ?>" target="_blank" class="map-link">📍 Ver en Google Maps →</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
