<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="button.css">
    <link rel="icon" href="logo.png">
    <title>Login</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="firstname" placeholder="Firstname" required=""><br>
        <input type="password" name="mdp" placeholder="Password" required=""><br>
        <button type="submit" name="login_btn" value="Login">Login</button>
    </form>
<?php
include "config.php";
if(isset($_POST['login_btn'])){
    $firstname=$_POST['firstname'];
    $mdp=$_POST['mdp'];

    $select="SELECT * FROM players WHERE firstname='$firstname' && mdp='$mdp'";
    $query=mysqli_query($config,$select);
    $row=mysqli_num_rows($query);
    $fetch=mysqli_fetch_array($query);
    if($row==1){
        $firstname=$fetch['firstname'];
        session_start();
        $_SESSION['firstname']=$firstname;
        header('location:home.php');
    }else{
        echo "invalide firstname/password";
    }
}
?>
</body>
</html>