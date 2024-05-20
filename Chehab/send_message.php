<?php
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
    $exp_id = intval($_POST['exp_id']);
    $dest_id = intval($_POST['dest_id']);
    $message = pg_escape_string($connexion, $_POST['message']);
    $timestamp = date('Y-m-d H:i:s');

    $query = "INSERT INTO messages (exp_id, dest_id, message, date) VALUES ($1, $2, $3, $4)";
    $result = pg_query_params($connexion, $query, array($exp_id, $dest_id, $message, $timestamp));

    if (!$result) {
        echo json_encode(array("status" => "error", "message" => pg_last_error($connexion)));
        exit;
    }

    echo json_encode(array("status" => "success", "message" => "Message envoyé avec succès"));
    exit;
} else {
    echo json_encode(array("status" => "error", "message" => "Méthode de requête non valide"));
    exit;
}
?>
