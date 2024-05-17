<?php
// deconnexion.php: Gère la déconnexion de l'utilisateur

session_start();
session_unset();
session_destroy();
header("Location: connexion.php"); // Redirige vers la page de connexion ou une autre page après déconnexion
exit;
?>
