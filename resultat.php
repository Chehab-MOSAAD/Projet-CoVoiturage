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
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77a3d0 3px solid;
        }
        header h1 {
            margin: 0;
            text-align: center;
        }
        .result {
            background: #e2e2e2;
            padding: 20px;
            margin-top: 20px;
        }
        .result h2 {
            text-align: center;
        }
        .result ul {
            list-style: none;
            padding: 0;
        }
        .result ul li {
            padding: 10px;
            background: #fff;
            margin-bottom: 10px;
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
                <li>
