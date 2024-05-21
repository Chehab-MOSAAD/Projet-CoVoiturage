<?php
session_start();

// Supposons que l'email de l'administrateur est fourni après la connexion
$email_administrateur = 'Covoitech@gmail.com';

// Stocker l'email de l'administrateur dans la session
$_SESSION['email_administrateur'] = $email_administrateur;
?>
