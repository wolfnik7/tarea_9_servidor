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
        $error = "No se encontraron resultados para \"$busqueda\".";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar — WorldExplorer</title>
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
                <a href="buscar.php" class="active">Buscar</a>
                <a href="listado.php">Listado</a>
                <a href="comparar.php">Comparar</a>
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero" style="padding-bottom: 20px;">
            <h2>Buscar País</h2>
            <p>Accede a datos demográficos, geográficos y gubernamentales al instante.</p>
        </section>

        <form action="buscar.php" method="GET" class="search-container">
            <input type="text" name="q" placeholder="Escribe el nombre de un país (ej: Japan, France)..." 
                   value="<?php echo $busqueda; ?>" autocomplete="off" required>
            <button type="submit" class="btn-search">Buscar</button>
        </form>

        <?php if ($error): ?>
            <div class="mensaje-error" style="text-align:center; max-width:600px; margin:0 auto 40px; color:#ff4d4d;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultados): ?>
            <p style="text-align:center; color:var(--text-secondary); margin-bottom:40px;">Se encontraron <?php echo count($resultados); ?> resultado(s)</p>
            <div class="country-grid">
                <?php foreach ($resultados as $pais): ?>
                    <a href="detalle.php?code=<?php echo $pais['cca2'] ?? ''; ?>" class="country-item">
                        <img src="<?php echo $pais['flags']['png'] ?? ''; ?>" alt="Bandera" class="country-flag">
                        <div class="country-info">
                            <span class="tag"><?php echo traducirRegion($pais['region'] ?? ''); ?></span>
                            <h3><?php echo nombreEspanol($pais); ?></h3>
                            <div class="country-details">
                                <span><?php echo obtenerCapital($pais); ?></span>
                                <span><?php echo formatearNumero($pais['population'] ?? 0); ?> habitantes</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>WorldExplorer — Tarea 9 DEWS — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
