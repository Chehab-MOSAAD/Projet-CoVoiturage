<?php
// Récupération des données de l'URL
$ville_depart = $_GET['ville_depart'] ?? 'Non spécifié';
$code_postal_depart = $_GET['code_postal_depart'] ?? 'Non spécifié';
$nom_rue_depart = $_GET['nom_rue_depart'] ?? 'Non spécifié';
$num_rue_depart = $_GET['num_rue_depart'] ?? 'Non spécifié';
$ville_arrivee = $_GET['ville_arrivee'] ?? 'Non spécifié';
$code_postal_arrivee = $_GET['code_postal_arrivee'] ?? 'Non spécifié';
$nom_rue_arrivee = $_GET['nom_rue_arrivee'] ?? 'Non spécifié';
$num_rue_arrivee = $_GET['num_rue_arrivee'] ?? 'Non spécifié';
$place_dispo = $_GET['place_dispo'] ?? 'Non spécifié';
$date_depart = $_GET['date_depart'] ?? 'Non spécifié';
$commentaire = $_GET['commentaire'] ?? 'Non spécifié';
$escale = $_GET['escale'] ?? 'Non spécifié';
$matricule = $_GET['matricule'] ?? 'Non spécifié';
$num_permis = $_GET['num_permis'] ?? 'Non spécifié';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de l'opération</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #388E3C 3px solid;
        }
        header h1 {
            margin: 0;
            text-align: center;
        }
        .result {
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .result h2 {
            text-align: center;
            color: #4CAF50;
        }
        .result ul {
            list-style: none;
            padding: 0;
        }
        .result ul li {
            padding: 10px;
            background: #f4f4f4;
            margin-bottom: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Résultat de l'opération</h1>
        </div>
    </header>
    <div class="container">
        <div class="result">
            <h2>Trajet proposé avec succès!</h2>
            <ul>
                <li>Ville de départ: <?php echo htmlspecialchars($ville_depart); ?></li>
                <li>Code postal de départ: <?php echo htmlspecialchars($code_postal_depart); ?></li>
                <li>Nom Rue de départ: <?php echo htmlspecialchars($nom_rue_depart); ?></li>
                <li>Numéro Rue de départ: <?php echo htmlspecialchars($num_rue_depart); ?></li>
                <li>Ville d'arrivée: <?php echo htmlspecialchars($ville_arrivee); ?></li>
                <li>Code postal d'arrivée: <?php echo htmlspecialchars($code_postal_arrivee); ?></li>
                <li>Nom Rue d'arrivée: <?php echo htmlspecialchars($nom_rue_arrivee); ?></li>
                <li>Numéro Rue d'arrivée: <?php echo htmlspecialchars($num_rue_arrivee); ?></li>
                <li>Places disponibles: <?php echo htmlspecialchars($place_dispo); ?></li>
                <li>Date de départ: <?php echo htmlspecialchars($date_depart); ?></li>
                <li>Commentaire: <?php echo htmlspecialchars($commentaire); ?></li>
                <li>Escale: <?php echo htmlspecialchars($escale); ?></li>
                <li>Matricule: <?php echo htmlspecialchars($matricule); ?></li>
                <li>Numéro de permis: <?php echo htmlspecialchars($num_permis); ?></li>
            </ul>
        </div>
    </div>
</body>
</html>
