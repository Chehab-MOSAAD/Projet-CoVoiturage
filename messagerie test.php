<?php
session_start();
include 'config.php'; // Votre script de connexion à la base de données PDO

// Assumer un utilisateur connecté (pour les tests, utiliser un ID fixe)
$userId = $_SESSION['user_id'] ?? 1; // Supposons que cet utilisateur est connecté
$idSession = $userId; // Simplification: chaque utilisateur a une session égale à son ID pour les messages

// Traitement de l'envoi de nouveaux messages
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    
    // Insertion du nouveau message dans la base de données
    $stmt = $pdo->prepare("INSERT INTO Messagerie (IdSession, Message) VALUES (:idSession, :message)");
    $stmt->execute(['idSession' => $idSession, 'message' => $message]);
    
    // Redirection vers la même page pour éviter les soumissions de formulaire multiples
    header("Location: messages.php");
    exit;
}

// Charger les messages de la session de l'utilisateur
$stmt = $pdo->prepare("SELECT Message FROM Messagerie WHERE IdSession = :idSession ORDER BY IdSession DESC");
$stmt->execute(['idSession' => $idSession]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Messagerie</h1>
    </header>
    <main>
        <!-- Formulaire pour envoyer un nouveau message -->
        <form action="messages.php" method="post">
            <textarea name="message" required></textarea>
            <button type="submit">Envoyer</button>
        </form>

        <!-- Affichage des messages existants -->
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message">
                    <p><?= htmlspecialchars($message['Message']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun message dans cette session.</p>
        <?php endif; ?>
    </main>
</body>
</html>
