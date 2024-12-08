<?php require __DIR__ . "/partials/top.partial.php"; ?>
<?php require __DIR__ . "/partials/navbar.partial.php"; ?>

<div class="container mt-3">
  <h1 class="text-center fw-bold">Resultados</h1>

  <?php if ($show_results): ?>
    <div class="card mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Imagen</th>
                <th>Candidato</th>
                <th>Votos</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($candidates as $candidate): ?>
                <tr>
                  <td width="100">
                    <?php if (!empty($candidate->candidate_image)): ?>
                      <img src="<?= SITE_URL . "/uploads/" . $candidate->candidate_image ?>" class="img-fluid"
                        alt="Imagen de <?= $candidate->candidate_name ?>">
                    <?php else: ?>
                      <img src="https://via.placeholder.com/300x200" class="img-fluid" alt="Imagen no disponible">
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($candidate->candidate_name) ?></td>
                  <td><?= htmlspecialchars($candidate->candidate_votes) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Mostrar mensaje de cuenta regresiva -->
    <h3 class="text-center">Los resultados estarán disponibles en:</h3>
    <div class="text-center">
      <div id="countdown" class="display-4"><?= $countdown_text ?></div>
    </div>
  <?php endif; ?>
</div>

<script>
  <?php if (!$show_results): ?>
    let remainingTime = <?= $total_seconds ?>; // Total de segundos
    let countdownElement = document.getElementById('countdown');

    let interval = setInterval(function () {
      if (remainingTime > 0) {
        let days = Math.floor(remainingTime / (3600 * 24));
        let hours = Math.floor((remainingTime % (3600 * 24)) / 3600);
        let minutes = Math.floor((remainingTime % 3600) / 60);
        let seconds = remainingTime % 60;

        countdownElement.innerHTML = `${days} días ${hours} horas ${minutes} minutos ${seconds} segundos`;

        remainingTime--; // Disminuir un segundo
      } else {
        clearInterval(interval);
        countdownElement.innerHTML = "¡Los resultados están disponibles!";
        setTimeout(function () {
          location.reload(); // Recargar la página
        }, 2000);
      }
    }, 1000);
  <?php endif; ?>

</script>

<?php require __DIR__ . "/partials/footer.partial.php"; ?>
<?php require __DIR__ . "/partials/bottom.partial.php"; ?>