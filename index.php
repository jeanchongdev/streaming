<?php
// Punto de entrada principal de la aplicación
// Se incluyen archivos de configuración y cabecera
include_once 'config/database.php'; // Archivo que contiene la conexión a la base de datos
include_once 'config/config.php';    // Archivo que contiene la configuración global
include_once 'includes/header.php';  // Incluye el encabezado de la página
include_once 'includes/stiker.php'; // Incluir el sticker

// Obtener las películas destacadas (últimas 6)
$sql = "SELECT p.*, c.nombre as categoria_nombre, c.slug as categoria_slug 
        FROM peliculas p 
        JOIN categorias c ON p.categoria_id = c.id 
        ORDER BY p.id DESC 
        LIMIT 10";  // Consulta para obtener las últimas 10 películas
$result = $conn->query($sql);
$featured_movies = []; // Arreglo para almacenar las películas destacadas

// Si hay resultados, se agregan las películas al arreglo
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $featured_movies[] = $row; // Añadir cada película al arreglo
    }
}

// Obtener todas las categorías
$sql = "SELECT * FROM categorias ORDER BY nombre";  // Consulta para obtener todas las categorías ordenadas por nombre
$result = $conn->query($sql);
$categories = [];  // Arreglo para almacenar las categorías

// Si hay resultados, se agregan las categorías al arreglo
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row; // Añadir cada categoría al arreglo
    }
}
?>

<main>
    <!-- Sección Hero: Imagen o video de fondo -->
    <section class="hero">
        <!-- Video de fondo (autoplay, mute, loop) -->
        <video autoplay muted loop playsinline class="background-video">
            <source src="<?php echo $base_url; ?>assets/videos/fondo.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>

        <!-- Contenido que se muestra encima del video -->
        <div class="hero-content">
            <h1>Bienvenido a tu Streaming de Películas</h1>
            <p>Disfruta de las mejores películas en un solo lugar</p>
            <!-- Botón para redirigir a la página de películas -->
            <a href="<?php echo url_amigable('peliculas', ''); ?>" class="btn">Ver Películas</a>
        </div>
    </section>

    <!-- Sección de Películas Destacadas -->
    <section class="featured-movies">
        <div class="container">
            <h2>Películas Destacadas</h2>
            <div class="movie-grid">
                <!-- Recorrer las películas destacadas y mostrar cada una -->
                <?php foreach($featured_movies as $movie): ?>
                <div class="movie-card">
                    <!-- Mostrar la imagen de la pelicula mediante una url -->
                    <div class="movie-poster">
                    <img src="<?php echo $movie['imagen']; ?>" alt="<?php echo $movie['titulo']; ?>">
                        <!-- Overlay con el botón de reproducción -->
                        <div class="movie-overlay">
                            <a href="<?php echo url_amigable('pelicula', $movie['slug'], true); ?>" class="btn-play">
                                <i class="fas fa-play"></i> <!-- Ícono de play -->
                            </a>
                        </div>
                    </div>
                    <!-- Información adicional de la película -->
                    <div class="movie-info">
                        <h3><?php echo $movie['titulo']; ?></h3>
                        <span class="category">
                            <!-- Enlace a la categoría de la película -->
                            <a href="<?php echo url_amigable('categoria', $movie['categoria_slug'], true); ?>">
                                <?php echo $movie['categoria_nombre']; ?>
                            </a>
                        </span>
                        <span class="year"><?php echo $movie['anio']; ?></span> <!-- Año de la película -->
                        <span class="duration"><?php echo $movie['duracion']; ?></span> <!-- Duración de la película -->
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <!-- Enlace para ver todas las películas -->
            <div class="view-all">
                <a href="<?php echo url_amigable('peliculas', ''); ?>" class="btn">Ver Todas las Películas</a>
            </div>
        </div>
    </section>

    <!-- Sección de Categorías -->
    <section class="categories-section">
        <div class="container">
            <h2>Explora por Categorías</h2>
            <div class="categories-grid">
                <!-- Recorrer las categorías y mostrar cada una -->
                <?php foreach($categories as $category): ?>
                <a href="<?php echo url_amigable('categoria', $category['slug'], true); ?>" class="category-card">
                    <h3><?php echo $category['nombre']; ?></h3>
                    <p><?php echo $category['descripcion']; ?></p> <!-- Descripción de la categoría -->
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<!-- Incluir el pie de página -->
<?php include_once 'includes/footer.php'; ?>
