<?php blockStart("style"); ?>
<style>
  .ballot {
    border: 2px solid #000;
    background-color: #fff;
    color: #000;
    margin: 20px auto;
    max-width: 700px;
  }

  .candidate-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border-bottom: 2px solid #000;
    position: relative;

    transition: all .3s ease-in-out;
  }

  .candidate-row:last-child {
    border-bottom: none;
  }

  .candidate-row:hover {
    background-color: #ddd;
    cursor: pointer;
  }

  .candidate-row img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    position: relative;
    z-index: 1;
    border-radius: .5rem;
  }

  .candidate-row .marke {
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    background-image: url("assets/img/x.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    display: none;
    z-index: 2;
  }

  .candidate-row.selected .marke {
    display: block;
  }
</style>
<?php blockEnd("style"); ?>

<?php blockStart("script"); ?>
<script>
  document.querySelectorAll('.candidate-row').forEach(row => {
    row.addEventListener('click', () => {
      // Quitar la clase 'selected' de los demás
      document.querySelectorAll('.candidate-row').forEach(r => r.classList.remove('selected'));
      // Marcar el seleccionado
      row.classList.add('selected');
      // Seleccionar el radio asociado
      row.querySelector('input[type="radio"]').checked = true;
    });
  });
</script>
<?php blockEnd("script"); ?>

<?php require __DIR__ . "/partials/top.partial.php"; ?>
<?php require __DIR__ . "/partials/navbar.partial.php"; ?>

<div class="container mt-3">
  <h1 class="text-center fw-bold">Votación Online</h1>
  <p class="text-center text-muted">Selecciona tu candidato preferido y presiona "Votar".</p>

  <form action="" method="POST" id="voteForm">
    <div class="ballot">
      <?php foreach ($candidates as $candidate): ?>
        <div class="candidate-row" data-id="<?= $candidate->candidate_id ?>">
          <span class="h2 fw-bold"><?= htmlspecialchars($candidate->candidate_name) ?></span>
          <div class="position-relative">
            <?php if (!empty($candidate->candidate_image)): ?>
              <img src="<?= SITE_URL . "/uploads/" . htmlspecialchars($candidate->candidate_image) ?>"
                alt="Imagen de <?= htmlspecialchars($candidate->candidate_name) ?>">
            <?php else: ?>
              <img src="https://via.placeholder.com/300x200" alt="Imagen no disponible">
            <?php endif; ?>
            <span class="marke"></span>
          </div>
          <input type="radio" name="candidate" value="<?= $candidate->candidate_id ?>" hidden>
        </div>
      <?php endforeach; ?>
      <div class="d-grid p-3">
        <button type="submit" class="btn btn-lg btn-danger text-white p-3 fw-bold ">Enviar Voto</button>
      </div>
    </div>
  </form>
</div>

<?php require __DIR__ . "/partials/footer.partial.php"; ?>
<?php require __DIR__ . "/partials/bottom.partial.php"; ?>