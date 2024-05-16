<?php
include 'db_connection.php';
$pdo = new PDO('pgsql:host=localhost;dbname=postgres', 'postgres', '0000');

// Vérifier si l'ID du trajet a été envoyé via la méthode GET
if(isset($_GET['tripId'])) {
    // Récupérer l'ID du trajet à partir de la requête GET
    $IdTrajet = $_GET['tripId'];

        // Start a transaction to ensure data consistency
        $pdo->beginTransaction();

        // Fetch the trip details
        $tripQuery = $pdo->prepare("
        SELECT t.IdTrajet, t.VilleDepart, t.CodePostalDepart, t.NomRueDepart, t.NumRueDepart, 
        t.VilleArrivee, t.CodePostalArrivee, t.NomRueArrivee, t.NumRueArrivee, 
        t.CommentaireTrajetConducteur, t.PlaceDispo, v.Marque, v.Modele, 
        v.Couleur, v.NbrPlace,v.type,v.carburant, c.NumPermis, c.NoteConducteur,
        u.Nom, u.Prenom, u.Sexe, u.Tel, u.Handicap, u.LangueParle1, u.LangueParle2, u.Fumeur, u.Jour, u.Mois, u.Annee,
        d.HeureDepart , d.HeureArrivee
        FROM Trajet t 
        INNER JOIN Conducteur c ON t.NumPermis = c.NumPermis 
        INNER JOIN Voiture v ON t.Matricule = v.Matricule 
        INNER JOIN Utilisateur u ON c.IdUtilisateur=u.IdUtilisateur
        INNER JOIN Départ d on d.IdTrajet=t.IdTrajet
        WHERE t.IdTrajet = :IdTrajet
            
        ");
        $tripQuery->execute(['IdTrajet' => $IdTrajet]);
        $Trajet = $tripQuery->fetch(PDO::FETCH_ASSOC);
        // If no trip was found, you can handle this however you prefer
        if (!$Trajet) {
            throw new Exception("No trip found with the ID: $IdTrajet");
        }
        // Requête SQL pour récupérer les escales du trajet
    $stmt = $pdo->prepare("SELECT E.Lieu, E.NomRue, E.NumRue, E.CodePostal, E.Accessibilite
    FROM Escale E
    INNER JOIN Contient C ON E.IdEscale = C.IdEscale
    WHERE C.IdTrajet = :IdTrajet");
$stmt->bindParam(':IdTrajet', $IdTrajet);
$stmt->execute();
$escales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

?>
