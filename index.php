<?php
/**
 * WorldExplorer — Aurora Edition
 * Main Gateway
 */
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorldExplorer — Aurora Edition</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <span>✦</span> WorldExplorer
            </div>
            <nav>
                <a href="index.php" class="active">Home</a>
                <a href="buscar.php">Search</a>
                <a href="listado.php">Discover</a>
                <a href="comparar.php">Compare</a>
                <a href="regiones.php">Regions</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Explore the Planet.<br>Discover the Details.</h2>
            <p>Your premium gateway to global data. Navigate through countries, regions, and statistics with a futuristic interface designed for clarity.</p>
        </section>

        <section class="sections-grid">
            <a href="buscar.php" class="section-card">
                <div class="card-icon">🔍</div>
                <h3>Quick Search</h3>
                <p>Instantly find comprehensive data about any nation. Populations, capitals, currencies, and languages at your fingertips.</p>
                <div class="card-arrow">→</div>
            </a>

            <a href="listado.php" class="section-card">
                <div class="card-icon">🗺️</div>
                <h3>Global Atlas</h3>
                <p>Browse the complete archive of all sovereign states. A digital encyclopedia of the world's geography.</p>
                <div class="card-arrow">→</div>
            </a>

            <a href="comparar.php" class="section-card">
                <div class="card-icon">⚖️</div>
                <h3>Compare Nations</h3>
                <p>Side-by-side analysis. Visualize economic and demographic differences between any two countries.</p>
                <div class="card-arrow">→</div>
            </a>

            <a href="regiones.php" class="section-card">
                <div class="card-icon">🌐</div>
                <h3>Regional Zones</h3>
                <p>Filter by continent. Explore the unique characteristics of Europe, Asia, Americas, Africa, and Oceania.</p>
                <div class="card-arrow">→</div>
            </a>
        </section>
    </main>

    <footer>
        <p>WorldExplorer Project — <?php echo date('Y'); ?> — Designed for Exploration</p>
    </footer>
</body>
</html>
