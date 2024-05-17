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

$conducteur_id = 304; // Remplacez par l'ID du conducteur

// Récupération de l'historique des trajets passés
$historiqueQuery = "SELECT t.villedepart, t.villearrivee, t.commentairetrajetconducteur, t.placedispo, t.matricule, d.jourdepart, d.jourarrivee, d.semaine, d.heuredepart, d.heurearrivee 
                    FROM trajet t
                    JOIN \"départ\" d ON t.idtrajet = d.idtrajet
                    WHERE t.numpermis = (SELECT numpermis FROM conducteur WHERE idutilisateur = $1)
                    AND (
                        (d.jourdepart + (d.semaine - 1) * 7) < EXTRACT(DOY FROM CURRENT_DATE)
                        OR (d.semaine < EXTRACT(WEEK FROM CURRENT_DATE) AND EXTRACT(YEAR FROM CURRENT_DATE) = EXTRACT(YEAR FROM CURRENT_DATE))
                    )";
$historiqueResult = pg_query_params($connexion, $historiqueQuery, array($conducteur_id));

if (!$historiqueResult) {
    die("Erreur lors de la récupération de l'historique des trajets: " . pg_last_error($connexion));
}

// Récupération des trajets à venir
$avenirQuery = "SELECT t.villedepart, t.villearrivee, t.commentairetrajetconducteur, t.placedispo, t.matricule, d.jourdepart, d.jourarrivee, d.semaine, d.heuredepart, d.heurearrivee 
                FROM trajet t
                JOIN \"départ\" d ON t.idtrajet = d.idtrajet
                WHERE t.numpermis = (SELECT numpermis FROM conducteur WHERE idutilisateur = $1)
                AND (
                    (d.jourdepart + (d.semaine - 1) * 7) >= EXTRACT(DOY FROM CURRENT_DATE)
                    OR (d.semaine >= EXTRACT(WEEK FROM CURRENT_DATE) AND EXTRACT(YEAR FROM CURRENT_DATE) = EXTRACT(YEAR FROM CURRENT_DATE))
                )";
$avenirResult = pg_query_params($connexion, $avenirQuery, array($conducteur_id));

if (!$avenirResult) {
    die("Erreur lors de la récupération des trajets à venir: " . pg_last_error($connexion));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Trajets</title>
    <link rel="stylesheet" href="historique.css">
</head>
<body>
    <header>
        <h1>Historique des Trajets</h1>
    </header>
    <main>
        <section>
            <h2>L'Historique :</h2>
            <?php while ($row = pg_fetch_assoc($historiqueResult)) : ?>
                <div class="trip-card">
                    <h3><?php echo 'Semaine ' . htmlspecialchars($row['semaine']) . ' - ' . htmlspecialchars($row['jourdepart']) . ' au ' . htmlspecialchars($row['jourarrivee']); ?></h3>
                    <p><strong>Ville de Départ :</strong> <?php echo htmlspecialchars($row['villedepart']); ?></p>
                    <p><strong>Ville d'Arrivée :</strong> <?php echo htmlspecialchars($row['villearrivee']); ?></p>
                    <p><strong>Commentaire :</strong> <?php echo htmlspecialchars($row['commentairetrajetconducteur']); ?></p>
                    <p><strong>Places Disponibles :</strong> <?php echo htmlspecialchars($row['placedispo']); ?></p>
                    <p><strong>Matricule :</strong> <?php echo htmlspecialchars($row['matricule']); ?></p>
                    <p><strong>Heure de Départ :</strong> <?php echo htmlspecialchars($row['heuredepart']); ?></p>
                    <p><strong>Heure d'Arrivée :</strong> <?php echo htmlspecialchars($row['heurearrivee']); ?></p>
                    <p class="status">Status : Fait</p>
                    <a href="#" class="comment-btn">Commenter</a>
                </div>
            <?php endwhile; ?>
        </section>
        <section>
            <h2>A venir :</h2>
            <?php while ($row = pg_fetch_assoc($avenirResult)) : ?>
                <div class="trip-card">
                    <h3><?php echo 'Semaine ' . htmlspecialchars($row['semaine']) . ' - ' . htmlspecialchars($row['jourdepart']) . ' au ' . htmlspecialchars($row['jourarrivee']); ?></h3>
                    <p><strong>Ville de Départ :</strong> <?php echo htmlspecialchars($row['villedepart']); ?></p>
                    <p><strong>Ville d'Arrivée :</strong> <?php echo htmlspecialchars($row['villearrivee']); ?></p>
                    <p><strong>Commentaire :</strong> <?php echo htmlspecialchars($row['commentairetrajetconducteur']); ?></p>
                    <p><strong>Places Disponibles :</strong> <?php echo htmlspecialchars($row['placedispo']); ?></p>
                    <p><strong>Matricule :</strong> <?php echo htmlspecialchars($row['matricule']); ?></p>
                    <p><strong>Heure de Départ :</strong> <?php echo htmlspecialchars($row['heuredepart']); ?></p>
                    <p><strong>Heure d'Arrivée :</strong> <?php echo htmlspecialchars($row['heurearrivee']); ?></p>
                    <p class="status pending">Status : En attente</p>
                    <a href="#" class="comment-btn">Commenter</a>
                </div>
            <?php endwhile; ?>
        </section>
    </main>
</body>
</html>

<?php
pg_close($connexion);
?>
