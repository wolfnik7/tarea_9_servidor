<?php
/**
 * Página de detalle de un país.
 * 
 * Muestra información completa de un país seleccionado.
 * Utiliza cURL para obtener los datos del país por su código alfa.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 * @package WorldExplorer
 */

require_once 'functions.php';

$pais = null;
$error = '';

if (isset($_GET['code']) && !empty(trim($_GET['code']))) {
    $codigo = sanitizarEntrada($_GET['code']);
    $pais = obtenerPaisPorCodigo($codigo);

    if ($pais === null) {
        $error = "No se pudo obtener la información del país con código \"$codigo\".";
    }
} else {
    $error = "No se especificó un código de país válido.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detalle del país - WorldExplorer">
    <title><?php echo $pais ? htmlspecialchars(obtenerNombreEspanol($pais)) : 'País no encontrado'; ?> — WorldExplorer</title>
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
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-title">
            <a href="javascript:history.back()" class="back-link">← Volver</a>

            <?php if ($error): ?>
                <div class="message message-error"><?php echo $error; ?></div>
            <?php endif; ?>
        </section>

        <?php if ($pais): ?>
            <div class="country-detail fade-in">
                <div class="country-detail-flag">
                    <img src="<?php echo htmlspecialchars($pais['flags']['svg'] ?? $pais['flags']['png'] ?? ''); ?>" 
                         alt="Bandera de <?php echo htmlspecialchars(obtenerNombreEspanol($pais)); ?>">
                </div>
                <div class="country-detail-info">
                    <h2><?php echo htmlspecialchars(obtenerNombreEspanol($pais)); ?></h2>
                    <p class="detail-subtitle"><?php echo htmlspecialchars($pais['name']['official'] ?? ''); ?></p>

                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="label">Capital</div>
                            <div class="value"><?php echo htmlspecialchars(obtenerCapital($pais)); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Región</div>
                            <div class="value"><?php echo htmlspecialchars(traducirRegion($pais['region'] ?? '')); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Subregión</div>
                            <div class="value"><?php echo htmlspecialchars($pais['subregion'] ?? 'No disponible'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Población</div>
                            <div class="value"><?php echo formatearPoblacion($pais['population'] ?? 0); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Área</div>
                            <div class="value"><?php echo isset($pais['area']) ? formatearPoblacion((int)$pais['area']) . ' km²' : 'No disponible'; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Zona Horaria</div>
                            <div class="value"><?php echo htmlspecialchars(implode(', ', $pais['timezones'] ?? ['No disponible'])); ?></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="label">Idiomas</div>
                            <div class="value"><?php echo htmlspecialchars(obtenerIdiomas($pais)); ?></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="label">Monedas</div>
                            <div class="value"><?php echo htmlspecialchars(obtenerMonedas($pais)); ?></div>
                        </div>
                        <?php if (isset($pais['borders']) && !empty($pais['borders'])): ?>
                            <div class="detail-item full-width">
                                <div class="label">Países Fronterizos</div>
                                <div class="value"><?php echo htmlspecialchars(implode(', ', $pais['borders'])); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($pais['maps']['googleMaps'])): ?>
                        <a href="<?php echo htmlspecialchars($pais['maps']['googleMaps']); ?>" target="_blank" rel="noopener noreferrer" class="map-link">
                            📍 Ver en Google Maps →
                        </a>
                    <?php endif; ?>
                </div>
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
