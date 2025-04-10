<?php
// Incluir archivo de configuración solo si la función no existe aún
if (!function_exists('url_amigable')) {
    include_once __DIR__ . '/../config/config.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming de Películas</title>

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/styles.css">
    
    <!-- Iconos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Fuentes personalizadas -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">

    
    <!-- Ícono del sitio -->
    <link rel="icon" href="https://i.postimg.cc/xjbxg5yZ/Logo.png" type="image/png">
</head>
<body>
    <header>
        <div class="container">

            <!-- Logo principal con enlace al inicio -->
            <div class="logo">
                <a href="<?php echo $base_url; ?>index.php">
                    <h1>CineStream</h1>
                </a>
            </div>

            <!-- Caja de búsqueda -->
            <div class="search-box">
                <form action="<?php echo $base_url; ?>views/buscar.php" method="GET">
                    <input type="text" name="q" placeholder="Buscar películas..." required>
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <!-- Botón para abrir menú en móviles -->
            <button class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Menú principal de navegación -->
            <nav>
                <ul class="main-menu">
                    <!-- Enlace a la página de inicio -->
                    <li><a href="<?php echo $base_url; ?>index.php">Inicio</a></li>

                    <!-- Menú desplegable de películas -->
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn">Películas <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown-content">
                            <!-- Enlace a todas las películas -->
                            <a href="<?php echo url_amigable('peliculas'); ?>">Todas las Películas</a>
                            <?php
                            // Verificamos si ya hay conexión a la base de datos
                            if (!isset($conn)) {
                                include_once __DIR__ . '/../config/database.php';
                            }

                            // Consulta para obtener todas las categorías
                            $sql = "SELECT * FROM categorias ORDER BY nombre";
                            $result = $conn->query($sql);

                            // Si hay resultados, los mostramos como enlaces
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<a href="' . url_amigable('categoria', $row['slug'], true) . '">' . htmlspecialchars($row['nombre']) . '</a>';
                                }
                            }
                            ?>
                        </div>
                    </li>

                    <!-- Menú desplegable de categorías -->
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn">Categorías <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown-content">
                            <?php
                            // Si no se puede reutilizar el resultado anterior, volver a hacer la consulta
                            if (!isset($result) || !$result) {
                                $sql = "SELECT * FROM categorias ORDER BY nombre";
                                $result = $conn->query($sql);
                            } else {
                                // Reiniciar el puntero de los resultados para reutilizar
                                $result->data_seek(0);
                            }

                            // Mostrar todas las categorías nuevamente
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<a href="' . url_amigable('categoria', $row['slug'], true) . '">' . htmlspecialchars($row['nombre']) . '</a>';
                                }
                            }
                            ?>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</body>
