<?php
// Inclut ton fichier de configuration de base de données
require 'db.php';

// Tente d'exécuter une requête simple (récupérer la version de PostgreSQL)
$query = $db->query('SELECT version()');

// Récupère et affiche le résultat de la requête
$version = $query->fetch();
echo "La version de PostgreSQL est : " . $version[0];
?>
