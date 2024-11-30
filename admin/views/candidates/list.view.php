<?php require BASE_DIR_ADMIN . "/views/partials/top.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/navbar.partial.php"; ?>

<div class="card">
  <div class="card-body">
    <form method="GET" action="">
      <div class="input-group mb-3">
        <input class="form-control" type="text" name="search" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>pdf</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($candidates as $candidate): ?>
            <tr>
              <td>
                <?php if (!empty($candidate->candidate_image)): ?>
                  <img src="<?= SITE_URL . "/uploads/" . htmlspecialchars($candidate->candidate_image) ?>"
                    alt="Imagen de <?= htmlspecialchars($candidate->candidate_name) ?>" width="100">
                <?php else: ?>
                  <img src="https://via.placeholder.com/300x200" alt="Imagen no disponible" width="100">
                <?php endif; ?>
              </td>
              <td><?= $candidate->candidate_name ?></td>
              <td>
                <a class="btn btn-red" href="<?= SITE_URL . "/uploads/" . $candidate->candidate_pdf ?>" target="_blank">
                  <i class="fa fa-file-pdf"></i>
                </a>
              </td>
              <td>

                <a href="edit.php?id=<?= $encryption->encrypt($candidate->candidate_id) ?>" class="btn btn-sm btn-success"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                  <i class="fa fa-pen"></i>
                </a>
                <a href="delete.php?id=<?= $encryption->encrypt($candidate->candidate_id) ?>"
                  class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar"
                  onClick="return confirm('¿Quieres eliminar?')">
                  <i class="fa fa-trash"></i>
                </a>

              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php renderPagination($offset, $limit, $total_results, $page, $search, $total_pages) ?>

  </div>
</div>

<?php require BASE_DIR_ADMIN . "/views/partials/footer.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/bottom.partial.php"; ?>