<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue Chehab</title>
    <link rel="stylesheet" href="historique.css">
</head>

<body>
    <header>
        <div class="user-info">
            <h1>Bienvenue !</h1>
            <div class="user-stats">
            </div>
            <button>Mettre à jour</button>
        </div>
        <button>Reserver un trajet</button>
    </header>

    <main>
        <section class="history">
            <h2>L'Historique :</h2>
            <!-- List items should be generated dynamically -->
            <div class="trip">
                <div class="trip-info">Vendredi 5 avril 2024 - Toulouse ➜ Paris - 03:00 / escale 10:30</div>
                <ul class="passengers">
                    <li>Nassar</li>
                    <li>Lina</li>
                    <li>Minar</li>
                    <li>Linda</li>
                </ul>
                <span>Status: Fait</span>
                <button>Commenter</button>
            </div>
        </section>
        <section class="upcoming">
            <h2>À venir :</h2>
            <!-- List items should be generated dynamically -->
            <div class="trip">
                <div class="trip-info">Vendredi 7 juin 2024 - Toulouse ➜ Paris - 03:00 / escale 10:30</div>
                <ul class="passengers">
                    <li>Niaz</li>
                    <li>Lina</li>
                    <li>Minir</li>
                    <li>Linda</li>
                </ul>
                <span>Status: En attente</span>
                <button>Commenter</button>
            </div>
        </section>
    </main>

    <footer>
        <a href="submit_trajet.php" >Proposer un trajet</a >
        <button>Consulter la boutique</button>
    </footer>
</body>

</html>
