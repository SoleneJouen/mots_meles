<?php 
session_start();
if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) {
    echo $_SESSION["message"];
    $_SESSION["message"] = "";
}
?>

<?php

//ouverture d'une connexion a la base de donnée mots meles
$objetPdo = new PDO('mysql:host=db;dbname=mots_meles','solene','solene');

//Préparation de la requête
$pdoStat = $objetPdo->prepare('SELECT * FROM topics');

//Execution de la requête
$executeIsOk = $pdoStat->execute();

//Récupération des résultats
$topics = $pdoStat->fetchAll();
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
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="button.css">
</head>
<body>
    <h1>Liste des sujets</h1>
    <ul>
        <?php foreach($topics as $topic): ?>
            <li>
                <?= $topic['topicName'] ?>
                <button><a href="supprimer_topic.php?numContact=<?= $topic['id'] ?>">Supprimer</a></button>
                <button><a href="modification_topic.php?numContact=<?= $topic['id'] ?>">Modifier</a></button>
            </li>
        <?php endforeach ?>
    </ul>
</body>
</html>