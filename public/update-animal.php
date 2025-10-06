<?php

// Importar los datos.
require '../data/datos.php';

// Antes de incluir la cabecera inicializamos la variable del título.
$titulo_pagina = "Actualizar Animal";
include '../includes/header.php';

// Siempre se ha de leer un id por GET, tanto para mostrar el formulario como para procesarlo.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<p>El id del animal no es válido.</p>";
} else {
  $id = (int)$_GET['id'];
  // Comprobamos que el id exista en el array de animales.
  if (!array_key_exists($id, $animales)) {
    echo "<p>No se ha encontrado el animal con id $id.</p>";
  } else {
    $animal = $animales[$id];
    // ------------------------------------------------------------------
    // Comprobamos si se ha enviado un formulario (método POST) o no.
    // ----------------------------------------
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      // Si se ha enviado el formulario procesamos los datos.
      printf("<h2>Actualizado Animal: %s (ID: %d)</h2>", $animal['nombre'], $id);

      require '../includes/functions.php';
      // Comprobamos si se ha enviado un archivo de imagen.
      $subirImagen = subirFichero($_FILES['imagen'], $id, ['image/jpeg', 'image/jpg'], 'images');
      if ($subirImagen !== null) {
        echo "<p>$subirImagen</p>";
      } else {
        $nombreImagen = $id . '.jpg';
        $rutaImagen = 'uploads/images/' . $nombreImagen;
        printf("<img src='%s' alt='Imagen de %s'>", $rutaImagen, $animal['nombre']);
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

    // ------------------------------------------------------------------
    // Fin procesar el formulario.
    // ------------------------------------------------------------------
    } else {
    // -----------------------------------------------------------
    // Si no se ha enviado el formulario mostramos el formulario.
    // -----------------------------------------------------------
    printf("<h2>Actualizar Animal: %s (ID: %d)</h2>", $animal['nombre'], $id);
  ?>
      <form action="update-animal.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <p>
          <label for="imagen">Imagen (JPG, JPEG):</label>
          <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg">
        </p>
        <p>
          <label for="pdf">Ficha en PDF:</label>
          <input type="file" id="pdf" name="pdf" accept=".pdf">
        </p>
        <p>
          <button type="submit">Crear</button>
        </p>
      </form>
  <?php
  // -----------------------------------------------------------
  // Fin mostrar el formulario.
  // -----------------------------------------------------------
    }
  }
}
// Incluir el pie de página.
include '../includes/footer.php';
?>
