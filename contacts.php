<?php
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
                            <a href="message.php?exp_id=305&dest_id=<?php echo urlencode($row['idutilisateur']); ?>&nom=<?php echo urlencode($row['nom']); ?>&prenom=<?php echo urlencode($row['prenom']); ?>&type=utilisateur" class="btn">Envoyer un message</a>
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
