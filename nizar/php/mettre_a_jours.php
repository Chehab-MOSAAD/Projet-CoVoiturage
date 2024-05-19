<?php
// mis_a_jours.php: Gère la mise à jour des informations utilisateur

// Démarrer la session pour gérer l'authentification de l'utilisateur et autres données de session
session_start();

// Connexion à la base de données
require 'db.php'; // Assurez-vous que vos paramètres de connexion à la base de données sont corrects dans ce fichier

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour voir cette page.");
}

// Initialisation du message
$message = '';

// Récupération de l'ID utilisateur depuis la session
$idUtilisateur = $_SESSION['user_id'];

// Charger les données de l'utilisateur
$userData = [];
if ($idUtilisateur) {
    $query = 'SELECT * FROM utilisateur WHERE idutilisateur = $1';
    $result = pg_query_params($db, $query, array($idUtilisateur));
    if ($result && pg_num_rows($result) > 0) {
        $userData = pg_fetch_assoc($result);
    } else {
        $message = "Utilisateur non trouvé.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mettre_a_jours'])) {
    // Récupération et nettoyage des données depuis la requête POST
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $tel = filter_var($_POST['tel'], FILTER_SANITIZE_STRING);
    $langue1 = filter_var($_POST['langue1'], FILTER_SANITIZE_STRING);
    $langue2 = filter_var($_POST['langue2'], FILTER_SANITIZE_STRING);
    $sexe = isset($_POST['sexe']) ? $_POST['sexe'] : 'M';
    $handicap = isset($_POST['handicap']) ? 'true' : 'false';
    $fumeur = isset($_POST['fumeur']) ? 'true' : 'false';
    $jour = (int)$_POST['jour'];
    $mois = (int)$_POST['mois'];
    $annee = (int)$_POST['annee'];

    // Validation du mot de passe
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (!empty($password) && $password === $confirm_password) {
        if (strlen($password) < 8 || !preg_match("/[a-z]/i", $password) || !preg_match("/[0-9]/", $password)) {
            $message = "Le mot de passe doit contenir au moins 8 caractères, inclure des lettres et des chiffres.";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
    } else if (!empty($password) && $password !== $confirm_password) {
        $message = "Les mots de passe ne correspondent pas.";
    }

    // Initialisation des requêtes et des paramètres
    $queries = [];
    $params = [];

    // Validation des données et préparation des requêtes
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Adresse email invalide.";
    } elseif (!preg_match('/^0[0-9]{9}$/', $tel)) {
        $message = "Le numéro de téléphone doit commencer par un '0' et contenir 10 chiffres.";
    } elseif (strlen($prenom) == 0 || !preg_match('/^[A-Za-z]+$/', $prenom)) {
        $message = "Prénom invalide.";
    } elseif (strlen($nom) == 0 || !preg_match('/^[A-Za-z]+$/', $nom)) {
        $message = "Nom invalide.";
    } else {
        // Ajout des requêtes de mise à jour individuelles
        if ($prenom !== $userData['prenom']) {
            $queries[] = "UPDATE utilisateur SET prenom = $1 WHERE idutilisateur = $2";
            $params[] = [$prenom, $idUtilisateur];
        }
        if ($nom !== $userData['nom']) {
            $queries[] = "UPDATE utilisateur SET nom = $1 WHERE idutilisateur = $2";
            $params[] = [$nom, $idUtilisateur];
        }
        if ($sexe !== $userData['sexe']) {
            $queries[] = "UPDATE utilisateur SET sexe = $1 WHERE idutilisateur = $2";
            $params[] = [$sexe, $idUtilisateur];
        }
        if ($tel !== $userData['tel']) {
            $queries[] = "UPDATE utilisateur SET tel = $1 WHERE idutilisateur = $2";
            $params[] = [$tel, $idUtilisateur];
        }
        if ($handicap != $userData['handicap']) {
            $queries[] = "UPDATE utilisateur SET handicap = $1 WHERE idutilisateur = $2";
            $params[] = [$handicap, $idUtilisateur];
        }
        if ($langue1 !== $userData['langueparle1']) {
            $queries[] = "UPDATE utilisateur SET langueparle1 = $1 WHERE idutilisateur = $2";
            $params[] = [$langue1, $idUtilisateur];
        }
        if ($langue2 !== $userData['langueparle2']) {
            $queries[] = "UPDATE utilisateur SET langueparle2 = $1 WHERE idutilisateur = $2";
            $params[] = [$langue2, $idUtilisateur];
        }
        if ($fumeur != $userData['fumeur']) {
            $queries[] = "UPDATE utilisateur SET fumeur = $1 WHERE idutilisateur = $2";
            $params[] = [$fumeur, $idUtilisateur];
        }
        if ($jour !== $userData['jour']) {
            $queries[] = "UPDATE utilisateur SET jour = $1 WHERE idutilisateur = $2";
            $params[] = [$jour, $idUtilisateur];
        }
        if ($mois !== $userData['mois']) {
            $queries[] = "UPDATE utilisateur SET mois = $1 WHERE idutilisateur = $2";
            $params[] = [$mois, $idUtilisateur];
        }
        if ($annee !== $userData['annee']) {
            $queries[] = "UPDATE utilisateur SET annee = $1 WHERE idutilisateur = $2";
            $params[] = [$annee, $idUtilisateur];
        }

        // Exécution des requêtes
        foreach ($queries as $index => $query) {
            $result = pg_query_params($db, $query, $params[$index]);
            if (!$result) {
                $message = "Erreur lors de la mise à jour des informations: " . pg_last_error($db);
                break;
            }
        }

        // Mise à jour du mot de passe si toutes les autres requêtes ont réussi et qu'il n'y a pas d'erreur de validation pour le mot de passe
        if (empty($message) && !empty($password) && $password === $confirm_password) {
            $query = "UPDATE utilisateur SET motdepasse = $1 WHERE idutilisateur = $2";
            $params = [$password, $idUtilisateur];
            $result = pg_query_params($db, $query, $params);
            if (!$result) {
                $message = "Erreur lors de la mise à jour du mot de passe: " . pg_last_error($db);
            }
        }

        // Vérifie si toutes les requêtes ont été exécutées avec succès
        if (empty($message)) {
            // Rediriger vers bienvenue.php après la mise à jour réussie
            header("Location: bienvenue.php");
            exit;
        }
    }
}

// Inclure le formulaire de mise à jour
include "../style/mettre_a_jours_form.php";
?>
