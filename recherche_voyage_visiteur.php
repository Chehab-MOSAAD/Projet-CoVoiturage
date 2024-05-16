<?php
session_start();
include 'db_connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data from the form
    $VilleDepart = clean_input($_POST['VilleDepart']);
    $VilleArrivee = clean_input($_POST['VilleArrivee']);
    $departureDate = clean_input($_POST['departureDate']);
    $PlaceDispo = clean_input($_POST['PlaceDispo']);
    
    // Connect to the database
    $pdo = new PDO('pgsql:host=localhost;dbname=postgres', 'postgres', '0000');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM trajet WHERE VilleDepart = :VilleDepart AND VilleArrivee = :VilleArrivee AND  PlaceDispo>= :PlaceDispo");

    // Bind parameters
    $stmt->bindParam(':VilleDepart', $VilleDepart);
    $stmt->bindParam(':VilleArrivee', $VilleArrivee);
    //$stmt->bindParam(':departureDate', $departureDate);
    $stmt->bindParam(':PlaceDispo', $PlaceDispo);

    // Execute the query
    $stmt->execute();

    // Fetch the results
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any results are returned
    if (empty($searchResults)) {
        echo "<p>Aucun trajet à cette date.</p>";
    } else {
        // Store the search results in the session
        $_SESSION['searchResults'] = $searchResults;
    }
}// Function to sanitize input data
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Recherche de trajets</title>
     <!-- CSS FILES -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700;900&display=swap" rel="stylesheet">
     <!-- CSS principale -->
    <!-- <link href="style.css" rel="stylesheet">-->
     <link href="style.css" rel="stylesheet">
     <style>
        /* Ajoutez ces styles dans votre fichier style.css */
.filter-section {
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.checkbox-group {
    margin-bottom: 10px;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 5px;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}
/* Styles pour la section de recherche */
.filter-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.filter-container form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
}

.filter-container label {
    font-weight: bold;
}

.filter-container input[type="text"],
.filter-container input[type="date"],
.filter-container input[type="number"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.filter-container button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.filter-container button:hover {
    background-color: #0056b3;
}
/* Styles pour la section des résultats */
.trip-card {
    text-decoration: none;
    color: #333; /* Couleur du texte */
    background-color: #eaf7ea; /* Fond vert clair */
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 20px; /* Espacement entre les voyages */
    overflow: hidden; /* Pour empêcher le débordement des éléments enfants */
    transition: all 0.3s ease;
}

.trip-card:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.trip-details {
    padding: 20px;
}

.trip-details h2 {
    margin-bottom: 10px;
    font-size: 18px; /* Taille de la police pour le titre */
}

.trip-details p {
    margin-bottom: 5px;
    font-size: 16px; /* Taille de la police pour le texte */
}


     </style>
</head>
<body>

<div class="container">
    <!-- Header Section -->
    <header class="row mb-4">
        <div class="col">
            <!-- Your Logo here -->
        </div>
    </header>

    <!-- Search Section -->
    <section class="row mb-3">
    <div class="col">
        <div class="filter-container">
            <form method="POST" id="search-form">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="departureDate">Date de départ:</label>
                        <input type="date" id="departureDate" name="departureDate" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="VilleDepart">Ville de départ:</label>
                        <input type="text" id="VilleDepart" name="VilleDepart" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="VilleArrivee">Ville d'arrivée:</label>
                        <input type="text" id="VilleArrivee" name="VilleArrivee" class="form-control" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="PlaceDispo">Nombre de Passagers:</label>
                        <input type="number" id="PlaceDispo" name="PlaceDispo" class="form-control" required min="1">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

    <!-- Results Section -->
    <div class="row">
        <div class="col">
        <div id="trip-results">
            <?php
            // Check if there are any search results
            if (!empty($_SESSION['searchResults'])) {
                // Retrieve the results from the session
                $searchResults = $_SESSION['searchResults'];

                echo "<div class='trips-container'>"; // Container for all trips

                // Display the results
                foreach ($searchResults as $result) {
                    // URL where the client will be redirected when clicking on a trip
                    $detailPageUrl = "voyage.php?tripId=" . urlencode($result['idtrajet']);

                    echo "<a href='{$detailPageUrl}' class='trip-card'>";
                    echo "<div class='trip-details'>";

                    // Display trip details using lowercase keys
                    echo "<h2>Voyage de " . htmlspecialchars($result['villedepart']) . " à " . htmlspecialchars($result['villearrivee']) . "</h2>";
                    echo "<p><strong>Adresse de départ:</strong> " . htmlspecialchars($result['numruedepart']) . " " . htmlspecialchars($result['nomruedepart']) . ", " . htmlspecialchars($result['codepostaldepart']) . ", " . htmlspecialchars($result['villedepart']) . "</p>";
                    echo "<p><strong>Nombre de passagers disponibles:</strong> " . htmlspecialchars($result['placedispo']) . "</p>";

                    echo "</div>"; // Closing div for trip-details
                    echo "</a>"; // Closing tag for the link
                }

                echo "</div>"; // Closing div for trips-container

                // Clear the results from the session after displaying them
                unset($_SESSION['searchResults']);
            }
            ?>
        </div>
        </div>

        <aside class="col-md-3 mb-3">
            <div class="filter-section">
                <form id="filter-form">
                    <h3>Trier Par:</h3>
                    
                    <!-- Checkbox filters for sorting options -->
                    <div class="checkbox-group">
                        <label for="earliest-departure">
                            <input type="checkbox" id="earliest-departure" name="sort" value="earliest"> Départ le plus tôt
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <label for="shortest-trip">
                            <input type="checkbox" id="shortest-trip" name="sort" value="shortest"> Trajet le plus court
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <label for="direct-only">
                            <input type="checkbox" id="direct-only" name="sort" value="direct"> Trajets directs uniquement
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <label for="high-rating">
                            <input type="checkbox" id="high-rating" name="sort" value="high-rating"> Profil +4 étoiles
                        </label>
                    </div>
            
                    <h3>Heure de départ:</h3>
                    
                    <!-- Checkbox filters for departure times -->
                    <div class="checkbox-group">
                        <label for="before-6">
                            <input type="checkbox" id="before-6" name="departure-time" value="before-6"> Avant 06:00
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <label for="between-6-12">
                            <input type="checkbox" id="between-6-12" name="departure-time" value="6-12"> 06:00 - 12:00
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <label for="between-12-18">
                            <input type="checkbox" id="between-12-18" name="departure-time" value="12-18"> 12:01 - 18:00
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <label for="after-18">
                            <input type="checkbox" id="after-18" name="departure-time" value="after-18"> Après 18:00
                        </label>
                    </div>
            
                    <button type="submit">Appliquer les filtres</button>
                </form>
            </div>
            
        </aside>
    </div>
</body>
</html>
