<?php
/**
 * Página de listado completo de países.
 * 
 * Muestra todos los países del mundo con paginación.
 * Utiliza cURL para obtener el listado de la API.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 * @package WorldExplorer
 */

require_once 'functions.php';

/** @var int Número de países por página */
$porPagina = 20;

/** @var int Página actual */
$paginaActual = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$todos = obtenerTodosLosPaises();
$error = '';

if ($todos === null) {
    $error = "No se pudieron cargar los países. Inténtalo de nuevo más tarde.";
    $todos = [];
}

// Ordenar por nombre
usort($todos, function($a, $b) {
    $nombreA = $a['name']['common'] ?? '';
    $nombreB = $b['name']['common'] ?? '';
    return strcmp($nombreA, $nombreB);
});

/** @var int Total de países */
$totalPaises = count($todos);

/** @var int Total de páginas */
$totalPaginas = ceil($totalPaises / $porPagina);

// Validar página actual
$paginaActual = min($paginaActual, $totalPaginas);

/** @var int Offset para la paginación */
$offset = ($paginaActual - 1) * $porPagina;

/** @var array Países de la página actual */
$paisesEnPagina = array_slice($todos, $offset, $porPagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Listado completo de países del mundo - WorldExplorer">
    <title>Listado de Países — WorldExplorer</title>
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
                <a href="listado.php" class="active">Listado</a>
                <a href="comparar.php">Comparar</a>
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-title">
            <a href="index.php" class="back-link">← Volver al inicio</a>
            <h2>📋 Listado de Países</h2>
            <p>Todos los países del mundo ordenados alfabéticamente. Se utiliza <code>cURL</code> para la petición a la API.</p>
        </section>

        <?php if ($error): ?>
            <div class="message message-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($paisesEnPagina)): ?>
            <p class="results-count fade-in">
                Mostrando <?php echo $offset + 1; ?>–<?php echo min($offset + $porPagina, $totalPaises); ?> de <?php echo $totalPaises; ?> países
                (Página <?php echo $paginaActual; ?> de <?php echo $totalPaginas; ?>)
            </p>

            <div class="countries-grid fade-in">
                <?php foreach ($paisesEnPagina as $pais): ?>
                    <a href="detalle.php?code=<?php echo urlencode($pais['cca2'] ?? ''); ?>" class="country-card" id="country-<?php echo htmlspecialchars($pais['cca2'] ?? ''); ?>">
                        <img src="<?php echo htmlspecialchars($pais['flags']['png'] ?? ''); ?>" 
                             alt="Bandera de <?php echo htmlspecialchars($pais['name']['common'] ?? ''); ?>"
                             class="country-flag" loading="lazy">
                        <div class="country-card-body">
                            <h3><?php echo htmlspecialchars($pais['name']['common'] ?? 'Desconocido'); ?></h3>
                            <div class="country-meta">
                                <span><strong>Capital:</strong> <?php echo htmlspecialchars(implode(', ', $pais['capital'] ?? ['N/A'])); ?></span>
                                <span><strong>Región:</strong> <?php echo htmlspecialchars(traducirRegion($pais['region'] ?? '')); ?></span>
                                <span><strong>Población:</strong> <?php echo formatearPoblacion($pais['population'] ?? 0); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Paginación -->
            <?php if ($totalPaginas > 1): ?>
                <nav class="pagination" id="pagination">
                    <?php if ($paginaActual > 1): ?>
                        <a href="?page=1">« Primera</a>
                        <a href="?page=<?php echo $paginaActual - 1; ?>">‹ Anterior</a>
                    <?php else: ?>
                        <span class="disabled">« Primera</span>
                        <span class="disabled">‹ Anterior</span>
                    <?php endif; ?>

                    <?php
                    $inicio = max(1, $paginaActual - 2);
                    $fin = min($totalPaginas, $paginaActual + 2);
                    for ($i = $inicio; $i <= $fin; $i++):
                    ?>
                        <?php if ($i == $paginaActual): ?>
                            <span class="active"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($paginaActual < $totalPaginas): ?>
                        <a href="?page=<?php echo $paginaActual + 1; ?>">Siguiente ›</a>
                        <a href="?page=<?php echo $totalPaginas; ?>">Última »</a>
                    <?php else: ?>
                        <span class="disabled">Siguiente ›</span>
                        <span class="disabled">Última »</span>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
        </div>
    </footer>
</body>
</html>
