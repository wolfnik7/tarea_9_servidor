<?php
/**
 * Página principal de navegación - Tarea 9 DEWS
 * 
 * Página índice que permite navegar por todos los apartados
 * de la tarea. Incluye descripción de cada sección y enlaces
 * a cada funcionalidad implementada.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 * @package WorldExplorer
 */

require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tarea 9 - DEWS. Aplicación PHP que consume la API REST de RestCountries para explorar información de países del mundo.">
    <title>WorldExplorer — Tarea 9 DEWS</title>
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
            <p class="subtitle">Tarea 9 — Desarrollo de Entornos Web del Servidor</p>
        </div>
    </header>

    <main class="container">
        <!-- Hero Section -->
        <section class="hero">
            <h2>Explorador de Países del Mundo</h2>
            <p>Aplicación web que consume la <strong>API REST de RestCountries</strong> (servicio público gratuito) para mostrar información detallada de países. Desarrollada con PHP utilizando <code>file_get_contents()</code> y <code>cURL</code>.</p>
        </section>

        <!-- Sections Grid -->
        <section class="sections-grid">
            <a href="buscar.php" class="section-card card-search" id="link-buscar">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
                <h3>Buscar País</h3>
                <p>Busca cualquier país por nombre. Visualiza bandera, capital, población, idiomas, monedas y más información.</p>
                <span class="card-tag">RA8_f — file_get_contents()</span>
                <span class="card-arrow">→</span>
            </a>

            <a href="listado.php" class="section-card card-list" id="link-listado">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
                <h3>Listado de Países</h3>
                <p>Explora el catálogo completo de países del mundo con paginación y tarjetas visuales con banderas.</p>
                <span class="card-tag">RA8_f — cURL</span>
                <span class="card-arrow">→</span>
            </a>

            <a href="comparar.php" class="section-card card-compare" id="link-comparar">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 3h5v5"></path>
                        <path d="M8 3H3v5"></path>
                        <path d="M12 22v-8.5"></path>
                        <path d="m19 8-7 7-7-7"></path>
                    </svg>
                </div>
                <h3>Comparar Países</h3>
                <p>Compara las estadísticas de dos países lado a lado: población, área, idiomas y más datos.</p>
                <span class="card-tag">RA8_f — cURL</span>
                <span class="card-arrow">→</span>
            </a>

            <a href="regiones.php" class="section-card card-types" id="link-regiones">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M2 12h20"></path>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                </div>
                <h3>Explorar Regiones</h3>
                <p>Descubre los países organizados por regiones del mundo: Europa, Asia, África, Américas y Oceanía.</p>
                <span class="card-tag">RA8_f — file_get_contents()</span>
                <span class="card-arrow">→</span>
            </a>
        </section>

        <!-- Info Section -->
        <section class="info-section">
            <h2>Apartados de la Tarea</h2>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-number">RA8_d</div>
                    <h4>Repositorio</h4>
                    <p>Código fuente publicado en un repositorio GitHub con control de versiones.</p>
                </div>
                <div class="info-card">
                    <div class="info-number">RA8_f</div>
                    <h4>Servicio Web REST</h4>
                    <p>Consumo de la API RestCountries con <code>file_get_contents()</code> y <code>cURL</code>. Datos JSON mostrados en páginas web con diseño moderno.</p>
                </div>
                <div class="info-card">
                    <div class="info-number">RA8_h</div>
                    <h4>Pruebas y Documentación</h4>
                    <p>Pruebas con JMeter (Concurrency Thread Group), documentación PHPDoc en todas las funciones, y página de navegación.</p>
                </div>
            </div>
        </section>

        <!-- API Info -->
        <section class="api-info">
            <h2>API Utilizada</h2>
            <div class="api-card">
                <div class="api-logo">
                    <span style="font-size: 4rem;">🌐</span>
                </div>
                <div class="api-details">
                    <h3>RestCountries API</h3>
                    <p>API RESTful gratuita y de uso libre que proporciona datos detallados sobre todos los países del mundo: banderas, poblaciones, capitales, idiomas, monedas, continentes y mucho más.</p>
                    <ul>
                        <li><strong>URL Base:</strong> <code>https://restcountries.com/v3.1/</code></li>
                        <li><strong>Formato:</strong> JSON</li>
                        <li><strong>Autenticación:</strong> No requerida</li>
                        <li><strong>Métodos PHP:</strong> <code>file_get_contents()</code> y <code>cURL</code></li>
                    </ul>
                    <a href="https://restcountries.com/" target="_blank" rel="noopener noreferrer" class="api-link">Visitar RestCountries →</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>Tarea 9 — DEWS — Francisco Javier Bailón García — <?php echo date('Y'); ?></p>
        </div>
    </footer>
</body>
</html>
