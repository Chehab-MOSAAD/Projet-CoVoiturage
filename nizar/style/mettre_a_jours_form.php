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

    <form method="POST" action="../php/mettre_a_jours.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>

        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>

        <label for="tel">Téléphone:</label>
        <input type="tel" id="tel" name="tel" placeholder="Entrez votre numéro de téléphone" required>

        <label for="langue1">Langue parlée 1:</label>
        <input type="text" id="langue1" name="langue1" placeholder="Langue principale" required>

        <label for="langue2">Langue parlée 2:</label>
        <input type="text" id="langue2" name="langue2" placeholder="Langue secondaire">

        <fieldset>
            <legend>Date de naissance:</legend>
            <div class="date-group">
                <select id="jour" name="jour">
                    <option value="" disabled selected>Jour</option>
                    <?php for ($i = 1; $i <= 31; $i++) {
                        echo "<option value='$i'>$i</option>";
                    } ?>
                </select>

                <select id="mois" name="mois">
                    <option value="" disabled selected>Mois</option>
                    <?php for ($i = 1; $i <= 12; $i++) {
                        echo "<option value='$i'>$i</option>";
                    } ?>
                </select>

                <select id="annee" name="annee">
                    <option value="" disabled selected>Année</option>
                    <?php for ($i = 1900; $i <= date("Y"); $i++) {
                        echo "<option value='$i'>$i</option>";
                    } ?>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend>Genre:</legend>
            <div class="radio-group">
                <label><input type="radio" name="sexe" value="M" checked> Homme</label>
                <label><input type="radio" name="sexe" value="F"> Femme</label>
            </div>
        </fieldset>

        <fieldset>
            <legend>Handicap:</legend>
            <div class="radio-group">
                <label><input type="radio" name="handicap" value="1"> Oui</label>
                <label><input type="radio" name="handicap" value="0" checked> Non</label>
            </div>
        </fieldset>

        <fieldset>
            <legend>Fumeur:</legend>
            <div class="radio-group">
                <label><input type="radio" name="fumeur" value="1"> Oui</label>
                <label><input type="radio" name="fumeur" value="0" checked> Non</label>
            </div>
        </fieldset>

        <button type="submit" name="mettre_a_jours">Mettre à jour</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 Voituretech. Tous droits réservés.</p>
</footer>

</body>
</html>
