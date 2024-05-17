<?php
$host = 'localhost';
$dbname = 'test2';
$user = 'postgres';
$password = 'nizar';

$connectionString = "host=$host dbname=$dbname user=$user password=$password";

// Essayer de se connecter à la base de données
$db = pg_connect($connectionString);

if ($db) {
    echo "Connexion à la base de données '$dbname' réussie";
} else {
    die("Erreur de connexion : " . pg_last_error());
}
?>
