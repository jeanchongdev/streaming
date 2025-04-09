<footer>
    <div class="container">
        <div class="footer-content">
            
            <!-- Logo y descripción -->
            <div class="footer-logo">
                <h2>CineStream</h2>
                <p>Tu plataforma de streaming favorita</p>
            </div>

            <!-- Enlaces rápidos (navegación principal) -->
            <div class="footer-links">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><a href="<?php echo $base_url; ?>index.php">Inicio</a></li>
                    <li><a href="<?php echo url_amigable('peliculas', ''); ?>">Películas</a></li>
                </ul>
            </div>

            <!-- Categorías populares (máximo 5) -->
            <div class="footer-categories">
                <h3>Categorías</h3>
                <ul>
                    <?php
                    // Incluir conexión a la base de datos si no está definida
                    if (!isset($conn)) {
                        include_once 'config/database.php';
                    }

                    // Obtener las primeras 5 categorías ordenadas por nombre
                    $sql = "SELECT * FROM categorias ORDER BY nombre LIMIT 5";
                    $result = $conn->query($sql);

                    // Mostrar cada categoría como enlace
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<li><a href="' . url_amigable('categoria', $row['slug'], true) . '">' . $row['nombre'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <!-- Redes sociales -->
            <div class="footer-social">
                <h3>Síguenos</h3>
                <div class="social-icons">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/jeanchongdev" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    
                    <!-- GitHub -->
                    <a href="https://github.com/jeanchongdev" target="_blank">
                        <i class="fab fa-github"></i>
                    </a>
                    
                    <!-- Contacto -->
                    <a href="<?= $base_url ?>views/contacto.php">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pie inferior con derechos de autor -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> CineStream. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<!-- Script principal del sitio -->
<script src="<?php echo $base_url; ?>assets/js/main.js"></script>
</body>
</html>
