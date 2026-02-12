<?php
/**
 * Global Atlas
 * Aurora Design
 */
require_once 'functions.php';

$porPagina = 20;
$paginaActual = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$todos = obtenerTodos();
$error = '';

if ($todos === null) {
    $error = "Unable to fetch global data.";
    $todos = [];
}

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas — WorldExplorer</title>
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
                <a href="listado.php" class="active">Discover</a>
                <a href="comparar.php">Compare</a>
                <a href="regiones.php">Regions</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero" style="padding-bottom: 20px;">
            <h2>The Global Atlas</h2>
            <p>A comprehensive directory of <?php echo $totalPaises; ?> nations.</p>
        </section>

        <?php if ($error): ?>
            <div class="mensaje-error" style="text-align:center;color:#ff4d4d;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($paisesPagina)): ?>
            <p style="text-align:center; color:var(--text-secondary); margin-bottom:40px;">
                Page <?php echo $paginaActual; ?> of <?php echo $totalPaginas; ?>
            </p>

            <div class="country-grid">
                <?php foreach ($paisesPagina as $pais): ?>
                    <a href="detalle.php?code=<?php echo $pais['cca2'] ?? ''; ?>" class="country-item">
                        <img src="<?php echo $pais['flags']['png'] ?? ''; ?>" alt="Flag" class="country-flag">
                        <div class="country-info">
                            <h3 style="font-size:1.2rem;"><?php echo $pais['name']['common'] ?? 'Unknown'; ?></h3>
                            <div class="country-details">
                                <span style="font-weight:600;color:var(--text-main);"><?php echo traducirRegion($pais['region'] ?? ''); ?></span>
                                <span><?php echo implode(', ', array_slice($pais['capital'] ?? [], 0, 1)); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPaginas > 1): ?>
                <div class="pagination">
                    <?php if ($paginaActual > 1): ?>
                        <a href="?page=<?php echo $paginaActual - 1; ?>" class="page-btn">←</a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $paginaActual - 2); $i <= min($totalPaginas, $paginaActual + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="page-btn <?php echo ($i == $paginaActual) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($paginaActual < $totalPaginas): ?>
                        <a href="?page=<?php echo $paginaActual + 1; ?>" class="page-btn">→</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer>
        <p>WorldExplorer Project — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
