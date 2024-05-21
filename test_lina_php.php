<?php
// Démarrage de la session au début du script
session_start();

// Configuration des paramètres de connexion
$host = 'localhost';
$port = '5432';
$db = 'lina';
$user = 'postgres';
$password = 'postgres';

// Création de la chaîne de connexion
$conn_string = "host=$host port=$port dbname=$db user=$user password=$password";

// Gestion des erreurs de connexion avec exceptions
try {
    $dbconn = pg_connect($conn_string);

    // Récupérer l'ID du conducteur stocké dans la session
    $userId = 1000;
    $userName = 'Visiteur'; // Nom par défaut

    // Récupérer le nom de l'utilisateur si connecté
    if ($userId) {
        $queryUser = "SELECT Nom, Prenom FROM Utilisateur WHERE IdUtilisateur = $userId";
        $resultUser = pg_query($dbconn, $queryUser);
        if ($resultUser && $userData = pg_fetch_assoc($resultUser)) {
            $userName = $userData['prenom'] . ' ' . $userData['nom'];
        }
    }

    // Vérification si un achat est en cours
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy'])) {
        $cadeauId = $_POST['buy'];

        // Récupération des points du conducteur
        $queryPoints = "SELECT C.Points, C.NumPermis
                        FROM Conducteur C
                        JOIN Utilisateur U ON U.IdUtilisateur = C.IdUtilisateur
                        WHERE U.IdUtilisateur = $userId";
        $resultPoints = pg_query($dbconn, $queryPoints);
        if ($resultPoints && pg_num_rows($resultPoints) > 0) {
            $userData = pg_fetch_assoc($resultPoints);
            $userPoints = $userData['points'];
            $numPermis = $userData['numpermis'];

            // Récupération des points nécessaires pour l'article
            $queryItemPoints = "SELECT PointsNecessaires FROM Boutique WHERE IdCadeau = $cadeauId";
            $resultItemPoints = pg_query($dbconn, $queryItemPoints);
            $itemPoints = pg_fetch_result($resultItemPoints, 0, 'pointsnecessaires');

            // Vérification si le conducteur a suffisamment de points
            if ($userPoints >= $itemPoints) {
                // Déduction des points et mise à jour de la base de données
                $newPoints = $userPoints - $itemPoints;
                $updatePoints = "UPDATE Conducteur SET Points = $newPoints WHERE NumPermis = '$numPermis'";
                pg_query($dbconn, $updatePoints);
                echo "<script>alert('Achat réussi! Vos points ont été déduits.');</script>";

                // Rediriger pour recharger la page et afficher les points mis à jour
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $updatePoints = "UPDATE Conducteur SET Points = $userPoints WHERE NumPermis = '$numPermis'";
                pg_query($dbconn, $updatePoints);
                echo "<script>alert('Pas assez de points pour cet achat.');</script>";
                // Rediriger pour recharger la page et afficher les points mis à jour
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
                
            }
        }
    } else {
        // Récupération des points du conducteur
        $queryPoints = "SELECT Points
                        FROM Conducteur
                        WHERE IdUtilisateur = $userId";
        $resultPoints = pg_query($dbconn, $queryPoints);
        if ($resultPoints && pg_num_rows($resultPoints) > 0) {
            $userPoints = pg_fetch_result($resultPoints, 0, 'points');
        }
    }

    // Requête pour récupérer les produits de la table Boutique
    $query = "SELECT IdCadeau, NomCadeau, DescriptionCadeau, PointsNecessaires FROM Boutique";
    $result = pg_query($dbconn, $query);
    $items = pg_fetch_all($result);
} catch (Exception $e) {
    echo "Erreur de connexion : ", $e->getMessage();
}



// Définition des images pour chaque item
$imagePaths = [
    'Montre connectée' => 'lina images/616L3zkYFzL.webp',
    'Sac à dos' => 'lina images/0-variant-kingsons-sac-a-dos-multifonction-avec-chargeur-usb-pour-homme-sacs-etanches-pour-ordinateur-portable-antivol-133-quot-156quot.webp',
    'Casque Audio' => 'lina images/px8-blanc-caramel_6332d57e2c3f8_300_square.webp',
];
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue <?php echo htmlspecialchars($userName); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: white;
            color: #004d40; /* Vert foncé */
        }
        .navbar {
            background-color: #b2dfdb; /* Vert clair */
            color: #004d40;
            margin-bottom: 30px;
        }
        .navbar-brand, .nav-link {
            color: #004d40 !important;
        }
        .card {
            margin-top: 20px;
            transition: transform .2s; /* Animation */
        }
        .card-img-top {
            width: 100%;
            height: 200px; /* fixed height */
            object-fit: cover; /* keeps the aspect ratio */
        }
        .card:hover {
            transform: scale(1.05); /* Zoom légèrement */
            background-color: #e0f2f1; /* Vert clair */
        }
        .card-body:hover .card-text {
            visibility: visible; /* Montrer la description au survol */
        }
        .card-text {
            visibility: hidden; /* Cacher la description initialement */
        }
        .btn-primary {
            background-color: #004d40; /* Vert foncé */
            border: none;
        }
        .btn-primary:hover {
            background-color: #00796b; /* Vert moyen */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">Boutique</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Deconnexion</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container py-5">
    <h1 class="mb-5">Bienvenue, <?php echo htmlspecialchars($userName); ?></h1>
    <h2 class="mb-4">Vous avez <?php echo htmlspecialchars($userPoints ?? 0); ?> points.</h2>

    <h2 class="mb-4">Boutique</h2>
    <?php if (!empty($items)): ?>
        <div class="row">
            <?php foreach($items as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- <img src="image_fond_pharma" class="card-img-top" alt="Image de l'article"> -->
                    <?php
                    // Sélection de l'image appropriée pour chaque item
                    $itemImage = 'images/default.jpg'; // Image par défaut
                    if (isset($imagePaths[$item['nomcadeau']])) {
                        $itemImage = $imagePaths[$item['nomcadeau']];
                    }
                    ?>
                    <img src="<?php echo htmlspecialchars($itemImage); ?>" class="card-img-top" alt="Image de l'article">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($item['nomcadeau']); ?> (<?php echo htmlspecialchars($item['pointsnecessaires']); ?> points)</h5>
                        <p class="card-text"><?php echo htmlspecialchars($item['descriptioncadeau']); ?></p>
                        <form method="POST" action="">
                            <input type="hidden" name="buy" value="<?php echo htmlspecialchars($item['idcadeau']); ?>">
                            <button type="submit" class="btn btn-primary">Acheter</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun article disponible pour le moment.</p>
    <?php endif; ?>
</div>

</body>
</html>
