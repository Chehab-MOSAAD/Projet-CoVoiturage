<?php
// Include the database connection file
include 'db.php';

if (isset($_GET['idTrajet'])) {
    $idTrajet = $_GET['idTrajet'];

    try {
        // Begin transaction
        $db->beginTransaction();

        // Delete from Reserver
        $stmt = $db->prepare("DELETE FROM Reserver WHERE IdRes IN (SELECT IdRes FROM Reservation WHERE IdTrajet = :idTrajet)");
        $stmt->bindParam(':idTrajet', $idTrajet, PDO::PARAM_INT);
        $stmt->execute();

        // Delete from Reservation
        $stmt = $db->prepare("DELETE FROM Reservation WHERE IdTrajet = :idTrajet");
        $stmt->bindParam(':idTrajet', $idTrajet, PDO::PARAM_INT);
        $stmt->execute();

        // Commit transaction
        $db->commit();

        echo "Trajet annulé avec succès.";
    } catch (PDOException $e) {
        // Rollback transaction in case of error
        $db->rollBack();
        echo "Erreur lors de l'annulation du trajet: " . $e->getMessage();
    }
} else {
    echo "ID de trajet non spécifié.";
}
?>
