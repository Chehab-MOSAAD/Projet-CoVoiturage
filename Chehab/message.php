<?php
session_start();
// Connexion à la base de données
$host = "localhost";
$port = "5433";
$user = "postgres";
$password = "lilou";
$dbname = "CoVoiturage";
$connexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connexion) {
    die("Échec de la connexion: " . pg_last_error());
}

// Récupération des identifiants de l'expéditeur et du destinataire
$exp_id = 305; // ID de l'utilisateur connecté pour les tests
$dest_id = pg_escape_string($connexion, $_GET['dest_id']);

// Récupération des messages entre les deux utilisateurs
$messagesQuery = "SELECT exp_id, dest_id, message, date FROM messages 
                  WHERE (exp_id = $1 AND dest_id = $2) OR (exp_id = $2 AND dest_id = $1)
                  ORDER BY date ASC";
$messagesResult = pg_query_params($connexion, $messagesQuery, array($exp_id, $dest_id));

if (!$messagesResult) {
    die("Erreur lors de la récupération des messages: " . pg_last_error($connexion));
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion</title>
    <link rel="stylesheet" href="message.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h1>Discussion</h1>
        </div>
        <div class="chat-messages" id="chat-messages">
            <?php while ($row = pg_fetch_assoc($messagesResult)) : ?>
                <div class="message <?php echo $row['exp_id'] == $exp_id ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($row['message']); ?></p>
                    <span><?php echo htmlspecialchars($row['date']); ?></span>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="chat-input">
            <input type="text" id="message" placeholder="Écrire un message..." />
            <button id="send-button">Envoyer</button>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#send-button').click(function() {
            var message = $('#message').val();
            if (message.trim() !== '') {
                $.ajax({
                    type: 'POST',
                    url: 'send_message.php',
                    data: {
                        exp_id: <?php echo $exp_id; ?>,
                        dest_id: <?php echo json_encode($dest_id); ?>,
                        message: message
                    },
                    success: function(response) {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.status === 'success') {
                            var date = new Date();
                            var formattedDate = date.getFullYear() + '-' + 
                                               ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                                               ('0' + date.getDate()).slice(-2) + ' ' + 
                                               ('0' + date.getHours()).slice(-2) + ':' + 
                                               ('0' + date.getMinutes()).slice(-2) + ':' + 
                                               ('0' + date.getSeconds()).slice(-2);
                            $('#chat-messages').append('<div class="message sent"><p>' + message + '</p><span>' + formattedDate + '</span></div>');
                            $('#message').val('');
                            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                        } else {
                            alert(jsonResponse.message);
                        }
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
