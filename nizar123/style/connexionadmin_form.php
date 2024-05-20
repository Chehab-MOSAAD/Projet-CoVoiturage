<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url(../image/fond_connexion.jpg);
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            background-blend-mode: overlay;
        }

        form {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 400px;
            animation: appear 0.5s ease-in-out;
        }

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 40px 12px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .input-group .icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            transition: color 0.3s;
        }

        .input-group input:focus + .icon {
            color: #4CAF50;
        }

        input[type="submit"], button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            display: block;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #4CAF50;
            color: white;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }

        input[type="submit"]:active, button:active {
            transform: translateY(2px);
        }

        .error {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 15px;
        }

        button {
            background-color: #555;
            margin-top: 10px;
        }

        button:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <form action="../php/connexionadmin.php" method="post">
        <h2>Connexion Administrateur</h2>
        <?php if (isset($message) && $message): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <div class="input-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            <span class="icon">📧</span>
        </div>
        <div class="input-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <span class="icon">🔒</span>
        </div>
        <div>
            <input type="submit" value="Se connecter">
        </div>
    </form>
</body>
</html>
