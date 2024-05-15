<?php
// Database configuration settings
$host = 'localhost';
$dbname = 'postgres';
$user = 'postgres'; 
$password = '0000'; 

// Data Source Name = une chaine de conenxion qui informe PDO comment se connecter à la BD
$dsn = "pgsql:host=$host;dbname=$dbname";

//PDO : PHP Data Objects 
// Options for error handling and fetching
$options = [
    // gestion des erreurs :
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // définir le code de récupération de données :
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a new PDO instance
    $db_connection = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    // If an error occurs, you can handle it here or log it
    error_log($e->getMessage());
    exit('Connection failed: ' . $e->getMessage());
}
?>
