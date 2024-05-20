<?php
// mettre_a_jours_conducteur.php: Handles updating the driver's information

// Start the session to manage user authentication and other session data
session_start();

// Include the database connection file
require 'db.php'; // Ensure your database connection parameters are correct in this file

// Check if the user is logged in
if (!isset($_SESSION['driver_info'])) {
    die("Vous devez être connecté pour voir cette page.");
}

// Initialize the message
$message = '';

// Retrieve driver information from the session
$driverInfo = $_SESSION['driver_info'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mettre_a_jours'])) {
    // Retrieve and sanitize data from the POST request
    $numPermis = filter_var($_POST['numPermis'], FILTER_SANITIZE_STRING);
    $points = (int)$_POST['points'];
    $noteConducteur = (float)$_POST['noteConducteur'];
    $matricule = filter_var($_POST['matricule'], FILTER_SANITIZE_STRING);
    $marque = filter_var($_POST['marque'], FILTER_SANITIZE_STRING);
    $modele = filter_var($_POST['modele'], FILTER_SANITIZE_STRING);
    $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
    $couleur = filter_var($_POST['couleur'], FILTER_SANITIZE_STRING);

    // Validate the data and prepare queries
    if (strlen($numPermis) == 0 || !preg_match('/^[A-Za-z0-9]+$/', $numPermis)) {
        $message = "Numéro de permis invalide.";
    } elseif ($points < 0 || $points > 15) {
        $message = "Points invalides.";
    } elseif ($noteConducteur < 0 || $noteConducteur > 5) {
        $message = "Note du conducteur invalide.";
    } elseif (strlen($matricule) == 0 || !preg_match('/^[A-Za-z0-9]+$/', $matricule)) {
        $message = "Matricule invalide.";
    } elseif (!preg_match('/^[A-Za-z0-9 ]+$/', $marque)) {
        $message = "Marque invalide.";
    } elseif (!preg_match('/^[A-Za-z0-9 ]+$/', $modele)) {
        $message = "Modèle invalide.";
    } elseif (!in_array($type, ['SUV', 'Berline', 'Compacte', 'Monospace'])) {
        $message = "Type de véhicule invalide.";
    } elseif (!in_array($couleur, ['bleu', 'violet', 'rose', 'rouge', 'orange', 'jaune', 'vert', 'noir', 'marron', 'gris', 'aluminium', 'argent', 'blanc'])) {
        $message = "Couleur de véhicule invalide.";
    } else {
        // Prepare update queries
        $queries = [];
        $params = [];

        if ($numPermis !== $driverInfo['numpermis']) {
            $queries[] = "UPDATE Conducteur SET NumPermis = $1 WHERE IdUtilisateur = $2";
            $params[] = [$numPermis, $driverInfo['idutilisateur']];
        }
        if ($points !== $driverInfo['points']) {
            $queries[] = "UPDATE Conducteur SET Points = $1 WHERE IdUtilisateur = $2";
            $params[] = [$points, $driverInfo['idutilisateur']];
        }
        if ($noteConducteur !== $driverInfo['noteconducteur']) {
            $queries[] = "UPDATE Conducteur SET NoteConducteur = $1 WHERE IdUtilisateur = $2";
            $params[] = [$noteConducteur, $driverInfo['idutilisateur']];
        }
        if ($matricule !== $driverInfo['matricule']) {
            $queries[] = "UPDATE Voiture SET Matricule = $1 WHERE NumPermis = $2";
            $params[] = [$matricule, $numPermis];
        }
        if ($marque !== $driverInfo['marque']) {
            $queries[] = "UPDATE Voiture SET Marque = $1 WHERE Num Permis = $2";
            $params[] = [$marque, $numPermis];
        }
        if ($modele !== $driverInfo['modele']) {
            $queries[] = "UPDATE Voiture SET Modele = $1 WHERE NumPermis = $2";
            $params[] = [$modele, $numPermis];
        }
        if ($type !== $driverInfo['type']) {
            $queries[] = "UPDATE Voiture SET Type = $1 WHERE NumPermis = $2";
            $params[] = [$type, $numPermis];
        }
        if ($couleur !== $driverInfo['couleur']) {
            $queries[] = "UPDATE Voiture SET Couleur = $1 WHERE NumPermis = $2";
            $params[] = [$couleur, $numPermis];
        }

        // Execute the queries
        foreach ($queries as $index => $query) {
            $result = pg_query_params($db, $query, $params[$index]);
            if (!$result) {
                $message = "Erreur lors de la mise à jour des informations: " . pg_last_error($db);
                break;
            }
        }

        // Update the session data if all queries were successful
        if (empty($message)) {
            // Update session data
            $_SESSION['driver_info'] = array_merge($driverInfo, [
                'numpermis' => $numPermis,
                'points' => $points,
                'noteconducteur' => $noteConducteur,
                'matricule' => $matricule,
                'marque' => $marque,
                'modele' => $modele,
                'type' => $type,
                'couleur' => $couleur
            ]);

            // Redirect to success.php
            header("Location: success.php");
            exit;
        }
    }
}

// Inclure le formulaire de mise à jour
include "../style/mettre_a_jours_conducteur_form.php";
?>
