<?php
/**
 * Página de comparación de dos países.
 * 
 * Compara estadísticas lado a lado.
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
            <div class="logo">
                <span>✦</span> WorldExplorer
            </div>
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
        <section class="hero" style="padding-bottom: 20px;">
            <h2>Comparar Países</h2>
            <p>Analiza las diferencias demográficas y geográficas entre dos naciones.</p>
        </section>

        <form action="comparar.php" method="GET" class="compare-form-container">
            <div class="form-row">
                <div class="form-group">
                    <label>Primer País</label>
                    <input type="text" name="pais1" class="form-input" placeholder="Ej: Spain" value="<?php echo $nombre1; ?>" required>
                </div>
                <div class="form-group">
                    <label>Segundo País</label>
                    <input type="text" name="pais2" class="form-input" placeholder="Ej: France" value="<?php echo $nombre2; ?>" required>
                </div>
                <button type="submit" class="btn-search" style="margin-bottom:2px;">Comparar</button>
            </div>
        </form>

        <?php if ($error): ?>
            <div class="mensaje-error" style="text-align:center;color:#ff4d4d;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($pais1 && $pais2): ?>
            <div class="compare-result">
                <div class="country-item" style="text-align:center; padding-bottom:20px;">
                    <img src="<?php echo $pais1['flags']['png'] ?? ''; ?>" alt="Bandera" class="country-flag" style="height:200px; border-radius: 24px 24px 0 0;">
                    <h3 style="margin-top:20px; font-size:1.8rem;"><?php echo nombreEspanol($pais1); ?></h3>
                    <p style="color:var(--accent-cyan);"><?php echo obtenerCapital($pais1); ?></p>
                </div>

                <div class="versus-circle">VS</div>

                <div class="country-item" style="text-align:center; padding-bottom:20px;">
                    <img src="<?php echo $pais2['flags']['png'] ?? ''; ?>" alt="Bandera" class="country-flag" style="height:200px; border-radius: 24px 24px 0 0;">
                    <h3 style="margin-top:20px; font-size:1.8rem;"><?php echo nombreEspanol($pais2); ?></h3>
                    <p style="color:var(--accent-purple);"><?php echo obtenerCapital($pais2); ?></p>
                </div>
            </div>

            <div class="stats-grid" style="margin-top:60px;">
                <div class="stat-box" style="text-align:center;">
                    <div class="stat-label">Población</div>
                    <div style="display:flex; justify-content:space-between; margin-top:10px;">
                        <span style="font-size:1.1rem;"><?php echo formatearNumero($pais1['population'] ?? 0); ?></span>
                        <span style="font-size:1.1rem;"><?php echo formatearNumero($pais2['population'] ?? 0); ?></span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.1); border-radius:3px; margin-top:8px; position:relative; overflow:hidden;">
                        <?php 
                        $maxPop = max($pais1['population'] ?? 1, $pais2['population'] ?? 1);
                        $p1 = (($pais1['population'] ?? 0) / $maxPop) * 100;
                        $p2 = (($pais2['population'] ?? 0) / $maxPop) * 100;
                        ?>
                        <div style="position:absolute; left:0; width:<?php echo $p1; ?>%; height:100%; background:var(--accent-cyan); opacity:0.8;"></div>
                        <div style="position:absolute; right:0; width:<?php echo $p2; ?>%; height:100%; background:var(--accent-purple); opacity:0.8;"></div>
                    </div>
                </div>

                <div class="stat-box" style="text-align:center;">
                    <div class="stat-label">Superficie (km²)</div>
                    <div style="display:flex; justify-content:space-between; margin-top:10px;">
                        <span style="font-size:1.1rem;"><?php echo formatearNumero((int)($pais1['area'] ?? 0)); ?></span>
                        <span style="font-size:1.1rem;"><?php echo formatearNumero((int)($pais2['area'] ?? 0)); ?></span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.1); border-radius:3px; margin-top:8px; position:relative; overflow:hidden;">
                        <?php 
                        $maxArea = max($pais1['area'] ?? 1, $pais2['area'] ?? 1);
                        $a1 = (($pais1['area'] ?? 0) / $maxArea) * 100;
                        $a2 = (($pais2['area'] ?? 0) / $maxArea) * 100;
                        ?>
                        <div style="position:absolute; left:0; width:<?php echo $a1; ?>%; height:100%; background:var(--accent-cyan); opacity:0.8;"></div>
                        <div style="position:absolute; right:0; width:<?php echo $a2; ?>%; height:100%; background:var(--accent-purple); opacity:0.8;"></div>
                    </div>
                </div>

                <div class="stat-box" style="text-align:center;">
                    <div class="stat-label">Región</div>
                    <div style="display:flex; justify-content:space-between; margin-top:10px; font-weight:600;">
                        <span style="color:var(--accent-cyan);"><?php echo traducirRegion($pais1['region'] ?? ''); ?></span>
                        <span style="color:var(--accent-purple);"><?php echo traducirRegion($pais2['region'] ?? ''); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>WorldExplorer — Tarea 9 DEWS — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
