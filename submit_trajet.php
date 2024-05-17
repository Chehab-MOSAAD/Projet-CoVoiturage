<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer un Trajet</title>
    <link rel="stylesheet" href="proposer-un-trajet.css">
</head>
<body>
    <header>
        <h1>Bienvenue !</h1>
    </header>

    <main>
        <form action="submit_trajet.php" method="post">
            <h2>Proposer un trajet :</h2>
            <div class="form-row">
                <input type="text" name="ville_depart" placeholder="Ville de départ" required>
                <input type="text" name="nom_rue_depart" placeholder="Nom Rue de départ" required>
                <input type="text" name="num_rue_depart" placeholder="Numéro Rue de départ" required>
                <input type="text" name="code_postal_depart" placeholder="Code postal de départ" required>
            </div>
            <div class="form-row">
                <input type="text" name="ville_arrivee" placeholder="Ville d'arrivée" required>
                <input type="text" name="nom_rue_arrivee" placeholder="Nom Rue d'arrivée" required>
                <input type="text" name="num_rue_arrivee" placeholder="Numéro Rue d'arrivée" required>
                <input type="text" name="code_postal_arrivee" placeholder="Code postal d'arrivée" required>
            </div>
            <div class="form-row">
                <input type="number" name="place_dispo" placeholder="Places disponibles" min="1" required>
                <input type="date" name="date_depart" required>
                <input type="text" name="escale" placeholder="Ajouter un escale">
                <textarea name="commentaire" placeholder="Commentaire" required></textarea>
            </div>
            <footer>
                <button type="submit">Proposer un trajet</button>
            </footer>
        </form>
    </main>
</body>
</html>
<?php
// Configuration de la connexion à la base de données
$host = "localhost";
$port = "5433";  // Port par défaut de PostgreSQL
$user = "postgres";
$password = "lilou";
$dbname = "CoVoiturage";

// Connexion à la base de données
$connexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connexion) {
    die("Échec de la connexion: " . pg_last_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ville_depart = pg_escape_string($connexion, $_POST['ville_depart']);
    $nom_rue_depart = pg_escape_string($connexion, $_POST['nom_rue_depart']);
    $num_rue_depart = pg_escape_string($connexion, $_POST['num_rue_depart']);
    $code_postal_depart = pg_escape_string($connexion, $_POST['code_postal_depart']);
    $ville_arrivee = pg_escape_string($connexion, $_POST['ville_arrivee']);
    $nom_rue_arrivee = pg_escape_string($connexion, $_POST['nom_rue_arrivee']);
    $num_rue_arrivee = pg_escape_string($connexion, $_POST['num_rue_arrivee']);
    $code_postal_arrivee = pg_escape_string($connexion, $_POST['code_postal_arrivee']);
    $place_dispo = pg_escape_string($connexion, $_POST['place_dispo']);
    $date_depart = pg_escape_string($connexion, $_POST['date_depart']);
    $commentaire = pg_escape_string($connexion, $_POST['commentaire']);
    $escale = pg_escape_string($connexion, $_POST['escale']);

    // Supposons que l'utilisateur connecté a l'ID 304
    $id_utilisateur = 304;

    // Récupérer les informations de la voiture pour le conducteur
    $voitureQuery = "SELECT matricule, numpermis FROM voiture WHERE numpermis = (SELECT numpermis FROM conducteur WHERE idutilisateur = $1)";
    $voitureResult = pg_query_params($connexion, $voitureQuery, array($id_utilisateur));
    $voiture = pg_fetch_assoc($voitureResult);

    if (!$voiture) {
        die("Erreur : Le conducteur n'a pas de voiture enregistrée.");
    }

    $matricule = $voiture['matricule'];
    $num_permis = $voiture['numpermis'];

    // Affichage des valeurs soumises pour débogage
    echo "Ville de départ: " . htmlspecialchars($ville_depart) . "<br>";
    echo "Nom Rue de départ: " . htmlspecialchars($nom_rue_depart) . "<br>";
    echo "Numéro Rue de départ: " . htmlspecialchars($num_rue_depart) . "<br>";
    echo "Code postal de départ: " . htmlspecialchars($code_postal_depart) . "<br>";
    echo "Ville d'arrivée: " . htmlspecialchars($ville_arrivee) . "<br>";
    echo "Nom Rue d'arrivée: " . htmlspecialchars($nom_rue_arrivee) . "<br>";
    echo "Numéro Rue d'arrivée: " . htmlspecialchars($num_rue_arrivee) . "<br>";
    echo "Code postal d'arrivée: " . htmlspecialchars($code_postal_arrivee) . "<br>";
    echo "Places disponibles: " . htmlspecialchars($place_dispo) . "<br>";
    echo "Date de départ: " . htmlspecialchars($date_depart) . "<br>";
    echo "Commentaire: " . htmlspecialchars($commentaire) . "<br>";
    echo "Escale: " . htmlspecialchars($escale) . "<br>";

    // Insertion dans la base de données
    $insertQuery = "INSERT INTO trajet (VilleDepart, CodePostalDepart, NomRueDepart, NumRueDepart, VilleArrivee, CodePostalArrivee, NomRueArrivee, NumRueArrivee, CommentaireTrajetConducteur, PlaceDispo, DateDepart, Matricule, NumPermis) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13)";
    $result = pg_query_params($connexion, $insertQuery, array($ville_depart, $code_postal_depart, $nom_rue_depart, $num_rue_depart, $ville_arrivee, $code_postal_arrivee, $nom_rue_arrivee, $num_rue_arrivee, $commentaire, $place_dispo, $date_depart, $matricule, $num_permis));

    if ($result) {
        echo "Trajet proposé avec succès!";
        // Redirection vers la page de résultats avec les données insérées
        header("Location: resultat.php?ville_depart=$ville_depart&code_postal_depart=$code_postal_depart&nom_rue_depart=$nom_rue_depart&num_rue_depart=$num_rue_depart&ville_arrivee=$ville_arrivee&code_postal_arrivee=$code_postal_arrivee&nom_rue_arrivee=$nom_rue_arrivee&num_rue_arrivee=$num_rue_arrivee&place_dispo=$place_dispo&date_depart=$date_depart&commentaire=$commentaire&escale=$escale&matricule=$matricule&num_permis=$num_permis");
        exit();
    } else {
        echo "Erreur lors de la proposition du trajet: " . pg_last_error($connexion);
    }

    pg_close($connexion);
} else {
    echo "Aucune donnée reçue.";
}
?>
