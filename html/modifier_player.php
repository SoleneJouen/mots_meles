<?php

//ouverture d'une connexion a la base de donnée mots meles
$objetPdo = new PDO('mysql:host=db;dbname=mots_meles','solene','solene');

//Préparation de la requête
$pdoStat = $objetPdo->prepare('UPDATE players set lastname=:lastname, firstname=:firstname, age=:age, mdp=:mdp WHERE id=:num LIMIT 1');

//Liaison du paramètre nommé
$pdoStat->bindValue(':num', $_POST['numContact'], PDO::PARAM_INT);
$pdoStat->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
$pdoStat->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
$pdoStat->bindValue(':age', $_POST['age'], PDO::PARAM_STR);
$pdoStat->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);

//ecution de la requête
$executeIsOk = $pdoStat->execute();

if( $executeIsOk ){
    session_start();
    $_SESSION["message"] = 'Le joueur a été mis à jour';
    header('Location: http://localhost/mots_meles/mots_meles/lister_player.php');
    die();
}else{
    $message = 'Échec de la mise à jour du joueur';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="logo.png">
    <title>Résultat modif</title>
</head>
<body>
    <h1>Résultat de la modification</h1>
    <p><?= $message ?></p>
</body>
</html>