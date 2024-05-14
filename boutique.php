<?php
session_start();

$host = 'localhost'; 
$dbname = 'BD_CovoiTECH';
$user = 'postgres';
$password = 'Amine2009';

$dsn = "pgsql:host=$host;dbname=$dbname";

$userName = $_SESSION['nom'];
$userId = $_SESSION['id'];
$userPoints = null;

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $queryItems = $pdo->query('SELECT * FROM Boutique');
    $items = $queryItems->fetchAll();

    // Utilisation directe de $userId pour récupérer les points de l'utilisateur
    if ($userId) {
        $queryPoints = $pdo->prepare('SELECT Points FROM Conducteur WHERE IdUtilisateur = :userId');
        $queryPoints->execute(['userId' => $userId]);
        $userResult = $queryPoints->fetch(PDO::FETCH_ASSOC);

        if ($userResult) {
            $userPoints = $userResult['Points'];
        }
    }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bienvenue <?php echo $userName ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
</head>
<body>
<div class="container py-5">
    <?php if(isset($_SESSION['id'])): ?>
        <h1 class="mb-5">Bienvenue, <?php echo $userName; ?></h1>
    <?php else: ?>
        <h1 class="mb-5">Bienvenue</h1>
    <?php endif; ?>

    <?php if(isset($userPoints)): ?>
        <h2 class="mb-4">Vous avez <?php echo $userPoints; ?> points.</h2>
    <?php else: ?>
        <h2 class="mb-4">Vous n'avez pas de points.</h2>
    <?php endif; ?>
</div>

        <h2 class="mb-4">Boutique</h2>
      <?php $counter = 0; ?>
      <?php foreach($items as $key => $item): ?>
        <?php if($counter % 3 == 0): ?>
        <div class="row">
        <?php endif; ?>
        <div class="col-md-4 mb-4">
    <div class="card">
        <img src="image_url" class="card-img-top" alt="Article Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $item['NomCadeau']; ?> <small class="text-muted">(<?php echo $item['PointsNecessaires']; ?> points)</small></h5>

            <form method="POST" action="manage_achat.php">
                <input type="hidden" name="buy" value="<?php echo $item['IdCadeau']; ?>">
                <button type="submit" class="btn btn-primary">Acheter</button>
            </form>

            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#itemModal<?php echo $key; ?>">
                Afficher la description
            </button>
        </div>
        
        <div class="modal fade" id="itemModal<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel<?php echo $key; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="itemModalLabel<?php echo $key; ?>"><?php echo $item['NomCadeau']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="image_url" class="img-fluid" alt="Article Image">
                            </div>
                            <div class="col-lg-6">
                                <p><?php echo $item['DescriptionCadeau']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <?php $counter++; ?>
        <?php if($counter % 3 == 0 || $counter == count($items)): ?>
        </div>
        <?php endif; ?>
      <?php endforeach; ?>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>