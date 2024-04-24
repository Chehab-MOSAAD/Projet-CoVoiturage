<?php
session_start();
include 'db.php'; 

$userId = $_SESSION['id'] ?? null;
$username = $_SESSION['nom'] ?? 'Visiteur'; 


try {
    $trajetsDisponibles = $db->query("SELECT * FROM trajets ORDER BY date_depart ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des trajets: " . $e->getMessage();
    $trajetsDisponibles = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de trajet - Voituretech</title>
    <style>
    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background: #f5f5f5;
        height: 100%;
        min-height: 100vh; 
        display: flex;
        flex-direction: column; 
    }

    header {
        background-color: #fff;
        color: #333;
        padding: 1em 0;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    nav {
        background-color: #38b238;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        overflow: hidden;
    }

    nav a {
        padding: 1em 1.5em;
        display: inline-block;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    nav a:hover, nav a:focus, nav a.active {
        background-color: #2d862d;
    }

    .search-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        width: 80%;
        max-width: 800px;
        margin: 30px auto;
        text-align: center;
    }

    .search-fields {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
    }

    .search-fields input, .search-fields button {
        padding: 10px;
        border: 2px solid #38b238;
        border-radius: 4px;
        outline: none;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .search-fields input:focus {
        border-color: #2d862d;
    }

    .search-button {
        background-color: #38b238;
        color: white;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s;
    }

    .search-button:hover {
        background-color: #2d862d;
    }

    table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #38b238;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    footer {
        text-align: center;
        padding: 10px;
        background-color: #333;
        color: white;
        position: fixed;
        bottom: 0;
        width: 100%;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.2);
        margin-top: auto;
        
    }

    @media (max-width: 768px) {
        .search-fields {
            flex-direction: column;
        }

        nav a {
            padding: 0.5em 1em;
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
        <a href="#Recherche" class="active">Recherche</a>
        <a href="#Offres">Offres</a>
        <a href="#Inscription">Inscription</a>
        <a href="#Connexion">Connexion</a>
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
    <section>
        <h2>Trajets disponibles</h2>
        <table>
            <thead>
                <tr>
                    <th>Date de départ</th>
                    <th>Lieu de départ</th>
                    <th>Destination</th>
                    <th>Nombre de passagers</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajetsDisponibles as $trajet): ?>
                <tr>
                    <td><?= htmlspecialchars($trajet['date_depart']) ?></td>
                    <td><?= htmlspecialchars($trajet['depart']) ?></td>
                    <td><?= htmlspecialchars($trajet['arrivee']) ?></td>
                    <td><?= htmlspecialchars($trajet['nombre_passagers']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <footer>
        &copy; 2024 Voituretech - Tous droits réservés.
    </footer>
</body>
</html>
