<?php
session_start();
if(!isset($_SESSION['firstname'])){
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="button.css">
    <link rel="icon" href="logo.png">
    <title>Document</title>
</head>
<body onload="start()">
    <header>
        <button><a href="logout.php">Logout</a></button>
        <button><a href="lister_player.php">Liste player</a></button>
        <button><a href="topic.php">Topic</a></button>
        <button><a href="lister_topic.php">Liste topic</a></button>
    </header>
    <main>
        <h1>Welcome <?php echo $_SESSION['firstname']; ?></h1>
    </main>
    <footer>
    </footer>
</body>
</html>