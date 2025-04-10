<?php
// Incluir archivos necesarios
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../includes/header.php';

// Iniciar sesión para recuperar el término de búsqueda si viene de una búsqueda fallida
session_start();
$search_query = isset($_SESSION['search_query']) ? $_SESSION['search_query'] : '';
// Limpiar la variable de sesión después de usarla
unset($_SESSION['search_query']);
?>

<!-- Incluir el CSS específico para la página de error 404 -->
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/error404.css">

<main>
    <section class="error-404">
        <div class="container">
            <div class="error-content">
                <h1>404</h1>
                <h2>Página no encontrada</h2>
                
                <?php if (!empty($search_query)): ?>
                    <p>No se encontraron resultados para tu búsqueda: "<strong><?php echo htmlspecialchars($search_query); ?></strong>"</p>
                <?php else: ?>
                    <p>La página que estás buscando no existe o ha sido movida.</p>
                <?php endif; ?>
                
                <div class="error-gif">
                <img src="https://i.postimg.cc/GtJD49LW/gifs.gif" alt="Error 404 - Página no encontrada">
                </div>
                
                <div class="error-suggestions">
                    <h3>Sugerencias:</h3>
                    <ul>
                        <li>Verifica la URL ingresada</li>
                        <li>Intenta con otra búsqueda o términos más generales</li>
                        <li>Explora nuestras categorías populares</li>
                    </ul>
                </div>
                
                <div class="error-actions">
                    <a href="<?php echo $base_url; ?>index.php" class="btn">Volver al inicio</a>
                    <?php if (!empty($search_query)): ?>
                        <a href="<?php echo $base_url; ?>views/peliculas.php" class="btn btn-secondary">Ver todas las películas</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
