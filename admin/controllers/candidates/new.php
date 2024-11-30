<?php

require_once "../../core.php";

require_once BASE_DIR . "/libs/FileUpload.php";

$accessControl->check_access([1, 2]);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name        = $_POST['name'];
  $description = $_POST['description'];
  $image       = generateUniqueFileName($_FILES['image']['name'], "cand_img_");
  $pdf         = generateUniqueFileName($_FILES['pdf']['name'], "cand_pdf_");

  // Subir archivos (imagen y PDF)
  move_uploaded_file($_FILES['image']['tmp_name'], BASE_DIR . '/uploads/' . $image);
  move_uploaded_file($_FILES['pdf']['tmp_name'], BASE_DIR . '/uploads/' . $pdf);

  $sql  = "INSERT INTO candidates (candidate_name, candidate_description, candidate_image, candidate_pdf) 
            VALUES (:name, :description, :image, :pdf)";
  $stmt = $connect->prepare($sql);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':image', $image);
  $stmt->bindParam(':pdf', $pdf);
  $stmt->execute();

  $messageHandler->addMessage("Candidato agregado exitosamente.");
  header("Location: list.php");
  exit();
}

/* ========== Theme config ========= */
$theme_title = "Candidato nuevo";
$theme_path  = "candidates-new";
include BASE_DIR_ADMIN . "/views/candidates/new.view.php";
/* ================================= */


