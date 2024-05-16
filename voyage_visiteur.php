<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du trajet</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Ajoutez ces styles dans votre fichier style.css ou dans une balise <style> dans le <head> de votre document HTML */

/* Style pour les boutons */
.btn {
    margin-right: 10px;
}

/* Style pour la section voiture, conducteur et trajet */
.row {
    margin-top: 20px;
}

.car-info, .trip-info, .driver-info {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}

.car-info h2, .trip-info h2, .driver-info h2 {
    margin-top: 0;
    margin-bottom: 10px;
}

.car-info p, .trip-info p, .driver-info p {
    margin-bottom: 5px;
}

    </style>
</head>
<body>
    <?php
    // Include or create a database connection script
    include 'db_connection.php';

    // Replace with the actual ID of the trip you want to display
//    $IdTrajet = 801; // This would typically come from a request parameter ($_GET or $_POST)
// Vérifier si l'ID du trajet a été envoyé via la méthode GET
if(isset($_GET['tripId'])) {
    // Récupérer l'ID du trajet à partir de la requête GET
    $IdTrajet = $_GET['tripId'];

    try {
        // Start a transaction to ensure data consistency
        $db_connection->beginTransaction();

        // Fetch the trip details
        $tripQuery = $db_connection->prepare("
            SELECT t.IdTrajet, t.VilleDepart, t.CodePostalDepart, t.NomRueDepart, t.NumRueDepart, 
            t.VilleArrivee, t.CodePostalArrivee, t.NomRueArrivee, t.NumRueArrivee, 
            t.CommentaireTrajetConducteur, t.PlaceDispo, v.Marque, v.Modele, 
            v.Couleur, v.NbrPlace, c.NumPermis, c.NoteConducteur
            FROM Trajet t 
            INNER JOIN Conducteur c ON t.NumPermis = c.NumPermis 
            INNER JOIN Voiture v ON t.Matricule = v.Matricule 
            WHERE t.IdTrajet = :IdTrajet
        ");
        $tripQuery->execute(['IdTrajet' => $IdTrajet]);
        $Trajet = $tripQuery->fetch(PDO::FETCH_ASSOC);
        // If no trip was found, you can handle this however you prefer
        if (!$Trajet) {
            throw new Exception("No trip found with the ID: $IdTrajet");
        }

        // Commit the transaction
        $db_connection->commit();

    } catch (PDOException $e) {
        // If there's a database error, rollback the transaction
        $db_connection->rollBack();
        die("Database error: " . $e->getMessage());
    } catch (Exception $e) {
        // Handle any other exceptions
        die("Error: " . $e->getMessage());
    }}
    ?>

    <div class="container mt-4">
        <!-- Notification Bar -->
        <div class="row">
            <div class="col text-center">
<p>Attention : Votre réservation sera confirmée lorsque le conducteur acceptera votre demande !</p>
            </div>
        </div>
        <body>
    <div class="container mt-4">
        <!-- Voiture, Conducteur et Trajet en trois colonnes -->
        <div class="row">
       <!-- Voiture Section -->

    <div class="col-md-4">
        <div class="car-info">
            <h2>Voiture:</h2>
            <p><strong>Marque:</strong> <?php echo htmlspecialchars($Trajet['marque']); ?></p>
            <p><strong>Modèle:</strong> <?php echo htmlspecialchars($Trajet['modele']); ?></p>
            <p><strong>Couleur:</strong> <?php echo htmlspecialchars($Trajet['couleur']); ?></p>
            <p><strong>Nombre de Places:</strong> <?php echo htmlspecialchars($Trajet['nbrplace']); ?></p>
            </div>
         </div>

    <!-- Trajet Section -->
    <div class="col-md-4">
        <div class="trip-info">
            <h2>Trajet:</h2>
            <p><strong>Départ:</strong> <?php echo htmlspecialchars($Trajet['nomruedepart'] . ' ' . $Trajet['numruedepart'] . ', ' . $Trajet['codepostaldepart'] . ' ' . $Trajet['villedepart']); ?></p>
            <p><strong>Arrivée:</strong> <?php echo htmlspecialchars($Trajet['nomruearrivee'] . ' ' . $Trajet['numruearrivee'] . ', ' . $Trajet['codepostalarrivee'] . ' ' . $Trajet['villearrivee']); ?></p>
            <p><strong>Commentaire:</strong> <?php echo htmlspecialchars($Trajet['commentairetrajetconducteur']); ?></p>
            <p><strong>Places Disponibles:</strong> <?php echo htmlspecialchars($Trajet['placedispo']); ?></p>
        </div>
    </div>

    <!-- Conducteur Section -->
    <div class="col-md-4">
        <div class="driver-info">
            <h2>Conducteur:</h2>
            <p><strong>Numéro de Permis:</strong> <?php echo htmlspecialchars($Trajet['numpermis']); ?></p>
            <p><strong>Note:</strong> <?php echo htmlspecialchars($Trajet['noteconducteur']); ?></p>
            <!-- Add more driver details here -->
        </div>
    </div>
    <div class="col-md-4">
       <a href="/nizar/login.php" class="btn btn-primary">Réserver ce voyage</a>
    </div>
    <div class="col-md-4">
       
    </div>
    <div class="col-md-4">
       <a href="/linda/messagerie.php" class="btn btn-primary">Contacter Le conducteur</a>
    </div>
</div>
</div>
    </div>
    
    <script>
        function contactDriver(driverPermisNumber) {
            // Implement the logic to contact the driver
            alert("Contacting driver with permit number: " + driverPermisNumber);
        }

        function requestReservation(tripId) {
            // Implement the logic for a reservation request
            alert("Requesting reservation for trip ID: " + tripId);
        }
    </script>
    <!-- Include Bootstrap JS and its dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
</body>
</html>
