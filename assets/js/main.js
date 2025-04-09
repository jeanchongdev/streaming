document.addEventListener("DOMContentLoaded", () => {
  // Toggle para el menú móvil: cambia el estado del menú al hacer clic
  const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
  const nav = document.querySelector("nav");

  if (mobileMenuToggle && nav) {
    mobileMenuToggle.addEventListener("click", function () {
      // Alterna la clase 'active' en el menú de navegación
      nav.classList.toggle("active");

      // Cambiar el ícono del botón de menú (de barras a cruz y viceversa)
      const icon = this.querySelector("i");
      if (icon) {
        if (nav.classList.contains("active")) {
          icon.classList.remove("fa-bars");
          icon.classList.add("fa-times");
        } else {
          icon.classList.remove("fa-times");
          icon.classList.add("fa-bars");
        }
      }
    });
  }

  // Menú desplegable para dispositivos móviles
  const dropdowns = document.querySelectorAll(".dropdown");

  dropdowns.forEach((dropdown) => {
    const dropbtn = dropdown.querySelector(".dropbtn");

    // Solo se aplica a pantallas pequeñas (menos de 768px)
    if (window.innerWidth <= 768 && dropbtn) {
      dropbtn.addEventListener("click", (e) => {
        // Prevenir la acción predeterminada del enlace
        e.preventDefault();

        // Cerrar todos los dropdowns abiertos antes de alternar el estado del actual
        dropdowns.forEach((otherDropdown) => {
          if (otherDropdown !== dropdown) {
            otherDropdown.classList.remove("active");
          }
        });

        // Alternar el estado activo de este dropdown
        if (dropdown.classList.contains("active")) {
          dropdown.classList.remove("active"); // Cierra el dropdown
        } else {
          dropdown.classList.add("active"); // Abre el dropdown
        }
      });
    }
  });

  // Cerrar los dropdowns cuando se hace clic fuera de ellos
  document.addEventListener("click", (e) => {
    // Verificar si el clic fue fuera de los elementos dropdown
    if (!e.target.closest(".dropdown")) {
      dropdowns.forEach((dropdown) => {
        dropdown.classList.remove("active"); // Cierra todos los dropdowns
      });
    }
  });

  // Controles para el reproductor de video
  const videoPlayer = document.querySelector("video");
  if (videoPlayer) {
    // Cuando el video comienza a reproducirse
    videoPlayer.addEventListener("play", () => {
      console.log("El video comenzó a reproducirse");
    });

    // Cuando el video se pausa
    videoPlayer.addEventListener("pause", () => {
      console.log("El video está en pausa");
    });

    // Cuando el video termina
    videoPlayer.addEventListener("ended", () => {
      console.log("El video terminó");
      // Desplazar hacia los videos relacionados
      const relatedMovies = document.querySelector(".related-movies");
      if (relatedMovies) {
        relatedMovies.scrollIntoView({
          behavior: "smooth",
        });
      }
    });
  }

  // Carga perezosa de imágenes (Lazy loading)
  if ("IntersectionObserver" in window) {
    // Crear un observador para cargar imágenes solo cuando sean visibles en pantalla
    const imgObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          const src = img.getAttribute("data-src");

          // Cargar la imagen si no está cargada ya
          if (src) {
            img.src = src;
            img.removeAttribute("data-src"); // Elimina el atributo para evitar cargas adicionales
          }

          // Deja de observar la imagen una vez que se ha cargado
          observer.unobserve(img);
        }
      });
    });

    // Iniciar la observación de todas las imágenes que tienen el atributo 'data-src'
    document.querySelectorAll("img[data-src]").forEach((img) => {
      imgObserver.observe(img);
    });
  }
});