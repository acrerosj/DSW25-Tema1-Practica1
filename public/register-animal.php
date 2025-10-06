<?php

// Importar los datos.
require '../data/datos.php';

// Antes de incluir la cabecera inicializamos la variable del título.
$titulo_pagina = "Registro de Animal";
include '../includes/header.php';

// Mostrar el formulario de registro de un nuevo animal.
?>
<h2>Registrar Nuevo Animal</h2>
<form action="process_animal.php" method="post" enctype="multipart/form-data">
  <p>

    <label for="categoria">Categoría:</label>
    <select name="categoria_id" id="categoria" required>
      <option value="" disabled selected>Seleccione una categoría</option>
      <?php
      foreach ($categorias as $categoria) {
        printf("<option value='%d'>%s</option>", $categoria['id'], $categoria['nombre']);
      }
      ?>
    </select>
  </p>
  <p>
    <label for="id">Identificador del Animal (número):</label>
    <input type="number" id="id" name="id" required>
  </p>
  <p>
    <label for="nombre">Nombre del Animal:</label>
    <input type="text" id="nombre" name="nombre" required>
  </p>
  <p>
    <label for="habitat">Hábitat:</label>
    <input type="text" id="habitat" name="habitat" required>
  </p>
  <p>
    <label for="caracteristicas">Características (separadas por comas):</label>
    <textarea name="caracteristicas" id="características"></textarea>
  </p>
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
// Incluir el pie de página.
include '../includes/footer.php';
?>