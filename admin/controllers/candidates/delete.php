<?php

require_once "../../core.php";

$accessControl->check_access([1, 2]);

// Comprobaciones
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

unlink(BASE_DIR . '/uploads/' . $candidate->candidate_image);
unlink(BASE_DIR . '/uploads/' . $candidate->candidate_pdf);

$statement = $connect->prepare('DELETE FROM candidates WHERE candidate_id = :id');
$statement->execute(array('id' => $id));

$messageHandler->addMessage("Usuario eliminado correctamente.", "success");
header('Location: list.php');
exit();




