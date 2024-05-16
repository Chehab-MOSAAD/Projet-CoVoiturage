<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <link rel="stylesheet" href="messagerie.css">
</head>
<body>
    <header>
        <h1>Messagerie</h1>
    </header>
    <main>
        <form action="envoyer_message.php" method="post">
            <label for="expediteur">Expéditeur (ID Utilisateur):</label>
            <input type="number" id="expediteur" name="expediteur" required>

            <label for="destinataire">Destinataire (ID Utilisateur):</label>
            <input type="number" id="destinataire" name="destinataire" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </main>
</body>
</html>
<?php
// Configuration de la connexion à la base de données
$host = "localhost";
$port = "5433";  // Port par défaut de PostgreSQL
$user = "postgres";
$password = "lilou";
$dbname = "CoVoiturage";
$connexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connexion) {
    die("Échec de la connexion: " . pg_last_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expediteur = pg_escape_string($connexion, $_POST['expediteur']);
    $destinataire = pg_escape_string($connexion, $_POST['destinataire']);
    $message = pg_escape_string($connexion, $_POST['message']);

    // Insertion du message dans la base de données
    $insertQuery = "INSERT INTO Messagerie (ExpediteurId, DestinataireId, Message) VALUES ($1, $2, $3)";
    $result = pg_query_params($connexion, $insertQuery, array($expediteur, $destinataire, $message));

    if ($result) {
        echo "Message envoyé avec succès!";
    } else {
        echo "Erreur lors de l'envoi du message: " . pg_last_error($connexion);
    }

    pg_close($connexion);
} else {
    echo "Aucune donnée reçue.";
}
?>
