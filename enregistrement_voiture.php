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
<?php
session_start(); // Démarrer la session

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = filter_input(INPUT_POST, 'matricule', FILTER_SANITIZE_STRING);
    $marque = filter_input(INPUT_POST, 'marque', FILTER_SANITIZE_STRING);
    $modele = filter_input(INPUT_POST, 'modele', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $couleur = filter_input(INPUT_POST, 'couleur', FILTER_SANITIZE_STRING);
    $nbr_place = filter_input(INPUT_POST, 'nbr_place', FILTER_VALIDATE_INT);
    $carburant = filter_input(INPUT_POST, 'carburant', FILTER_SANITIZE_STRING);
    $numpermis = filter_input(INPUT_POST, 'numpermis', FILTER_SANITIZE_STRING);

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

    if ($nbr_place === false || $nbr_place <= 0 || $nbr_place > 100) {
        die("Nombre de places invalide. Valeur reçue : " . htmlspecialchars($nbr_place));
    }

    if (!in_array($carburant, ['essence', 'diesel', 'éthanol', 'gaz', 'électrique', 'hybride'])) {
        die("Carburant invalide. Valeur reçue : " . htmlspecialchars($carburant));
    }

    if (!preg_match("/^[0-9A-Z]+$/", $numpermis)) {
        die("Numéro de permis invalide. Valeur reçue : " . htmlspecialchars($numpermis));
    }

    // Vérifiez si le numéro de permis existe dans la table Conducteur
    $checkPermisQuery = "SELECT COUNT(*) FROM Conducteur WHERE NumPermis = :numpermis";
    $stmt = $pdo->prepare($checkPermisQuery);
    $stmt->execute(['numpermis' => $numpermis]);

    if ($stmt->fetchColumn() == 0) {
        die("Le numéro de permis n'existe pas dans la table Conducteur. Veuillez ajouter le conducteur d'abord.");
    }

    // Insérer la date courante dans LaDate si elle n'existe pas
    $currentDate = getdate();
    $jour = $currentDate['mday'];
    $mois = $currentDate['mon'];
    $annee = $currentDate['year'];
    $heure = $currentDate['hours'] . ':' . $currentDate['minutes'] . ':' . $currentDate['seconds'];

    $insertDateQuery = "INSERT INTO LaDate (Jour, Mois, Annee, Heure) 
                        VALUES (:jour, :mois, :annee, :heure) 
                        ON CONFLICT (Jour, Mois, Annee) DO NOTHING";
    $stmt = $pdo->prepare($insertDateQuery);
    $stmt->execute(['jour' => $jour, 'mois' => $mois, 'annee' => $annee, 'heure' => $heure]);

    // Insertion des données dans la table Voiture
    $insertVoitureQuery = "INSERT INTO Voiture (matricule, marque, modele, type, couleur, nbrplace, carburant, numpermis) 
                           VALUES (:matricule, :marque, :modele, :type, :couleur, :nbrplace, :carburant, :numpermis)";
    $stmt = $pdo->prepare($insertVoitureQuery);

    try {
        $stmt->execute([
            ':matricule' => $matricule,
            ':marque' => $marque,
            ':modele' => $modele,
            ':type' => $type,
            ':couleur' => $couleur,
            ':nbrplace' => $nbr_place,
            ':carburant' => $carburant,
            ':numpermis' => $numpermis
        ]);
        echo "Voiture enregistrée avec succès.";

        // Récupération de l'ID de l'utilisateur connecté (ou le mettre en dur pour le test)
        $exp_id = 304; // Remplacez par l'ID de l'utilisateur connecté
        $admin_id = 1; // ID de l'administrateur

        // Création du message pour l'administrateur
        $sujet = "Nouvelle demande d'enregistrement de voiture";
        $message = "Une nouvelle voiture a été enregistrée avec les informations suivantes :\n
                    Matricule : $matricule\n
                    Marque : $marque\n
                    Modèle : $modele\n
                    Type : $type\n
                    Couleur : $couleur\n
                    Nombre de places : $nbr_place\n
                    Carburant : $carburant\n
                    Numéro de permis : $numpermis";

        // Insertion du message dans la table Messagerie
        $insertMessageQuery = "INSERT INTO Messagerie (IdSession, Message, ExpediteurId, DestinataireId) 
                               VALUES (DEFAULT, :message, :expediteurid, :destinataireid) RETURNING IdSession";
        $stmt = $pdo->prepare($insertMessageQuery);
        $stmt->execute([':message' => $message, ':expediteurid' => $exp_id, ':destinataireid' => $admin_id]);

        $idSession = $stmt->fetchColumn();

        // Insertion dans la table Envoyer
        $insertEnvoyerQuery = "INSERT INTO Envoyer (IdSession, IdUtilisateur, Jour, Mois, Annee) 
                               VALUES (:idSession, :idUtilisateur, :jour, :mois, :annee)";
        $stmt = $pdo->prepare($insertEnvoyerQuery);
        $stmt->execute([':idSession' => $idSession, ':idUtilisateur' => $exp_id, ':jour' => $jour, ':mois' => $mois, ':annee' => $annee]);

        // Insertion dans la table Recevoir
        $insertRecevoirQuery = "INSERT INTO Recevoir (IdSession, IdUtilisateur, Jour, Mois, Annee) 
                                VALUES (:idSession, :idUtilisateur, :jour, :mois, :annee)";
        $stmt = $pdo->prepare($insertRecevoirQuery);
        $stmt->execute([':idSession' => $idSession, ':idUtilisateur' => $admin_id, ':jour' => $jour, ':mois' => $mois, ':annee' => $annee]);

        echo "Notification envoyée à l'administrateur.";
        echo '<a href="message.php?exp_id=' . urlencode($exp_id) . '&dest_id=' . urlencode($admin_id) . '&nom=' . urlencode('Administrateur') . '&prenom=' . urlencode('CoVoiTECH') . '&type=admin" class="btn">Envoyer un message</a>';
    } catch (PDOException $e) {
        echo "Erreur lors de l'enregistrement de la voiture ou de l'envoi de la notification: " . $e->getMessage();
    }
}
?>
