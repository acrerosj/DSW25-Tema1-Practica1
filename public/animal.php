<?php

// Importar los datos.
require '../data/datos.php';

if (!isset($_GET['id']) || !array_key_exists($_GET['id'], $animales)) {
  // Si no se ha proporcionado un id de animal no válido, se muestra el error.
  echo "ERROR: el id de animal no es válido.";
} else {
  $animal_id = $_GET['id'];
  $animal = $animales[$animal_id];
  $titulo_pagina = "Animal: $animal[nombre]";
  include '../includes/header.php';

  // Busca en el array $categorias la información de la categoría correspondiente y muestra su nombre y descripción.
  printf("<h2>%s</h2>", $animal['nombre']);
  printf("<p>Hábitat: %s</p>", $animal['habitat']);
  
  // Muestra las características del animal en una lista.
  echo "<h3>Características:</h3>";
  echo "<ul>";
  foreach ($animal['caracteristicas'] as $caracteristica) {
    printf("<li>%s</li>", $caracteristica);
  }
  echo "</ul>";

  // Muestra la imagen y el enlace al PDF.
  printf("<img src='uploads/images/%s' alt='Imagen de %s'>", $animal['imagen'], $animal['nombre']);
  printf("<p><a href='uploads/pdfs/%s'>Ver ficha en PDF</a></p>", $animal['pdf']);
  // Las imagenes se encuentran en la carpeta images y los PDFs en la carpeta pdf.
  // No se mostrará la imagen hasta que no se suba un archivo imagen para el animal.


  // Incluir el pie de página.
  include '../includes/footer.php';
}
?>