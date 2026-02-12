<?php
/**
 * Página principal de navegación.
 * 
 * Página índice con enlaces a todas las secciones de la tarea.
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
    <title>WorldExplorer — Tarea 9</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🌍 World<span>Explorer</span></h1>
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
            <h2>Explorador de Países</h2>
            <p>Aplicación PHP que consume la API REST de RestCountries para mostrar información de países del mundo.</p>
        </section>

        <section class="sections-grid">
            <a href="buscar.php" class="section-card">
                <h3>🔍 Buscar País</h3>
                <p>Busca cualquier país por nombre y visualiza su información completa.</p>
                <span class="card-tag">file_get_contents()</span>
            </a>

            <a href="listado.php" class="section-card">
                <h3>📋 Listado de Países</h3>
                <p>Listado completo de todos los países con paginación.</p>
                <span class="card-tag">cURL</span>
            </a>

            <a href="comparar.php" class="section-card">
                <h3>⚖️ Comparar Países</h3>
                <p>Compara estadísticas de dos países lado a lado.</p>
                <span class="card-tag">cURL + file_get_contents()</span>
            </a>

            <a href="regiones.php" class="section-card">
                <h3>🌐 Regiones</h3>
                <p>Explora países agrupados por regiones del mundo.</p>
                <span class="card-tag">file_get_contents()</span>
            </a>
        </section>

        <section class="info-section">
            <h2>Apartados de la Tarea</h2>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-number">RA8_d</div>
                    <h4>Repositorio</h4>
                    <p>Código publicado en GitHub.</p>
                </div>
                <div class="info-card">
                    <div class="info-number">RA8_f</div>
                    <h4>Servicio Web</h4>
                    <p>Consumo de RestCountries API con file_get_contents() y cURL.</p>
                </div>
                <div class="info-card">
                    <div class="info-number">RA8_h</div>
                    <h4>Pruebas y Documentación</h4>
                    <p>Pruebas JMeter y documentación PHPDoc.</p>
                </div>
            </div>
        </section>

        <section class="api-info">
            <h2>API Utilizada</h2>
            <div class="api-card">
                <h3>RestCountries API</h3>
                <p>API REST gratuita con datos de todos los países del mundo.</p>
                <ul>
                    <li><strong>URL:</strong> <code>https://restcountries.com/v3.1/</code></li>
                    <li><strong>Formato:</strong> JSON</li>
                    <li><strong>Autenticación:</strong> No requerida</li>
                </ul>
                <a href="https://restcountries.com/" target="_blank">Visitar RestCountries →</a>
            </div>
        </section>
    </main>

    <footer>
        <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
