<?php
// connexion.php: Traite la logique de connexion et la gestion de session

// Démarre une nouvelle session ou reprend une session existante
session_start();

// Inclusion de la connexion à la base de données
require_once 'db.php';

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // Redirige vers la page de bienvenue s'il est connecté
    header("Location: profileadmin.php");
    exit;
}

// Initialisation du message d'erreur
$message = '';

// Vérifie si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère l'email et le mot de passe du formulaire
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prépare une requête pour récupérer l'utilisateur correspondant à l'email fourni
    $sql = 'SELECT idadm, mail, motdepasse FROM administrateur WHERE mail = $1';
    $result = pg_query_params($db, $sql, array($email));

    // Vérifie si un utilisateur a été trouvé
    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);

        // Vérifie si le mot de passe est correct
        if (password_verify($password, $user['motdepasse'])) {
            // Initialise les variables de session avec l'ID et l'email de l'utilisateur
            $_SESSION['user_id'] = $user['idadm'];
            $_SESSION['email'] = $user['mail'];
            // Redirige vers la page de bienvenue
            header("Location: profileadmin.php");
            exit;
        } else {
            // Définit un message d'erreur si le mot de passe est incorrect
            $message = "Email ou mot de passe incorrect.";
        }
    } else {
        // Définit un message d'erreur si aucun utilisateur n'a été trouvé
        $message = "Aucun utilisateur trouvé avec cet email.";
    }
}

// Vérifie si un message d'erreur de session existe et le définit
if (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    unset($_SESSION['error']);
}

// Inclut le formulaire de connexion
include "../style/connexionadmin_form.php";
?>
