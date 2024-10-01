<?php include VIEWS_DIR . "/header.php"; ?>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: separate; /* Utilisation de border-spacing */
            border-spacing: 10px; /* Espacement entre les cellules */
        }
        th, td {
            padding: 15px; /* Espace intérieur des cellules */
            border: 1px solid #ccc; /* Bordure des cellules */
            text-align: center; /* Centrer le texte dans les cellules */
        }
        th {
            background-color: #f2f2f2; /* Couleur d'arrière-plan des en-têtes */
        }
    </style>
</head>

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
<?php

echo "<h1 class='h3 mb-3 fw-normal text-center'>Tableau de vos activités</h1>";
echo "<div class='container'>";

if (isset($data["table"])) {
    $table = $data["table"];
    if (count($table) > 0) {
        echo "<p class='lead mb-4'>Vous avez ".count($table)." activités : </p>";
        echo "<table id='table'>";
        echo "<tr>";
            echo "<th>Description</th>";
            echo "<th>Date</th>";
            echo "<th>Heure</th>";
            echo "<th>Durée</th>";
            echo "<th>Distance</th>";
            echo "<th>Cardio min</th>";
            echo "<th>Cardio max</th>";
            echo "<th>Cardio moy</th>";
        echo "</tr>";
        foreach ($table as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>$cell</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='lead mb-4'>Vous n'avez pas encore d'activité.</p>";
    }
}

echo "</div>";

?>