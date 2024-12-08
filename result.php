<?php

require_once "core.php";

if (!isset($_SESSION['person_id']) || empty($_SESSION['person_id'])) {
  $messageHandler->addMessage("Tienes que ingresar primero para poder votar", "info");
  setcookie('psLogin', '', time() - 3600, "/");
  header('Location: login.php');
  exit();
}

$query = "SELECT has_voted from persons WHERE person_id=:person_id";
$smtp  = $connect->prepare($query);
$smtp->bindParam(":person_id", $_SESSION['person_id']);
$smtp->execute();

$has_voted = $smtp->fetch(PDO::FETCH_OBJ);

if ($has_voted->has_voted == 0) {
  $messageHandler->addMessage("Usted no a votado.", "info");
  header('Location: vote.php');
  exit();
}

$results_visible_at = new DateTime(RESULTS_VISIBLE_AT);
$current_time       = new DateTime();

if ($current_time < $results_visible_at) {
  $remaining_time = $current_time->diff($results_visible_at);
  $countdown_text = $remaining_time->format('%d días %h horas %i minutos %s segundos');
  $show_results   = false;

  $total_seconds = $remaining_time->days * 86400 + $remaining_time->h * 3600 + $remaining_time->i * 60 + $remaining_time->s;

} else {
  $show_results = true;

  $stmt = $connect->query("SELECT candidates.candidate_name, candidates.candidate_image, COUNT(votes.vote_id) AS candidate_votes
                          FROM candidates
                          LEFT JOIN votes ON candidates.candidate_id = votes.candidate_id
                          GROUP BY candidates.candidate_id
                          ORDER BY candidate_votes DESC");

  $candidates = $stmt->fetchAll(PDO::FETCH_OBJ);
}



$pageTitle = "Resultados";
include "views/result.view.php";