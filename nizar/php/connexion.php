<?php
// connexion.php: Traite la logique de connexion et la gestion de session

// Démarre une nouvelle session ou reprend une session existante
session_start();

// Inclusion de la connexion à la base de données
require_once 'db.php'; 

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // Redirige vers la page de bienvenue s'il est connecté
    header("Location: bienvenue.php");
    exit;
}

// Initialisation du message d'erreur
$message = '';

// Vérifie si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère l'email et le mot de passe du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prépare une requête pour récupérer l'utilisateur correspondant à l'email fourni
        $sql = "SELECT IdUtilisateur, Mail, motdepasse FROM Utilisateur WHERE Mail = ?"; 
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Vérifie si un utilisateur a été trouvé
        if ($user) {
            // Vérifie si le mot de passe est correct
            if (password_verify($password, $user['motdepasse'])) {
                // Initialise les variables de session avec l'ID et l'email de l'utilisateur
                $_SESSION['user_id'] = $user['IdUtilisateur'];
                $_SESSION['email'] = $user['Mail']; 
                // Redirige vers la page de bienvenue
                header("Location: bienvenue.php");
                exit;
            } else {
                // Définit un message d'erreur si le mot de passe est incorrect
                $message = "Email ou mot de passe incorrect.";
            }
        } else {
            // Définit un message d'erreur si aucun utilisateur n'a été trouvé
            $message = "Aucun utilisateur trouvé avec cet email.";
        }
    } catch (PDOException $e) {
        // Définit un message d'erreur en cas d'exception
        $message = "Erreur lors de la connexion : " . $e->getMessage();
    }
}

// Vérifie si un message d'erreur de session existe et le définit
if (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    unset($_SESSION['error']);
}

// Inclut le formulaire de connexion
include "../style/connexion_form.php";
?>
