<?php
/**
 * Página de comparación de dos países.
 * 
 * Compara estadísticas lado a lado usando file_get_contents().
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 */

require_once 'functions.php';

$pais1 = null;
$pais2 = null;
$nombre1 = '';
$nombre2 = '';
$error = '';

if (isset($_GET['pais1']) && isset($_GET['pais2'])) {
    $nombre1 = htmlspecialchars(trim($_GET['pais1']));
    $nombre2 = htmlspecialchars(trim($_GET['pais2']));

    if (!empty($nombre1) && !empty($nombre2)) {
        $res1 = buscarPais($nombre1);
        $res2 = buscarPais($nombre2);

        if ($res1 && !empty($res1)) $pais1 = $res1[0];
        if ($res2 && !empty($res2)) $pais2 = $res2[0];

        if (!$pais1 || !$pais2) {
            $error = "No se encontraron uno o ambos países.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparar — WorldExplorer</title>
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
                <a href="comparar.php" class="active">Comparar</a>
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-title">
            <a href="index.php" class="back-link">← Volver</a>
            <h2>⚖️ Comparar Países</h2>
            <p>Introduce dos países para comparar sus datos.</p>
        </section>

        <form action="comparar.php" method="GET" class="compare-form">
            <div class="form-group">
                <label for="pais1">País 1</label>
                <input type="text" name="pais1" id="pais1" placeholder="Ej: Spain" value="<?php echo $nombre1; ?>" required>
            </div>
            <div class="form-group">
                <label for="pais2">País 2</label>
                <input type="text" name="pais2" id="pais2" placeholder="Ej: France" value="<?php echo $nombre2; ?>" required>
            </div>
            <button type="submit" class="btn">Comparar</button>
        </form>

        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($pais1 && $pais2): ?>
            <div class="compare-grid">
                <div class="compare-card">
                    <img src="<?php echo $pais1['flags']['png'] ?? ''; ?>" alt="Bandera">
                    <h3><?php echo nombreEspanol($pais1); ?></h3>
                    <div class="country-meta">
                        <span><strong>Capital:</strong> <?php echo obtenerCapital($pais1); ?></span>
                    </div>
                </div>
                <div class="compare-vs">VS</div>
                <div class="compare-card">
                    <img src="<?php echo $pais2['flags']['png'] ?? ''; ?>" alt="Bandera">
                    <h3><?php echo nombreEspanol($pais2); ?></h3>
                    <div class="country-meta">
                        <span><strong>Capital:</strong> <?php echo obtenerCapital($pais2); ?></span>
                    </div>
                </div>
            </div>

            <div class="compare-stats">
                <h3>📊 Estadísticas</h3>

                <div class="stat-row">
                    <div class="stat-value left"><?php echo formatearNumero($pais1['population'] ?? 0); ?></div>
                    <div class="stat-label">Población</div>
                    <div class="stat-value right"><?php echo formatearNumero($pais2['population'] ?? 0); ?></div>
                </div>

                <div class="stat-row">
                    <div class="stat-value left"><?php echo isset($pais1['area']) ? formatearNumero((int)$pais1['area']) . ' km²' : 'N/A'; ?></div>
                    <div class="stat-label">Área</div>
                    <div class="stat-value right"><?php echo isset($pais2['area']) ? formatearNumero((int)$pais2['area']) . ' km²' : 'N/A'; ?></div>
                </div>

                <div class="stat-row">
                    <div class="stat-value left"><?php echo obtenerIdiomas($pais1); ?></div>
                    <div class="stat-label">Idiomas</div>
                    <div class="stat-value right"><?php echo obtenerIdiomas($pais2); ?></div>
                </div>

                <div class="stat-row">
                    <div class="stat-value left"><?php echo obtenerMonedas($pais1); ?></div>
                    <div class="stat-label">Monedas</div>
                    <div class="stat-value right"><?php echo obtenerMonedas($pais2); ?></div>
                </div>

                <div class="stat-row">
                    <div class="stat-value left"><?php echo traducirRegion($pais1['region'] ?? ''); ?></div>
                    <div class="stat-label">Región</div>
                    <div class="stat-value right"><?php echo traducirRegion($pais2['region'] ?? ''); ?></div>
                </div>
            </div>
        <?php elseif (empty($nombre1)): ?>
            <div class="empty-state">
                <h3>Compara dos países</h3>
                <p>Ejemplo: Spain vs France</p>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
