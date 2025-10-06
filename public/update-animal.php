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

      // Comprobamos si se ha enviado un archivo de imagen.
      if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE) {
        echo "<p>No se ha enviado ninguna imagen.</p>";
      } elseif ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        echo "<p>Error al subir la imagen.</p>";
      } else {
        // El archivo se ha subido correctamente.

        // Comprobamos que el tipo de archivo es una imagen.
        $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['imagen']['type'], $tiposPermitidos)) {
          echo "<p>El archivo subido no es una imagen válida.</p>";
        } else {
          // Movemos el archivo a la carpeta uploads.
          $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
          $nombreImagen = $id . '.' . $extension; 
          $rutaDestino = 'uploads/images/' . $nombreImagen;
          if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            printf("<img src='%s' alt='Imagen de %s' style='max-width:300px;'/></p>", $rutaDestino, $animal['nombre']); 
          } else {
            echo "<p>Error al mover la imagen a la carpeta de destino.</p>";
          }
        }
      }

      // Comprobamos si se ha enviado un archivo PDF.
      if (!isset($_FILES['pdf']) || $_FILES['pdf']['error'] === UPLOAD_ERR_NO_FILE) {
        echo "<p>No se ha enviado ningún archivo PDF.</p>";
      } elseif ($_FILES['pdf']['error'] !== UPLOAD_ERR_OK) {
        echo "<p>Error al subir el archivo PDF.</p>";
      } else {
        // El archivo se ha subido correctamente.
        // Comprobamos que el tipo de archivo es un PDF.
        if ($_FILES['pdf']['type'] !== 'application/pdf') {
          echo "<p>El archivo subido no es un PDF válido.</p>";
        } else {
          // Movemos el archivo a la carpeta uploads.
          $nombrePdf = $id . '.pdf';
          $rutaDestino = 'uploads/pdfs/' . $nombrePdf;
          if (move_uploaded_file($_FILES['pdf']['tmp_name'], $rutaDestino)) {
            printf("<p><a href='%s' target='_blank'>Ver ficha en PDF</a></p>", $rutaDestino); 
          } else {
            echo "<p>Error al mover el archivo PDF a la carpeta de destino.</p>";
          }
        }
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
