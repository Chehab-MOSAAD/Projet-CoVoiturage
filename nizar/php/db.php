<?php
$host = 'localhost'; 
$dbname = 'test2';
$user = 'postgres';
$password = 'nizar';

$dsn = "pgsql:host=$host;dbname=$dbname";


try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données '$dbname' réussie";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>

