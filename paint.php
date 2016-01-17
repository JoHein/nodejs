<?php
/**
 * Created by PhpStorm.
 * User: Fox
 * Date: 09/01/2016
 * Time: 15:06
 */
    // on démarre la session, si l'utilisateur n'est pas connecté alors on redirige vers la page main.php.
include('header.php');
    if(!isset($_SESSION['prenom'])) {
        header("Location: main.php");
    }

    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Pictionnary</title>
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <script>

        // les quatre tailles de pinceau possible.
        var sizes=[8,20,44,90];
        // la taille et la couleur du pinceau
        var size, color;
        // la dernière position du stylo
        var x0, y0;
        // le tableau de commandes de dessin à envoyer au serveur lors de la validation du dessin
        var drawingCommands = [];

        var setColor = function() {
            // on récupère la valeur du champs couleur
            color = document.getElementById('color').value;
            console.log("color:" + color);
        }

        var setSize = function() {
            // ici, récupèrez la taille dans le tableau de tailles, en fonction de la valeur choisie dans le champs taille.
            var indexSize=document.getElementById('size').value;
            size=sizes[indexSize];
            console.log("size:" + size);
        }

        window.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = 400;
            canvas.height = 400;
            var context = canvas.getContext('2d');
            setSize();
            setColor();

            document.getElementById('size').onchange = setSize;
            document.getElementById('color').onchange = setColor;

            var isDrawing = false;

            var clickX = new Array();
            var clickY = new Array();
            var clickDrag = new Array();

            function addClick(x, y, dragging)
            {
                clickX.push(x);
                clickY.push(y);
                clickDrag.push(dragging);
            }

            function redraw(){

                context.strokeStyle = color;
                context.lineJoin = "round";
                context.lineWidth = size;

                for(var i=0; i < clickX.length; i++) {
                    context.beginPath();
                    if(clickDrag[i] && i){
                        context.moveTo(clickX[i-1], clickY[i-1]);
                    }else{
                        context.moveTo(clickX[i]-1, clickY[i]);
                    }
                    context.lineTo(clickX[i], clickY[i]);
                    context.closePath();
                    context.stroke();
                }
            }

            var startDrawing = function(e) {
                console.log("start");
                // crér un nouvel objet qui représente une commande de type "start", avec la position, la couleur
                var command = {};
                command.command="start";
                command.x=e.pageX;
                command.y= e.pageY;
                command.size = size;
                command.color = color;
                command.drag= e.drag;


                // Ce genre d'objet Javascript simple est nommé JSON. Pour apprendre ce qu'est le JSON, c.f. http://blog.xebia.fr/2008/05/29/introduction-a-json/

                // on l'ajoute à la liste des commandes
                drawingCommands.push(command);

                // ici, dessinez un cercle de la bonne couleur, de la bonne taille, et au bon endroit.


                context.beginPath();

                addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
                redraw();

                    /*context.arc(mousePosX, mousePosY, 50, 0, 2 * Math.PI);
                    context.stroke();
    */

                isDrawing = true;
            }

            var stopDrawing = function(e) {
                console.log("stop");
                isDrawing = false;
            }

            var draw = function(e) {
                if(isDrawing) {
                    console.log("draw");
                    var command = {};
                    command.command="draw";
                    command.x=e.pageX;
                    command.y= e.pageY;
                    command.size = size;
                    command.color = color;
                    command.drag=true;
                    drawingCommands.push(command);

                    addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);

                    redraw();

                    // ici, créer un nouvel objet qui représente une commande de type "draw", avec la position, et l'ajouter à la liste des commandes.
                    // ici, dessinez un cercle de la bonne couleur, de la bonne taille, et au bon endroit.
                }
            }

            canvas.onmousedown = startDrawing;
            canvas.onmouseout = stopDrawing;
            canvas.onmouseup = stopDrawing;
            canvas.onmousemove = draw;

            document.getElementById('restart').onclick = function() {
                console.log("clear");
                // ici ajouter à la liste des commandes une nouvelle commande de type "clear"
                // ici, effacer le context, grace à la méthode clearRect.
                var command = {};
                command.command="clear";
                drawingCommands.push(command);
                clickX.length = 0;
                clickY.length = 0;
                clickDrag.length = 0;

                context.clearRect(0, 0, context.canvas.width, context.canvas.height);
            };

            document.getElementById('validate').onclick = function() {
                // la prochaine ligne transforme la liste de commandes en une chaîne de caractères, et l'ajoute en valeur au champs "drawingCommands" pour l'envoyer au serveur.
                document.getElementById('drawingCommands').value = JSON.stringify(drawingCommands);

                // ici, exportez le contenu du canvas dans un data url, et ajoutez le en valeur au champs "picture" pour l'envoyer au serveur.
                var dataurl = canvas.toDataURL(drawingCommands);
                document.getElementById("picture").value = dataurl;

            };
        };
    </script>
</head>
<body>
<section class="container">
<canvas id="myCanvas"></canvas>

<form name="tools" action="req_paint.php" method="post">
    <input type="range"  id="size" min="0" max="3" step="1" value="1"/>
    <input type="color"  id="color" value="<?php echo "#".$_SESSION['couleur'];?>">
    <!-- ici, insérez un champs de type range avec id="size", pour choisir un entier entre 0 et 4) -->
    <!-- ici, insérez un champs de type color avec id="color", et comme valeur l'attribut  de session couleur (à l'aide d'une commande php echo).) -->

    <input id="restart" type="button" value="Recommencer"/>
    <input type="hidden" id="drawingCommands" name="drawingCommands"/>
    <!-- à quoi servent ces champs hidden ? -->
    <input type="hidden" id="picture" name="picture"/>
    <input id="validate" type="submit" value="Valider"/>
</form>
</section>
</body>
</html>