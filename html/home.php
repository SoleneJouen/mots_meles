<?php
session_start();
if(!isset($_SESSION['firstname'])){
    header('location: login.php');
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=db;dbname=mots_meles','solene','solene');


// Fonction pour récupérer un thème aléatoire depuis la base de données
function getThemeAleatoire($pdo) {
    $query = $pdo->query('SELECT topicName FROM topics ORDER BY RAND() LIMIT 1');
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['topicName'];
}

// Fonction pour récupérer un mot aléatoire depuis la base de données en fonction du thème
function getMotsDuTheme($pdo, $topics) {
    $query = $pdo->prepare('SELECT word FROM words WHERE id_topic = (SELECT id FROM topics WHERE topicName = ?)');
    $query->execute([$topics]);
    $result = $query->fetchAll(PDO::FETCH_COLUMN);
    return $result;
}

// Génère la grille de lettres
function genererGrille($mots) {
    $grille = [];
    $tailleGrille = 10;
    $alphabet = range('A', 'Z');

    // Remplir la grille avec des lettres aléatoires
    for ($i = 0; $i < $tailleGrille; $i++) {
        for ($j = 0; $j < $tailleGrille; $j++) {
            $grille[$i][$j] = $alphabet[rand(0, 25)];
        }
    }

    // Placez les mots dans la grille
    foreach ($mots as $mot) {
        placerMotDansGrille($mot, $grille);
    }

    return $grille;
}

// Place un mot dans la grille de manière aléatoire
function placerMotDansGrille($mot, &$grille) {
    $tailleGrille = count($grille);
    $motLen = strlen($mot);
    $alphabet = range('A', 'Z');

    // Définir la direction de placement du mot : 0 pour horizontal, 1 pour vertical, 2 pour diagonale
    $direction = rand(0, 2);
    // Définir la position de départ du mot
    $x = rand(0, $tailleGrille - 1);
    $y = rand(0, $tailleGrille - 1);
    // Définir si le mot sera inversé
    $reverse = rand(0, 1);

    // Placez le mot dans la grille selon la direction
    switch ($direction) {
        case 0: // Horizontal
            if ($x + $motLen > $tailleGrille) {
                break;
            }
            for ($j = 0; $j < $motLen; $j++) {
                if ($grille[$x + $j][$y] != "" && $grille[$x + $j][$y] != $mot[$j]) {
                    break;
                }
            }
            // Placez le mot dans la grille
            for ($j = 0; $j < $motLen; $j++) {
                if ($reverse) {
                    $grille[$x + $j][$y] = $mot[$motLen - $j - 1];
                } else {
                    $grille[$x + $j][$y] = $mot[$j];
                }
            }
            return; // Le mot a été placé avec succès

        case 1: // Vertical
            if ($y + $motLen > $tailleGrille) {
                break;
            }
            for ($j = 0; $j < $motLen; $j++) {
                if ($grille[$x][$y + $j] != "" && $grille[$x][$y + $j] != $mot[$j]) {
                    break;
                }
            }
            // Placez le mot dans la grille
            for ($j = 0; $j < $motLen; $j++) {
                if ($reverse) {
                    $grille[$x][$y + $j] = $mot[$motLen - $j - 1];
                } else {
                    $grille[$x][$y + $j] = $mot[$j];
                }
            }
            return; // Le mot a été placé avec succès

        case 2: // Diagonale
            if ($x + $motLen > $tailleGrille || $y + $motLen > $tailleGrille) {
                break;
            }
            for ($j = 0; $j < $motLen; $j++) {
                if ($grille[$x + $j][$y + $j] != "" && $grille[$x + $j][$y + $j] != $mot[$j]) {
                    break;
                }
            }
            // Placez le mot dans la grille
            for ($j = 0; $j < $motLen; $j++) {
                if ($reverse) {
                    $grille[$x + $j][$y + $j] = $mot[$motLen - $j - 1];
                } else {
                    $grille[$x + $j][$y + $j] = $mot[$j];
                }
            }
            return; // Le mot a été placé avec succès
    }
}

// Affiche la grille de lettres
function afficherGrille($grille) {
    echo '<table class="grille">';
    foreach ($grille as $ligne) {
        echo '<tr>';
        foreach ($ligne as $lettre) {
            echo '<td>' . $lettre . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

// Vérifie si tous les mots du thème ont été trouvés
function tousMotsTrouves($motsTheme, $motsTrouves) {
    return count(array_diff($motsTheme, $motsTrouves)) == 0;
}

// Code principal
if (!isset($_SESSION['topics']) || !isset($_SESSION['mots']) || !isset($_SESSION['mots_trouves'])) {
    $_SESSION['topics'] = getThemeAleatoire($pdo);
    $_SESSION['mots'] = getMotsDuTheme($pdo, $_SESSION['topics']);
    $_SESSION['mots_trouves'] = [];
}

$topics = $_SESSION['topics'];
$motsTheme = $_SESSION['mots'];
$motsTrouves = $_SESSION['mots_trouves'];

if (isset($_POST['mot'])) {
    $motJoueur = strtoupper($_POST['mot']);
    if (in_array($motJoueur, $motsTheme) && !in_array($motJoueur, $motsTrouves)) {
        array_push($motsTrouves, $motJoueur);
        $_SESSION['mots_trouves'] = $motsTrouves;
    }
}

if (tousMotsTrouves($motsTheme, $motsTrouves)) {
    // Tous les mots du thème ont été trouvés, régénérer la grille avec de nouveaux mots
    $_SESSION['topics'] = getThemeAleatoire($pdo);
    $_SESSION['mots'] = getMotsDuTheme($pdo, $_SESSION['topics']);
    $_SESSION['mots_trouves'] = [];
    $topics = $_SESSION['topics'];
    $motsTheme = $_SESSION['mots'];
    $motsTrouves = $_SESSION['mots_trouves'];
}

$grille = genererGrille($motsTheme);
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
    <style>
        .grille {
            border-collapse: collapse;
            margin: 20px auto;
        }
        .grille td {
            width: 30px;
            height: 30px;
            border: 1px solid #000000;
            text-align: center;
            font-size: 20px;
            font-family: Arial, sans-serif;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .mots-trouves {
            margin-top: 20px;
        }
    </style>
</head>
<body onload="start()">
    <header>
        <button><a href="logout.php">Logout</a></button>
        <button><a href="lister_player.php">Liste player</a></button>
        <button><a href="topic.php">Topic</a></button>
        <button><a href="lister_topic.php">Liste topic</a></button>
    </header>
    <main>
        <h1>Bienvenue sur Mots Mêlés <?php echo $_SESSION['firstname']; ?></h1>
        <h2>Thème : <?php echo $topics; ?></h2>
        <h3>Trouvez les mots dans la grille ci-dessous :</h3>

        <?php afficherGrille($grille); ?>
        <form action="home.php" method="post">
            <label for="mot">Entrez un mot trouvé :</label>
            <input type="text" id="mot" name="mot" maxlength="10">
            <input type="submit" value="Vérifier">
        </form>
        <div class="mots-trouves">
            <h3>Mots trouvés :</h3>
            <ul>
                <?php foreach ($motsTrouves as $mot) {
                    echo "<li style='color: green;'>$mot</li>";
                } ?>
            </ul>
        </div>

    </main>
    <footer>
    </footer>
</body>
</html>