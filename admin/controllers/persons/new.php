<?php

require_once "../../core.php";

$accessControl->check_access([1, 2]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $dni      = $_POST['dni'];
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $password = $_POST['password'];

  $sql  = "INSERT INTO persons (person_dni, person_name, person_email, person_password) 
            VALUES (:dni, :name, :email, :password)";
  $stmt = $connect->prepare($sql);
  $stmt->bindParam(':dni', $dni);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);

  if ($stmt->execute()) {
    $messageHandler->addMessage("Persona registrada exitosamente.", "success");
    header("Location: list.php");
    exit();
  } else {
    $messageHandler->addMessage("Error al registrar a la persona.", "danger");
  }
}

/* ========== Theme config ========= */
$theme_title = "Usuario nuevo";
$theme_path  = "persons-new";
include BASE_DIR_ADMIN . "/views/persons/new.view.php";
/* ================================= */


