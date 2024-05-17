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
        $nomadm = filter_var($_POST["nomadm"], FILTER_SANITIZE_STRING);
        $prenomadm = filter_var($_POST["prenomadm"], FILTER_SANITIZE_STRING);
        $mail = $_SESSION['temp_email'];
        $motdepasse = $_SESSION['temp_password'];

        // Préparation de la requête SQL
        $sql = "INSERT INTO administrateur (nomadm, prenomadm, mail, motdepasse) VALUES ($1, $2, $3, $4)";
        $params = [$nomadm, $prenomadm, $mail, $motdepasse];
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

include "../style/inscription_admin_form.php";
?>
