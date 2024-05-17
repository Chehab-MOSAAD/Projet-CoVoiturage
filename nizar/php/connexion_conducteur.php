<?php
// connexion_conducteur.php: Manages driver login based on driver's license number and vehicle registration number

// Start a new session or resume the existing one
session_start();

// Include the database connection file
require_once 'db.php';

// Initialize error message
$message = '';

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve driver's license number and vehicle registration number from the form
    $numPermis = filter_var($_POST['numPermis'], FILTER_SANITIZE_STRING);
    $matricule = filter_var($_POST['matricule'], FILTER_SANITIZE_STRING);

    // Prepare a query to fetch all relevant information for the driver and vehicle
    $sql = 'SELECT c.NumPermis, c.Points, c.NoteConducteur, v.Matricule, v.Marque, v.Modele, v.Type, v.Couleur
            FROM Conducteur AS c
            JOIN Voiture AS v ON c.NumPermis = v.NumPermis
            WHERE c.NumPermis = $1 AND v.Matricule = $2';
    $result = pg_query_params($db, $sql, array($numPermis, $matricule));

    // Check if the combination of driver and vehicle was found
    if ($result && pg_num_rows($result) > 0) {
        // Fetch the data
        $driverInfo = pg_fetch_assoc($result);

        // Store driver information in session variables
        $_SESSION['driver_info'] = $driverInfo;
        header("Location: success.php"); // Redirect to the success page
        exit;
    } else {
        // Set an error message if no match found
        $message = "Aucune correspondance trouvée pour ce numéro de permis et matricule.";
    }
}

// Include the login form
include "../style/connexion_conducteur_form.php";
?>
