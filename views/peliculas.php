<?php
// Incluir archivos necesarios: conexión a la base de datos, configuración, y encabezado del sitio
include_once __DIR__ . '/../config/database.php';  // Archivo que contiene la conexión a la base de datos
include_once __DIR__ . '/../config/config.php';     // Archivo que contiene la configuración global
include_once __DIR__ . '/../includes/header.php';   // Incluye el encabezado de la página
include_once '../includes/stiker.php'; // Incluir el sticker

// Obtener todas las películas con su categoría asociada
$sql = "SELECT p.*, c.nombre as categoria_nombre, c.slug as categoria_slug 
        FROM peliculas p 
        JOIN categorias c ON p.categoria_id = c.id 
        ORDER BY p.titulo"; // Consulta SQL que selecciona todas las películas junto con la categoría correspondiente
$result = $conn->query($sql); // Ejecutar la consulta
$movies = []; // Inicializar un arreglo vacío para almacenar las películas

// Verificar si la consulta se ejecutó correctamente y contiene resultados
if ($result && $result->num_rows > 0) {
    // Si hay resultados, recorrerlos y almacenarlos en el arreglo $movies
    while($row = $result->fetch_assoc()) {
        $movies[] = $row; // Agregar cada película al arreglo
    }
}
?>

<main>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/stiker.css">
    <!-- Sección de películas -->
    <section class="movies-section">
        <div class="container">
            <!-- Título de la página -->
            <h1>Todas las Películas</h1>
            
            <!-- Grilla de películas -->
            <div class="movie-grid">
                <?php foreach($movies as $movie): ?> <!-- Iterar sobre todas las películas -->
                <div class="movie-card">
                    <!-- Mostrar el cartel de la pelicula mediante una url -->
                    <div class="movie-poster">
                    <img src="<?php echo $movie['imagen']; ?>" alt="<?php echo $movie['titulo']; ?>">
                        <!-- Superposición con el botón de reproducción -->
                        <div class="movie-overlay">
                            <a href="<?php echo url_amigable('pelicula', $movie['slug'], true); ?>" class="btn-play">
                                <i class="fas fa-play"></i> <!-- Icono de reproducción -->
                            </a>
                        </div>
                    </div>
                    <!-- Información de la película -->
                    <div class="movie-info">
                        <h3>
                            <a href="<?php echo url_amigable('pelicula', $movie['slug'], true); ?>">
                                <?php echo $movie['titulo']; ?> <!-- Título de la película -->
                            </a>
                        </h3>
                        <!-- Categoría de la película -->
                        <span class="category">
                            <a href="<?php echo url_amigable('categoria', $movie['categoria_slug'], true); ?>">
                                <?php echo $movie['categoria_nombre']; ?> <!-- Nombre de la categoría -->
                            </a>
                        </span>
                        <!-- Año de estreno y duración de la película -->
                        <span class="year"><?php echo $movie['anio']; ?></span> <!-- Año -->
                        <span class="duration"><?php echo $movie['duracion']; ?></span> <!-- Duración -->
                    </div>
                </div>
                <?php endforeach; ?> <!-- Fin de la iteración sobre las películas -->
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?> <!-- Incluir el pie de página -->
