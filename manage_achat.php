<?php
session_start();

// Vérifiez que la requête POST contient bien 'buy'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy'])) {
    $host = 'localhost'; 
    $dbname = 'UPSIVOITURE';
    $user = 'postgres';
    $password = 'nizar';

    $dsn = "pgsql:host=$host;dbname=$dbname";

    // Effectuez la connexion à la base de données et saisissez les erreurs éventuelles
    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $userId = $_SESSION['id'];
        $itemId = $_POST['buy'];

        // Récupérez les points nécessaires de l'article et les points de l'utilisateur
        $queryItem = $pdo->prepare('SELECT PointsNecessaires FROM Boutique WHERE IdCadeau = :itemId');
        $queryItem->execute(['itemId' => $itemId]);
        $itemResult = $queryItem->fetch(PDO::FETCH_ASSOC);

        $queryPoints = $pdo->prepare('SELECT Points FROM Conducteur WHERE IdUtilisateur = :userId');
        $queryPoints->execute(['userId' => $userId]);
        $userResult = $queryPoints->fetch(PDO::FETCH_ASSOC);

        // Vérifiez si l'utilisateur a suffisamment de points pour l'article
        if ($userResult['Points'] >= $itemResult['PointsNecessaires']) {
            // Deduisez les points de l'utilisateur
            $newPoints = $userResult['Points'] - $itemResult['PointsNecessaires'];
            $updatePoints = $pdo->prepare('UPDATE Conducteur SET Points = :newPoints WHERE IdUtilisateur = :userId');
            $updatePoints->execute(['newPoints' => $newPoints, 'userId' => $userId]);

            // Ajoutez l'article à la liste des achats de l'utilisateur
            $addPurchase = $pdo->prepare('INSERT INTO ListeDesAchats (IdUtilisateur, IdCadeau) VALUES (:userId, :itemId)');
            $addPurchase->execute(['userId' => $userId, 'itemId' => $itemId]);

            echo "Vous avez acheté l'article avec succès. Vos points restants sont : " . $newPoints;

            // Après qu'un article a été acheté avec succès, affichez tous les articles que l'utilisateur a achetés
            $getPurchases = $pdo->prepare(
                'SELECT Boutique.NomCadeau 
                 FROM Boutique
                 INNER JOIN ListeDesAchats 
                 ON Boutique.IdCadeau = ListeDesAchats.IdCadeau
                 WHERE ListeDesAchats.IdUtilisateur = :userId'
            );

            $getPurchases->execute(['userId' => $userId]);
            $purchases = $getPurchases->fetchAll(PDO::FETCH_ASSOC);

            if ($purchases) {
                echo "<br>Voici la liste des articles que vous avez achetés :";
                foreach ($purchases as $purchase) {
                    echo "<br>" . $purchase['NomCadeau'];
                }
            }
        } else {
            echo "Vous n'avez pas assez de points pour acheter cet article.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "Erreur : Aucun article spécifié.";
}
?>