<?php

// Importar los datos.
require '../data/datos.php';

// Antes de incluir la cabecera inicializamos la variable del título.
$titulo_pagina = "Enciclopedia de Animales - Inicio";
include '../includes/header.php';

// Mostrar las categorías disponibles en una lista con el enlace requerido.
echo "<ul>";
foreach ($categorias as $categoria) {
  printf("<li><a href='category.php?id=%d'>%s</a></li>", 
    $categoria['id'], 
    $categoria['nombre'] 
);
}
echo "</ul>";

// Incluir el pie de página.
include '../includes/footer.php';
?>
