<?php
/**
 * Página de búsqueda de países.
 * 
 * Permite buscar países por nombre utilizando la API RestCountries.
 * Muestra los resultados con banderas e información básica.
 * Utiliza file_get_contents() para las peticiones HTTP.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 * @package WorldExplorer
 */

require_once 'functions.php';

$busqueda = '';
$resultados = null;
$error = '';

// Procesar búsqueda si se envió el formulario
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $busqueda = sanitizarEntrada($_GET['q']);
    $resultados = buscarPaisPorNombre($busqueda);

    if ($resultados === null) {
        $error = "No se encontraron países con el nombre \"$busqueda\". Intenta con otro término.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Buscar países por nombre - WorldExplorer">
    <title>Buscar País — WorldExplorer</title>
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
                <a href="buscar.php" class="active">Buscar</a>
                <a href="listado.php">Listado</a>
                <a href="comparar.php">Comparar</a>
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-title">
            <a href="index.php" class="back-link">← Volver al inicio</a>
            <h2>🔍 Buscar País</h2>
            <p>Introduce el nombre de un país para obtener su información detallada. Se utiliza <code>file_get_contents()</code> para la petición.</p>
        </section>

        <!-- Formulario de búsqueda -->
        <section class="search-section">
            <form action="buscar.php" method="GET" class="search-form" id="search-form">
                <input type="text" name="q" id="search-input" placeholder="Escribe el nombre de un país..." 
                       value="<?php echo htmlspecialchars($busqueda); ?>" required autocomplete="off">
                <button type="submit" class="btn btn-primary" id="btn-buscar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    Buscar
                </button>
            </form>
        </section>

        <?php if ($error): ?>
            <div class="message message-error fade-in"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultados !== null): ?>
            <p class="results-count fade-in"><?php echo count($resultados); ?> país(es) encontrado(s) para "<?php echo htmlspecialchars($busqueda); ?>"</p>

            <div class="countries-grid fade-in">
                <?php foreach ($resultados as $pais): ?>
                    <a href="detalle.php?code=<?php echo urlencode($pais['cca2'] ?? ''); ?>" class="country-card" id="country-<?php echo htmlspecialchars($pais['cca2'] ?? ''); ?>">
                        <img src="<?php echo htmlspecialchars($pais['flags']['png'] ?? ''); ?>" 
                             alt="Bandera de <?php echo htmlspecialchars(obtenerNombreEspanol($pais)); ?>" 
                             class="country-flag" loading="lazy">
                        <div class="country-card-body">
                            <h3><?php echo htmlspecialchars(obtenerNombreEspanol($pais)); ?></h3>
                            <div class="country-meta">
                                <span><strong>Capital:</strong> <?php echo htmlspecialchars(obtenerCapital($pais)); ?></span>
                                <span><strong>Región:</strong> <?php echo htmlspecialchars(traducirRegion($pais['region'] ?? '')); ?></span>
                                <span><strong>Población:</strong> <?php echo formatearPoblacion($pais['population'] ?? 0); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php elseif (empty($busqueda)): ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <h3>Busca un país</h3>
                <p>Escribe el nombre de cualquier país del mundo para ver su información.</p>
                <p style="margin-top: 16px; font-size: 0.85rem;">Ejemplos: Spain, France, Japan, Argentina, Mexico...</p>
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
