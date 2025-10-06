<?php
// Función para actualizar un archivo (imagen o PDF) asociado a un animal.
// Parámetros:
// - $file: del array $_FILES correspondiente al archivo subido.
// - $id: identificador del animal (número).
// - $tiposPermitidos: array con los tipos MIME permitidos para el archivo.
// - $carpeta: carpeta dentro de 'uploads' donde se guardará el archivo
//  (por ejemplo, 'images' o 'pdfs').
// Retorna null si todo fue correcto o un mensaje de error en caso contrario.
function subirFichero($file, $id, $tiposPermitidos, $carpeta) {
  // Comprobamos si se ha enviado un archivo.
  if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
    return "No se ha enviado ningún archivo.";
  } 
  
  if ($file['error'] !== UPLOAD_ERR_OK) {
    return "Error al subir el archivo.";
  }
  
  // El archivo se ha subido correctamente.
  // Comprobamos que el tipo de archivo es válido.
  if (!in_array($file['type'], $tiposPermitidos)) {
    return "El archivo subido no es válido.";
  }

  // Movemos el archivo a la carpeta uploads.
  $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $nombreArchivo = $id . '.' . $extension; 
  $rutaDestino = 'uploads/' . $carpeta . '/' . $nombreArchivo;
  if (!move_uploaded_file($file['tmp_name'], $rutaDestino)) {
    return "Error al mover el archivo a la carpeta de destino.";
  }
  return null; // Indica que no hubo errores.
}