<?php
// Incluir los archivos de configuración y encabezado para establecer conexión y estructura básica
include_once '../config/database.php';  // Archivo que contiene la conexión a la base de datos
include_once '../config/config.php';    // Archivo que contiene la configuración global
include_once '../includes/header.php';  // Incluye el encabezado de la página
include_once '../includes/stiker.php'; // Incluir el sticker
?>

<main>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/stiker.css">
    <!-- Sección principal de contacto -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-container">
                <!-- Información de contacto -->
                <div class="contact-info">
                    <h1>Contáctanos</h1>
                    <p>¿Tienes alguna pregunta, sugerencia o comentario? Nos encantaría saber de ti. Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>
                    
                    <!-- Detalles de contacto -->
                    <div class="contact-details">
                        <!-- Dirección -->
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h3>Dirección</h3>
                                <p>Av. Streaming 123, Ciudad Digital</p>
                            </div>
                        </div>
                        
                        <!-- Teléfono -->
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h3>Teléfono</h3>
                                <p>+123 456 7890</p>
                            </div>
                        </div>
                        
                        <!-- Correo electrónico -->
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h3>Email</h3>
                                <p>info@cinestream.com</p>
                            </div>
                        </div>
                        
                        <!-- Horarios de atención -->
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h3>Horario de Atención</h3>
                                <p>Lunes a Viernes: 9am - 6pm</p>
                            </div>
                        </div>
                    </div>
            
                </div>
                
                <!-- Formulario de contacto -->
                <div class="contact-form">
                    <h2>Envíanos un mensaje</h2>
                    <!-- Formulario que envía los datos a Formspree -->
                    <form id="contactForm" action="https://formspree.io/f/mblgprzk" method="POST">
                        <!-- Campo para el nombre completo -->
                        <div class="form-group">
                            <label for="name">Nombre completo</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <!-- Campo para el correo electrónico -->
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <!-- Campo para el mensaje -->
                        <div class="form-group">
                            <label for="message">Mensaje</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-submit">Enviar mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer simplificado para la página de contacto -->
<footer>
    <div class="container">
        <div class="footer-content">
            <!-- Logo y descripción del pie de página -->
            <div class="footer-logo">
                <h2>CineStream</h2>
                <p>Tu plataforma de streaming favorita</p>
            </div>
            <!-- Enlaces rápidos -->
            <div class="footer-links">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><a href="<?php echo $base_url; ?>index.php">Inicio</a></li>
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
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> CineStream. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<!-- Inclusión de SweetAlert2 para mostrar alertas -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const formData = new FormData(contactForm);
            
            // Mostrar mensaje de éxito inmediatamente
            Swal.fire({
                title: '¡Mensaje enviado!',
                text: 'Gracias por contactarnos. Te responderemos lo antes posible.',
                icon: 'success',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#e50914'
            });

            // Limpiar el formulario de inmediato
            contactForm.reset();
            
            // Enviar datos al servidor en segundo plano
            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Solo mostramos error si algo sale mal
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al enviar tu mensaje. Por favor, inténtalo de nuevo.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#e50914'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al enviar tu mensaje. Por favor, inténtalo de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#e50914'
                });
            });
        });
    }
});
</script>


<!-- Script principal de la página -->
<script src="<?php echo $base_url; ?>assets/js/main.js"></script>

</body>
</html>
