<?php include VIEWS_DIR . "/header.php"; ?>
<?php $today = date('Y-m-d');?>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4">SportTrack</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">Accueil</a></li>
            <li class="nav-item"><a href="/user_add" class="nav-link active" aria-current="page">Inscription</a></li>
            <li class="nav-item"><a href="/connect" class="nav-link">Connexion</a></li>
        </ul>
    </header>
</div>
<div class="container">
    <form class="form-signin w-75 m-auto" method="post" action="/user_add">
        <h1 class="h3 mb-3 fw-normal text-center">Inscription</h1>
        <fieldset class="border border-secondary-subtle rounded p-2">
            <legend>Informations personnelles</legend>
            <div class="row mb-1">
                <div class="form-floating col">
                    <input class="form-control" id="nom" name="nom" placeholder="Nom" autofocus required>
                    <label for="nom">Nom</label>
                </div>
                <div class="form-floating col">
                    <input class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                    <label for="prenom">Prénom</label>
                </div>
            </div>
            <div class="form-floating mb-1">
                <input type="date" class="form-control" id="birth" name="birth" min="1900-01-01" max="<?php echo $today;?>" placeholder="Date de naissance" required>
                <label for="birth">Date de naissance</label>
            </div>
            <select class="form-select mb-1" id="gender" name="gender" required>
                <option selected="selected" disabled="disabled" value="">Genre</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
                <option value="Ne souhaite pas partager">Ne souhaite pas partager</option>
            </select>
            <div class="row">
                <div class="form-floating col">
                    <input type="number" class="form-control" id="height" name="height" min="1" placeholder="Taille"
                        required>
                    <label for="birth">Taille</label>
                </div>
                <div class="form-floating col">
                    <input type="number" class="form-control" id="weight" name="weight" min="1" placeholder="Poids"
                        required>
                    <label for="birth">Poids</label>
                </div>
            </div>
        </fieldset>
        <fieldset class="border border-secondary-subtle rounded p-2 mt-1">
            <legend>Identification</legend>
            <div class="form-floating mb-1">
                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" required>
                <label for="email">E-Mail</label>
            </div>
            <div class="form-floating mb-1">
                <input type="password" class="form-control" id="password" name="passwd" minlength="8" placeholder="Mot de passe" required>
                <label for="password">Mot de passe</label>
            </div>
            <div class="form-floating mb-1">
                <input type="password" class="form-control" id="passwd-confirm" name="passwd-confirm" minlength="8" placeholder="Confirmer le mot de passe" required>
                <label for="passwd-confirm">Confirmer le mot de passe</label>
            </div>
        </fieldset>
        <button class="btn btn-primary w-100 py-2" type="submit">S'inscrire</button>
    </form>
</div>
