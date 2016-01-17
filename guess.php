<?php
include('header.php');

    if(!isset($_SESSION['id'])) {
        header("Location: main.php");
    } else {
        $idpic=$_GET['idpic'];
        $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');
        $sql = $dbh->query("SELECT drawingcommands FROM drawings  WHERE idpic='".$idpic."'");
        $res= $sql->fetchAll(PDO::FETCH_ASSOC);

        $commands=$res[0]['drawingcommands'];
        // ici, récupérer la liste des commandes dans la table DRAWINGS avec l'identifiant $_GET['id']
        // l'enregistrer dans la variable $commands


    }
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Pictionnary</title>
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <script>
        // la taille et la couleur du pinceau
        var size, color;
        // la dernière position du stylo
        var x0, y0;
        // le tableau de commandes de dessin à envoyer au serveur lors de la validation du dessin
        var drawingCommands = <?php echo $commands; ?>;
        console.log(drawingCommands);
        window.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = 400;
            canvas.height= 400;
            var context = canvas.getContext('2d');

            var start = function(c) {
                // complétez
                context.beginPath();
                context.moveTo(c.x - this.offsetLeft, c.y - this.offsetTop);
                context.lineTo(c.x-100, c.y-100);
                context.closePath();
                context.stroke();


            }
            var draw = function(c) {

                     // complétez
                context.strokeStyle = c.color;
                context.lineJoin = "round";
                context.lineWidth = c.size;

                context.beginPath();
                context.moveTo(c.x - this.offsetLeft, c.y - this.offsetTop);
                context.lineTo(c.x-100, c.y-100);
                context.closePath();
                context.stroke();

                    }

            var clear = function() {
               context.clearRect(0, 0, context.canvas.width, context.canvas.height);
            }


            // étudiez ce bout de code
            var i = 0;
            var iterate = function() {
                if(i>=drawingCommands.length)
                    return;
                var c = drawingCommands[i];
                console.log(c.command);
                switch(c.command) {
                    case "start":
                        start(c);
                        break;
                    case "draw":
                        draw(c);
                        break;
                    case "clear":
                        clear();
                        break;
                    default:
                        console.error("cette commande n'existe pas "+ c.command);
                }
                i++;
                setTimeout(iterate,30);
            };

            iterate();

        };

    </script>
</head>
<body>
<section class="container">

<canvas id="myCanvas"></canvas>
    </section>
</body>
</html>