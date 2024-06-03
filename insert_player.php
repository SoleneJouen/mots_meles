<?php

//ouverture d'une connexion a la base de donnée contact
$objetPdo = new PDO('mysql:host=localhost:3307;dbname=mots_meles','root','');

//Préparation de la requête d'insertion (SQL)
$pdoStat = $objetPdo->prepare('INSERT INTO players VALUES(NULL, :lastname, :firstname, :age, :mdp)');

// //On lie chaque marqueur à une valeur
$pdoStat->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
$pdoStat->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
$pdoStat->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
$pdoStat->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);

//Éxecution de la requête préparée
$insertIsOk = $pdoStat->execute();

if( $insertIsOk ){
    session_start();
    $_SESSION["message"] = 'Le joueur a été ajouté dans la bdd';
    header("Location: http://localhost/mots_meles/mots_meles/player.php");
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
    <h1>Insertion des joueurs</h1>
    <p><?php echo $message; ?></p>
</body>
</html>