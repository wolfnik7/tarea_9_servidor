<?php
/**
 * WorldExplorer — Página principal
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 */
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorldExplorer — Explorador de Países</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <span>✦</span> WorldExplorer
            </div>
            <nav>
                <a href="index.php" class="active">Inicio</a>
                <a href="buscar.php">Buscar</a>
                <a href="listado.php">Listado</a>
                <a href="comparar.php">Comparar</a>
                <a href="regiones.php">Regiones</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Explora el Planeta.<br>Descubre cada Detalle.</h2>
            <p>Tu puerta de acceso a datos de todos los países del mundo. Navega entre naciones, regiones y estadísticas con una interfaz moderna y visual.</p>
        </section>

        <section class="sections-grid">
            <a href="buscar.php" class="section-card">
                <div class="card-icon">🔍</div>
                <h3>Búsqueda Rápida</h3>
                <p>Encuentra al instante datos completos de cualquier nación. Población, capital, moneda e idiomas a un clic.</p>
                <div class="card-arrow">→</div>
            </a>

            <a href="listado.php" class="section-card">
                <div class="card-icon">🗺️</div>
                <h3>Atlas Global</h3>
                <p>Recorre el archivo completo de todos los estados soberanos. Una enciclopedia digital de la geografía mundial.</p>
                <div class="card-arrow">→</div>
            </a>

            <a href="comparar.php" class="section-card">
                <div class="card-icon">⚖️</div>
                <h3>Comparar Países</h3>
                <p>Análisis lado a lado. Visualiza las diferencias demográficas y geográficas entre dos países.</p>
                <div class="card-arrow">→</div>
            </a>

            <a href="regiones.php" class="section-card">
                <div class="card-icon">🌐</div>
                <h3>Zonas Regionales</h3>
                <p>Filtra por continente. Explora las características de Europa, Asia, Américas, África y Oceanía.</p>
                <div class="card-arrow">→</div>
            </a>
        </section>
    </main>

    <footer>
        <p>WorldExplorer — Tarea 9 DEWS — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
