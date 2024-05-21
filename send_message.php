<?php
session_start();
// Connexion à la base de données
$host = "localhost";
$port = "5433";
$user = "postgres";
$password = "lilou";
$dbname = "CoVoiturage";
$connexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connexion) {
    die("Échec de la connexion: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expediteurid = $_POST['expediteurid'];
    $destinataireid = $_POST['destinataireid'];
    $message = $_POST['message'];
    $dateenvoi = date('Y-m-d H:i:s');
    $status = 'envoyé';

    $insertQuery = "INSERT INTO messagerie (expediteurid, destinataireid, message, dateenvoi, status) 
                    VALUES ($1, $2, $3, $4, $5)";
    $result = pg_query_params($connexion, $insertQuery, array($expediteurid, $destinataireid, $message, $dateenvoi, $status));

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'envoi du message.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode de requête invalide.']);
}
?>
