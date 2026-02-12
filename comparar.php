<?php
/**
 * Página de comparación de países.
 * 
 * Permite comparar las estadísticas de dos países lado a lado.
 * Utiliza cURL para obtener los datos de ambos países.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 * @package WorldExplorer
 */

require_once 'functions.php';

$pais1 = null;
$pais2 = null;
$nombre1 = '';
$nombre2 = '';
$error = '';

// Procesar comparación
if (isset($_GET['pais1']) && isset($_GET['pais2']) && !empty(trim($_GET['pais1'])) && !empty(trim($_GET['pais2']))) {
    $nombre1 = sanitizarEntrada($_GET['pais1']);
    $nombre2 = sanitizarEntrada($_GET['pais2']);

    $resultado1 = buscarPaisPorNombre($nombre1);
    $resultado2 = buscarPaisPorNombre($nombre2);

    if ($resultado1 !== null && !empty($resultado1)) {
        $pais1 = $resultado1[0];
    }
    if ($resultado2 !== null && !empty($resultado2)) {
        $pais2 = $resultado2[0];
    }

    if ($pais1 === null || $pais2 === null) {
        $error = "No se pudieron encontrar uno o ambos países. Verifica los nombres e inténtalo de nuevo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Comparar estadísticas de dos países - WorldExplorer">
    <title>Comparar Países — WorldExplorer</title>
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
                <a href="comparar.php" class="active">Comparar</a>
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="page-title">
            <a href="index.php" class="back-link">← Volver al inicio</a>
            <h2>⚖️ Comparar Países</h2>
            <p>Introduce el nombre de dos países para comparar sus estadísticas. Se utiliza <code>cURL</code> para las peticiones.</p>
        </section>

        <!-- Formulario de comparación -->
        <section class="compare-section">
            <form action="comparar.php" method="GET" class="compare-form" id="compare-form">
                <div class="form-group">
                    <label for="pais1">País 1</label>
                    <input type="text" name="pais1" id="pais1" placeholder="Ej: Spain" 
                           value="<?php echo htmlspecialchars($nombre1); ?>" required>
                </div>
                <div class="form-group">
                    <label for="pais2">País 2</label>
                    <input type="text" name="pais2" id="pais2" placeholder="Ej: France" 
                           value="<?php echo htmlspecialchars($nombre2); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-comparar">
                    ⚖️ Comparar
                </button>
            </form>
        </section>

        <?php if ($error): ?>
            <div class="message message-error fade-in"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($pais1 !== null && $pais2 !== null): ?>
            <!-- Cards de países -->
            <div class="compare-grid fade-in">
                <div class="compare-card">
                    <img src="<?php echo htmlspecialchars($pais1['flags']['png'] ?? ''); ?>" 
                         alt="Bandera de <?php echo htmlspecialchars(obtenerNombreEspanol($pais1)); ?>">
                    <h3><?php echo htmlspecialchars(obtenerNombreEspanol($pais1)); ?></h3>
                    <div class="country-meta">
                        <span><strong>Capital:</strong> <?php echo htmlspecialchars(obtenerCapital($pais1)); ?></span>
                        <span><strong>Región:</strong> <?php echo htmlspecialchars(traducirRegion($pais1['region'] ?? '')); ?></span>
                    </div>
                </div>

                <div class="compare-vs">VS</div>

                <div class="compare-card">
                    <img src="<?php echo htmlspecialchars($pais2['flags']['png'] ?? ''); ?>" 
                         alt="Bandera de <?php echo htmlspecialchars(obtenerNombreEspanol($pais2)); ?>">
                    <h3><?php echo htmlspecialchars(obtenerNombreEspanol($pais2)); ?></h3>
                    <div class="country-meta">
                        <span><strong>Capital:</strong> <?php echo htmlspecialchars(obtenerCapital($pais2)); ?></span>
                        <span><strong>Región:</strong> <?php echo htmlspecialchars(traducirRegion($pais2['region'] ?? '')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Estadísticas de comparación -->
            <div class="compare-stats fade-in">
                <h3>📊 Estadísticas Comparativas</h3>

                <?php
                $pop1 = $pais1['population'] ?? 0;
                $pop2 = $pais2['population'] ?? 0;
                $maxPop = max($pop1, $pop2);

                $area1 = $pais1['area'] ?? 0;
                $area2 = $pais2['area'] ?? 0;
                $maxArea = max($area1, $area2);
                ?>

                <!-- Población -->
                <div class="stat-row">
                    <div>
                        <div class="stat-value left"><?php echo formatearPoblacion($pop1); ?></div>
                        <?php echo generarBarraEstadistica($pop1, $maxPop, 'var(--accent-blue)'); ?>
                    </div>
                    <div class="stat-label">Población</div>
                    <div>
                        <div class="stat-value right"><?php echo formatearPoblacion($pop2); ?></div>
                        <?php echo generarBarraEstadistica($pop2, $maxPop, 'var(--accent-purple)'); ?>
                    </div>
                </div>

                <!-- Área -->
                <div class="stat-row">
                    <div>
                        <div class="stat-value left"><?php echo formatearPoblacion((int)$area1); ?> km²</div>
                        <?php echo generarBarraEstadistica($area1, $maxArea, 'var(--accent-emerald)'); ?>
                    </div>
                    <div class="stat-label">Área</div>
                    <div>
                        <div class="stat-value right"><?php echo formatearPoblacion((int)$area2); ?> km²</div>
                        <?php echo generarBarraEstadistica($area2, $maxArea, 'var(--accent-amber)'); ?>
                    </div>
                </div>

                <!-- Idiomas -->
                <div class="stat-row">
                    <div>
                        <div class="stat-value left"><?php echo htmlspecialchars(obtenerIdiomas($pais1)); ?></div>
                    </div>
                    <div class="stat-label">Idiomas</div>
                    <div>
                        <div class="stat-value right"><?php echo htmlspecialchars(obtenerIdiomas($pais2)); ?></div>
                    </div>
                </div>

                <!-- Monedas -->
                <div class="stat-row">
                    <div>
                        <div class="stat-value left"><?php echo htmlspecialchars(obtenerMonedas($pais1)); ?></div>
                    </div>
                    <div class="stat-label">Monedas</div>
                    <div>
                        <div class="stat-value right"><?php echo htmlspecialchars(obtenerMonedas($pais2)); ?></div>
                    </div>
                </div>

                <!-- Zona Horaria -->
                <div class="stat-row">
                    <div>
                        <div class="stat-value left"><?php echo htmlspecialchars(implode(', ', $pais1['timezones'] ?? ['N/A'])); ?></div>
                    </div>
                    <div class="stat-label">Zona Horaria</div>
                    <div>
                        <div class="stat-value right"><?php echo htmlspecialchars(implode(', ', $pais2['timezones'] ?? ['N/A'])); ?></div>
                    </div>
                </div>
            </div>
        <?php elseif (empty($nombre1) && empty($nombre2)): ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M16 3h5v5"></path>
                    <path d="M8 3H3v5"></path>
                    <path d="M12 22v-8.5"></path>
                    <path d="m19 8-7 7-7-7"></path>
                </svg>
                <h3>Compara dos países</h3>
                <p>Introduce el nombre de dos países para ver sus estadísticas lado a lado.</p>
                <p style="margin-top: 16px; font-size: 0.85rem;">Ejemplo: Spain vs France, Japan vs China, Brazil vs Argentina...</p>
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
