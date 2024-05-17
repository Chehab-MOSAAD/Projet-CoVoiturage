
<?php
$host = 'localhost';
$db = 'CoVoiturage';
$user = 'postgres';
$pass = 'lilou';
$port = '5433';
$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSession = filter_input(INPUT_POST, 'id_session', FILTER_VALIDATE_INT);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    if ($idSession && $action) {
        if ($action === 'accept') {
            // Traitement pour accepter la demande
            $query = "UPDATE Messagerie SET Status = 'Accepted' WHERE IdSession = :id_session";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['id_session' => $idSession]);
            echo "Demande acceptée avec succès.";
        } elseif ($action === 'reject') {
            // Traitement pour refuser la demande
            $query = "UPDATE Messagerie SET Status = 'Rejected' WHERE IdSession = :id_session";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['id_session' => $idSession]);
            echo "Demande refusée avec succès.";
        } else {
            echo "Action invalide.";
        }
    } else {
        echo "Données invalides.";
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
