<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du trajet</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .row {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
    }

    .col-md-4 {
        display: flex;
        flex-direction: column;
        flex: 0 0 33.333333%; /* Change based on your layout */
        max-width: 33.333333%; /* Change based on your layout */
        padding: 0 15px;
    }

    .info-section {
        background-color: #f8f9fa;
        border: 8px solid #6B8E23;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1; /* Ensures that the card stretches to fill the container */
    }

    .info-section h2 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .info-section p {
        margin-bottom: 5px;
        flex-grow: 1; /* Allows the paragraph to fill the space and push buttons down */
    }

    .card {
    display: flex;
    flex-direction: column; /* Organise le contenu de la carte en colonne */
}

.btn-container {
    width: 100%; /* Assure que le conteneur du bouton s'étend sur toute la largeur */
    order: -1; /* Place le conteneur du bouton en haut de la carte */
}

.btn, .btn-primary {
    width: 100%; /* Assure que le bouton s'étend sur toute la largeur de la carte */
    margin-top: 10px; /* Ajoute de l'espace au-dessus du bouton */
    background-color: #6B8E23; /* Définit la couleur du bouton */
    margin-bottom: 10px; /* Ajoute de l'espace en dessous du bouton */
}


</style>

</head>
<body>
<?php
    include 'reservation_visiteur.php';

    ?>
<div class="container mt-4">
        <!-- Notification Bar -->
        <div class="row">
            <div class="col text-center">
              <p><strong>Attention : Votre réservation sera confirmée lorsque le conducteur acceptera votre demande !</strong></p>
            </div>
        </div>
    <div class="container mt-4">
        <!-- Voiture, Conducteur et Trajet en trois colonnes -->
        <div class="row">
       <!-- Voiture Section -->

    <div class="col-md-4">
        <div class="info-section car-info">
            <h2>Voiture:</h2>
            <p><strong>Marque:</strong> <?php echo htmlspecialchars($Trajet['marque']); ?></p>
            <p><strong>Modèle:</strong> <?php echo htmlspecialchars($Trajet['modele']); ?></p>
            <p><strong>Couleur:</strong> <?php echo htmlspecialchars($Trajet['couleur']); ?></p>
            <p><strong>Nombre de Places:</strong> <?php echo htmlspecialchars($Trajet['nbrplace']); ?></p>
            <p><strong>Type de la voiture:</strong> <?php echo htmlspecialchars($Trajet['type']); ?></p>
            <p><strong>Le carburant:</strong> <?php echo htmlspecialchars($Trajet['carburant']); ?></p>
        </div>
    </div>   
    <!-- Trajet Section -->
    <div class="col-md-4">
        <div class="info-section ">
            <h2>Trajet:</h2>
            <p><strong>Départ:</strong> <?php echo htmlspecialchars($Trajet['nomruedepart'] . ' ' . $Trajet['numruedepart'] . ', ' . $Trajet['codepostaldepart'] . ' ' . $Trajet['villedepart']); ?></p>
            <p><strong>Arrivée:</strong> <?php echo htmlspecialchars($Trajet['nomruearrivee'] . ' ' . $Trajet['numruearrivee'] . ', ' . $Trajet['codepostalarrivee'] . ' ' . $Trajet['villearrivee']); ?></p>
            <p><strong>Commentaire:</strong> <?php echo htmlspecialchars($Trajet['commentairetrajetconducteur']); ?></p>
            <p><strong>Places Disponibles:</strong> <?php echo htmlspecialchars($Trajet['placedispo']); ?></p>
            <p><strong>Heure De Départ :</strong> <?php echo htmlspecialchars($Trajet['heuredepart']); ?></p>
            <p><strong>Heure D'arrivée:</strong> <?php echo htmlspecialchars($Trajet['heurearrivee']); ?></p>
        </div>
    
      
    </div>

    <!-- Conducteur Section -->
    <div class="col-md-4">
        <div class="info-section driver-info">
            <h2>Conducteur:</h2>
            <p><strong>Nom:</strong> <?php echo htmlspecialchars($Trajet['nom']); ?></p>
            <p><strong>Prénom:</strong> <?php echo htmlspecialchars($Trajet['prenom']); ?></p>
            <p><strong>Date de naissance:</strong> <?php echo htmlspecialchars($Trajet['jour']) . "/" . htmlspecialchars($Trajet['mois']) . "/" . htmlspecialchars($Trajet['annee']); ?></p>
            <p><strong>Sexe:</strong> <?php echo htmlspecialchars($Trajet['sexe']); ?></p>
            <p><strong>Handicap:</strong> <?php echo $Trajet['handicap'] ? 'Oui' : 'Non'; ?></p>
            <p><strong>Langue Parlée:</strong> <?php echo htmlspecialchars($Trajet['langueparle1']); ?></p>
            <p><strong>Langue parlée:</strong> <?php echo htmlspecialchars($Trajet['langueparle2']); ?></p>
            <p><strong>Fumeur:</strong> <?php echo $Trajet['fumeur'] ? 'Oui' : 'Non'; ?></p>
            <p><strong>Note:</strong> <?php echo htmlspecialchars($Trajet['noteconducteur']); ?></p>
            <!-- Add more driver details here -->
        </div>
    </div>
    
    <div class="col-md-4">

    <div class="escale-info">
     <!-- Section Escales -->
            <div class="info-section escales-info">
                <h2>Escales:</h2>   
                <?php
       if (!empty($escales)) {
        foreach ($escales as $escale) {
            ?>
            <p><strong>Lieu:</strong> <?php echo htmlspecialchars($escale['lieu']); ?></p>
            <p><strong>Nom de la Rue:</strong> <?php echo htmlspecialchars($escale['nomrue']); ?></p>
            <p><strong>Numéro de Rue:</strong> <?php echo htmlspecialchars($escale['numrue']); ?></p>
            <p><strong>Code Postal:</strong> <?php echo htmlspecialchars($escale['codepostal']); ?></p>
            <p><strong>Accessibilité:</strong> <?php echo $escale['accessibilite'] ? 'Oui' : 'Non'; ?></p>
            <?php
        }
       } else {
        echo "<p>Aucune escale pour ce trajet.</p>";
       }
        ?>            
    </div>
    </div>
    </div>
    <div class="col-md-4">
           <!-- Bouton Réserver -->             
             <form  class="btn-container">
                   <a href="nizar/login.php" type="submit" name="submit" class="btn btn-primary">Réserver ce voyage</a>
             </form>   
    </div>
    <div class="col-md-4">
        <!-- bouton pour envoyer un message à ce conducteur-->
         <form a method="post" class="btn-container">
                <a href="nizar/login.ph" type="submit" name="submit"  class="btn btn-primary">Contacter Le conducteur</a>
              </form>
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



