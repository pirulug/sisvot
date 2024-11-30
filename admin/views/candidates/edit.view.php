<?php require BASE_DIR_ADMIN . "/views/partials/top.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/navbar.partial.php"; ?>



<div class="card mb-3">
  <div class="card-body">
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $encryption->encrypt($candidate->candidate_id) ?>">
      <div class="mb-3">
        <label class="form-label" for="name">Nombre:</label>
        <input class="form-control" type="text" id="name" name="name" value="<?= $candidate->candidate_name ?>"
          required>
      </div>

      <div class="mb-3">
        <label class="form-label" for="description">Descripción:</label>
        <textarea class="form-control" id="description"
          name="description"><?= $candidate->candidate_description ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label" for="image">Imagen:</label>
        <input class="form-control" type="file" id="image" name="image" accept="image/*">
      </div>

      <div class="mb-3">
        <label class="form-label" for="pdf">PDF:</label>
        <input class="form-control" type="file" id="pdf" name="pdf" accept="application/pdf">
      </div>

      <button class="btn btn-primary" type="submit">Agregar Candidato</button>
    </form>
  </div>
</div>

<?php require BASE_DIR_ADMIN . "/views/partials/footer.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/bottom.partial.php"; ?>