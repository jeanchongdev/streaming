<?php
// Incluir archivos necesarios usando rutas absolutas
include_once __DIR__ . '/../config/database.php';  // Conexión a la base de datos
include_once __DIR__ . '/../config/config.php';    // Configuración global (como $base_url)

// Verificar si se ha enviado el parámetro de búsqueda "q"
if (!isset($_GET['q']) || empty($_GET['q'])) {
    // Si no hay búsqueda, redirigir al inicio
    header("Location: " . $base_url . "index.php");
    exit();
}

// Escapar caracteres peligrosos para evitar inyección SQL
$search_query = $conn->real_escape_string($_GET['q']);

// Consulta SQL para buscar películas por título, descripción o nombre de la categoría
$sql = "
    SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug 
    FROM peliculas p
    JOIN categorias c ON p.categoria_id = c.id
    WHERE p.titulo LIKE '%$search_query%' 
    OR p.descripcion LIKE '%$search_query%' 
    OR c.nombre LIKE '%$search_query%'
    ORDER BY p.titulo
";

// Ejecutar consulta
$result = $conn->query($sql);
$movies = [];

// Si hay resultados, guardarlos en un array
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}

// Si no hay resultados, redirigir a la página de error 404
if (count($movies) == 0) {
    // Guardar el término de búsqueda en una variable de sesión para mostrarla en la página de error
    session_start();
    $_SESSION['search_query'] = $search_query;
    
    // Redirigir a la página de error 404
    header("Location: " . $base_url . "views/error404.php");
    exit();
}

// Si llegamos aquí, hay resultados, así que incluimos el encabezado
include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/stiker.php'; // Incluir el sticker
?>

<main>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/stiker.css">
    <section class="search-results">
        <div class="container">
            <!-- Mostrar el término de búsqueda -->
            <h1>Resultados de búsqueda para: "<?php echo htmlspecialchars($search_query); ?>"</h1>

            <!-- Mostrar películas (sabemos que hay resultados porque sino habría redirigido) -->
            <div class="movie-grid">
                <?php foreach ($movies as $movie): ?>
                <div class="movie-card">
                    <!-- Imagen de la película url con overlay de botón de reproducción -->
                    <div class="movie-poster">
                    <img src="<?php echo $movie['imagen']; ?>" alt="<?php echo $movie['titulo']; ?>">
                        <div class="movie-overlay">
                            <a href="<?php echo url_amigable('pelicula', $movie['slug'], true); ?>" class="btn-play">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Información básica de la película -->
                    <div class="movie-info">
                        <h3>
                            <a href="<?php echo url_amigable('pelicula', $movie['slug'], true); ?>">
                                <?php echo $movie['titulo']; ?>
                            </a>
                        </h3>
                        <!-- Mostrar categoría con enlace -->
                        <span class="category">
                            <a href="<?php echo url_amigable('categoria', $movie['categoria_slug'], true); ?>">
                                <?php echo $movie['categoria_nombre']; ?>
                            </a>
                        </span>
                        <!-- Año y duración -->
                        <span class="year"><?php echo $movie['anio']; ?></span>
                        <span class="duration"><?php echo $movie['duracion']; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<!-- Pie de página del sitio -->
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
