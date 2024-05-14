<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Réservation est en Attente</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style pour centrer le contenu */
        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Centrer verticalement */
            text-align: center; /* Centrer horizontalement */
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header>
        <!-- Logo et autres éléments d'en-tête communs -->
        <div class="logo">
            <!-- Logo ici -->
        </div>
        
        <!-- Navigation -->
        <nav>
            <ul>
                <!-- Liens de navigation communs -->
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="recherche_voyage.php">Recherche de Voyages</a></li>
                <!-- Autres liens communs -->

                <!-- Condition pour afficher les liens spécifiques selon l'état de connexion -->
                <?php if ($estConnecteConducteur) : ?>
                    <!-- Lien spécifique pour le conducteur connecté -->
                    <li><a href="profil_conducteur.php">Profil Conducteur</a></li>
                <?php elseif ($estConnecteUtilisateur) : ?>
                    <!-- Lien spécifique pour l'utilisateur connecté -->
                    <li><a href="profil_utilisateur.php">Profil Utilisateur</a></li>
                <?php else : ?>
                    <!-- Lien spécifique pour le visiteur non connecté -->
                    <li><a href="connexion.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="center-content">
        <div class="container">
            <h1>Votre Réservation est en Attente</h1>
            <p>Il faut attendre que le conducteur confirme votre réservation.</p>
            <!-- Lien au milieu de la page -->
            <a href="recherche_voyage.php" class="btn btn-primary">Retourner à la recherche des voyages</a>
        </div>
    </div>
</body>
</html>
