<?php
require 'db.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données
session_start();

$message = '';
$display_part1 = 'block'; // Affichez par défaut la première partie
$display_part2 = 'none'; // Cachez par défaut la deuxième partie

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["part_one"])) {
    // Assainissement et assignation des valeurs pour la première partie
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Stocker les valeurs dans la session pour les utiliser après le "suivant"
    $_SESSION['temp_email'] = $email;
    $_SESSION['temp_password'] = $password;

    // Modifier l'affichage des parties du formulaire
    $display_part1 = 'none';
    $display_part2 = 'block';
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["complete_registration"])) {
    // Assainissement et assignation des valeurs pour la deuxième partie
    $prenom = filter_var($_POST["prenom"], FILTER_SANITIZE_STRING);
    $nom = filter_var($_POST["nom"], FILTER_SANITIZE_STRING);
    $tel = filter_var($_POST["tel"], FILTER_SANITIZE_STRING); // Assurez-vous d'ajouter tous les champs nécessaires

    // Récupérer les valeurs de la première partie stockées dans la session
    $email = $_SESSION['temp_email'];
    $password = $_SESSION['temp_password'];

    // Préparation et exécution de la requête SQL pour l'insertion (assurez-vous de valider l'unicité de l'email)
    // Code pour insérer dans la base de données
    // Nettoyage des données de session après l'inscription
    unset($_SESSION['temp_email'], $_SESSION['temp_password']);

    // Message de réussite
    $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
    // Vous pouvez rediriger ou afficher un message ici
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Voituretech</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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

        input[type=email], input[type=password], input[type=text], input[type=tel] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        input[type=radio], input[type=checkbox] {
            margin-right: 5px;
        }

        label {
            margin-right: 10px;
        }

        .part {
            display: none;
        }

        .part.active {
            display: block;
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
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            left: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Inscription Voituretech</h1>
    </header>

    <div class="container">
        <div class="steps">
            <div class="step active" onclick="goToStep(1)">1</div>
            <div class="step" onclick="goToStep(2)">2</div>
        </div>

        <div class="part active" id="part-one">
            <h2>Créez votre compte</h2>
            <form method="POST" action="">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="submit" name="part_one" value="Suivant" onclick="nextStep(event)">
            </form>
        </div>

        <div class="part" id="part-two">
            <h2>Complétez votre profil</h2>
            <form method="POST" action="">
                <input type="text" name="prenom" placeholder="Prénom" required>
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="tel" name="tel" placeholder="Téléphone">
                <label><input type="radio" name="sexe" value="M"> Homme</label>
                <label><input type="radio" name="sexe" value="F"> Femme</label>
                <label><input type="checkbox" name="handicap" value="1"> Handicap</label>
                <input type="submit" name="complete_registration" value="Inscrire">
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Voituretech. Tous droits réservés.</p>
    </footer>

    <script>
        function nextStep(event) {
            event.preventDefault(); // Empêche l'envoi du formulaire par défaut

            // Masque la première partie et affiche la deuxième partie
            document.getElementById('part-one').classList.remove('active');
            document.getElementById('part-two').classList.add('active');

            // Met à jour l'indicateur d'étape
            document.querySelectorAll('.step')[0].classList.remove('active');
            document.querySelectorAll('.step')[1].classList.add('active');
        }

        function goToStep(stepNumber) {
            // Affiche la première partie et masque la deuxième partie si stepNumber est 1
            if (stepNumber === 1) {
                document.getElementById('part-one').classList.add('active');
                document.getElementById('part-two').classList.remove('active');

                // Met à jour l'indicateur d'étape
                document.querySelectorAll('.step')[0].classList.add('active');
                document.querySelectorAll('.step')[1].classList.remove('active');
            }
        }
    </script>
</body>
</html>