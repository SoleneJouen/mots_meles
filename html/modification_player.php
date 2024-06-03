<?php

//ouverture d'une connexion a la base de donnée mots meles
$objetPdo = new PDO('mysql:host=db;dbname=mots_meles','solene','solene');

$pdoStat = $objetPdo->prepare('SELECT * FROM players WHERE id = :num');
$pdoStat->bindValue(':num', $_GET['numContact'], PDO::PARAM_INT);

//Execution de la requête
$executeIsOk = $pdoStat->execute();

//Récuperation des players
$player = $pdoStat->fetch();
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
    <h1>Modifier le joueur</h1>

    <form action="modifier_player.php" method="POST">
        <input type="hidden" name="numContact" value="<?= $player['id'] ?>">
        <p>
            <label for="lastname">Nom :</label>
            <input required id="lastname" type="text" name="lastname" value="<?= $player['lastname'];?>">
        </p>
        <p>
            <label for="firstname">Prénom :</label>
            <input required id="firstname" type="text" name="firstname" value="<?= $player['firstname'];?>">
        </p>
        <p>
            <label for="age">Age :</label>
            <input required id="age" type="text" name="age" value="<?= $player['age'];?>">
        </p>
        <p>
            <label for="mdp">Mot de passe :</label>
            <input required id="mdp" type="password" name="mdp" value="<?= $player['mdp'];?>">
        </p>
        <p>
            <input type="submit" value="Enregistrer les modifications">
        </p>
    </form>  
</body>
</html>