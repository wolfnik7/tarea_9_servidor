<?php
/**
 * Página de listado de países con paginación.
 * 
 * Muestra todos los países usando cURL.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 */

require_once 'functions.php';

$porPagina = 20;
$paginaActual = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$todos = obtenerTodos();
$error = '';

if ($todos === null) {
    $error = "No se pudieron cargar los países.";
    $todos = [];
}

// Ordenar por nombre
usort($todos, function($a, $b) {
    return strcmp($a['name']['common'] ?? '', $b['name']['common'] ?? '');
});

$totalPaises = count($todos);
$totalPaginas = ceil($totalPaises / $porPagina);
$paginaActual = min($paginaActual, max(1, $totalPaginas));
$offset = ($paginaActual - 1) * $porPagina;
$paisesPagina = array_slice($todos, $offset, $porPagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado — WorldExplorer</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🌍 World<span>Explorer</span></h1>
            <nav>
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
            <a href="index.php" class="back-link">← Volver</a>
            <h2>📋 Listado de Países</h2>
            <p>Todos los países ordenados alfabéticamente. Se usa <code>cURL</code>.</p>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($paisesPagina)): ?>
            <p class="results-count">
                Mostrando <?php echo $offset + 1; ?>–<?php echo min($offset + $porPagina, $totalPaises); ?> 
                de <?php echo $totalPaises; ?> países (Pág. <?php echo $paginaActual; ?>/<?php echo $totalPaginas; ?>)
            </p>

            <div class="countries-grid">
                <?php foreach ($paisesPagina as $pais): ?>
                    <a href="detalle.php?code=<?php echo $pais['cca2'] ?? ''; ?>" class="country-card">
                        <img src="<?php echo $pais['flags']['png'] ?? ''; ?>" alt="Bandera" class="country-flag">
                        <div class="country-card-body">
                            <h3><?php echo $pais['name']['common'] ?? 'Desconocido'; ?></h3>
                            <div class="country-meta">
                                <span><strong>Capital:</strong> <?php echo implode(', ', $pais['capital'] ?? ['N/A']); ?></span>
                                <span><strong>Población:</strong> <?php echo formatearNumero($pais['population'] ?? 0); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPaginas > 1): ?>
                <nav class="pagination">
                    <?php if ($paginaActual > 1): ?>
                        <a href="?page=<?php echo $paginaActual - 1; ?>">← Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $paginaActual - 2); $i <= min($totalPaginas, $paginaActual + 2); $i++): ?>
                        <?php if ($i == $paginaActual): ?>
                            <span class="active"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($paginaActual < $totalPaginas): ?>
                        <a href="?page=<?php echo $paginaActual + 1; ?>">Siguiente →</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer>
        <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
