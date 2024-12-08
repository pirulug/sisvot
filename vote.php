<?php

require_once "core.php";

if (!isset($_SESSION['person_id']) || empty($_SESSION['person_id'])) {
  $messageHandler->addMessage("Tienes que ingresar primero para poder votar", "info");
  setcookie('psLogin', '', time() - 3600, "/");
  header('Location: login.php');
  exit();
}

var_dump($_SESSION);

$user_id = $_SESSION['person_id'];

$stmt = $connect->prepare("SELECT has_voted FROM persons WHERE person_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if ($user->has_voted == 1) {
  $messageHandler->addMessage("Usted ya realizado su voto", "info");
  header('Location: result.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $candidate_id = $_POST['candidate'];

  $stmt = $connect->prepare("INSERT INTO votes (person_id, candidate_id) VALUES (:person_id, :candidate_id)");
  $stmt->execute(['person_id' => $_SESSION['person_id'], 'candidate_id' => $candidate_id]);

  $stmt = $connect->prepare("UPDATE persons SET has_voted = 1 WHERE person_id = :person_id");
  $stmt->execute(['person_id' => $_SESSION['person_id']]);

  echo "Voto registrado correctamente.";
  header('Location: result.php');
  exit;
}

$query      = $connect->query("SELECT * FROM candidates");
$candidates = $query->fetchAll(PDO::FETCH_OBJ);

$pageTitle = "Formulario de votación";
include "views/vote.view.php";