<?php
session_start(); // Démarrer la session

// Connexion à la base de données
$host = 'localhost';
$db = 'CoVoiturage';
$user = 'postgres';
$pass = 'lilou';
$port = '5433';
$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifiez si l'email du conducteur est stocké dans la session
if (!isset($_SESSION['email_conducteur'])) {
    die("Erreur : Aucun email de conducteur trouvé dans la session.");
}

$email_conducteur = $_SESSION['email_conducteur'];

// Récupération de l'ID du conducteur à partir de l'email
$idQuery = "SELECT c.idutilisateur FROM conducteur c JOIN utilisateur u ON c.idutilisateur = u.idutilisateur WHERE u.mail = :email";
$stmt = $pdo->prepare($idQuery);
$stmt->execute(['email' => $email_conducteur]);

if ($stmt->rowCount() == 0) {
    die("Aucun conducteur trouvé avec cet email.");
}

$conducteur_row = $stmt->fetch(PDO::FETCH_ASSOC);
$id_utilisateur = $conducteur_row['idutilisateur'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = filter_input(INPUT_POST, 'matricule', FILTER_SANITIZE_STRING);
    $marque = filter_input(INPUT_POST, 'marque', FILTER_SANITIZE_STRING);
    $modele = filter_input(INPUT_POST, 'modele', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $couleur = filter_input(INPUT_POST, 'couleur', FILTER_SANITIZE_STRING);
    $nbr_place = filter_input(INPUT_POST, 'nbr_place', FILTER_VALIDATE_INT);
    $carburant = filter_input(INPUT_POST, 'carburant', FILTER_SANITIZE_STRING);
    $numpermis = filter_input(INPUT_POST, 'numpermis', FILTER_SANITIZE_STRING);

    // Création du message pour l'administrateur
    $message = "Une nouvelle demande d'enregistrement de voiture a été soumise avec les informations suivantes :\n
                Matricule : $matricule\n
                Marque : $marque\n
                Modèle : $modele\n
                Type : $type\n
                Couleur : $couleur\n
                Nombre de places : $nbr_place\n
                Carburant : $carburant\n
                Numéro de permis : $numpermis";
    $dateenvoi = date('Y-m-d H:i:s');
    $status = 'Pending';

    // Insertion du message dans la table Messagerie
    $insertMessageQuery = "INSERT INTO Messagerie (expediteurid, destinataireid, message, dateenvoi, status) 
                           VALUES (:expediteurid, :destinataireid, :message, :dateenvoi, :status)";
    $stmt = $pdo->prepare($insertMessageQuery);
    $stmt->execute([
        ':expediteurid' => $id_utilisateur,
        ':destinataireid' => 1, // ID de l'administrateur, vous pouvez changer cela si nécessaire
        ':message' => $message,
        ':dateenvoi' => $dateenvoi,
        ':status' => $status
    ]);

    echo "Votre demande a été envoyée pour approbation.";
}
?>
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
            <h1>Bienvenue !</h1>
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
            <input type="number" id="nbr_place" name="nbr_place" required>

            <label for="carburant">Carburant</label>
            <input type="text" id="carburant" name="carburant" required>

            <label for="numpermis">Numéro de permis</label>
            <input type="text" id="numpermis" name="numpermis" required>

            <button type="submit">Envoyer votre demande</button>
        </form>
    </div>
</body>
</html>
