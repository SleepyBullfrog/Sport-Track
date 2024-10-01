<?php include VIEWS_DIR . "/header.php"; ?>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4">SportTrack</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/upload" class="nav-link active" aria-current="page">Tableau de bord</a></li>
            <li class="nav-item"><a href="/disconnect" class="nav-link">Déconnexion</a></li>
        </ul>
    </header>
</div>
<main>
    <div class="container">
        <h1>Bienvenue, <?php 
                            require DAO_DIR . "/UserDAO.php";
                            require MODELS_DIR . "/User.php";
                            
                            if (!isset($_SESSION['current']) && empty($_SESSION['current'])) {
                                session_start();
                            }
                            if (isset($_SESSION['current']) && !empty($_SESSION['current'])) {
                                $userDAO = UserDAO::getInstance();
                                $nomUtilisateur = $userDAO->findById($_SESSION['current'])->getFirstNameUser();
                                echo $nomUtilisateur;
                            } else {
                                echo "ERROR";
                            }
                        ?>
        </h1>
        <hr>
        <div class="row">
            <div class="col text-center">
                <form method="post" action="/upload" enctype="multipart/form-data">
                    <div class="form-control">
                        <h2 class="mb-2">Envoyer un fichier</h2>
                        <input type="file" id="JSON" name="JSON" accept="application/JSON" placeholder="Sélectionnez un fichier">
                        <?php if (isset($data["uploadMessage"])) : ?>
                            <p align="center"><?php echo $data["uploadMessage"];?></p>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primary py-2" type="submit">Envoyer le fichier</button>
                </form>
            </div>
            <div class="col text-center">
                <h2 class="mb-2">Informations personnelles</h2>
                <p>Accéder à la page de modification de vos informations personnelles</p>
                <a class="btn btn-primary py-2" href="/edit">Modifier mes informations personelles</a>
            </div>
        </div>
    </div>
    <br>
    <div class="container text-center mt-3">
        <form method="get" action="/activities">
            <button class="btn btn-primary w-25 py-2 mx-2" type="submit">Voir mes activités</button>
        </form>
    </div>
</main>
