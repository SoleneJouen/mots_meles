<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="button.css">
    <title>Document</title>
</head>
<body>
    <h1>Ajouter un sujet</h1>
    <form action="insert_topic.php" method="POST">
        <p>
            <label for="tipicName">Sujet :</label><br>
            <input required id="topicName" type="text" name="topicName">
        </p>
        <p>
            <button type="submit" value="Enregistrer">Enregistrer</button>
        </p>
    </form>

<?php
    session_start();
    if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) {
    echo $_SESSION["message"];
    $_SESSION["message"] = "";
}
?>
</body>
</html>