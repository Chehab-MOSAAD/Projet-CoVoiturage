<?php
// Include the database connection file
include 'db.php';

if (isset($_GET['idTrajet'])) {
    $idTrajet = $_GET['idTrajet'];

    // Connexion à la base de données
    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
    if (!$conn) {
        die("Erreur de connexion : " . pg_last_error());
    }

    try {
        // Begin transaction
        pg_query($conn, 'BEGIN');

        // Delete from Reserver
        $query = "DELETE FROM Reserver WHERE IdRes IN (SELECT IdRes FROM Reservation WHERE IdTrajet = $1)";
        $result = pg_query_params($conn, $query, array($idTrajet));
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }

        // Delete from CommenterReservation
        $query = "DELETE FROM CommenterReservation WHERE IdRes IN (SELECT IdRes FROM Reservation WHERE IdTrajet = $1)";
        $result = pg_query_params($conn, $query, array($idTrajet));
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }

        // Delete from Reservation
        $query = "DELETE FROM Reservation WHERE IdTrajet = $1";
        $result = pg_query_params($conn, $query, array($idTrajet));
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }

        // Delete from Départ
        $query = "DELETE FROM Départ WHERE IdTrajet = $1";
        $result = pg_query_params($conn, $query, array($idTrajet));
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }

        // Delete from Trajet
        $query = "DELETE FROM Trajet WHERE IdTrajet = $1";
        $result = pg_query_params($conn, $query, array($idTrajet));
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }

        // Commit transaction
        pg_query($conn, 'COMMIT');

        // Redirection après succès
        header("Location: history.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaction in case of error
        pg_query($conn, 'ROLLBACK');
        echo "Erreur lors de l'annulation du trajet: " . $e->getMessage();
    } finally {
        pg_close($conn);
    }
} else {
    echo "ID de trajet non spécifié.";
}
?>
