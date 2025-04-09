<?php
// -----------------------------------------------
// Archivo de configuración de la base de datos
// Creamos las tablas necesarias para el proyecto
// -----------------------------------------------

// Datos de conexión a la base de datos MySQL debemos de poner los datos correctos
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname   = $_ENV['DB_NAME'];

// Crear conexión con MySQL y seleccionar la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa o mostrar el error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// -----------------------------------------------
// Crearemos tabla de categorías
// -----------------------------------------------
$sql = "CREATE TABLE IF NOT EXISTS categorias (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,    -- ID autoincremental
    nombre VARCHAR(100) NOT NULL,             -- Nombre de la categoría
    descripcion TEXT                          -- Descripción opcional
)";

// Ejecutar query y mostrar mensaje cuando se cree la tabla
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'categorias' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'categorias': " . $conn->error . "<br>";
}

// -----------------------------------------------
// Crearemos tabla de películas
// -----------------------------------------------
$sql = "CREATE TABLE IF NOT EXISTS peliculas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,    -- ID de la película
    titulo VARCHAR(255) NOT NULL,             -- Título obligatorio
    descripcion TEXT,                         -- Descripción opcional
    categoria_id INT(11),                     -- Relación con tabla 'categorias'
    imagen VARCHAR(255),                      -- Ruta o URL de la imagen
    video_url VARCHAR(255),                   -- URL del video
    anio INT(4),                              -- Año de estreno
    duracion VARCHAR(10),                     -- Duración (ej. 1h 30m)
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
    -- Si se borra la categoría, se pone en NULL
)";

// Ejecutar query y mostrar mensaje cuando se cree la tabla
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'peliculas' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'peliculas': " . $conn->error . "<br>";
}

// Cerrar conexión a la base de datos
$conn->close();

// Mensaje final de configuración exitosa
echo "✔️ Configuración completada correctamente!";
?>
