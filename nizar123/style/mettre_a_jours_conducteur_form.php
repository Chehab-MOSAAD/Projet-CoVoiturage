<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour les informations du conducteur</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9f5f2;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #1c87c9;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        input, select, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input:focus, select:focus, button:focus {
            border-color: #1c87c9;
            outline: none;
            box-shadow: 0 0 5px rgba(28, 135, 201, 0.5);
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #333;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        }
        .back-button {
            background-color: #1c87c9;
            color: white;
        }
        .back-button:hover {
            background-color: #145a7d;
        }
    </style>
</head>
<body>

<header>
    <h1>Mettre à jour les informations du conducteur</h1>
</header>

<div class="container">
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="mettre_a_jours_conducteur.php">
        <input type="hidden" name="id_utilisateur" value="<?php echo htmlspecialchars($driverInfo['idutilisateur'] ?? ''); ?>">
        <label for="numPermis">Numéro de Permis:</label>
        <input type="text" id="numPermis" name="numPermis" value="<?php echo htmlspecialchars($driverInfo['numpermis'] ?? ''); ?>" required><br>
        <label for="points">Points:</label>
        <input type="number" id="points" name="points" value="<?php echo htmlspecialchars($driverInfo['points'] ?? ''); ?>" required><br>
        <label for="noteConducteur">Note du Conducteur:</label>
        <input type="number" step="0.1" id="noteConducteur" name="noteConducteur" value="<?php echo htmlspecialchars($driverInfo['noteconducteur'] ?? ''); ?>" required><br>
        <label for="matricule">Matricule:</label>
        <input type="text" id="matricule" name="matricule" value="<?php echo htmlspecialchars($driverInfo['matricule'] ?? ''); ?>" required><br>
        <label for="marque">Marque:</label>
        <input type="text" id="marque" name="marque" value="<?php echo htmlspecialchars($driverInfo['marque'] ?? ''); ?>" required><br>
        <label for="modele">Modèle:</label>
        <input type="text" id="modele" name="modele" value="<?php echo htmlspecialchars($driverInfo['modele'] ?? ''); ?>" required><br>
        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <option value="SUV" <?php if (($driverInfo['type'] ?? '') === 'SUV') echo 'selected'; ?>>SUV</option>
            <option value="Berline" <?php if (($driverInfo['type'] ?? '') === 'Berline') echo 'selected'; ?>>Berline</option>
            <option value="Compacte" <?php if (($driverInfo['type'] ?? '') === 'Compacte') echo 'selected'; ?>>Compacte</option>
            <option value="Monospace" <?php if (($driverInfo['type'] ?? '') === 'Monospace') echo 'selected'; ?>>Monospace</option>
        </select><br>
        <label for="couleur">Couleur:</label>
        <select id="couleur" name="couleur" required>
            <option value="bleu" <?php if (($driverInfo['couleur'] ?? '') === 'bleu') echo 'selected'; ?>>Bleu</option>
            <option value="violet" <?php if (($driverInfo['couleur'] ?? '') === 'violet') echo 'selected'; ?>>Violet</option>
            <option value="rose" <?php if (($driverInfo['couleur'] ?? '') === 'rose') echo 'selected'; ?>>Rose</option>
            <option value="rouge" <?php if (($driverInfo['couleur'] ?? '') === 'rouge') echo 'selected'; ?>>Rouge</option>
            <option value="orange" <?php if (($driverInfo['couleur'] ?? '') === 'orange') echo 'selected'; ?>>Orange</option>
            <option value="jaune" <?php if (($driverInfo['couleur'] ?? '') === 'jaune') echo 'selected'; ?>>Jaune</option>
            <option value="vert" <?php if (($driverInfo['couleur'] ?? '') === 'vert') echo 'selected'; ?>>Vert</option>
            <option value="noir" <?php if (($driverInfo['couleur'] ?? '') === 'noir') echo 'selected'; ?>>Noir</option>
            <option value="marron" <?php if (($driverInfo['couleur'] ?? '') === 'marron') echo 'selected'; ?>>Marron</option>
            <option value="gris" <?php if (($driverInfo['couleur'] ?? '') === 'gris') echo 'selected'; ?>>Gris</option>
            <option value="aluminium" <?php if (($driverInfo['couleur'] ?? '') === 'aluminium') echo 'selected'; ?>>Aluminium</option>
            <option value="argent" <?php if (($driverInfo['couleur'] ?? '') === 'argent') echo 'selected'; ?>>Argent</option>
            <option value="blanc" <?php if (($driverInfo['couleur'] ?? '') === 'blanc') echo 'selected'; ?>>Blanc</option>
        </select><br>
        <button type="submit" name="mettre_a_jours">Mettre à jour</button>
    </form>
    <form action="success.php" method="post">
        <button type="submit" class="back-button">Retour</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 Voituretech. Tous droits réservés.</p>
</footer>

</body>
</html>
