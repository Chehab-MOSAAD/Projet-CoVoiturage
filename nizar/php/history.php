<?php
session_start();
require 'db.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour voir cette page.");
}

echo "<div class='container'>";

try {
    // Préparer la requête SQL
    $sql = "SELECT 
    Trajet.IdTrajet,
    Trajet.VilleDepart,
    Trajet.CodePostalDepart,
    Trajet.NomRueDepart,
    Trajet.NumRueDepart,
    Trajet.VilleArrivee,
    Trajet.CodePostalArrivee,
    Trajet.NomRueArrivee,
    Trajet.NumRueArrivee,
    Trajet.CommentaireTrajetConducteur,
    Trajet.PlaceDispo,
    Départ.JourDepart,
    Départ.JourArrivee,
    Départ.Semaine,
    Départ.HeureDepart,
    Départ.HeureArrivee,
    Reservation.Status,
    Utilisateur.Prenom AS ConducteurPrenom,
    Utilisateur.Nom AS ConducteurNom
    FROM 
        Reserver
    JOIN 
        Reservation ON Reserver.IdRes = Reservation.IdRes
    JOIN 
        Trajet ON Reservation.IdTrajet = Trajet.IdTrajet
    JOIN 
        Départ ON Trajet.IdTrajet = Départ.IdTrajet
    JOIN 
        Conducteur ON Trajet.NumPermis = Conducteur.NumPermis
    JOIN 
        Utilisateur ON Conducteur.IdUtilisateur = Utilisateur.IdUtilisateur
    WHERE 
        Reserver.IdUtilisateur = $1
    ORDER BY 
        Reservation.Status, Départ.JourDepart DESC, Départ.HeureDepart DESC";

    // Définir l'ID utilisateur à partir de la session
    $idUtilisateur = $_SESSION['user_id']; 

    // Exécuter la requête
    $result = pg_query_params($db, $sql, array($idUtilisateur));
    
    if (!$result) {
        throw new Exception("Erreur lors de l'exécution de la requête : " . pg_last_error($db));
    }
    
    // Récupérer tous les résultats
    $trajets = pg_fetch_all($result);

    $confirmedTrajets = [];
    $otherTrajets = [];

    // Séparer les trajets par statut
    if ($trajets) {
        foreach ($trajets as $trajet) {
            if ($trajet['status'] == 'Confirmed') {
                $confirmedTrajets[] = $trajet;
            } else {
                $otherTrajets[] = $trajet;
            }
        }
    }

    echo "<h2>Trajets Confirmés</h2>";
    if (!empty($confirmedTrajets)) {
        // Boucle à travers les résultats et les afficher sous forme de cartes
        foreach ($confirmedTrajets as $trajet) {
            echo "<div class='card'>";
            echo "<p><strong>Ville de Départ:</strong> " . htmlspecialchars($trajet['villedepart']) . "</p>";
            echo "<p><strong>Adresse de Départ:</strong> " . htmlspecialchars($trajet['numruedepart']) . " " . htmlspecialchars($trajet['nomruedepart']) . ", " . htmlspecialchars($trajet['codepostaldepart']) . "</p>";
            echo "<p><strong>Ville d'Arrivée:</strong> " . htmlspecialchars($trajet['villearrivee']) . "</p>";
            echo "<p><strong>Adresse d'Arrivée:</strong> " . htmlspecialchars($trajet['numruearrivee']) . " " . htmlspecialchars($trajet['nomruearrivee']) . ", " . htmlspecialchars($trajet['codepostalarrivee']) . "</p>";
            echo "<p><strong>Jour de Départ:</strong> " . htmlspecialchars($trajet['jourdepart']) . "</p>";
            echo "<p><strong>Jour d'Arrivée:</strong> " . htmlspecialchars($trajet['jourarrivee']) . "</p>";
            echo "<p><strong>Semaine:</strong> " . htmlspecialchars($trajet['semaine']) . "</p>";
            echo "<p><strong>Heure de Départ:</strong> " . htmlspecialchars($trajet['heuredepart']) . "</p>";
            echo "<p><strong>Heure d'Arrivée:</strong> " . htmlspecialchars($trajet['heurearrivee']) . "</p>";
            echo "<p><strong>Commentaire:</strong> " . htmlspecialchars($trajet['commentairetrajetconducteur']) . "</p>";
            echo "<p><strong>Places Disponibles:</strong> " . htmlspecialchars($trajet['placedispo']) . "</p>";
            echo "<p><strong>Prénom du Conducteur:</strong> " . htmlspecialchars($trajet['conducteurprenom']) . "</p>";
            echo "<p><strong>Nom du Conducteur:</strong> " . htmlspecialchars($trajet['conducteurnom']) . "</p>";
            echo "<button onclick=\"annulerTrajet(" . htmlspecialchars($trajet['idtrajet']) . ")\">Annuler</button>";
            echo "</div>";
        }
    } else {
        echo "Aucun trajet confirmé trouvé.";
    }

    echo "<h2>Historique Trajets</h2>";
    if (!empty($otherTrajets)) {
        foreach ($otherTrajets as $trajet) {
            echo "<div class='card'>";
            echo "<p><strong>Ville de Départ:</strong> " . htmlspecialchars($trajet['villedepart']) . "</p>";
            echo "<p><strong>Adresse de Départ:</strong> " . htmlspecialchars($trajet['numruedepart']) . " " . htmlspecialchars($trajet['nomruedepart']) . ", " . htmlspecialchars($trajet['codepostaldepart']) . "</p>";
            echo "<p><strong>Ville d'Arrivée:</strong> " . htmlspecialchars($trajet['villearrivee']) . "</p>";
            echo "<p><strong>Adresse d'Arrivée:</strong> " . htmlspecialchars($trajet['numruearrivee']) . " " . htmlspecialchars($trajet['nomruearrivee']) . ", " . htmlspecialchars($trajet['codepostalarrivee']) . "</p>";
            echo "<p><strong>Jour de Départ:</strong> " . htmlspecialchars($trajet['jourdepart']) . "</p>";
            echo "<p><strong>Jour d'Arrivée:</strong> " . htmlspecialchars($trajet['jourarrivee']) . "</p>";
            echo "<p><strong>Semaine:</strong> " . htmlspecialchars($trajet['semaine']) . "</p>";
            echo "<p><strong>Heure de Départ:</strong> " . htmlspecialchars($trajet['heuredepart']) . "</p>";
            echo "<p><strong>Heure d'Arrivée:</strong> " . htmlspecialchars($trajet['heurearrivee']) . "</p>";
            echo "<p><strong>Commentaire:</strong> " . htmlspecialchars($trajet['commentairetrajetconducteur']) . "</p>";
            echo "<p><strong>Places Disponibles:</strong> " . htmlspecialchars($trajet['placedispo']) . "</p>";
            echo "<p><strong>Prénom du Conducteur:</strong> " . htmlspecialchars($trajet['conducteurprenom']) . "</p>";
            echo "<p><strong>Nom du Conducteur:</strong> " . htmlspecialchars($trajet['conducteurnom']) . "</p>";
            echo "<button onclick=\"commenterTrajet(" . htmlspecialchars($trajet['idtrajet']) . ")\">Commenter</button>";
            echo "</div>";
        }
    } else {
        echo "Aucun autre trajet trouvé.";
    }

} catch (Exception $e) {
    echo "Erreur de base de données: " . $e->getMessage();
}

echo "</div>";

// Inclut le formulaire de connexion
include "../style/historique_form.php";

?>

<script>
    function annulerTrajet(idTrajet) {
        if (confirm('Êtes-vous sûr de vouloir annuler ce trajet ?')) {
            window.location.href = 'annuler_trajet.php?idTrajet=' + idTrajet;
        }
    }

    function commenterTrajet(idTrajet) {
        window.location.href = 'commenter_trajet.php?idTrajet=' + idTrajet;
    }
</script>
