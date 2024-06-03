<?php

//ouverture d'une connexion a la base de donnée contact
$objetPdo = new PDO('mysql:host=db;dbname=mots_meles','solene','solene');
//Préparation de la requête d'insertion (SQL)
$pdoStat = $objetPdo->prepare('INSERT INTO topics VALUES(NULL, :topicName)');

// //On lie chaque marqueur à une valeur
$pdoStat->bindValue(':topicName', $_POST['topicName'], PDO::PARAM_STR);

//Éxecution de la requête préparée
$insertIsOk = $pdoStat->execute();

if( $insertIsOk ){
    session_start();
    $_SESSION["message"] = 'Le sujet a été ajouté dans la bdd';
    header("Location: http://localhost/mots_meles/mots_meles/topic.php");
    die();
}else{
    $message = 'Échec de l\ajout';
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
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    <h1>Insertion des sujets</h1>
    <p><?php echo $message; ?></p>
</body>
</html>