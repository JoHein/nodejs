<?php
/**
 * Created by PhpStorm.
 * User: Fox
 * Date: 09/01/2016
 * Time: 14:37
 */

include('header.php');
?>

<div>
    <h4>Vous devez vous identifer pour jouer!</h4>
    <a href="/Pictionnary/inscription.php">Inscription</a>
    <a href="/Pictionnary/paint.php">Jouer!</a>
</div>
<?php    if(isset($_SESSION['prenom'])){ ?>

<aside>
    <h3>Vos dessins: </h3>

    <?php
    $iduser=$_SESSION['id'];
    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');
    $sql = $dbh->query("SELECT idpic FROM drawings  WHERE iduser='".$iduser."'");
    $res= $sql->fetchAll(PDO::FETCH_ASSOC);
    $taille=sizeof($res);
    for($i=0; $i<$taille;$i++){
        $idpic= $res[$i]['idpic'];
        ?>
         <a href="guess.php?idpic=<?= urlencode($idpic)?>">Picture <?= $i+1 ?></a>
    <?php
    }
    }
    ?>
</aside>