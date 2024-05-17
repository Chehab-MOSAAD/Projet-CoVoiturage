<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement Voiture</title>
    <link rel="stylesheet" href="enregistrement_voiture.css">
</head>
<body>
    <div class="login-container">
        <div class="header">
            <h1>Bienvenue  !</h1>
        </div>
        <form action="enregistrement_voiture.php" method="POST">
            <label for="matricule">Numéro de Matricule</label>
            <input type="text" id="matricule" name="matricule" required>

            <label for="marque">Marque</label>
            <input type="text" id="marque" name="marque" required>

            <label for="modele">Modèle</label>
            <input type="text" id="modele" name="modele" required>

            <label for="type">Type</label>
            <input type="text" id="type" name="type" required>

            <label for="couleur">Couleur</label>
            <input type="text" id="couleur" name="couleur" required>

            <label for="nbr_place">Nombre de places</label>
            <input type="text" id="nbr_place" name="nbr_place" required>

            <label for="carburant">Carburant</label>
            <input type="text" id="carburant" name="carburant" required>

            <label for="numpermis">Numéro de permis</label>
            <input type="text" id="numpermis" name="numpermis" required>

            <button type="submit">Envoyer votre demande</button>
        </form>
    </div>
</body>
</html>
<?php
$host = "localhost";
$port = "5433";  // Port par défaut de PostgreSQL
$user = "postgres";
$password = "lilou";
$dbname = "CoVoiturage";

// Connexion à la base de données
$connexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connexion) {
    die("Échec de la connexion: " . pg_last_error());
}

// Vérification de la méthode de la requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = pg_escape_string($connexion, $_POST['matricule']);
    $marque = pg_escape_string($connexion, $_POST['marque']);
    $modele = pg_escape_string($connexion, $_POST['modele']);
    $type = pg_escape_string($connexion, $_POST['type']);
    $couleur = pg_escape_string($connexion, $_POST['couleur']);
    $nbr_place = pg_escape_string($connexion, $_POST['nbr_place']);
    $carburant = pg_escape_string($connexion, $_POST['carburant']);
    $numpermis = pg_escape_string($connexion, $_POST['numpermis']);

    // Affichage des valeurs soumises pour débogage
    echo "Matricule: " . htmlspecialchars($matricule) . "<br>";
    echo "Marque: " . htmlspecialchars($marque) . "<br>";
    echo "Modèle: " . htmlspecialchars($modele) . "<br>";
    echo "Type: " . htmlspecialchars($type) . "<br>";
    echo "Couleur: " . htmlspecialchars($couleur) . "<br>";
    echo "Nombre de places: " . htmlspecialchars($nbr_place) . "<br>";
    echo "Carburant: " . htmlspecialchars($carburant) . "<br>";
    echo "Numéro de permis: " . htmlspecialchars($numpermis) . "<br>";

    // Validation des données
    if (!preg_match("/^[A-Z0-9]+$/", $matricule)) {
        die("Numéro de matricule invalide. Valeur reçue : " . htmlspecialchars($matricule));
    }

    if (!preg_match("/^[A-Za-z0-9 ]+$/", $marque)) {
        die("Marque invalide. Valeur reçue : " . htmlspecialchars($marque));
    }

    if (!preg_match("/^[A-Za-z0-9 ]+$/", $modele)) {
        die("Modèle invalide. Valeur reçue : " . htmlspecialchars($modele));
    }

    if (!in_array($type, ['SUV', 'Berline', 'Compacte', 'Monospace'])) {
        die("Type invalide. Valeur reçue : " . htmlspecialchars($type));
    }

    if (!in_array($couleur, ['bleu', 'violet', 'rose', 'rouge', 'orange', 'jaune', 'vert', 'noir', 'marron', 'gris', 'aluminium', 'argent', 'blanc'])) {
        die("Couleur invalide. Valeur reçue : " . htmlspecialchars($couleur));
    }

    if (!is_numeric($nbr_place) || $nbr_place <= 0 || $nbr_place > 100) {
        die("Nombre de places invalide. Valeur reçue : " . htmlspecialchars($nbr_place));
    }

    if (!in_array($carburant, ['essence', 'diesel', 'éthanol', 'gaz', 'électrique', 'hybride'])) {
        die("Carburant invalide. Valeur reçue : " . htmlspecialchars($carburant));
    }

    if (!preg_match("/^[0-9A-Z]+$/", $numpermis)) {
        die("Numéro de permis invalide. Valeur reçue : " . htmlspecialchars($numpermis));
    }

    // Requête préparée pour insérer les données dans la table Voiture
    $insertVoitureQuery = "INSERT INTO voiture (matricule, marque, modele, type, couleur, nbrplace, carburant, numpermis) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
    $insertVoitureResult = pg_query_params($connexion, $insertVoitureQuery, array($matricule, $marque, $modele, $type, $couleur, $nbr_place, $carburant, $numpermis));

    if ($insertVoitureResult) {
        echo "Voiture enregistrée avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de la voiture: " . pg_last_error($connexion);
    }

    pg_close($connexion);
}
?>
