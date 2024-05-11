<?php
// Include the database connection file
include 'db.php';

echo "<div class='container'>";

try {
    // Prepare the SQL query
    $stmt = $db->prepare("SELECT 
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
    Utilisateur.IdUtilisateur = :idUtilisateur
ORDER BY 
    Reservation.Status, Départ.JourDepart DESC, Départ.HeureDepart DESC");




    // Bind the user ID parameter
    $idUtilisateur = 7; // Example user ID
    $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();
    
    // Fetch all the results
    $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $confirmedTrajets = [];
    $otherTrajets = [];

    // Separate the trajets by status
    foreach ($trajets as $trajet) {
        if ($trajet['status'] == 'Confirmed') {
            $confirmedTrajets[] = $trajet;
        } else {
            $otherTrajets[] = $trajet;
        }
    }

    

    echo "<h2>Trajets Confirmés</h2>";
    if (!empty($confirmedTrajets)) {
        // Loop through the results and print them as cards
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
            echo "<button onclick=\"annulerTrajet(" . $trajet['idtrajet'] . ")\">Annuler</button>";

            echo "</div>";
        }
    } else {
        echo "Aucun trajet trouvé.";
    }

    echo "<h2>Historique Trajet</h2>";
    if (!empty($otherTrajets)) {
        foreach ($otherTrajets as $trajet) {
            echo "<div class='card';>";
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
            echo "<button onclick=\"commenterTrajet(" . $trajet['idtrajet'] . ")\">Commenter</button>";

            echo "</div>";
        }
    } else {
        echo "<p>Aucun autre trajet trouvé.</p>";
    }

} catch (PDOException $e) {
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