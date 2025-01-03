<?php blockStart("style"); ?>
<style>
  .img-candidate {
    width: 100%;
    height: 200px;

    object-fit: cover;
  }
</style>
<?php blockEnd("style"); ?>

<?php require __DIR__ . "/partials/top.partial.php"; ?>
<?php require __DIR__ . "/partials/navbar.partial.php"; ?>

<div class="container mt-3">

  <h1 class="text-center  fw-bold">Candidatos en Contienda</h1>
  <p class="text-center text-muted">Aquí puedes ver la lista completa de los candidatos participantes.</p>

  <div class="row row-cols-3">
    <?php foreach ($candidates as $candidate): ?>
      <div class="col">
        <div class="card mb-3">
          <!-- Imagen del candidato -->
          <?php if (!empty($candidate->candidate_image)): ?>
            <img src="<?= SITE_URL . "/uploads/" . htmlspecialchars($candidate->candidate_image) ?>"
              class="card-img-top img-candidate" alt="Imagen de <?= htmlspecialchars($candidate->candidate_name) ?>">
          <?php else: ?>
            <img src="https://via.placeholder.com/300x200" class="card-img-top img-candidate" alt="Imagen no disponible">
          <?php endif; ?>

          <!-- Información del candidato -->
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($candidate->candidate_name) ?></h5>
            <p class="card-text text-muted"><?= htmlspecialchars($candidate->candidate_description) ?></p>
          </div>

          <!-- Votos -->
          <div class="card-footer text-center">
            <a href="<?= SITE_URL . "/uploads/" . $candidate->candidate_pdf ?>" class="btn btn-danger fw-bold" target="_blank">
              <i class="fs-2 fa-solid fa-file-pdf"></i>
              Descargar propuesta
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<?php require __DIR__ . "/partials/footer.partial.php"; ?>
<?php require __DIR__ . "/partials/bottom.partial.php"; ?>