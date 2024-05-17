<?php
session_start();
require 'db.php';

// Vérifie si l'administrateur est connecté
if (!isset($_SESSION['email'])) {
    die("Vous devez être connecté pour voir cette page.");
}

$adminEmail = $_SESSION['email'];
$message = '';

// Requête pour récupérer les informations de l'administrateur connecté
$sql = 'SELECT idadm, mail, nomadm, prenomadm, motdepasse
        FROM administrateur
        WHERE mail = $1';
$result = pg_query_params($db, $sql, array($adminEmail));

if ($result && pg_num_rows($result) > 0) {
    $admin = pg_fetch_assoc($result);
} else {
    $message = "Erreur lors de la récupération des informations administrateur.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Administrateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Profil Administrateur</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php else: ?>
        <table>
            <tr><th>ID</th><td><?php echo htmlspecialchars($admin['idadm']); ?></td></tr>
            <tr><th>Email</th><td><?php echo htmlspecialchars($admin['mail']); ?></td></tr>
            <tr><th>Nom</th><td><?php echo htmlspecialchars($admin['nomadm']); ?></td></tr>
            <tr><th>Prénom</th><td><?php echo htmlspecialchars($admin['prenomadm']); ?></td></tr>
        </table>
    <?php endif; ?>
</body>
</html>
