<?php
// update_user.php: Gère la mise à jour des informations utilisateur

// Démarrer la session pour gérer l'authentification de l'utilisateur et autres données de session
session_start();

// Connexion à la base de données
require 'db.php'; // Assurez-vous que vos paramètres de connexion à la base de données sont corrects dans ce fichier

// Initialisation du message
$message = '';

// Définir l'ID utilisateur par défaut pour les tests
$idUtilisateur = 7;

// Charger les données de l'utilisateur s'il n'y a pas de requête POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    if ($idUtilisateur) {
        $query = $db->prepare("SELECT * FROM Utilisateur WHERE IdUtilisateur = ?");
        $query->execute([$idUtilisateur]);
        $userData = $query->fetch(PDO::FETCH_ASSOC);
        if (!$userData) {
            $message = "Utilisateur non trouvé.";
        }
    } 
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    // Récupération de l'ID utilisateur depuis le formulaire
    $idUtilisateur = (int)$_POST['id_utilisateur'];

    // Récupération et nettoyage des données depuis la requête POST
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $tel = filter_var($_POST['tel'], FILTER_SANITIZE_STRING);
    $langue1 = filter_var($_POST['langue1'], FILTER_SANITIZE_STRING);
    $langue2 = filter_var($_POST['langue2'], FILTER_SANITIZE_STRING);
    $sexe = isset($_POST['sexe']) ? $_POST['sexe'] : 'M';
    $handicap = isset($_POST['handicap']) ? true : false;
    $fumeur = isset($_POST['fumeur']) ? true : false;
    $jour = (int)$_POST['jour'];
    $mois = (int)$_POST['mois'];
    $annee = (int)$_POST['annee'];

    // Initialisation du tableau pour les requêtes
    $queries = [];
    $params = [];

    // Validation des données et préparation des requêtes
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Adresse email invalide.";
    } elseif (!preg_match('/^0[0-9]{9}$/', $tel)) {
        $message = "Le numéro de téléphone doit commencer par un '0' et contenir 10 chiffres.";
    } elseif (strlen($prenom) == 0 || !preg_match('/^[A-Za-z]+$/', $prenom)) {
        $message = "Prénom invalide.";
    } elseif (strlen($nom) == 0 || !preg_match('/^[A-Za-z]+$/', $nom)) {
        $message = "Nom invalide.";
    } else {
        // Ajout des requêtes de mise à jour individuelles
        if ($prenom !== $userData['Prenom']) {
            $queries[] = "UPDATE Utilisateur SET Prenom = ? WHERE IdUtilisateur = ?";
            $params[] = [$prenom, $idUtilisateur];
        }
        if ($nom !== $userData['Nom']) {
            $queries[] = "UPDATE Utilisateur SET Nom = ? WHERE IdUtilisateur = ?";
            $params[] = [$nom, $idUtilisateur];
        }
        if ($sexe !== $userData['Sexe']) {
            $queries[] = "UPDATE Utilisateur SET Sexe = ? WHERE IdUtilisateur = ?";
            $params[] = [$sexe, $idUtilisateur];
        }
        if ($tel !== $userData['Tel']) {
            $queries[] = "UPDATE Utilisateur SET Tel = ? WHERE IdUtilisateur = ?";
            $params[] = [$tel, $idUtilisateur];
        }
        if ($handicap != $userData['Handicap']) {
            $queries[] = "UPDATE Utilisateur SET Handicap = ? WHERE IdUtilisateur = ?";
            $params[] = [(int)$handicap, $idUtilisateur];
        }
        if ($langue1 !== $userData['LangueParle1']) {
            $queries[] = "UPDATE Utilisateur SET LangueParle1 = ? WHERE IdUtilisateur = ?";
            $params[] = [$langue1, $idUtilisateur];
        }
        if ($langue2 !== $userData['LangueParle2']) {
            $queries[] = "UPDATE Utilisateur SET LangueParle2 = ? WHERE IdUtilisateur = ?";
            $params[] = [$langue2, $idUtilisateur];
        }
        if ($fumeur != $userData['Fumeur']) {
            $queries[] = "UPDATE Utilisateur SET Fumeur = ? WHERE IdUtilisateur = ?";
            $params[] = [(int)$fumeur, $idUtilisateur];
        }
        if ($jour !== $userData['Jour']) {
            $queries[] = "UPDATE Utilisateur SET Jour = ? WHERE IdUtilisateur = ?";
            $params[] = [$jour, $idUtilisateur];
        }
        if ($mois !== $userData['Mois']) {
            $queries[] = "UPDATE Utilisateur SET Mois = ? WHERE IdUtilisateur = ?";
            $params[] = [$mois, $idUtilisateur];
        }
        if ($annee !== $userData['Annee']) {
            $queries[] = "UPDATE Utilisateur SET Annee = ? WHERE IdUtilisateur = ?";
            $params[] = [$annee, $idUtilisateur];
        }

        // Exécution des requêtes
        foreach ($queries as $index => $query) {
            $stmt = $db->prepare($query);
            if ($stmt === false) {
                $message = "Erreur de préparation de la requête pour $query.";
                break;
            } else {
                $executed = $stmt->execute($params[$index]);
                if (!$executed) {
                    $errorInfo = $stmt->errorInfo();
                    $message = "Erreur lors de la mise à jour des informations pour $query: " . $errorInfo[2];
                    break;
                }
            }
        }

        // Vérifie si toutes les requêtes ont été exécutées avec succès
        if (empty($message)) {
            $message = "Informations mises à jour avec succès.";
        }

        // Recharger les données mises à jour pour les afficher dans le formulaire
        $query = $db->prepare("SELECT * FROM Utilisateur WHERE IdUtilisateur = ?");
        $query->execute([$idUtilisateur]);
        $userData = $query->fetch(PDO::FETCH_ASSOC);
    }
}

// Inclure le formulaire de mise à jour
include "../style/mettre_a_jours_form.php";
?>
