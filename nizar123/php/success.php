<?php
// success.php: Displays the driver's information

// Start the session
session_start();

// Check if driver information is available in the session
if (!isset($_SESSION['driver_info'])) {
    header("Location: connexion_conducteur.php");
    exit;
}

// Retrieve driver information from the session
$driverInfo = $_SESSION['driver_info'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations du Conducteur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .update-button {
            background-color: #4CAF50;
            color: white;
        }
        .logout-button {
            background-color: #f44336;
            color: white;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Informations du Conducteur et de sa Voiture</h2>
    <table>
        <tr>
            <th>Numéro de Permis</th>
            <td><?php echo htmlspecialchars($driverInfo['numpermis']); ?></td>
        </tr>
        <tr>
            <th>Points</th>
            <td><?php echo htmlspecialchars($driverInfo['points']); ?></td>
        </tr>
        <tr>
            <th>Note du Conducteur</th>
            <td><?php echo htmlspecialchars($driverInfo['noteconducteur']); ?></td>
        </tr>
        <tr>
            <th>Matricule</th>
            <td><?php echo htmlspecialchars($driverInfo['matricule']); ?></td>
        </tr>
        <tr>
            <th>Marque</th>
            <td><?php echo htmlspecialchars($driverInfo['marque']); ?></td>
        </tr>
        <tr>
            <th>Modèle</th>
            <td><?php echo htmlspecialchars($driverInfo['modele']); ?></td>
        </tr>
        <tr>
            <th>Type</th>
            <td><?php echo htmlspecialchars($driverInfo['type']); ?></td>
        </tr>
        <tr>
            <th>Couleur</th>
            <td><?php echo htmlspecialchars($driverInfo['couleur']); ?></td>
        </tr>
    </table>
    <form action="mettre_a_jours_conducteur.php" method="post">
        <button type="submit" class="update-button">Mettre à jour</button>
    </form>
    <form action="deconnexion.php" method="post">
        <button type="submit" class="logout-button">Se déconnecter</button>
    </form>
</div>

</body>
</html>
