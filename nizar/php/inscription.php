<?php
require 'db.php';
session_start();

$message = '';
$display_part1 = 'block';
$display_part2 = 'none';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["part_one"])) {
        // Validation et nettoyage des entrées
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Adresse email invalide.";
        } else {
            $password = $_POST["password"];
            // Validation supplémentaire pour le mot de passe
            if (strlen($password) < 8 || !preg_match("/[a-z]/i", $password) || !preg_match("/[0-9]/", $password)) {
                $message = "Le mot de passe doit contenir au moins 8 caractères, inclure des lettres et des chiffres.";
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $_SESSION['temp_email'] = $email;
                $_SESSION['temp_password'] = $password;
                $display_part1 = 'none';
                $display_part2 = 'block';
            }
        }
    } elseif (isset($_POST["complete_registration"])) {
        // Collecter et nettoyer les autres informations
        $prenom = filter_var($_POST["prenom"], FILTER_SANITIZE_STRING);
        $nom = filter_var($_POST["nom"], FILTER_SANITIZE_STRING);
        $tel = filter_var($_POST["tel"], FILTER_SANITIZE_STRING);
        if (!preg_match('/^0[0-9]{9}$/', $tel)) {
            $message = "Le numéro de téléphone doit commencer par un '0' et contenir 10 chiffres.";
        } else {
            $sexe = isset($_POST['sexe']) ? $_POST['sexe'] : 'M';
            $handicap = isset($_POST['handicap']) ? $_POST['handicap'] : 0;
            $langue1 = filter_var($_POST["langue1"], FILTER_SANITIZE_STRING);
            $langue2 = filter_var($_POST["langue2"], FILTER_SANITIZE_STRING);
            $fumeur = isset($_POST['fumeur']) ? $_POST['fumeur'] : 0;
            $jour = (int)$_POST["jour"];
            $mois = (int)$_POST["mois"];
            $annee = (int)$_POST["annee"];
            $notePassager = 0;

            $email = $_SESSION['temp_email'];
            $password = $_SESSION['temp_password'];

            // Préparation de la requête SQL
            $sql = "INSERT INTO utilisateur (mail, motdepasse, nom, prenom, sexe, tel, handicap, langueparle1, langueparle2, fumeur, jour, mois, annee, notepassager) 
            VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14)";
            $params = [$email, $password, $nom, $prenom, $sexe, $tel, $handicap, $langue1, $langue2, $fumeur, $jour, $mois, $annee, $notePassager];
            $result = pg_query_params($db, $sql, $params);

            if ($result) {
                $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                unset($_SESSION['temp_email'], $_SESSION['temp_password']);
                $display_part1 = 'none';
                $display_part2 = 'none';
            } else {
                $message = "Erreur lors de l'inscription : " . pg_last_error($db);
            }
        }
    }
}

include "../style/inscription_form.php";
?>
