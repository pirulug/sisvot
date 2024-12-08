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

$query = "SELECT * FROM persons WHERE person_id = $id";
$stmt  = $connect->prepare($query);
$stmt->execute();
$person = $stmt->fetch(PDO::FETCH_OBJ);


if (empty($person)) {
  $messageHandler->addMessage("Usuario no encontrado.", "danger");
  header("Location: list.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id       = trim($_POST['id']);
  $dni      = trim($_POST['dni']);
  $name     = trim($_POST['name']);
  $email    = trim($_POST['email']);
  $password = trim($_POST['password']);

  if ($id != "") {
    $id = $encryption->decrypt($id);
  } else {
    $messageHandler->addMessage("Eres gracioso.", "danger", "toast");
  }

  $changeDni = false;
  if ($dni == "") {
    $messageHandler->addMessage("El DNI no debe estar vacío.", "danger");
  } elseif (!ctype_digit($dni) || strlen($dni) !== 8) {
    $messageHandler->addMessage("El DNI debe ser un número de 8 dígitos.", "danger");
  } else {
    $query = "SELECT person_dni FROM persons WHERE person_id = :id";
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $currentDni = $stmt->fetchColumn();

    if ($currentDni !== $dni) {
      $query = "SELECT COUNT(*) FROM persons WHERE person_dni = :dni";
      $stmt  = $connect->prepare($query);
      $stmt->bindParam(':dni', $dni);
      $stmt->execute();
      $dniExists = $stmt->fetchColumn();


      if ($dniExists > 0) {
        $messageHandler->addMessage("El DNI ya está registrado en el sistema.", "danger");
      } else {
        $changeDni = true;
      }
    }
  }

  if ($name == "") {
    $messageHandler->addMessage("El nombre no debe estar vacío.", "danger");
  }

  $changeEmail = false;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $messageHandler->addMessage("El email no es válido.", "danger");
  } else {
    // Obtener el email actual del registro
    $query = "SELECT person_email FROM persons WHERE person_id = :id";
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $currentEmail = $stmt->fetchColumn();

    // Validar si el email cambió y si ya existe en otro registro
    if ($currentEmail !== $email) {
      $query = "SELECT COUNT(*) FROM persons WHERE person_email = :email";
      $stmt  = $connect->prepare($query);
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $emailExists = $stmt->fetchColumn();

      if ($emailExists > 0) {
        $messageHandler->addMessage("El email ya está registrado en el sistema.", "danger");
      } else {
        $changeEmail = true;
      }
    }
  }

  if (strlen($password) < 6) {
    $messageHandler->addMessage("La contraseña debe tener al menos 6 caracteres.", "danger");
  }

  // Solo proceder si no hay mensajes de error
  if (!$messageHandler->hasMessagesOfType('danger')) {
    try {
      $query = "UPDATE persons SET person_name = :name, person_password = :password";

      if ($changeDni) {
        $query .= ", person_dni = :dni";
      }
      if ($changeEmail) {
        $query .= ", person_email = :email";
      }
      $query .= " WHERE person_id = :id";

      $stmt = $connect->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':password', $password);

      if ($changeDni) {
        $stmt->bindParam(':dni', $dni);
      }
      if ($changeEmail) {
        $stmt->bindParam(':email', $email);
      }

      $stmt->execute();

      $messageHandler->addMessage("Usuario se actualizó correctamente.", "success", "toast");
    } catch (PDOException $e) {
      $messageHandler->addMessage("Error al actualizar el usuario: " . $e->getMessage(), "danger");
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
  }
}

/* ========== Theme config ========= */
$theme_title = "Editar usuario";
$theme_path  = "persons-new";
include BASE_DIR_ADMIN . "/views/persons/edit.view.php";
/* ================================= */


