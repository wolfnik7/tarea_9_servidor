<?php
/**
 * Funciones auxiliares para la aplicación WorldExplorer.
 * 
 * Este archivo contiene todas las funciones necesarias para consumir
 * la API REST de RestCountries (https://restcountries.com/) y procesar
 * los datos obtenidos. Se utilizan tanto file_get_contents() como cURL
 * para realizar las peticiones HTTP.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 * @package WorldExplorer
 */

/** @var string URL base de la API RestCountries v3.1 */
define('API_BASE_URL', 'https://restcountries.com/v3.1');

/**
 * Realiza una petición GET a una URL usando file_get_contents().
 * 
 * Esta función utiliza file_get_contents() con un contexto HTTP
 * configurado para realizar peticiones GET a la API REST.
 * Devuelve los datos decodificados desde JSON.
 * 
 * @param string $url La URL completa a la que se realizará la petición.
 * @return array|null Los datos decodificados del JSON o null si hay error.
 */
function peticionFileGetContents(string $url): ?array
{
    $contexto = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Accept: application/json\r\n",
            'timeout' => 10
        ]
    ]);

    $respuesta = @file_get_contents($url, false, $contexto);

    if ($respuesta === false) {
        return null;
    }

    $datos = json_decode($respuesta, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }

    return $datos;
}

/**
 * Realiza una petición GET a una URL usando cURL.
 * 
 * Esta función utiliza la librería cURL para realizar peticiones GET
 * a la API REST. Incluye manejo de errores y configuración de timeout.
 * 
 * @param string $url La URL completa a la que se realizará la petición.
 * @return array|null Los datos decodificados del JSON o null si hay error.
 */
function peticionCurl(string $url): ?array
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => ['Accept: application/json'],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_FOLLOWLOCATION => true
    ]);

    $respuesta = curl_exec($ch);
    $codigoHttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($respuesta === false || $codigoHttp !== 200) {
        return null;
    }

    $datos = json_decode($respuesta, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }

    return $datos;
}

/**
 * Busca un país por su nombre usando la API RestCountries.
 * 
 * Realiza una búsqueda por nombre en la API. Utiliza file_get_contents()
 * como método de petición HTTP.
 * 
 * @param string $nombre El nombre del país a buscar (parcial o completo).
 * @return array|null Array con los países encontrados o null si no hay resultados.
 */
function buscarPaisPorNombre(string $nombre): ?array
{
    $url = API_BASE_URL . '/name/' . urlencode($nombre);
    return peticionFileGetContents($url);
}

/**
 * Obtiene la información detallada de un país por su código alfa.
 * 
 * Utiliza cURL para obtener los datos completos de un país
 * identificado por su código ISO 3166-1 alfa-2 o alfa-3.
 * 
 * @param string $codigo El código alfa del país (ej: "ES", "ESP").
 * @return array|null Array con los datos del país o null si no se encuentra.
 */
function obtenerPaisPorCodigo(string $codigo): ?array
{
    $url = API_BASE_URL . '/alpha/' . urlencode($codigo);
    $resultado = peticionCurl($url);

    if ($resultado !== null && isset($resultado[0])) {
        return $resultado[0];
    }

    return $resultado;
}

/**
 * Obtiene todos los países de una región específica.
 * 
 * Consulta la API para obtener todos los países que pertenecen
 * a una región geográfica determinada. Utiliza file_get_contents().
 * 
 * @param string $region Nombre de la región (Africa, Americas, Asia, Europe, Oceania).
 * @return array|null Array con los países de la región o null si hay error.
 */
function obtenerPaisesPorRegion(string $region): ?array
{
    $url = API_BASE_URL . '/region/' . urlencode($region);
    return peticionFileGetContents($url);
}

/**
 * Obtiene un listado de todos los países disponibles.
 * 
 * Consulta la API para obtener todos los países. Solo solicita
 * los campos necesarios para optimizar la respuesta. Utiliza cURL.
 * 
 * @return array|null Array con todos los países o null si hay error.
 */
function obtenerTodosLosPaises(): ?array
{
    $url = API_BASE_URL . '/all?fields=name,flags,cca2,region,population,capital';
    return peticionCurl($url);
}

/**
 * Obtiene los países que comparten idioma.
 * 
 * Busca países por idioma usando la API RestCountries.
 * Utiliza file_get_contents() para la petición.
 * 
 * @param string $idioma El idioma a buscar (en inglés, ej: "spanish").
 * @return array|null Array con los países que hablan ese idioma o null si hay error.
 */
function obtenerPaisesPorIdioma(string $idioma): ?array
{
    $url = API_BASE_URL . '/lang/' . urlencode($idioma);
    return peticionFileGetContents($url);
}

