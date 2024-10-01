<?php include VIEWS_DIR . "/header.php"; ?>
<?php $today = date('Y-m-d');?>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4">SportTrack</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/upload" class="nav-link">Tableau de bord</a></li>
            <li class="nav-item"><a href="/disconnect" class="nav-link">Déconnexion</a></li>
        </ul>
    </header>
</div>
<div class="container">
    <form class="form-signin w-75 m-auto" method="post" action="/edit">
        <h1 class="h3 mb-3 fw-normal text-center">Modifications de vos données</h1>
        <fieldset class="border border-secondary-subtle rounded p-2">
            <legend>Informations personnelles</legend>
            <div class="row mb-1">
                <div class="form-floating col">
                    <input class="form-control" id="nom" name="nom" placeholder="Nouveau nom" autofocus required>
                    <label for="nom">Nouveau nom</label>
                </div>
                <div class="form-floating col">
                    <input class="form-control" id="prenom" name="prenom" placeholder="Nouveau prénom" required>
                    <label for="prenom">Nouveau prénom</label>
                </div>
            </div>
            <div class="form-floating mb-1">
                <input type="date" class="form-control" id="birth" name="birth" min="1900-01-01" max="<?php echo $today;?>" placeholder="Nouvelle date de naissance" required>
                <label for="birth">Nouvelle date de naissance</label>
            </div>
            <select class="form-select mb-1" id="gender" name="gender" required>
                <option selected="selected" disabled="disabled" value="">Nouveau genre</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
                <option value="Ne souhaite pas partager">Ne souhaite pas partager</option>
            </select>
            <div class="row">
                <div class="form-floating col">
                    <input type="number" class="form-control" id="height" name="height" min="1" placeholder="Nouvelle taille"
                        required>
                    <label for="birth">Nouvelle taille</label>
                </div>
                <div class="form-floating col">
                    <input type="number" class="form-control" id="weight" name="weight" min="1" placeholder="Nouveau poids"
                        required>
                    <label for="birth">Nouveau poids</label>
                </div>
            </div>
        </fieldset>
        <fieldset class="border border-secondary-subtle rounded p-2 mt-1">
            <legend>Facteurs d'identification</legend>
            <div class="form-floating mb-1">
                <input type="email" class="form-control" id="email" name="email" placeholder="Nouveau e-mail" required>
                <label for="email">Nouveau e-mail</label>
            </div>
            <div class="form-floating mb-1">
                <input type="password" class="form-control" id="password" name="passwd" minlength="8" placeholder="Nouveau mot de passe" required>
                <label for="password">Nouveau mot de passe</label>
            </div>
            <div class="form-floating mb-1">
                <input type="password" class="form-control" id="passwd-confirm" name="passwd-confirm" minlength="8" placeholder="Confirmer le nouveau mot de passe" required>
                <label for="passwd-confirm">Confirmer le nouveau mot de passe</label>
            </div>
        </fieldset>
        <button class="btn btn-primary w-100 py-2" type="submit">Mettre à jour mes données</button>
    </form>
</div>
