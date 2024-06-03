<?php

//ouverture d'une connexion a la base de donnée mots meles
$objetPdo = new PDO('mysql:host=localhost:3307;dbname=mots_meles','root','');

$pdoStat = $objetPdo->prepare('SELECT * FROM topics WHERE id = :num');
$pdoStat->bindValue(':num', $_GET['numContact'], PDO::PARAM_INT);

//Execution de la requête
$executeIsOk = $pdoStat->execute();

//Récuperation des sujets
$topic = $pdoStat->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="icon" href="logo.png">
    <title>Modification</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Modifier le sujet</h1>

    <form action="modifier_topic.php" method="POST">
        <input type="hidden" name="numContact" value="<?= $topic['id'] ?>">
        <p>
            <label for="tipicName">Sujet :</label><br>
            <input required id="topicName" type="text" name="topicName" value="<?= $topic['topicName'];?>">
        </p>
        <p>
            <input class="btn" type="submit" value="Enregistrer">
        </p>
    </form>
</body>
</html>