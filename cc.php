<?php
session_start();

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=mm', 'root', 'azertyuiop123456789?!*');

// Fonction pour récupérer un thème aléatoire depuis la base de données
function getThemeAleatoire($pdo) {
    $query = $pdo->query('SELECT nom_theme FROM themes ORDER BY RAND() LIMIT 1');
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['nom_theme'];
}

// Fonction pour récupérer un mot aléatoire depuis la base de données en fonction du thème
function getMotsDuTheme($pdo, $theme) {
    $query = $pdo->prepare('SELECT mot FROM mots_meles WHERE id_theme = (SELECT id FROM themes WHERE nom_theme = ?)');
    $query->execute([$theme]);
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
if (!isset($_SESSION['theme']) || !isset($_SESSION['mots']) || !isset($_SESSION['mots_trouves'])) {
    $_SESSION['theme'] = getThemeAleatoire($pdo);
    $_SESSION['mots'] = getMotsDuTheme($pdo, $_SESSION['theme']);
    $_SESSION['mots_trouves'] = [];
}

$theme = $_SESSION['theme'];
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
    $_SESSION['theme'] = getThemeAleatoire($pdo);
    $_SESSION['mots'] = getMotsDuTheme($pdo, $_SESSION['theme']);
    $_SESSION['mots_trouves'] = [];
    $theme = $_SESSION['theme'];
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
    <title>Jeu de Mots Mêlés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
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
<body>
    <h1>Jeu de Mots Mêlés</h1>
    <h2>Thème : <?php echo $theme; ?></h2>
    <h3>Trouvez les mots dans la grille ci-dessous :</h3>
    <?php afficherGrille($grille); ?>
    <form action="cc.php" method="post">
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
</body>
</html>