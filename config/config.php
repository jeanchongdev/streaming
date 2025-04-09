<?php
// Verificar si el archivo .env ya está cargado
if (!isset($_ENV['BASE_URL'])) {
    require_once __DIR__ . '/../vendor/autoload.php';
    Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}

// Usar la variable BASE_URL cargada desde .env
$base_url = $_ENV['BASE_URL'];

// -----------------------------------------------
// Función para generar URLs amigables
// -----------------------------------------------
function url_amigable($tipo, $id_o_slug = '', $es_slug = false) {
    global $base_url;

    if (empty($id_o_slug) && !in_array($tipo, ['peliculas', 'anime', 'contacto'])) {
        return $base_url;
    }

    switch ($tipo) {
        case 'pelicula':
            return $base_url . 'views/pelicula.php?' . ($es_slug ? 'slug=' : 'id=') . urlencode($id_o_slug);
        case 'categoria':
            return $base_url . 'views/categoria.php?' . ($es_slug ? 'slug=' : 'id=') . urlencode($id_o_slug);
        case 'peliculas':
            return $base_url . 'views/peliculas.php';
        case 'buscar':
            return $base_url . 'views/buscar.php' . (!empty($id_o_slug) ? '?q=' . urlencode($id_o_slug) : '');
        case 'contacto':
            return $base_url . 'views/contacto.php';
        case 'anime':
            return $base_url . 'views/anime.php';
        default:
            return $base_url . $tipo . '.php';
    }
}

// -----------------------------------------------
// Función de depuración (eliminar en producción)
// -----------------------------------------------
function debug($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

// -----------------------------------------------
// Verifica si un slug existe en una tabla dada
// -----------------------------------------------
function slug_existe($conn, $tabla, $slug) {
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM $tabla WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] > 0;
}

// -----------------------------------------------
// Ruta absoluta del proyecto en el servidor
// -----------------------------------------------
function get_root_path() {
    return $_SERVER['DOCUMENT_ROOT'] . '/streaming/';
}
?>
