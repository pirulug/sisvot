<?php

require_once "core.php";

session_start();

$person_id = $_SESSION['person_id'];

$query = "SELECT * FROM persons WHERE person_id=:person_id";
$stmt  = $connect->prepare($query);
$stmt->bindParam(":person_id", $person_id);
$stmt->execute();
$person = $stmt->fetch(PDO::FETCH_OBJ);

$log->logAction($person_id, 'Salir', $person->person_name . " salió.");

session_destroy();
$_SESSION = array();

if (isset($_COOKIE['psLogin'])) {
  setcookie('psLogin', '', time() - 3600, "/");
}

header('Location: /');
