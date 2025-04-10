<?php
// Incluir archivos necesarios: conexión a la base de datos, configuración general y encabezado del sitio
include_once __DIR__ . '/../config/database.php';  // Archivo que contiene la conexión a la base de datos
include_once __DIR__ . '/../config/config.php';     // Archivo que contiene la configuración global
include_once __DIR__ . '/../includes/header.php';   // Incluye el encabezado de la página
include_once '../includes/stiker.php'; // Incluir el sticker

// Verificar si se proporciona un "slug" o un "id" para identificar la película
if (isset($_GET['slug'])) {
    $slug = $_GET['slug']; // Usar el slug para identificar la película
    
    // Consulta SQL para obtener la película usando el slug
    $sql = "SELECT p.*, c.nombre as categoria_nombre, c.id as categoria_id, c.slug as categoria_slug 
            FROM peliculas p 
            JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.slug = '$slug'"; // Buscar por slug
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pelicula_id = $_GET['id']; // Usar el ID si se proporciona (compatibilidad con enlaces antiguos)
    
    // Consulta SQL para obtener la película usando el ID
    $sql = "SELECT p.*, c.nombre as categoria_nombre, c.id as categoria_id, c.slug as categoria_slug 
            FROM peliculas p 
            JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.id = $pelicula_id"; // Buscar por ID
} else {
    // Si no hay slug ni ID, redirigir a la página principal
    header("Location: " . $base_url . "index.php");
    exit(); // Detener la ejecución del script
}

// Ejecutar la consulta SQL para obtener la película
$result = $conn->query($sql);

// Verificar si la consulta no fue exitosa o no encontró resultados
if (!$result || $result->num_rows == 0) {
    // Si no hay resultados, redirigir a la página principal
    header("Location: " . $base_url . "index.php");
    exit(); // Detener la ejecución del script
}

// Obtener la película de la consulta y almacenarla en un arreglo
$movie = $result->fetch_assoc();

// Obtener películas relacionadas de la misma categoría
$sql = "SELECT p.* 
        FROM peliculas p 
        WHERE p.categoria_id = {$movie['categoria_id']} 
        AND p.id != {$movie['id']} 
        ORDER BY RAND() 
        LIMIT 4"; // Buscar 4 películas aleatorias de la misma categoría, excluyendo la película actual
$result = $conn->query($sql);
$related_movies = []; // Inicializar arreglo para almacenar películas relacionadas

// Verificar si la consulta fue exitosa y contiene resultados
if ($result && $result->num_rows > 0) {
    // Si hay resultados, agregarlos al arreglo de películas relacionadas
    while($row = $result->fetch_assoc()) {
        $related_movies[] = $row;
    }
}
?>

<main>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/stiker.css">
    <!-- Sección de detalles de la película -->
    <section class="movie-detail">
        <div class="container">
            <!-- Encabezado con el título y metadatos de la película -->
            <div class="movie-header">
                <h1><?php echo $movie['titulo']; ?></h1> <!-- Título de la película -->
                <div class="movie-meta">
                    <span class="category">
                        <!-- Enlace a la categoría de la película -->
                        <a href="<?php echo url_amigable('categoria', $movie['categoria_slug'], true); ?>">
                            <?php echo $movie['categoria_nombre']; ?> <!-- Nombre de la categoría -->
                        </a>
                    </span>
                    <span class="year"><?php echo $movie['anio']; ?></span> <!-- Año de estreno -->
                    <span class="duration"><?php echo $movie['duracion']; ?></span> <!-- Duración de la película -->
                </div>
            </div>
            
            <!-- Contenido principal de la película -->
            <div class="movie-content">
                <div class="movie-player">
                    <!-- Reproductor de video usando un iframe para una URL externa -->
                    <?php if (!empty($movie['video_url'])): ?>
                        <iframe src="<?php echo $movie['video_url']; ?>" frameborder="0" allowfullscreen></iframe>
                    <?php else: ?>
                        <p>No hay video disponible.</p>
                    <?php endif; ?>
                </div>
                
                <div class="movie-info-detail">
                    <h2>Descripción</h2>
                    <p><?php echo $movie['descripcion']; ?></p> <!-- Descripción de la película -->
                </div>
            </div>
            
            <!-- Mostrar películas relacionadas si existen -->
            <?php if (count($related_movies) > 0): ?>
            <div class="related-movies">
                <h2>Películas Relacionadas</h2>
                <div class="movie-grid">
                    <?php foreach($related_movies as $related): ?> <!-- Iterar sobre las películas relacionadas -->
                    <div class="movie-card">
                        <div class="movie-poster">
                            <!-- Mostrar la imagen de la película relacionada mediante una URL -->
                            <?php
                                $imagen_url = $related['imagen'];
                                if (!preg_match('/^https?:\/\//', $imagen_url)) {
                                    $imagen_url = $base_url . 'assets/images/' . $imagen_url;
                                }
                            ?>
                            <img src="<?php echo $imagen_url; ?>" alt="<?php echo $related['titulo']; ?>">
                            <!-- Botón para ver la película relacionada -->
                            <div class="movie-overlay">
                                <a href="<?php echo url_amigable('pelicula', $related['slug'], true); ?>" class="btn-play">
                                    <i class="fas fa-play"></i> <!-- Icono de reproducción -->
                                </a>
                            </div>
                        </div>
                        <div class="movie-info">
                            <h3>
                                <!-- Enlace a la página de detalles de la película relacionada -->
                                <a href="<?php echo url_amigable('pelicula', $related['slug'], true); ?>">
                                    <?php echo $related['titulo']; ?> <!-- Título de la película relacionada -->
                                </a>
                            </h3>
                            <span class="year"><?php echo $related['anio']; ?></span> <!-- Año de estreno -->
                            <span class="duration"><?php echo $related['duracion']; ?></span> <!-- Duración -->
                        </div>
                    </div>
                    <?php endforeach; ?> <!-- Fin de la iteración sobre las películas relacionadas -->
                </div>
            </div>
            <?php endif; ?> <!-- Fin de la sección de películas relacionadas -->
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?> <!-- Incluir el pie de página -->
