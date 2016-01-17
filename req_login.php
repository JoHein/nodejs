<?php
/**
 * Created by PhpStorm.
 * User: Fox
 * Date: 09/01/2016
 * Time: 14:30
 */
session_start();

if(empty($_POST['email']) || empty($_POST['password']))
{
    echo "Email ou password incorrect";
}
else{

    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');

    $email=$_POST['email'];
    $password=$_POST['password'];

        $q= "SELECT email, password FROM users WHERE email = '$email' and password = '$password'";

        try {
            $r =  $dbh->query($q);

            $res= $r->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("PDO Error :".$e->getMessage());
        }

        if (sizeof($res)==0) {


            header("Location:main.php?badlogin=".urlencode("Pas le bon login ou mot de passe"));

        }else{
            $sql = $dbh->query("SELECT u.id, u.email, u.nom, u.prenom, u.couleur, u.profilepic FROM USERS u WHERE u.email='".$email."'");
                $user=$sql->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id']=$user['id'];
                $_SESSION['email']=$user['email'];
                $_SESSION['nom']=$user['nom'];
                $_SESSION['prenom']=$user['prenom'];
                $_SESSION['couleur']=$user['couleur'];
                $_SESSION['profilepic']=$user['profilepic'];

            header("Location:main.php");
        }

}

