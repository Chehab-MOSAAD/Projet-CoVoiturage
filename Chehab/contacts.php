<?php
session_start(); // Démarrer la session

// Connexion à la base de données
$host = "localhost";
$port = "5433";
$user = "postgres";
$password = "lilou";
$dbname = "CoVoiturage";
$connexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connexion) {
    die("Échec de la connexion: " . pg_last_error());
}

// Vérifiez si l'email du conducteur est stocké dans la session
if (!isset($_SESSION['email_conducteur'])) {
    die("Erreur : Aucun email de conducteur trouvé dans la session.");
}

$email_conducteur = $_SESSION['email_conducteur'];

// Récupération de l'ID du conducteur
$idQuery = "SELECT c.idutilisateur 
            FROM conducteur c 
            JOIN utilisateur u ON c.idutilisateur = u.idutilisateur 
            WHERE u.mail = $1";
$idResult = pg_query_params($connexion, $idQuery, array($email_conducteur));

if (!$idResult) {
    die("Erreur lors de la récupération de l'ID du conducteur: " . pg_last_error($connexion));
}

if (pg_num_rows($idResult) == 0) {
    die("Aucun conducteur trouvé avec cet email.");
}

$conducteur_row = pg_fetch_assoc($idResult);
$id_utilisateur = $conducteur_row['idutilisateur'];

// Récupération des contacts (tous les utilisateurs et conducteurs)
$contactsQuery = "SELECT idutilisateur, nom, prenom FROM utilisateur";
$contactsResult = pg_query($connexion, $contactsQuery);

if (!$contactsResult) {
    die("Erreur lors de la récupération des contacts: " . pg_last_error($connexion));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
    <link rel="stylesheet" href="contacts.css">
</head>
<body>
    <header>
        <h1>Contacts</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = pg_fetch_assoc($contactsResult)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                        <td>
                            <a href="message.php?exp_id=<?php echo urlencode($id_utilisateur); ?>&dest_id=<?php echo urlencode($row['idutilisateur']); ?>&nom=<?php echo urlencode($row['nom']); ?>&prenom=<?php echo urlencode($row['prenom']); ?>&type=utilisateur" class="btn">Envoyer un message</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
pg_close($connexion);
?>
