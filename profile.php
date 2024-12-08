<?php

require_once "core.php";

if (isset($_SESSION['signedin']) && $_SESSION['signedin']) {
  header("Location: index.php");
  exit();
}

if (!isset($_SESSION['person_id'])) {
  header('Location: login.php');
  exit();
}

$person_id = $_SESSION['person_id'];

// Consulta para obtener el candidato al que votó el usuario
$stmt = $connect->prepare("SELECT candidates.candidate_name, candidates.candidate_image 
                                FROM votes
                                JOIN candidates ON votes.candidate_id = candidates.candidate_id
                                WHERE votes.person_id = :person_id
                                LIMIT 1
                              ");
$stmt->execute([':person_id' => $person_id]);
$candidate_voted = $stmt->fetch(PDO::FETCH_OBJ);

$pageTitle = "Home";
include "views/profile.view.php";