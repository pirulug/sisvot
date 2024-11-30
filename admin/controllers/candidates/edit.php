<?php

require_once "../../core.php";

$accessControl->check_access([1, 2]);

// Si no tine id
if (!isset($_GET["id"]) || $_GET["id"] == "") {
  $messageHandler->addMessage("Tienes que tener un id.", "danger");
  header("Location: list.php");
  exit();
}

$id = $encryption->decrypt($_GET["id"]);

if (!is_numeric($id)) {
  $messageHandler->addMessage("El id no encontrado.", "danger");
  header("Location: list.php");
  exit();
}

$query = "SELECT * FROM candidates WHERE candidate_id = $id";
$stmt  = $connect->prepare($query);
$stmt->execute();
$candidate = $stmt->fetch(PDO::FETCH_OBJ);


if (empty($candidate)) {
  $messageHandler->addMessage("Usuario no encontrado.", "danger");
  header("Location: list.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id          = $encryption->decrypt($_POST['id']);
  $name        = $_POST['name'];
  $description = $_POST['description'];
  $image       = $_FILES['image']['name'];
  $pdf         = $_FILES['pdf']['name'];

  echo $id;

  // Subir archivos si se cargan
  if ($image) {
    $image = generateUniqueFileName($image, "cand_img_");
    move_uploaded_file($_FILES['image']['tmp_name'], BASE_DIR . '/uploads/' . $image);
    unlink(BASE_DIR . '/uploads/' . $candidate->candidate_image);
  }
  if ($pdf) {
    $pdf = generateUniqueFileName($pdf, "cand_pdf_");
    move_uploaded_file($_FILES['pdf']['tmp_name'], BASE_DIR . '/uploads/' . $pdf);
    unlink(BASE_DIR . '/uploads/' . $candidate->candidate_pdf);
  }

  // Iniciar la consulta SQL básica
  $sql = "UPDATE candidates SET 
            candidate_name = :name, 
            candidate_description = :description";

  // Condicionalmente agregar los campos si tienen valores
  if ($image) {
    $sql .= ", candidate_image = :image";
  }
  if ($pdf) {
    $sql .= ", candidate_pdf = :pdf";
  }

  // Agregar la cláusula WHERE
  $sql .= " WHERE candidate_id = :id";

  // Preparar la consulta
  $stmt = $connect->prepare($sql);

  // Vincular los parámetros obligatorios
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':description', $description);

  // Condicionalmente vincular los parámetros opcionales
  if ($image) {
    $stmt->bindParam(':image', $image);
  }
  if ($pdf) {
    $stmt->bindParam(':pdf', $pdf);
  }

  // Ejecutar la consulta
  $stmt->execute();

  $messageHandler->addMessage("Candidato actualizado exitosamente.", "success", "toast");
  header("Location: " . $_SERVER['HTTP_REFERER']);
  exit();

}

/* ========== Theme config ========= */
$theme_title = "Editar candidato";
$theme_path  = "candidates-edit";
// $theme_scripts = ["js/clear.js"];
// $theme_styles = ["pages/dashboard.css"];
include BASE_DIR_ADMIN . "/views/candidates/edit.view.php";
/* ================================= */


