<?php

require_once "../../core.php";

$accessControl->check_access([1, 2]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $dni      = $_POST['dni'];
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $password = $_POST['password'];

  if ($dni == "") {
    $messageHandler->addMessage("El DNI no debe estar vacío.", "danger");
  } elseif (!ctype_digit($dni) || strlen($dni) !== 8) {
    $messageHandler->addMessage("El DNI debe ser un número de 8 dígitos.", "danger");
  } else {
    $query = "SELECT person_dni FROM persons WHERE person_dni = :dni";
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(":dni", $dni);
    $stmt->execute();
    if($stmt->fetch(PDO::FETCH_OBJ)){
      $messageHandler->addMessage("El DNI ya se encuentra registrado.", "danger");
    }
  }

  if ($name == "") {
    $messageHandler->addMessage("El NOMBRE no debe estar vacío.", "danger");
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $messageHandler->addMessage("El email no es válido.", "danger");
  }

  if ($password == "") {
    $messageHandler->addMessage("La contraseña no debe estar vacío.", "danger");
  }

  if (!$messageHandler->hasMessagesOfType('danger')) {
    $query = "INSERT INTO persons (person_dni, person_name, person_email, person_password) 
                    VALUES (:dni, :name, :email, :password)";
    $stmt  = $connect->prepare($query);
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
}

/* ========== Theme config ========= */
$theme_title = "Usuario nuevo";
$theme_path  = "persons-new";
include BASE_DIR_ADMIN . "/views/persons/new.view.php";
/* ================================= */


