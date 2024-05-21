<?php
// Démarrer la session
session_start();

// Simuler une connexion réussie (remplacez cela par votre propre logique de connexion)
$email_utilisateur = "nizarslamas@gmail.com"; // Remplacez cela par l'email de l'utilisateur connecté après validation

// Stocker l'email dans la session
$_SESSION['email_conducteur'] = $email_utilisateur;

// Rediriger vers la page de proposition de trajet après la connexion
header("Location: submit_trajet.php");
exit();
?>
