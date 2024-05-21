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

// Vérifiez si l'email de l'administrateur est stocké dans la session
if (!isset($_SESSION['email_administrateur'])) {
    die("Erreur : Aucun email d'administrateur trouvé dans la session.");
}

$email_administrateur = $_SESSION['email_administrateur'];

// Récupération de l'ID de l'administrateur
$query = "SELECT idadm FROM administrateur WHERE mail = :email";
$stmt = $pdo->prepare($query);
$stmt->execute(['email' => $email_administrateur]);

if ($stmt->rowCount() == 0) {
    die("Erreur : Aucun administrateur trouvé avec cet email.");
}

$admin = $stmt->fetch(PDO::FETCH_ASSOC);
$admin_id = $admin['idadm'];

$query = "SELECT m.idsession, m.message, m.dateenvoi, m.status, u.mail AS expediteur_mail
          FROM Messagerie m
          JOIN utilisateur u ON m.expediteurid = u.idutilisateur
          WHERE m.destinataireid = :admin_id
          ORDER BY m.dateenvoi DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['admin_id' => $admin_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idSession']) && isset($_POST['action'])) {
    $idSession = filter_input(INPUT_POST, 'idSession', FILTER_VALIDATE_INT);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    if ($idSession && $action) {
        if ($action === 'accept') {
            // Récupérer les détails de la demande
            $messageQuery = "SELECT message FROM Messagerie WHERE idsession = :idSession";
            $stmt = $pdo->prepare($messageQuery);
            $stmt->execute(['idSession' => $idSession]);
            $messageRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $messageContent = $messageRow['message'];

            // Extraire les informations de la demande à partir du message
            preg_match_all('/:\s(.+?)(?:\n|$)/', $messageContent, $matches);
            if (count($matches[1]) !== 8) {
                die("Erreur: Informations de la demande invalides.");
            }
            list($matricule, $marque, $modele, $type, $couleur, $nbr_place, $carburant, $numpermis) = $matches[1];

            // Convertir les valeurs en les types appropriés
            $nbr_place = intval($nbr_place);
            if (!$nbr_place) {
                die("Erreur: Nombre de places invalide.");
            }

            // Insertion des données dans la table Voiture
            $insertVoitureQuery = "INSERT INTO Voiture (matricule, marque, modele, type, couleur, nbrplace, carburant, numpermis) 
                                   VALUES (:matricule, :marque, :modele, :type, :couleur, :nbrplace, :carburant, :numpermis)";
            $stmt = $pdo->prepare($insertVoitureQuery);
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

            // Mettre à jour le statut du message
            $updateQuery = "UPDATE Messagerie SET status = 'Accepted' WHERE idsession = :idSession";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute(['idSession' => $idSession]);
            echo "Demande acceptée avec succès.";
        } elseif ($action === 'reject') {
            // Mettre à jour le statut du message
            $updateQuery = "UPDATE Messagerie SET status = 'Rejected' WHERE idsession = :idSession";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute(['idSession' => $idSession]);
            echo "Demande refusée avec succès.";
        } else {
            echo "Action invalide.";
        }
    } else {
        echo "Données invalides.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de l'Administrateur</title>
    <link rel="stylesheet" href="admin_messages.css">
</head>
<body>
    <div class="container">
        <h1>Messages Reçus</h1>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Expéditeur</th>
                    <th>Message</th>
                    <th>Status</th>                
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $row) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['dateenvoi']); ?></td>
                        <td><?php echo htmlspecialchars($row['expediteur_mail']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
    
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
