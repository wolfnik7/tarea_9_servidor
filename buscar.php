<?php
/**
 * Página de búsqueda de países.
 * 
 * Busca países por nombre usando file_get_contents().
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 */

require_once 'functions.php';

$busqueda = '';
$resultados = null;
$error = '';

if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $busqueda = htmlspecialchars(trim($_GET['q']));
    $resultados = buscarPais($busqueda);
    if ($resultados === null) {
        $error = "No se encontraron países con \"$busqueda\".";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar País — WorldExplorer</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🌍 World<span>Explorer</span></h1>
            <nav>
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
            <a href="index.php" class="back-link">← Volver</a>
            <h2>🔍 Buscar País</h2>
            <p>Busca por nombre usando <code>file_get_contents()</code>.</p>
        </section>

        <form action="buscar.php" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Nombre del país (ej: Spain)..." 
                   value="<?php echo $busqueda; ?>" required>
            <button type="submit" class="btn">Buscar</button>
        </form>

        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultados): ?>
            <p class="results-count"><?php echo count($resultados); ?> resultado(s)</p>
            <div class="countries-grid">
                <?php foreach ($resultados as $pais): ?>
                    <a href="detalle.php?code=<?php echo $pais['cca2']; ?>" class="country-card">
                        <img src="<?php echo $pais['flags']['png']; ?>" alt="Bandera" class="country-flag">
                        <div class="country-card-body">
                            <h3><?php echo nombreEspanol($pais); ?></h3>
                            <div class="country-meta">
                                <span><strong>Capital:</strong> <?php echo obtenerCapital($pais); ?></span>
                                <span><strong>Región:</strong> <?php echo traducirRegion($pais['region'] ?? ''); ?></span>
                                <span><strong>Población:</strong> <?php echo formatearNumero($pais['population'] ?? 0); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php elseif (empty($busqueda)): ?>
            <div class="empty-state">
                <h3>Busca un país</h3>
                <p>Escribe el nombre de cualquier país para ver su información.</p>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
