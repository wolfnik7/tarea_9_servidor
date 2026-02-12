# WorldExplorer — Tarea 9 DEWS

Aplicación web PHP que consume la API REST de **RestCountries** (https://restcountries.com/) para explorar información detallada de países del mundo.

## 📋 Descripción

Este proyecto cumple con los requisitos de la Tarea 9 de Desarrollo de Entornos Web del Servidor (DEWS):

- **RA8_d**: Repositorio creado en GitHub con el código fuente.
- **RA8_f**: Consumo de servicio web REST (RestCountries API) con `file_get_contents()` y `cURL`. Resultados mostrados en páginas web con diseño moderno.
- **RA8_h**: Pruebas con JMeter, documentación PHPDoc, y página de navegación.

## 🚀 Funcionalidades

| Página | Descripción | Método HTTP |
|--------|-------------|-------------|
| `index.php` | Página principal con navegación a todos los apartados | — |
| `buscar.php` | Búsqueda de países por nombre | `file_get_contents()` |
| `detalle.php` | Información detallada de un país | `cURL` |
| `listado.php` | Listado completo con paginación | `cURL` |
| `comparar.php` | Comparación lado a lado de dos países | `file_get_contents()` + `cURL` |
| `regiones.php` | Exploración por regiones del mundo | `file_get_contents()` |

## 🛠️ Tecnologías

- **PHP 8.x** — Backend y consumo de API
- **HTML5 / CSS3** — Frontend con diseño moderno (dark theme, glassmorphism)
- **RestCountries API v3.1** — Servicio REST público gratuito
- **Google Fonts (Outfit)** — Tipografía moderna

## 📂 Estructura del Proyecto

```
tarea9/
├── index.php           # Página principal de navegación
├── buscar.php          # Búsqueda de países
├── detalle.php         # Detalle de un país
├── listado.php         # Listado con paginación
├── comparar.php        # Comparación de países
├── regiones.php        # Exploración por regiones
├── functions.php       # Funciones con documentación PHPDoc
├── css/
│   └── styles.css      # Estilos del diseño
└── README.md           # Este archivo
```

## ⚙️ Instalación

1. Copiar el proyecto en el directorio `htdocs` de XAMPP.
2. Iniciar Apache en XAMPP.
3. Acceder a `http://localhost/tarea9/` en el navegador.

## 📖 API Utilizada

**RestCountries API** — https://restcountries.com/

- URL Base: `https://restcountries.com/v3.1/`
- Formato: JSON
- Autenticación: No requerida
- Documentación: https://restcountries.com/#endpoints-all

## 📝 Documentación PHPDoc

La documentación PHPDoc se genera ejecutando:

```bash
php phpDocumentor.phar -d C:\xampp\XAMPP\htdocs\tarea9 -t C:\ruta\doc
```

## 🧪 Pruebas JMeter

Configuración del Concurrency Thread Group:
- **Target Concurrency**: 200 usuarios
- **Ramp Up Time**: 10 min
- **Ramp-Up Steps Count**: 10
- **Hold Target Rate Time**: 5 min

## 👤 Autor

**Francisco Javier Bailón García** — DEWS — 2026
