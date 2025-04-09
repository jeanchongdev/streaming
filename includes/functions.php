<?php
// ==============================
// Funciones personalizadas del sitio
// ==============================

/**
 * Genera un slug amigable a partir de un texto.
 * Ejemplo: "Película de Acción 2024" → "pelicula-de-accion-2024"
 *
 * @param string $texto Texto original.
 * @return string Slug generado.
 */
function generarSlug($texto) {
    // Convertir a minúsculas
    $texto = strtolower($texto);
    
    // Reemplazar caracteres especiales por guiones
    $texto = preg_replace('/[^a-z0-9]/', '-', $texto);
    
    // Reemplazar múltiples guiones seguidos por uno solo
    $texto = preg_replace('/-+/', '-', $texto);
    
    // Quitar guiones al inicio y al final
    $texto = trim($texto, '-');
    
    return $texto;
}

// ======================================
// función adicional:
// ======================================

/**
 * Función para limitar texto a cierta cantidad de caracteres sin cortar palabras.
 *
 * @param string $texto Texto original.
 * @param int $limite Cantidad máxima de caracteres.
 * @return string Texto resumido con "..." si fue recortado.
 */
function limitarTexto($texto, $limite = 100) {
    if (strlen($texto) <= $limite) return $texto;
    
    // Cortar sin romper palabras
    $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' '));
    return $texto . '...';
}
?>
