<?php
// Incluir los archivos necesarios usando rutas absolutas para evitar errores de inclusión
include_once __DIR__ . '/../config/database.php'; // Conexión a la base de datos
include_once __DIR__ . '/../config/config.php';    // Variables globales de configuración (como $base_url)
include_once __DIR__ . '/../includes/header.php';  // Encabezado común del sitio
include_once '../includes/stiker.php'; // Incluir el sticker

// Verificar si se ha pasado un slug (nombre amigable) por la URL
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    // Consulta SQL para obtener la categoría correspondiente al slug
    $sql = "SELECT * FROM categorias WHERE slug = '$slug'";

} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoria_id = $_GET['id'];

    // Consulta para obtener la categoría por ID (opción antigua o respaldo)
    $sql = "SELECT * FROM categorias WHERE id = $categoria_id";

} else {
    // Si no se proporcionó ni slug ni ID, redirigir a la página principal
    header("Location: " . $base_url . "index.php");
    exit();
}

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si se encontró una categoría válida
if (!$result || $result->num_rows == 0) {
    // Redirigir a inicio si no existe la categoría
    header("Location: " . $base_url . "index.php");
    exit();
}

// Guardar los datos de la categoría encontrada
$category = $result->fetch_assoc();

// Consultar todas las películas que pertenecen a esta categoría
$sql = "SELECT p.*, c.nombre as categoria_nombre, c.slug as categoria_slug 
        FROM peliculas p 
        JOIN categorias c ON p.categoria_id = c.id 
        WHERE p.categoria_id = {$category['id']} 
        ORDER BY p.titulo";

// Ejecutar la consulta
$result = $conn->query($sql);

// Inicializar array para almacenar las películas
$movies = [];

// Si hay resultados, guardar cada película en el array
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}
?>

<main>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/stiker.css">
    <section class="category-section">
        <div class="container">
            <!-- Mostrar nombre y descripción de la categoría -->
            <h1>Categoría: <?php echo $category['nombre']; ?></h1>
            <p class="category-description"><?php echo $category['descripcion']; ?></p>

            <?php if (count($movies) > 0): ?>
                <!-- Si hay películas en la categoría, mostrarlas en forma de grilla -->
                <div class="movie-grid">
                    <?php foreach($movies as $movie): ?>
                    <div class="movie-card">
                        <!-- Mostrar imagen de la película con enlace para verla -->
                        <div class="movie-poster">
                        <img src="<?php echo $movie['imagen']; ?>" alt="<?php echo $movie['titulo']; ?>">
                            <div class="movie-overlay">
                                <!-- Botón de play sobre la imagen -->
                                <a href="<?php echo url_amigable('pelicula', $movie['slug'], true); ?>" class="btn-play">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Mostrar información de la película -->
                        <div class="movie-info">
                            <h3>
                                <a href="<?php echo url_amigable('pelicula', $movie['slug'], true); ?>">
                                    <?php echo $movie['titulo']; ?>
                                </a>
                            </h3>
                            <!-- Mostrar la categoría y enlazarla -->
                            <span class="category">
                                <a href="<?php echo url_amigable('categoria', $movie['categoria_slug'], true); ?>">
                                    <?php echo $movie['categoria_nombre']; ?>
                                </a>
                            </span>
                            <!-- Mostrar el año y duración de la película -->
                            <span class="year"><?php echo $movie['anio']; ?></span>
                            <span class="duration"><?php echo $movie['duracion']; ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Si no hay películas, mostrar mensaje -->
                <div class="no-movies">
                    <p>No hay películas disponibles en esta categoría.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<!-- Incluir pie de página -->
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
