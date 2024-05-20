<?php
session_start();
include 'db.php'; 
$userId = $_SESSION['id'] ?? null;
$username = $_SESSION['nom'] ?? 'Visiteur';  

$anciensTrajets = [];

if ($userId) {
    try {
        $sql = "SELECT trajets.depart, trajets.arrivee 
                FROM historique_trajets 
                JOIN trajets ON historique_trajets.trajet_id = trajets.id 
                WHERE historique_trajets.user_id = :userId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $anciensTrajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des anciens trajets: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voituretech</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: all 0.3s ease;
        }

        body, html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(120deg, #f0f9f0 0%, #e0f8e0 100%);
            display: flex;
            flex-direction: column;
        }

        header {
            color: #333;
            text-align: center;
            padding: 1em 0;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(36, 37, 38, 0.1);
        }

        nav {
            display: flex;
            justify-content: center;
            padding: 0.5em 0;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(36, 37, 38, 0.1);
        }

        nav a {
            text-decoration: none;
            color: #38b238; 
            margin: 0 1em;
            padding: 0.25em 0;
            position: relative;
        }

        nav a:hover, nav a:focus {
            color: #2d862d; 
        }

        nav a:before {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #38b238; 
            transform: translateX(-50%);
        }

        nav a:hover:before, nav a:focus:before {
            width: 100%;
        }

        .search-box {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 2em;
            margin: 2em;
            background-color: #ffffffcc;
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 8px 10px rgba(0, 0, 0, 0.1);
        }

        .search-box h2 {
            color: #333;
            margin-bottom: 0.5em;
        }

        .search-fields input, .search-fields button {
            padding: 0.5em;
            margin: 0.5em;
            border: 2px solid #38b238; 
            border-radius: 5px;
            font-size: 1em;
            outline: none;
        }

        .search-fields input:focus {
            border-color: #2d862d; 
        }

        .search-button {
            background-color: #38b238; 
            color: white;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #2d862d; 
        }

        footer {
            text-align: center;
            padding: 1em;
            background-color: #333;
            color: white;
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
            }

            nav a {
                margin: 0.5em 0;
            }
        }
    </style>
</head>
<body>
    <header>
        Voituretech
    </header>
    <nav>
        <a href="#Accueil">Accueil</a>
        <a href="rechercher.php">Recherche</a>
        <a href="#Offres">Offres</a>
        <a href="inscription.php">Inscription</a>
        <a href="connexion.php">Connexion</a>
    </nav>
    <div class="search-box">
        <h2>CHERCHER UN TRAJET</h2>
        <p>Trouvez le covoiturage qui vous correspond</p>
        <div class="search-fields">
            <input type="text" placeholder="Départ">
            <input type="text" placeholder="Arrivée">
            <input type="text" onfocus="(this.type='date')" placeholder="dd/mm/aaaa">
            <button class="search-button">Chercher</button>
        </div>
    </div>
    <footer>
        &copy; 2024 Voituretech - Tous droits réservés.
    </footer>
</body>
</html>
