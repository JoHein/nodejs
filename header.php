<?php
/**
 * Created by PhpStorm.
 * User: johei
 * Date: 08/01/2016
 * Time: 10:37
 */
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Pictionnary - Inscription</title>
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <link rel="stylesheet" media="screen" href="css/bootstrap.css" >

</head>
<header>
    <a id="accueil" href="/Pictionnary/main.php">Accueil</a>
    <?php
    if(isset($_SESSION['prenom'])){


        $imgPic = $_SESSION['profilepic'];

        echo '<a id="logout" href="/Pictionnary/logout.php">LOGOUT</a>';
        echo "<img src='$imgPic' title='image profil'/>";

        echo "<p>Bonjour ".$_SESSION['prenom'] ."</p>" ;
    }else{
        ?>
        <a id="register" href="/register">Register</a>

        <form action="req_login.php" method="post" name="connexion">
            <input type="text" name="email" id="email" placeholder="Email">
            <input type="password" name="password" id="password" placeholder="Mot de passe">
            <input id="loginButton" type="submit" value="login">
        </form>

    <?php
    }
?>
</br>
    <h5 style="color: red;">
    <?=(isset($_GET['badlogin'])?$_GET['badlogin']:'')?>
    </h5>
</header>
<body>

</body>
</html>
