<?php
session_start();
require 'db.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour voir cette page.");
}

$idTrajet = $_GET['idTrajet'] ?? null;

if (!$idTrajet) {
    die("ID de trajet non spécifié.");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentaire = $_POST['commentaire'] ?? '';
    $noteTrajet = $_POST['noteTrajet'] ?? null;
    $idUtilisateur = $_SESSION['user_id'];

    // Valider les entrées
    if (empty($commentaire) || empty($noteTrajet)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        try {
            // Insérer le commentaire dans la base de données
            $query = "INSERT INTO CommenterReservation (IdUtilisateur, IdRes, CommentairePassager, NoteTrajet)
                      VALUES ($1, (SELECT IdRes FROM Reservation WHERE IdTrajet = $2), $3, $4)";
            $result = pg_query_params($db, $query, array($idUtilisateur, $idTrajet, $commentaire, $noteTrajet));

            if ($result) {
                header("Location: history.php");
                exit;
            } else {
                $message = "Erreur lors de l'insertion du commentaire : " . pg_last_error($db);
            }
        } catch (Exception $e) {
            $message = "Erreur de base de données : " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commenter le Trajet</title>
</head>
<body>
    <h2>Commenter le Trajet</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="commentaire">Commentaire :</label><br>
        <textarea id="commentaire" name="commentaire" rows="4" cols="50"></textarea><br><br>
        <label for="noteTrajet">Note (0 à 5) :</label><br>
        <input type="number" id="noteTrajet" name="noteTrajet" min="0" max="5"><br><br>
        <button type="submit">Soumettre le commentaire</button>
    </form>
</body>
</html>
