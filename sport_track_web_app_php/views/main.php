<?php include VIEWS_DIR . "/header.php"; ?>
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4">SportTrack</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link active" aria-current="page">Accueil</a></li>
            <li class="nav-item"><a href="/user_add" class="nav-link">Inscription</a></li>
            <li class="nav-item"><a href="/connect" class="nav-link">Connexion</a></li>
        </ul>
    </header>
</div>
<div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold text-body-emphasis">SportTrack</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">L'outil pour traquer ses performances sportives simplement!</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <a class="btn btn-primary btn-lg px-4 gap-3" href="/user_add">Inscription</a>
        <a class="btn btn-outline-secondary btn-lg px-4" href="/connect">Connexion</a>
      </div>
    </div>
</div>
