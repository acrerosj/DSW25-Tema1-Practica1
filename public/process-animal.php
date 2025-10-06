<?php
require '../data/datos.php';

// Creamos una variable error para almacenar mensajes de error.
$error = [];

// Validamos la categoría es enviada y es válida.
if (!isset($_POST['categoria_id']) || !array_key_exists($_POST['categoria_id'], $categorias)) {
  $error[] = "La categoría no es válida.";
} else {
  $categoria_id = $_POST['categoria_id'];
} 

// Validamos el id del animal es enviado y es un número.
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
  $error[] = "El id del animal no es válido.";
} else {
  $id = (int) $_POST['id'];
  // Deberíamos validar que el id del animal no exista ya en el array $animales.
  if (array_key_exists($id, $animales)) {
    $error[] = "El id del animal ya existe.";
  }
}

// Validamos el nombre del animal es enviado y no está vacío.
if (!isset($_POST['nombre']) || trim($_POST['nombre'])==='') {
  $error[] = "El nombre del animal no es válido.";
} else {
  $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
}

// Validamos el hábitat del animal es enviado y no está vacío.
if (!isset($_POST['habitat']) || trim($_POST['habitat'])==='') {
  $error[] = "El hábitat del animal no es válido.";
} else {
  $habitat = htmlspecialchars(trim($_POST['habitat']), ENT_QUOTES, 'UTF-8');
} 

// Validamos las características del animal es enviado.
if (!isset($_POST['caracteristicas'])) {
  $error[] = "Las características del animal no son válidas.";
} else {
  // Troceamos las características por comas y limpiamos espacios en blanco.
  $trozos_cadena = explode(',', $_POST['caracteristicas']);
  // Creamos un array para almacenar las características limpias.
  $caracteristicas = [];
  foreach ($trozos_cadena as $trozo) {
    // Limpiamos espacios en blanco y convertimos caracteres especiales.
    $caracteristica = htmlspecialchars(trim($trozo), ENT_QUOTES, 'UTF-8');
    // Si la característica no está vacía la añadimos al array.
    if ($caracteristica !== '') {
      $caracteristicas[] = $caracteristica;
    }
  }
}

// No lo dice el enunciado, pero vamos a suponer que el archivo de imagen y el pdf no son obligatorios.
// Por tanto, no validamos que se hayan enviado para no dar error si no se envían.


$titulo_pagina = "Procesar Registro de Animal";
include '../includes/header.php';
// Si hay errores los mostramos y no procesamos el formulario.
if (count($error) > 0) {
  echo "<h2>Errores en el formulario</h2>";
  echo "<ul>";
  foreach ($error as $mensaje) {
    printf("<li>%s</li>", $mensaje);
  }
  echo "</ul>";
} else {
  // No hay errores, mostramos los datos recibidos.
  echo "<h2>Nuevo Animal Registrado</h2>";
  printf("<p>Categoría: %s</p>", $categorias[$categoria_id]['nombre']);
  printf("<p>Id: %d</p>", $id);
  printf("<p>Nombre: %s</p>", $nombre);
  printf("<p>Hábitat: %s</p>", $habitat);
  echo "<h3>Características:</h3>";
  echo "<ul>";
  foreach ($caracteristicas as $caracteristica) {
    printf("<li>%s</li>", $caracteristica); 
  }
  echo "</ul>";

  // Incluimos el archivo de funciones para subir los archivos.

  require '../includes/functions.php';
  // Comprobamos si se ha enviado un archivo de imagen.
  $subirImagen = subirFichero($_FILES['imagen'], $id, ['image/jpeg', 'image/jpg'], 'images');
  if ($subirImagen !== null) {
    echo "<p>$subirImagen</p>";
  } else {
    $nombreImagen = $id . '.jpg';
    $rutaImagen = 'uploads/images/' . $nombreImagen;
    printf("<img src='%s' alt='Imagen de %s'>", $rutaImagen, $nombre);
  }

  // Comprobamos si se ha enviado un archivo PDF.
  $subirPdf = subirFichero($_FILES['pdf'], $id, ['application/pdf'], 'pdfs');
  if ($subirPdf !== null) {
    echo "<p>$subirPdf</p>";
  } else {
    $nombrePdf = $id . '.pdf';
    $rutaPdf = 'uploads/pdfs/' . $nombrePdf;
    printf("<p><a href='%s' target='_blank'>Ver ficha en PDF</a></p>", $rutaPdf);
  }
}

include '../includes/footer.php';

?>
