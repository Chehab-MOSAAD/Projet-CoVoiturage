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

$query = "SELECT m.IdSession, m.Message, e.Jour, e.Mois, e.Annee, m.Status
          FROM Messagerie m
          JOIN Recevoir r ON m.IdSession = r.IdSession
          JOIN Envoyer e ON m.IdSession = e.IdSession
          WHERE r.IdUtilisateur = :admin_id
          ORDER BY e.Annee DESC, e.Mois DESC, e.Jour DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['admin_id' => $admin_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idSession']) && isset($_POST['action'])) {
    $idSession = filter_input(INPUT_POST, 'idSession', FILTER_VALIDATE_INT);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    if ($action === 'accept') {
        $updateQuery = "UPDATE Messagerie SET Status = 'Accepted' WHERE IdSession = :idSession";
    } elseif ($action === 'reject') {
        $updateQuery = "UPDATE Messagerie SET Status = 'Rejected' WHERE IdSession = :idSession";
    }

    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute(['idSession' => $idSession]);
    header("Location: admin_requests.php");
    exit();
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
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $row) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['jour']) . '/' . htmlspecialchars($row['mois']) . '/' . htmlspecialchars($row['annee']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <?php if ($row['status'] === 'Pending') : ?>
                                <form method="post">
                                    <input type="hidden" name="idSession" value="<?php echo htmlspecialchars($row['idsession']); ?>">
                                    <button type="submit" name="action" value="accept">Accepter</button>
                                    <button type="submit" name="action" value="reject">Refuser</button>
                                </form>
                            <?php else : ?>
                                <span><?php echo htmlspecialchars($row['status']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
