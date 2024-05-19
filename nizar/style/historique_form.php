
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de trajet - Voituretech</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Variables de couleur */
:root {
    --primary-color: #4CAF50;  
    --accent-color: #2E7D32; 
    --bg-color: #f7f7f7; 
    --text-color: #212529; /* Assombrissement pour un meilleur contraste */
    --border-color: #ccc; 
}

/* Style global */
        /* Style global */
        body {
            margin: 250;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        header {
            background-color: #63a35c;
            color: #fff;
            padding: 1em 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover, nav a.active {
            background-color: #4c894e;
        }




/* Style du contenu principal */
.content {
    transition: margin-left 0.3s; /* Transition en douceur pour le basculement de la barre latérale */
    padding: 20px; /* Rembourrage intérieur */
    margin-left: 260px; /* Marge à gauche pour laisser de la place pour la barre latérale */
}

.card {
    background-color: white; /* Fond blanc pour les cartes */
    border: 1px solid var(--border-color); /* Bordure subtile */
    border-radius: 8px; /* Coins arrondis */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre légère pour un effet de profondeur */
    padding: 20px; /* Espace interne suffisant */
    margin-bottom: 20px; /* Marge entre les cartes */
    transition: transform 0.3s; /* Animation lors du survol */
}

.card:hover {
    transform: scale(1.03); /* Effet de zoom légèrement lors du survol */
}


/* Conception réactive : ajuster la marge du contenu lorsque la taille de l'écran change */
@media screen and (max-width: 768px) {
    aside {
        width: 200px; /* Barre latérale plus petite sur les écrans étroits */
    }

    .content {
        margin-left: 220px; /* Ajuster la marge du contenu pour correspondre à la largeur de la barre latérale */
    }
}

/* Style des résultats de recherche */
#results-list {
    display: grid; /* Affichage en grille */
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Colonnes de largeur flexible */
    gap: 20px; /* Espace entre les cartes de résultat */
    list-style: none; /* Pas de style de liste pour supprimer les puces */
    padding: 0; /* Pas de rembourrage */
}

.search-result {
    background-color: #fff;
    padding: 15px; /* Rembourrage intérieur */
    border-radius: 5px; /* Coins arrondis pour les cartes */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Ombre portée */
}

.search-result:hover {
    transform: translateY(-5px); /* Effet de léger soulèvement au survol */
}

.search-result .info {
    display: flex; /* Disposition en flexbox */
    align-items: center; /* Alignement des éléments */
    margin-bottom: 15px; /* Marge en dessous de l'info */
}

h2 {
            color: #333;
            text-align: center;
            margin-bottom: 15px;
        }

        p {
            color: #555;
            margin: 5px 0;
        }

        button {
            background-color: #63a35c; /* Vert foncé */
            color: #fff; /* Texte blanc */
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4c894e; /* Vert plus foncé au survol */
        }



 
/* Style du pied de page */
footer {
            text-align: center;
            padding: 10px;
            background-color: #63a35c; /* Vert foncé */
            color: #fff; /* Texte blanc */
            width: 100%;
            position: fixed;
            bottom: 0;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.2);
        }

    </style>
    </head>
<body>
    <header>
        Voituretech
        <nav>
            <a href="bienvenue.php">Accueil</a>
            <a href="#Recherche" class="active">Recherche</a>
            <a href="#Offres">Offres</a>
            <a href="#Inscription">Inscription</a>
            <a href="#Connexion">Connexion</a>
        </nav>
    </header>
    
    <div class="content">
        <!-- Le contenu sera aligné à droite de la barre latérale -->
    </div>
    <footer>
        &copy; 2024 Voituretech - Tous droits réservés.
    </footer>
</body>
</html>
