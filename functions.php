<?php
/**
 * Funciones para consumir la API RestCountries.
 * 
 * Contiene funciones para obtener datos de países usando
 * file_get_contents() y cURL.
 * 
 * @author Francisco Javier Bailón García
 * @version 1.0
 */

/**
 * Hace una petición GET con file_get_contents().
 * 
 * @param string $url URL a la que hacer la petición.
 * @return array|null Datos en array o null si falla.
 */
function peticionGet($url) {
    $respuesta = @file_get_contents($url);
    if ($respuesta === false) {
        return null;
    }
    return json_decode($respuesta, true);
}

/**
 * Hace una petición GET con cURL.
 * 
 * @param string $url URL a la que hacer la petición.
 * @return array|null Datos en array o null si falla.
 */
function peticionCurl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $respuesta = curl_exec($ch);
    curl_close($ch);

    if ($respuesta === false) {
        return null;
    }
    return json_decode($respuesta, true);
}

/**
 * Busca países por nombre usando file_get_contents().
 * 
 * @param string $nombre Nombre del país a buscar.
 * @return array|null Países encontrados o null.
 */
function buscarPais($nombre) {
    $url = "https://restcountries.com/v3.1/name/" . urlencode($nombre);
    return peticionGet($url);
}

/**
 * Obtiene un país por su código usando cURL.
 * 
 * @param string $codigo Código del país (ej: ES, FR).
 * @return array|null Datos del país o null.
 */
function obtenerPorCodigo($codigo) {
    $url = "https://restcountries.com/v3.1/alpha/" . urlencode($codigo);
    $resultado = peticionCurl($url);
    if ($resultado !== null && isset($resultado[0])) {
        return $resultado[0];
    }
    return null;
}

/**
 * Obtiene todos los países usando cURL.
 * 
 * @return array|null Lista de países o null.
 */
function obtenerTodos() {
    $url = "https://restcountries.com/v3.1/all?fields=name,flags,cca2,region,population,capital";
    return peticionCurl($url);
}

/**
 * Obtiene países de una región usando file_get_contents().
 * 
 * @param string $region Nombre de la región en inglés.
 * @return array|null Países de la región o null.
 */
function obtenerPorRegion($region) {
    $url = "https://restcountries.com/v3.1/region/" . urlencode($region);
    return peticionGet($url);
}

/**
 * Obtiene el nombre en español de un país.
 * 
 * @param array $pais Datos del país.
 * @return string Nombre en español o en inglés si no hay traducción.
 */
function nombreEspanol($pais) {
    if (isset($pais['translations']['spa']['common'])) {
        return $pais['translations']['spa']['common'];
    }
    return $pais['name']['common'] ?? 'Desconocido';
}

/**
 * Obtiene la capital de un país.
 * 
 * @param array $pais Datos del país.
 * @return string Nombre de la capital.
 */
function obtenerCapital($pais) {
    if (isset($pais['capital'][0])) {
        return $pais['capital'][0];
    }
    return 'No disponible';
}

/**
 * Formatea un número con separador de miles.
 * 
 * @param int $numero Número a formatear.
 * @return string Número formateado.
 */
function formatearNumero($numero) {
    return number_format($numero, 0, ',', '.');
}

/**
 * Obtiene los idiomas de un país como texto.
 * 
 * @param array $pais Datos del país.
 * @return string Idiomas separados por comas.
 */
function obtenerIdiomas($pais) {
    if (!isset($pais['languages'])) {
        return 'No disponible';
    }
    return implode(', ', $pais['languages']);
}

/**
 * Obtiene las monedas de un país como texto.
 * 
 * @param array $pais Datos del país.
 * @return string Monedas con su símbolo.
 */
function obtenerMonedas($pais) {
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
 * Traduce el nombre de una región al español.
 * 
 * @param string $region Nombre de la región en inglés.
 * @return string Nombre en español.
 */
function traducirRegion($region) {
    $traducciones = [
        'Africa' => 'África',
        'Americas' => 'Américas',
        'Asia' => 'Asia',
        'Europe' => 'Europa',
        'Oceania' => 'Oceanía'
    ];
    return $traducciones[$region] ?? $region;
}