/**
 * Formatea un número de población para mostrar de forma legible.
 * 
 * Convierte un número grande en un formato más legible,
 * por ejemplo: 1000000 → "1.000.000".
 * 
 * @param int $poblacion El número de población a formatear.
 * @return string La población formateada con separadores de miles.
 */
function formatearPoblacion(int $poblacion): string
{
    return number_format($poblacion, 0, ',', '.');
}

/**
 * Obtiene el nombre común de un país en español si está disponible.
 * 
 * Intenta obtener la traducción al español del nombre del país.
 * Si no existe traducción, devuelve el nombre común en inglés.
 * 
 * @param array $pais Array con los datos del país de la API.
 * @return string El nombre del país, preferiblemente en español.
 */
function obtenerNombreEspanol(array $pais): string
{
    if (isset($pais['translations']['spa']['common'])) {
        return $pais['translations']['spa']['common'];
    }
    return $pais['name']['common'] ?? 'Desconocido';
}

/**
 * Extrae los idiomas de un país y los devuelve como cadena.
 * 
 * Obtiene la lista de idiomas oficiales de un país y
 * los concatena en una cadena separada por comas.
 * 
 * @param array $pais Array con los datos del país de la API.
 * @return string Los idiomas del país separados por comas.
 */
function obtenerIdiomas(array $pais): string
{
    if (!isset($pais['languages'])) {
        return 'No disponible';
    }
    return implode(', ', $pais['languages']);
}

/**
 * Extrae las monedas de un país y las devuelve como cadena.
 * 
 * Obtiene la lista de monedas oficiales de un país con su
 * nombre y símbolo, concatenadas en una cadena.
 * 
 * @param array $pais Array con los datos del país de la API.
 * @return string Las monedas del país con nombre y símbolo.
 */
function obtenerMonedas(array $pais): string
{
    if (!isset($pais['currencies'])) {
        return 'No disponible';
    }

    $monedas = [];
    foreach ($pais['currencies'] as $codigo => $info) {
        $nombre = $info['name'] ?? $codigo;
        $simbolo = isset($info['symbol']) ? " ({$info['symbol']})" : '';
        $monedas[] = $nombre . $simbolo;
    }

    return implode(', ', $monedas);
}

/**
 * Obtiene la capital de un país.
 * 
 * Extrae el nombre de la capital del array de datos del país.
 * Un país puede tener múltiples capitales.
 * 
 * @param array $pais Array con los datos del país de la API.
 * @return string El nombre de la capital o capitales del país.
 */
function obtenerCapital(array $pais): string
{
    if (!isset($pais['capital']) || empty($pais['capital'])) {
        return 'No disponible';
    }
    return implode(', ', $pais['capital']);
}

/**
 * Genera el HTML para mostrar las barras de estadísticas de comparación.
 * 
 * Crea una barra visual que representa proporcionalmente un valor
 * respecto al valor máximo entre dos países.
 * 
 * @param float $valor El valor actual a representar.
 * @param float $maximo El valor máximo para calcular el porcentaje.
 * @param string $color El color CSS de la barra (valor hexadecimal o nombre).
 * @return string El HTML de la barra de estadísticas.
 */
function generarBarraEstadistica(float $valor, float $maximo, string $color): string
{
    $porcentaje = ($maximo > 0) ? ($valor / $maximo) * 100 : 0;
    return '<div class="stat-bar">
                <div class="stat-bar-fill" style="width: ' . $porcentaje . '%; background: ' . $color . ';"></div>
            </div>';
}

/**
 * Traduce el nombre de una región al español.
 * 
 * Convierte el nombre de la región que devuelve la API (en inglés)
 * a su equivalente en español.
 * 
 * @param string $region Nombre de la región en inglés.
 * @return string Nombre de la región en español.
 */
function traducirRegion(string $region): string
{
    $traducciones = [
        'Africa'   => 'África',
        'Americas' => 'Américas',
        'Asia'     => 'Asia',
        'Europe'   => 'Europa',
        'Oceania'  => 'Oceanía',
        'Antarctic' => 'Antártida'
    ];

    return $traducciones[$region] ?? $region;
}

/**
 * Sanitiza una cadena de entrada del usuario.
 * 
 * Limpia la entrada del usuario eliminando etiquetas HTML,
 * espacios en blanco innecesarios y caracteres especiales
 * para prevenir ataques XSS.
 * 
 * @param string $entrada La cadena a sanitizar.
 * @return string La cadena sanitizada y segura para mostrar.
 */
function sanitizarEntrada(string $entrada): string
{
    return htmlspecialchars(strip_tags(trim($entrada)), ENT_QUOTES, 'UTF-8');
}
