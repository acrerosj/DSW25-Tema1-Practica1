<?php

// Importar los datos.
require '../data/datos.php';

if (!isset($_GET['id']) || !array_key_exists($_GET['id'], $categorias)) {
  // Si no se ha proporcionado una categoría válida, mostrar error.
  echo "ERROR: la categoría no es válida.";
} else {
  $categoria_id = $_GET['id'];
  $categoria = $categorias[$categoria_id];
  $nombre_categoria = $categoria['nombre'];
  $titulo_pagina = "Categoría: $nombre_categoria";
  include '../includes/header.php';

  // Busca en el array $categorias la información de la categoría correspondiente y muestra su nombre y descripción.
  printf("<h2>%s</h2>", $nombre_categoria);
  printf("<p>%s</p>", $categoria['descripcion']);

  //Recorre el array $animales y muestra un listado con los nombres de los animales que pertenecen a esa categoría.
  echo "<ul>";
  foreach ($animales as $animal_id => $animal) {
    if ($animal['categoria_id'] == $categoria_id) {
      printf("<li><a href='animal.php?id=%d'>%s</a></li>", 
        $animal_id, 
        $animal['nombre'] 
      );
    }
  }
  echo "</ul>";

  // Incluir el pie de página.
  include '../includes/footer.php';
}
?>