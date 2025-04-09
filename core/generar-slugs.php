<?php
include_once '../config/database.php';

// Función para generar slugs
function generarSlug($texto) {
    // Convertir a minúsculas
    $texto = strtolower($texto);
    
    // Reemplazar caracteres especiales y espacios por guiones
    $texto = preg_replace('/[^a-z0-9]/', '-', $texto);
    
    // Eliminar guiones múltiples
    $texto = preg_replace('/-+/', '-', $texto);
    
    // Eliminar guiones al principio y al final
    $texto = trim($texto, '-');
    
    return $texto;
}

// Generar slugs para películas
$sql = "SELECT id, titulo FROM peliculas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $slug = generarSlug($row['titulo']);
        
        // Actualizar el registro con el slug
        $update = "UPDATE peliculas SET slug = '$slug' WHERE id = {$row['id']}";
        $conn->query($update);
        
        echo "Película ID {$row['id']}: '{$row['titulo']}' → slug: '$slug'<br>";
    }
}

// Generar slugs para categorías
$sql = "SELECT id, nombre FROM categorias";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $slug = generarSlug($row['nombre']);
        
        // Actualizar el registro con el slug
        $update = "UPDATE categorias SET slug = '$slug' WHERE id = {$row['id']}";
        $conn->query($update);
        
        echo "Categoría ID {$row['id']}: '{$row['nombre']}' → slug: '$slug'<br>";
    }
}

echo "<p>¡Slugs generados correctamente!</p>";
?>

