<?php
require 'db.php'; // Inclut et exécute le script de connexion

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assainissement des entrées
    $nom = isset($_POST["nom"]) ? trim($_POST["nom"]) : '';
    $prenom = isset($_POST["prenom"]) ? trim($_POST["prenom"]) : '';
    $sexe = isset($_POST["sexe"]) ? trim($_POST["sexe"]) : '';
    $tel = isset($_POST["tel"]) ? trim($_POST["tel"]) : '';
    $handicap = isset($_POST["handicap"]) ? (trim($_POST["handicap"]) == 'oui' ? true : false) : false;
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : '';

    // Préparation de la requête d'insertion
    $sql = "INSERT INTO users (nom, prenom, sexe, tel, handicap, email, password) VALUES (:nom, :prenom, :sexe, :tel, :handicap, :email, :password)";
    $stmt = $db->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':sexe', $sexe);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':handicap', $handicap, PDO::PARAM_BOOL);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    // Exécution de la requête
    try {
        $stmt->execute();
        $message = "Nouveau profil créé avec succès! Vous pouvez maintenant vous <a href='login.php'>connecter</a>.";
    } catch (PDOException $e) {
        $message = "Erreur lors de l'inscription: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un profil utilisateur</title>
</head>
<body>
    <h1>Créer un nouveau profil</h1>
    <?php if (!empty($message)): ?>
        <p><?= $message; ?></p>
    <?php endif; ?>
    <form action="create_profile.php" method="post">
        <div>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="sexe">Sexe:</label>
            <select id="sexe" name="sexe" required>
                <option value="M">M</option>
                <option value="F">F</option>
                <option value="O">O</option>
            </select>
        </div>
        <div>
            <label for="tel">Téléphone:</label>
            <input type="text" id="tel" name="tel">
        </div>
        <div>
            <label for="handicap">Handicap:</label>
            <select id="handicap" name="handicap" required>
                <option value="non">Non</option>
                <option value="oui">Oui</option>
            </select>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="Créer le profil">
        </div>
    </form>
</body>
</html>
