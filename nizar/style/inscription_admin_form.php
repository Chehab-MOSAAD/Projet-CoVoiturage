<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Admin</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url(../image/fond_inscription_admin.jpg);
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
            animation: appear 0.5s ease-in-out;
        }
        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        h2 {
            margin-bottom: 20px;
            color: #4CAF50;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #555;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            text-align: left;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="submit"], button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            display: block;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        .error {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription Admin</h2>
        <?php if ($message): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Partie 1 du formulaire -->
        <form action="../php/inscription_admin.php" method="post" style="display: <?= $display_part1; ?>;">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <input type="submit" name="part_one" value="Suivant">
            </div>
        </form>

        <!-- Partie 2 du formulaire -->
        <form action="../php/inscription_admin.php" method="post" style="display: <?= $display_part2; ?>;">
            <div>
                <label for="nomadm">Nom:</label>
                <input type="text" id="nomadm" name="nomadm" required>
            </div>
            <div>
                <label for="prenomadm">Prénom:</label>
                <input type="text" id="prenomadm" name="prenomadm" required>
            </div>
            <div>
                <input type="submit" name="complete_registration" value="S'inscrire">
            </div>
        </form>
    </div>
</body>
</html>
