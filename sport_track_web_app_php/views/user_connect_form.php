<?php include VIEWS_DIR . "/header.php"; ?>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4">SportTrack</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">Accueil</a></li>
            <li class="nav-item"><a href="/user_add" class="nav-link">Inscription</a></li>
            <li class="nav-item"><a href="/connect" class="nav-link active" aria-current="page">Connexion</a></li>
        </ul>
    </header>
</div>
<div class="container">
    <div class="w-50 m-auto">
        <form class="form-signing" method="post" action="/connect">
            <h1 class="h3 mb-3 fw-normal text-center">Connexion</h1>
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" autofocus required>
                <label for="email">E-Mail</label>
            </div>
            <div class="form-floating my-1">
                <input type="password" class="form-control" id="passwd" name="passwd" minlength="8" placeholder="Mot de passe" required>
                <label for="passwd">Mot de passe</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Se connecter</button>
        </form>
    </div>
</div>
