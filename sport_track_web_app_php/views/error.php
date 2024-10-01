<?php include VIEWS_DIR . "/header.php";?>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4">SportTrack</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link" aria-current="page">Accueil</a></li>
            <li class="nav-item"><a href="/user_add" class="nav-link">Inscription</a></li>
            <li class="nav-item"><a href="/connect" class="nav-link">Connexion</a></li>
        </ul>
    </header>
</div>

<div class="w-75 m-auto">
    <h1 class="h3 mb-3 fw-normal text-center">Page d'erreur</h1>
    <h1 align="center"><?php echo $data["errorMessage"];?><h1/>
</div>
