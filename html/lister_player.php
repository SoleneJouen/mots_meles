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
$pdoStat = $objetPdo->prepare('SELECT * FROM players');

//Execution de la requête
$executeIsOk = $pdoStat->execute();

//Récupération des résultats
$contacts = $pdoStat->fetchAll();
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
    <h1>Liste des joueurs</h1>
    <ul>
        <?php foreach($contacts as $contact): ?>
            <table>
            <tr>
                <td><?= $contact['lastname'] ?></td>
                <td><?= $contact['firstname'] ?></td>
                <td><?= $contact['age'] ?>ans</td>
                <td><button><a href="supprimer_player.php?numContact=<?= $contact['id'] ?>">Supprimer</a></button></td>
                <td><button><a href="modification_player.php?numContact=<?= $contact['id'] ?>">Modifier</a></button></td>
            </tr>
            </table>
        <?php endforeach ?>
    </ul>

</body>
</html>