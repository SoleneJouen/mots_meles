<?php

//ouverture d'une connexion a la base de donnée mots meles
$objetPdo = new PDO('mysql:host=db;dbname=mots_meles','solene','solene');

//Préparation de la requête
$pdoStat = $objetPdo->prepare('DELETE FROM topics WHERE id=:num LIMIT 1');

//Liaison du paramètre nommé
$pdoStat->bindValue(':num', $_GET['numContact'], PDO::PARAM_INT);

//execution de la requête
$executeIsOk = $pdoStat->execute();

if($executeIsOk){
    session_start();
    $_SESSION["message"] = 'Le thème a été supprimé';
    header('Location: http://localhost/mots_meles/mots_meles/lister_topic.php');
    die();
}else{
    $message = 'Échec de la suppression du thème';
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
    <link rel="icon" href="logo.png">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Suppression</h1>
    <p><?= $message ?></p>    
</body>
</html>