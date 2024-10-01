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

<?php if($data["buttonState"] === "true") : ?>
    <h1 class="h3 mb-3 fw-normal text-center">Confirmation de connexion</h1>
    <h1 align="center">Souhaitez-vous vraiment vous connecter ?<h1/>
    <div class="container text-center mt-3">
        <form method="get">
            <button class="btn btn-primary w-25 py-2 mx-2" type="submit" formaction="/upload">Oui</button>
            <button class="btn btn-outline-secondary w-25 py-2 mx-2" type="submit" formaction="/">Non</button>
        </form>
    </div>
<?php else : ?>
    <h1 class="h3 mb-3 fw-normal text-center">Problème de connexion</h1>
    <h1 align="center">Une ou plusieurs des données fournies ne sont pas valides, recommencez...</h1>
<?php endif; ?>