<?php
// success.php

session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Conducteur</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            width: 100%;
            max-width: 500px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        .success {
            color: #28a745; /* Green for success messages */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .no-data {
            text-align: center;
            color: #dc3545; /* Red for error or no data messages */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['driver_info'])): 
            $info = $_SESSION['driver_info'];
            echo "<h1>Informations du Conducteur</h1>";
            echo "<p class='success'>Conducteur connecté avec succès!</p>";
            echo "<p>Numéro de permis: " . htmlspecialchars($info['numpermis']) . "</p>";
            echo "<p>Points: " . htmlspecialchars($info['points']) . "</p>";
            echo "<p>Note du conducteur: " . htmlspecialchars($info['noteconducteur']) . "</p>";
            echo "<p>Matricule de la voiture: " . htmlspecialchars($info['matricule']) . "</p>";
            echo "<p>Marque: " . htmlspecialchars($info['marque']) . "</p>";
            echo "<p>Modèle: " . htmlspecialchars($info['modele']) . "</p>";
            echo "<p>Type: " . htmlspecialchars($info['type']) . "</p>";
            echo "<p>Couleur: " . htmlspecialchars($info['couleur']) . "</p>";
            unset($_SESSION['driver_info']); // Clear the information after displaying it
        else:
            echo "<p class='no-data'>Aucun conducteur n'est connecté.</p>";
            header("Refresh: 5; url=connexion_conducteur.php"); // Redirect after 5 seconds if not connected
        endif; ?>
    </div>
</body>
</html>
