<?php
session_start(); 
require 'db.php'; 

$message = '';
$trips = [];


$userEmail = $_SESSION['email'] ?? 'Non connecté'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $villeDepart = $_POST['villeDepart'] ?? null;
    $villeArrivee = $_POST['villeArrivee'] ?? null;

    // Construction dynamique de la requête en fonction des entrées
    $sql = "SELECT * FROM Trajet WHERE PlaceDispo > 0";
    $conditions = [];
    $params = [];
    if (!empty($villeDepart)) {
        $conditions[] = "VilleDepart = :villeDepart";
        $params[':villeDepart'] = $villeDepart;
    }
    if (!empty($villeArrivee)) {
        $conditions[] = "VilleArrivee = :villeArrivee";
        $params[':villeArrivee'] = $villeArrivee;
    }

    if (!empty($conditions)) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }

    $stmt = $db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindParam($key, $value);
    }

    try {
        $stmt->execute();
        $trips = $stmt->fetchAll();
    } catch (PDOException $e) {
        $message = "Erreur lors de la récupération des trajets: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de trajets</title>
</head>
<body>
    <h1>Recherche de trajets</h1>
    <div>
        <p>Utilisateur connecté : <?= htmlspecialchars($userEmail) ?></p> <!-- Affichage de l'email de l'utilisateur connecté -->
    </div>
    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="search_trips.php" method="post">
        <label for="villeDepart">Ville de départ:</label>
        <input type="text" id="villeDepart" name="villeDepart">
        <label for="villeArrivee">Ville d'arrivée:</label>
        <input type="text" id="villeArrivee" name="villeArrivee">
        <input type="submit" value="Rechercher">
    </form>
    <?php if (!empty($trips)): ?>
        <ul>
            <?php foreach ($trips as $trip): ?>
                <li><?= htmlspecialchars($trip['VilleDepart']) ?> à <?= htmlspecialchars($trip['VilleArrivee']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
