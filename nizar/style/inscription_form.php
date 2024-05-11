<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Voituretech</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .part {
            display: <?php echo $display_part1; ?>;
        }
        .part.active {
            display: <?php echo $display_part2; ?>;
        }
        .steps {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .step {
            width: 25px;
            height: 25px;
            background-color: #ddd;
            border-radius: 50%;
            margin: 0 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #666;
        }
        .step.active {
            background-color: #4CAF50;
            color: white;
        }
        footer {
            position: fixed; /* Fixer le footer */
            bottom: 0; /* Positionner le footer au bas de la fenêtre */
            width: 100%; /* Assurer que le footer s'étend sur toute la largeur de la page */
            height: 50px;
            padding: 10px 20px;
            font-size: 14px;
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

</head>
<body>
    <form action="../php/inscription.php" method="post">

<header>
    <h1>Inscription Voituretech</h1>
</header>

<div class="container">
    <div class="steps">
        <div class="step <?php echo $display_part2 == 'none' ? 'active' : ''; ?>">1</div>
        <div class="step <?php echo $display_part2 == 'block' ? 'active' : ''; ?>">2</div>
    </div>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="part" id="part-one">
        <h2>Créez votre compte</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" name="part_one" value="Suivant">
        </form>
    </div>

    <div class="part active" id="part-two">
        <h2>Complétez votre profil</h2>
        <form method="POST" action="">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>

            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>

            <label for="tel">Téléphone:</label>
            <input type="tel" id="tel" name="tel" placeholder="Entrez votre numéro de téléphone" required>

            <label for="langue1">Langue parlée 1:</label>
            <input type="text" id="langue1" name="langue1" placeholder="Langue principale" required>

            <label for="langue2">Langue parlée 2:</label>
            <input type="text" id="langue2" name="langue2" placeholder="Langue secondaire" required>

            <label for="jour">Jour de naissance:</label>
            <select id="jour" name="jour">
                <?php for ($i = 1; $i <= 31; $i++) {
                    echo "<option value='$i'>$i</option>";
                } ?>
            </select>

            <label for="mois">Mois de naissance:</label>
            <select id="mois" name="mois">
                <?php for ($i = 1; $i <= 12; $i++) {
                    echo "<option value='$i'>$i</option>";
                } ?>
            </select>

            <label for="annee">Année de naissance:</label>
            <select id="annee" name="annee">
                <?php for ($i = 1900; $i <= date("Y"); $i++) {
                    echo "<option value='$i'>$i</option>";
                } ?>
            </select>

            <fieldset>
                <legend>Genre:</legend>
                <label><input type="radio" name="sexe" value="M" checked> Homme</label>
                <label><input type="radio" name="sexe" value="F"> Femme</label>
            </fieldset>

            <fieldset>
                <legend>Handicap:</legend>
                <label><input type="radio" name="handicap" value="1" required> Oui</label>
                <label><input type="radio" name="handicap" value="0" required> Non</label>
            </fieldset>

            <fieldset>
                <legend>Fumeur:</legend>
                <label><input type="radio" name="fumeur" value="1" required> Oui</label>
                <label><input type="radio" name="fumeur" value="0" required> Non</label>
            </fieldset>


            <button type="submit" name="complete_registration">Inscrire</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2024 Voituretech. Tous droits réservés.</p>
</footer>

</body>
</html>
