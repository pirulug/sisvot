<?php require BASE_DIR_ADMIN . "/views/partials/top.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/navbar.partial.php"; ?>

<div class="card mb-3">
  <div class="card-body">
    <form id="formNewUser" enctype="multipart/form-data" action="" method="post">
      <input type="hidden" name="id" value="<?= $encryption->encrypt($person->person_id) ?>">
      <div class="mb-3">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" class="form-control" id="dni" name="dni" pattern="[0-9]{8}"
          oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
          title="Debe ingresar exactamente 8 dígitos numéricos." value="<?= $person->person_dni ?>" require>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $person->person_name ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $person->person_email ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="text" class="form-control" id="password" name="password" value="<?= $person->person_password ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
  </div>
</div>

<?php require BASE_DIR_ADMIN . "/views/partials/footer.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/bottom.partial.php"; ?>