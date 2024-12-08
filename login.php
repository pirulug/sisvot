<?php

require_once "core.php";

if (isset($_SESSION['person_id']) || !empty($_SESSION['person_id'])) {
  header('Location: login.php');
  exit();
}

if (isset($_COOKIE['psLogin'])) {
  $person_id = $encryption->decrypt($_COOKIE['psLogin']);

  // Consultar si el usuario existe y está activo
  $query = "SELECT * FROM persons WHERE person_id = :person_id";
  $stmt  = $connect->prepare($query);
  $stmt->bindParam(':person_id', $person_id, PDO::PARAM_INT);
  $stmt->execute();

  $result_cookie = $stmt->fetch(PDO::FETCH_OBJ);

  if ($result_cookie !== false) {
    $_SESSION['person_login'] = true;
    $_SESSION['person_id']    = $result_cookie->user_id;

    $log->logAction($_SESSION['user_id'], 'Ingreso', $result_cookie->person_name . " ingresó automáticamente con cookie.");
    header('Location: ' . SITE_URL . '/vote.php');
    exit();
  } else {
    // Si la cookie es inválida, eliminarla
    setcookie('psLogin', '', time() - 3600, "/");
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $dni         = cleardata($_POST['dni']);
  $password    = cleardata($_POST['password']);
  $remember_me = $_POST['remember-me'];

  $query = "SELECT * FROM persons WHERE person_dni = :person_dni AND person_password = :person_password";
  $stmt  = $connect->prepare($query);
  $stmt->bindParam(':person_dni', $dni);
  $stmt->bindParam(':person_password', $password);
  $stmt->execute();

  $result_login = $stmt->fetch(PDO::FETCH_OBJ);

  if ($result_login !== false) {
    $_SESSION['person_login'] = true;
    $_SESSION['person_id']    = $result_login->person_id;

    if (isset($remember_me)) {
      setcookie('psLogin', $encryption->encrypt($result_login->person_id), time() + (86400 * 30), "/");
    }

    $log->logAction($_SESSION['person_id'], 'Ingreso', $result_login->person_name . " Ingreso.");
    $messageHandler->addMessage("Datos correctos", "success", "toast");
    header('Location: ' . SITE_URL . "/vote.php");
    exit();
  } else {
    $messageHandler->addMessage("incorrect login data or access denied", "danger");
  }

}

$pageTitle = "Login";
include "views/login.view.php";