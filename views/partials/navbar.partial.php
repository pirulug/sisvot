<nav class="navbar navbar-expand-lg bg-body">
  <div class="container">
    <a class="navbar-brand" href="<?= SITE_URL ?>">
      <img id="logo-ligth" src="<?= SITE_URL . $brand->st_whitelogo ?>" alt="Logo Light" class="logo-light" height="40">
      <img id="logo-dark" src="<?= SITE_URL . $brand->st_darklogo ?>" alt="Logo Dark" class="logo-dark d-none"
        height="40">
    </a>
    <button class="navbar-toggler me-1 ms-auto" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-start" id="navbarResponsive">
      <div class="offcanvas-header">
        <a class="navbar-brand" href="<?= SITE_NAME ?>">
          <img id="logo-ligth" src="<?= SITE_URL . $brand->st_whitelogo ?>" alt="Logo Light" class="logo-light"
            height="40">
          <img id="logo-dark" src="<?= SITE_URL . $brand->st_darklogo ?>" alt="Logo Dark" class="logo-dark d-none"
            height="40">
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav align-items-lg-center justify-content-end flex-grow-1 pe-1">
          <li class="nav-item">
            <a class="nav-link" href="/">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="candidates.php">Candidatos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="vote.php">Votar</a>
          </li>


          <?php if (isset($_SESSION["person_id"])): ?>
            <li class="nav-item">
              <a class="nav-link" href="result.php">Resultados</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-inline-block d-lg-none" href="#" data-bs-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-user align-middle">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
              </a>
              <a class="nav-link dropdown-toggle d-none d-lg-inline-flex align-items-center" href="#" role="button"
                data-bs-toggle="dropdown">
                <img class="rounded me-1" src="<?= getGravatar($person_session->person_email, 40) ?>"
                  alt="<?= $person_session->person_name ?>">
                <div class="text-center">
                  <b>
                    <?= ucfirst($person_session->person_name) ?>
                  </b>
                </div>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="profile.php">Perfil</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="logout.php">Salir</a>
                </li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <ul class="navbar-nav">
      <li class="nav-item">
        <button class="nav-link py-2 d-flex align-items-center" id="bd-theme-toggle" type="button"><span
            class="theme-icon-active mr-1" id="bd-theme-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" class="feather feather-sun">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3"></line>
              <line x1="12" y1="21" x2="12" y2="23"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
              <line x1="1" y1="12" x2="3" y2="12"></line>
              <line x1="21" y1="12" x2="23" y2="12"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
          </span>
        </button>
      </li>
    </ul>
  </div>
</nav>

<main class="flex-shrink-0">

  <?php if ($messageHandler->hasMessages()): ?>
    <div class="container ">
      <?= $messageHandler->displayMessages(); ?>
    </div>
  <?php endif; ?>