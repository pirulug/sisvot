<?php require __DIR__ . "/partials/top.partial.php"; ?>
<?php require __DIR__ . "/partials/navbar.partial.php"; ?>

<div class="container mt-3">
  <div class="row">
    <div class="col-3">
      <div class="card">
        <div class="card-body">
          <img class="w-50 m-auto d-block rounded " src="<?= getGravatar($person_session->person_email, 100) ?>" alt="">
          <i class="d-block text-center my-3">
            @admin
          </i>
          <hr>
          <dl>
            <dt>Name</dt>
            <dd><?= ucfirst($person_session->person_name) ?></dd>
            <dt>Correo electrónico</dt>
            <dd><?= $person_session->person_email ?></dd>
            <dt>Miembro desde</dt>
            <dd><?= formatDate($person_session->created_at) ?></dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="col-9">
      <div class="card">
        <div class="card-body">
          <h2 class="f2-bold fs-4">Mi candidato votado</h2>

          <?php if ($candidate_voted): ?>
            <div class="d-flex align-items-center">
              <img src="<?= SITE_URL . "/uploads/" . $candidate_voted->candidate_image ?>"
                alt="<?= htmlspecialchars($candidate_voted->candidate_name) ?>" class="img-thumbnail"
                style="width: 100px; height: 100px; object-fit: cover;">
              <div class="ms-3">
                <h5><?= htmlspecialchars($candidate_voted->candidate_name) ?></h5>
              </div>
            </div>
          <?php else: ?>
            <p>No has votado por ningún candidato.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . "/partials/footer.partial.php"; ?>
<?php require __DIR__ . "/partials/bottom.partial.php"; ?>