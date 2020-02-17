<?php // explore.php :: Déplacements et actions en cours "Actuellement".

function move() {
    
    global $userrow, $controlrow;
    
    if ($userrow["currentaction"] == "En combat") { header("Location: index.php?do=fight"); die(); }
	
    $latitude = $userrow["latitude"];
    $longitude = $userrow["longitude"];
    if (isset($_POST["north_x"])) { $latitude++; if ($latitude > $controlrow["gamesize"]) { $latitude = $controlrow["gamesize"]; } }
    if (isset($_POST["south_x"])) { $latitude--; if ($latitude < ($controlrow["gamesize"]*-1)) { $latitude = ($controlrow["gamesize"]*-1); } }
    if (isset($_POST["east_x"])) { $longitude++; if ($longitude > $controlrow["gamesize"]) { $longitude = $controlrow["gamesize"]; } }
    if (isset($_POST["west_x"])) { $longitude--; if ($longitude < ($controlrow["gamesize"]*-1)) { $longitude = ($controlrow["gamesize"]*-1); } }
    
    $townquery = doquery("SELECT id FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "towns");
    if (mysql_num_rows($townquery) > 0) {
        $townrow = mysql_fetch_array($townquery);
        include('towns.php');
        travelto($townrow["id"], false);
        die();
    }
	
	$homequery = doquery("SELECT id FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "maison");
    if (mysql_num_rows($homequery) > 0) {
        $homerow = mysql_fetch_array($homequery);
        include('home.php');
        travelto($homerow["id"], false);
        die();
    }
	
	$solquery = doquery("SELECT id FROM {{table}} WHERE nom='arbre' AND lati='$latitude' AND longi='$longitude' LIMIT 1", "sol");
	if (mysql_num_rows($solquery) > 0) {
	$page = " Vous ne pouvez pas continuer dans cette direction!<br>Utilisez les touches de navigation pour repartir a l 'aventure.<br></center><a href='index.php'> Revenir en arriere</a></table>";
	display($page, "Passage fermer"); 
	die();
	}

	$solquery = doquery("SELECT id FROM {{table}} WHERE nom='mer' AND lati='$latitude' AND longi='$longitude' LIMIT 1", "sol");
	if (mysql_num_rows($solquery) > 0) {
	$page = " Vous ne pouvez pas continuer dans cette direction!<br>Utilisez les touches de navigation pour repartir a l 'aventure.<br></center><a href='index.php'> Revenir en arriere</a></table>";
	display($page, "Passage fermer"); 
	die();
	} 
	
	//AJOUT QUETE TYPE RECHERCHE (2) : Trouver un endroit
	$requete=mysql_query("select quete from rpg_users where id='".$userrow["id"]."'");
	while($row=mysql_fetch_array($requete)) {$quete_en_cours=$row[0];}
	if($quete_en_cours>0)
	{
	$requete=mysql_query("select * from rpg_quete WHERE id='$quete_en_cours'");
	while($row=mysql_fetch_array($requete)) 
	{
	if($row[4] == '2') //C bien une quete de recherche
	{
	//On verifie si on est au bon endroit
	if($latitude==$row[8] AND $longitude==$row[7])
	{
	$page = "Vous avez résolu la quête nommée $row[1] ! Félicitation. Vous gagnez :<br>";
	$page .= "$row[10] points d'Expérience et $row[11] Gils !";
	$requete1=mysql_query("SELECT listquest FROM rpg_users WHERE id='".$userrow["id"]."'");
	while($reque=mysql_fetch_array($requete1)) {$prev=$reque[0]; }
	mysql_query("UPDATE rpg_users SET experience=experience+$row[10], gold=gold+$row[11], quete='0',listquest='" . $prev ."," .$quete_en_cours ."' WHERE id='".$userrow["id"]."'");
	display($page, "Quête Résolue");
	die();
	}
	}
	}
	}
	//FIN AJOUT

    $chancetofight = rand(1,5);
    if ($chancetofight == 1) { 
        $action = "currentaction='En combat', currentfight='1',";
    } else {
        $action = "currentaction='En exploration',";
    }

    
    $updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
    header("Location: index.php");

    
}

Function cherche() {

global $userrow;

if ($userrow["itemsac3qt"] < 1 ) { display("<br><center>Vous n'avez plus de Pioches, retournez en acheter en Ville pour pouvoir creuser.</center><br><br>
<center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>", "Chercher"); die(); }
if ($userrow["currenttp"] < 10 ) { display("<br><center>Vous etez trop fatigués pour continuer, rentrez vous reposer.....</center><br><br>
<center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>", "Chercher"); die(); }

$latitude = $userrow["latitude"];
$longitude = $userrow["longitude"];
$action = "currentaction='En exploration',";
$pioche = $userrow["itemsac3qt"] - 1;
$chancetrouve = rand(1,25);
$nbrobj = rand(1,2);
if ($chancetrouve == 1 || $chancetrouve == 2 || $chancetrouve == 3 || $chancetrouve == 4 || $chancetrouve == 5) {
doquery("UPDATE {{table}} SET itemsac3qt=itemsac3qt-1, currenttp=currenttp-10, cuivre=cuivre+$nbrobj WHERE id=".$userrow["id"], "users"); // Mise a jour de la variable cuivre.
doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); // Update position.
$page = "<br><br> Vos efforts sont récompensés. En creusant vous venez de trouvez $nbrobj Minerais de Cuivre!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>"; // Output

display($page, "Vous venez de trouver du cuivre!");
die();

} else if ($chancetrouve == 6 || $chancetrouve == 7 || $chancetrouve == 8 || $chancetrouve == 9 ) {
doquery("UPDATE {{table}} SET itemsac3qt=itemsac3qt-1, currenttp=currenttp-10, fer=fer+$nbrobj WHERE id=".$userrow["id"], "users"); // Mise a jour de la variable fer.
doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); // Update position.
$page = "<br><br> Vos efforts sont récompensés. En creusant vous venez de trouvez $nbrobj Minerais de Fer!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>"; // Output

display($page, "Vous venez de trouver du fer!");
die();

} else if ($chancetrouve == 10 || $chancetrouve == 11 || $chancetrouve == 12 ) {
doquery("UPDATE {{table}} SET itemsac3qt=itemsac3qt-1, currenttp=currenttp-10, argent=argent+$nbrobj WHERE id=".$userrow["id"], "users"); // Mise a jour de la variable argent.
doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); // Update position.
$page = "<br><br> Vos efforts sont récompensés. En creusant vous venez de trouvez $nbrobj Minerais d'argent!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>"; // Output

display($page, "Vous venez de trouver de l'argent!");
die();

} else if ($chancetrouve == 15 ) {
doquery("UPDATE {{table}} SET itemsac3qt=itemsac3qt-1, currenttp=currenttp-10, platine=platine+$nbrobj WHERE id=".$userrow["id"], "users"); // Mise a jour de la variable bronze.
doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); // Update position.
$page = "<br><br> Vos efforts sont récompensés. En creusant vous venez de trouvez $nbrobj Platine!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>"; // Output

display($page, "Vous venez de trouver du Platine!");
die();
} else {
display("<br><br> Désolé, vous ne trouvez rien!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>", "Chercher"); die(); }

$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
header("Location: index.php");

}


function potionsoins() {

global $userrow;

if ($userrow["itemsac1qt"] < 1 ) { display("<br><center>Vous n'avez plus de potions de soins , retournez en acheter en Ville pour pouvoir vous soigner.</center><br><br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>", "Chercher"); die(); }

$latitude = $userrow["latitude"];
$longitude = $userrow["longitude"];
$action = "currentaction='En exploration',";
$potion = $userrow["maxhp"] / 2;

$newhp = $userrow["currenthp"] + $potion;
if ($userrow["maxhp"] < $newhp) { $potion = $userrow["maxhp"] - $userrow["currenthp"];
$newhp = $userrow["currenthp"] + $potion; }

doquery("UPDATE {{table}} SET itemsac1qt=itemsac1qt-1, currenthp=$newhp WHERE id=".$userrow["id"], "users");
doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<br><br>Vous buvez la potion et sentez ses effets sur votre corp. Vous venez de reccuperez $potion de Points de vie!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>"; // Output

display($page, "Vous buvez une potion de soins!");
die();

$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
header("Location: index.php");
}

function nourriture() {

global $userrow;

if ($userrow["itemsac6qt"] < 1 ) { display("<br><center>Vous n'avez plus de provisions sur vous , retournez en acheter en Ville pour pouvoir manger.</center><br><br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>", "Chercher"); die(); }

$latitude = $userrow["latitude"];
$longitude = $userrow["longitude"];
$action = "currentaction='En exploration',";
$pomme = $userrow["level"] * 5;

$newhp = $userrow["currenthp"] + $pomme;
if ($userrow["maxhp"] < $newhp) { $pomme = $userrow["maxhp"] - $userrow["currenthp"];
$newhp = $userrow["currenthp"] + $pomme; }

doquery("UPDATE {{table}} SET itemsac6qt=itemsac6qt-1, currenthp=$newhp WHERE id=".$userrow["id"], "users");
doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<br><br>Vous manger un peu et vous sentez un peu mieux. Vous venez de reccuperez $pomme de Points de vie!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>"; // Output
display($page, "Vous buvez une potion de soins!");
die();

$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
header("Location: index.php");
}

function potiontp() {

global $userrow;

if ($userrow["itemsac5qt"] < 1 ) { display("<br><center>Vous n'avez plus de potion sur vous , retournez en acheter en Ville pour pouvoir recuperer vos TP</center><br><br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>", "Chercher"); die(); }

$latitude = $userrow["latitude"];
$longitude = $userrow["longitude"];
$action = "currentaction='En exploration',";
$pomme = $userrow["level"] * 5;

$newtp = $userrow["currenttp"] + $pomme;
if ($userrow["maxtp"] < $newtp) { $pomme = $userrow["maxtp"] - $userrow["currenttp"];
$newtp = $userrow["currenttp"] + $pomme; }

doquery("UPDATE {{table}} SET itemsac5qt=itemsac5qt-1, currenttp=$newtp WHERE id=".$userrow["id"], "users");
doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<br><br>Vous manger un peu et vous sentez un peu mieux. Vous venez de reccuperez $pomme de Points de vie!<br><center>Retournez sur la <a href=\"index.php\">Carte</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>"; // Output
display($page, "Vous buvez une potion de soins!");
die();

$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
header("Location: index.php");
}
?>