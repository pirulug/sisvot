<?php
function zipProject($source, $destination, $ignored = []) {
  if (!extension_loaded('zip') || !file_exists($source)) {
    return false;
  }

  $destinationDir = dirname($destination);
  if (!file_exists($destinationDir)) {
    if (!mkdir($destinationDir, 0777, true)) {
      return false; // Error al crear el directorio
    }
  }

  // Crear el archivo ZIP
  $zip = new ZipArchive();
  if (!$zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
    return false;
  }

  $source = realpath($source);
  if ($source === false) {
    return false; // Error en la resolución de la ruta
  }

  // Recursión para agregar archivos
  $files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
  );

  foreach ($files as $file) {
    $filePath     = $file->getRealPath();
    $relativePath = substr($filePath, strlen($source) + 1);

    // Verificar si el archivo debe ser ignorado
    $skip = false;
    foreach ($ignored as $ignore) {
      // Comprobar si el archivo o directorio actual está en la lista de exclusión
      if (strpos($filePath, $source . DIRECTORY_SEPARATOR . $ignore) === 0) {
        $skip = true;
        break;
      }
    }

    if (!$skip) {
      $zip->addFile($filePath, $relativePath);
    }
  }

  return $zip->close();
}

// Ruta al directorio que deseas comprimir
$sourceDir = __DIR__; // Ruta a la raíz de tu proyecto
$zipFile   = __DIR__ . '/_up/project.zip'; // Ruta donde se creará el archivo ZIP

// Archivos y carpetas a excluir
$ignoredFiles = [
  '.git',
  '_up',
  'psg.php',
  '.gitignore',
  'readme.md',
  basename(__FILE__)
];

// Comprimir el proyecto
if (zipProject($sourceDir, $zipFile, $ignoredFiles)) {
  echo "Proyecto comprimido exitosamente en: $zipFile";
} else {
  echo "Error al comprimir el proyecto.";
}
?>