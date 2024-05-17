<?php
session_start();
require 'db.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    die("Vous devez être connecté pour voir cette page.");
}

$userEmail = $_SESSION['email'];
$message = '';

// Requête pour récupérer les informations de l'utilisateur connecté
$sql = 'SELECT idutilisateur, mail, motdepasse, nom, prenom, sexe, tel, handicap, notepassager, langueparle1, langueparle2, fumeur, jour, mois, annee
        FROM utilisateur
        WHERE mail = $1';
$result = pg_query_params($db, $sql, array($userEmail));

if ($result && pg_num_rows($result) > 0) {
    $user = pg_fetch_assoc($result);
} else {
    $message = "Erreur lors de la récupération des informations utilisateur.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
</head>
<body>
    <h2>Profil Utilisateur</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php else: ?>
        <table border="1">
            <tr><th>ID</th><td><?php echo htmlspecialchars($user['idutilisateur']); ?></td></tr>
            <tr><th>Email</th><td><?php echo htmlspecialchars($user['mail']); ?></td></tr>
            <tr><th>Nom</th><td><?php echo htmlspecialchars($user['nom']); ?></td></tr>
            <tr><th>Prénom</th><td><?php echo htmlspecialchars($user['prenom']); ?></td></tr>
            <tr><th>Sexe</th><td><?php echo htmlspecialchars($user['sexe']); ?></td></tr>
            <tr><th>Téléphone</th><td><?php echo htmlspecialchars($user['tel']); ?></td></tr>
            <tr><th>Handicap</th><td><?php echo $user['handicap'] ? 'Oui' : 'Non'; ?></td></tr>
            <tr><th>Note Passager</th><td><?php echo htmlspecialchars($user['notepassager']); ?></td></tr>
            <tr><th>Langue Parlée 1</th><td><?php echo htmlspecialchars($user['langueparle1']); ?></td></tr>
            <tr><th>Langue Parlée 2</th><td><?php echo htmlspecialchars($user['langueparle2']); ?></td></tr>
            <tr><th>Fumeur</th><td><?php echo $user['fumeur'] ? 'Oui' : 'Non'; ?></td></tr>
            <tr><th>Date de Naissance</th><td><?php echo htmlspecialchars($user['jour']) . '/' . htmlspecialchars($user['mois']) . '/' . htmlspecialchars($user['annee']); ?></td></tr>
        </table>
        <br>
        <form action="mettre_a_jours.php" method="get">
            <button type="submit">Mettre à jour mes informations</button>
        </form>
        <br>
        <form action="history.php" method="post">
            <button type="submit">history</button>
        </form>
        <br>
        <form action="deconnexion.php" method="post">
            <button type="submit">Se déconnecter</button>
        </form>
    <?php endif; ?>
</body>
</html>
