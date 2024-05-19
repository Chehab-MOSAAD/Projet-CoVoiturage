<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour des informations utilisateur</title>
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
        fieldset {
            border: none;
            margin: 15px 0;
        }
        legend {
            font-size: 18px;
            margin-bottom: 10px;
            color: #1c87c9;
        }
        .radio-group, .date-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .radio-group label, .date-group label {
            display: flex;
            align-items: center;
            font-weight: 500;
            margin-right: 10px;
        }
        .radio-group input, .date-group select {
            margin-right: 5px;
            accent-color: #4CAF50;
        }
        .date-group select {
            width: 32%;
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
    </style>
</head>
<body>

<header>
    <h1>Mise à jour des informations utilisateur</h1>
</header>

<div class="container">
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="mettre_a_jours.php">
        <input type="hidden" name="id_utilisateur" value="<?php echo htmlspecialchars($userData['idutilisateur'] ?? ''); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['mail'] ?? ''); ?>" required><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($userData['prenom'] ?? ''); ?>" required><br>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($userData['nom'] ?? ''); ?>" required><br>
        <label for="tel">Téléphone:</label>
        <input type="text" id="tel" name="tel" value="<?php echo htmlspecialchars($userData['tel'] ?? ''); ?>" required><br>
        <label for="langue1">Langue Parlée 1:</label>
        <input type="text" id="langue1" name="langue1" value="<?php echo htmlspecialchars($userData['langueparle1'] ?? ''); ?>" required><br>
        <label for="langue2">Langue Parlée 2:</label>
        <input type="text" id="langue2" name="langue2" value="<?php echo htmlspecialchars($userData['langueparle2'] ?? ''); ?>"><br>
        <label for="sexe">Sexe:</label>
        <select id="sexe" name="sexe">
            <option value="M" <?php if (($userData['sexe'] ?? '') === 'M') echo 'selected'; ?>>Masculin</option>
            <option value="F" <?php if (($userData['sexe'] ?? '') === 'F') echo 'selected'; ?>>Féminin</option>
        </select><br>
        <label for="handicap">Handicap:</label>
        <input type="checkbox" id="handicap" name="handicap" <?php if (($userData['handicap'] ?? 'f') == 't') echo 'checked'; ?>><br>
        <label for="fumeur">Fumeur:</label>
        <input type="checkbox" id="fumeur" name="fumeur" <?php if (($userData['fumeur'] ?? 'f') == 't') echo 'checked'; ?>><br>
        <label for="jour">Jour de Naissance:</label>
        <input type="number" id="jour" name="jour" value="<?php echo htmlspecialchars($userData['jour'] ?? ''); ?>" required><br>
        <label for="mois">Mois de Naissance:</label>
        <input type="number" id="mois" name="mois" value="<?php echo htmlspecialchars($userData['mois'] ?? ''); ?>" required><br>
        <label for="annee">Année de Naissance:</label>
        <input type="number" id="annee" name="annee" value="<?php echo htmlspecialchars($userData['annee'] ?? ''); ?>" required><br>
        <fieldset>
            <legend>Modifier le mot de passe (optionnel):</legend>
            <label for="password">Nouveau mot de passe:</label>
            <input type="password" id="password" name="password"><br>
            <label for="confirm_password">Confirmer le nouveau mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password"><br>
        </fieldset>
        <button type="submit" name="mettre_a_jours">Mettre à jour</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 Voituretech. Tous droits réservés.</p>
</footer>

</body>
</html>
