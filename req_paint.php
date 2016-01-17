<?php
/**
 * Created by PhpStorm.
 * User: Fox
 * Date: 10/01/2016
 * Time: 12:11
 */
session_start();
 $iduser=stripslashes($_SESSION['id']);
$drawingcommands=stripslashes($_POST['drawingCommands']);
 $picture=stripslashes($_POST['picture']);


    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');

    $sql = $dbh->prepare("INSERT INTO drawings (iduser, drawingcommands, picture) VALUES (:iduser, :drawingcommands, :picture)");
    $sql->bindValue(":iduser", $iduser);
    $sql->bindValue(":drawingcommands", $drawingcommands);
    $sql->bindValue(":picture", $picture);
    $sql->execute();

    header('Location:main.php');


