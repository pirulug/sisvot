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
            <th>DNI</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Contraseña</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($persons as $data): ?>
            <tr>
              <td>
                <?= $data->person_dni ?>
              </td>
              <td>
                <?= $data->person_name ?>
              </td>
              <td>
                <?= $data->person_email ?>
              </td>
              <td>
                <?= $data->person_password ?>
              </td>
              <td>
                <a href="edit.php?id=<?= $encryption->encrypt($data->person_id) ?>" class="btn btn-sm btn-success"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                  <i class="fa fa-pen"></i>
                </a>
                <a href="delete.php?id=<?= $encryption->encrypt($data->person_id) ?>" class="btn btn-sm btn-danger"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar"
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