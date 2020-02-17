<?php // towns.php :: Handles all actions you can do in town. 

function travelto($id, $usepoints=true) { // Send a user to a town from the Travel To menu. 

global $userrow, $numqueries; 

$homequery = doquery("SELECT name,latitude,longitude FROM {{table}} WHERE id='$id' LIMIT 1", "maison"); 
$homerow = mysql_fetch_array($homequery); 

if ($usepoints==true) { 
if ($userrow["currenttp"] < 1) { 
display("<img src=././images/desole.gif><br>Vous n'avez pas assez de TP pour vous rendre à cette maison. <br>Veuillez retourner et essayer encore quand vous aurez plus de PT.", "Se rendre à"); die(); 
} 
} 

if (($userrow["latitude"] == $homerow["latitude"]) && ($userrow["longitude"] == $homerow["longitude"])) { display("<img src=././images/bienvenue.gif/><br>Vous êtes déjà dans cette maison. <br><a href=index.php>Cliquez ici</a> pour retourner au menu principal de cette ville.", "Se rendre à"); die(); } 

if ($usepoints == true) { $newtp = $userrow["currenttp"] - $homerow["travelpoints"]; } else { $newtp = $userrow["currenttp"]; } 

$newlat = $homerow["latitude"]; 
$newlon = $homerow["longitude"]; 
$newid = $userrow["id"]; 

// If they got here by exploring, add this town to their map. 
$mapped = explode(",",$userrow["towns"]); 
$town = false; 
foreach($mapped as $a => $b) { 
if ($b == $id) { $town = true; } 
} 
$mapped = implode(",",$mapped); 
if ($town == false) { 
$mapped .= ",$id"; 
$mapped = "towns='".$mapped."',"; 
} else { 
$mapped = "towns='".$mapped."',"; 
} 

$updatequery = doquery("UPDATE {{table}} SET currentaction='En maison',$mapped currenttp='$newtp',latitude='$newlat',longitude='$newlon' WHERE id='$newid' LIMIT 1", "users"); 

$page = "<img src=././images/bienvenue.gif><br>Bienvenue dans la maison de ".$homerow["name"].". <br>Vous pouvez maintenant <a href=index.php>entrer chez lui</a>"; 
$page .= "<center><iframe src=./map.php name=carte width=500 height=440 align=middle scrolling=No frameborder=0 allowtransparency=true></iframe></center>";
display($page, "Se rendre à"); 

} 

function reposhome() { // Staying at the inn resets all expendable stats to their max values.

global $userrow, $numqueries;

$homequery = doquery("SELECT name,innprice,proprio FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "maison");
$homerow = mysql_fetch_array($homequery);

if ($userrow["gold"] < $homerow["innprice"]) { display("Vous n'avez pas assez de gils pour dormir dans cette maison ce soir.<br /><br />Vous pouvez <a href=index.php>retourner à l'accueil</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Dormir dans la chambre"); die(); }

if (isset($_POST["submit"])) {

$newgold = $userrow["gold"] - $homerow["innprice"];
$newgold2 = $userrow["gold"] + $homerow["innprice"];
$query = doquery("UPDATE {{table}} SET gold='$newgold',currenthp='".$userrow["maxhp"]."',currentmp='".$userrow["maxmp"]."',currenttp='".$userrow["maxtp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$query = doquery("UPDATE {{table}} SET gold='$newgold2' WHERE id='".$homerow["proprio"]."' LIMIT 1", "users");
$title = "Auberge";
$page = "Vous vous êtes réveillé avec le sentiment d'être régénéré. Vous êtes prêt pour le combat! <br /><br />Vous pouvez <a href=index.php>retourner à l'accueil</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.";

} elseif (isset($_POST["cancel"])) {

header("Location: index.php"); die();

} else {

$title = "Auberge";
$page = "Le repos dans la chambre remplira vos barres de HP, MP, et TP à leurs niveaux maximum.<br /><br />
";
$page .= "Une nuit dans cette chambre vous coûtera <b>" . $homerow["innprice"] . " gils</b>. Est ce que vous acceptez?<br /><br />
";
$page .= "<form action=index.php?do=reposhome method='post'>
";
$page .= "<input type='submit' name='submit' value='Oui' /> <input type='submit' name='cancel' value='Non' />
";
$page .= "</form>
";
$page .= "<br><center><img src=././images/auberge.gif/></center>
";
}

display($page, $title);

}

function bierrehome() { // Staying at the inn resets all expendable stats to their max values.

global $userrow, $numqueries;

$homequery = doquery("SELECT name,buvette,proprio FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "maison");
$homerow = mysql_fetch_array($homequery);

if ($userrow["gold"] < $homerow["buvette"]) { display("Vous n'avez pas assez de gils pour acheter une bierre ce soir ce soir.<br /><br />Vous pouvez <a href=index.php>retourner à l'accueil</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Boire une bierre"); die(); }

if (isset($_POST["submit"])) {

$newgold = $userrow["gold"] - $homerow["buvette"];
$newgold2 = $userrow["gold"] + $homerow["buvette"];
$query = doquery("UPDATE {{table}} SET gold='$newgold',currenthp='".$userrow["maxhp"]."',currentmp='".$userrow["maxmp"]."',currenttp='".$userrow["maxtp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$query = doquery("UPDATE {{table}} SET gold='$newgold2' WHERE id='".$homerow["proprio"]."' LIMIT 1", "users");
$title = "Auberge";
$page = "Une bonne bierre et vous etes pret a reprendre la route. Vous êtes prêt pour le combat! <br /><br />Vous pouvez <a href=index.php>retourner à l'accueil</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.";

} elseif (isset($_POST["cancel"])) {

header("Location: index.php"); die();

} else {

$title = "Auberge";
$page = "Boire une bierre vous remplira votre barre de TP à son niveau maximum.<br /><br />
";
$page .= "La bierre vous coûtera <b>" . $homerow["buvette"] . " gils</b>. Est ce que vous acceptez?<br /><br />
";
$page .= "<form action=index.php?do=bierrehome method='post'>
";
$page .= "<input type='submit' name='submit' value='Oui' /> <input type='submit' name='cancel' value='Non' />
";
$page .= "</form>
";
$page .= "<br><center><img src=././images/auberge.gif></center>
";
}

display($page, $title);

}

function msg() {

global $userrow;

$homequery = doquery("SELECT proprio FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "maison");
$homerow = mysql_fetch_array($homequery);

if (isset($_POST["msg"])) {

$sender = $userrow["id"]; 
$owner = $homerow["proprio"]; 

extract($_POST);
$errors = 0;
$errorlist = "";
if ($reciever == $sender) { $errors++; $errorlist .= "There is no need to be sending gold to yourself."; }

if ($errors == 0) { 
$query = doquery("INSERT INTO {{table}} SET destinataire='$owner', message='$messa', envoyeur='$sender', titre='$title', date='NOW()', id=''","msg");
display("Message envoyer.<br /><br /><a href='index.php'>Retourner en ville.</a>","Envoyer un message");
} else {
display("<b>Erreurs:</b><br /><div style='color:red;'>$errorlist</div><br />Merci de cliquer sur precedant et de recommancer.<br /><a href='index.php?do=msg'>Retour</a><br /></table>", "Envoyer un message");
} 

} 
$page .= "<b><u>Envoyer un message au proprietaire</u></b><br />Vous pouvez envoyez un message au proprietaire.<br /><table width='100%'><form method='post' action='index.php?do=msg'><tr><td width='30%'>Titre:</td><td><input name='title' type='text' size='30' maxlength='12' /> <br /></td></tr><tr><td width='30%'>message:</td><td><input name='messa' type='text' size='80' /><br /></td></tr><tr><td width='30%'><input name='msg' type='submit' value='Submit' /></form><tr><td colspan='2'><a href='index.php'>Retourner en ville</a></td></tr></table></table>
";


display($page,"Envoyer un message");
}

function admin_maison() {     global $userrow, $numqueries;    						 	if (isset($_POST["submit"])) {		extract($_POST);		if ( $nuit == "" ) {display("Mettre une valeur pour la nuit SVP !!!"); die(); }		if ($userrow["currentaction"] == "En maison" ) {
	    $texte = new texte();        $query = doquery("UPDATE {{table}} SET innprice='$nuit',bloghome='".htmlentities($bloghome)."',buvette='$buvette'   WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' AND name='".$userrow["charname"]."' LIMIT 1", "maison");
		$texte = new texte();
		$title = "Admin. maison";        $page .= "La mise a jour a bien été effectué : <br><br>Prix de la nuit : <strong>".$nuit."</strong> gils<br><br>Prix de la buvette : <strong>".$buvette."</strong> gils<br><br>MessageBlog : <strong>".$texte->ms_format(htmlentities($bloghome))."</strong><br><br><a href=\"index.php\">retourner dans la maison</a>.";     } else {display("C'est pas bien de vouloir tricher.", "Tricheur !!"); die(); }    	} elseif (isset($_POST["cancel"])) {                header("Location: index.php"); die();             } else {        		$maisonquery = doquery("SELECT innprice,bloghome,buvette FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' AND name='".$userrow["charname"]."' LIMIT 1", "maison");		$texte = new texte();
		$maisonrow = mysql_fetch_array($maisonquery);        		$title = "Admin. maison";		$page .= "Bienvenue dans l'aministration de votre maison.<br>Vous pouvez editer les prix et avoir un petit blog dans votre maison.<br><br>";		$page .= "<form name=\"form1\" method=\"post\" action=\"\">";		$page .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr>";		$page .= "<td width=\"159\">Prix de la nuit : </td><td width=\"30\"></td>";		$page .= "<td width=\"28\"><input type=\"text\" name=\"nuit\" size=\"5\" value=\"".$maisonrow["innprice"]."\" > gils</td></tr><tr>";
		$page .= "<td width=\"159\">Prix de la buvette : </td><td width=\"30\"></td>";
		$page .= "<td width=\"28\"><input type=\"text\" name=\"buvette\" size=\"5\" value=\"".$maisonrow["buvette"]."\" > gils</td></tr><tr>";
		$page .= "<td width=\"159\">MessageBlog : </td><td width=\"30\"></td>";
		$page .= "<td width=\"28\"><textarea name=\"bloghome\" size=\"600\">".$texte->ms_format(htmlentities($maisonrow["bloghome"]))."</textarea></td></tr><tr>";
		$page .= "</tr><tr><td></td><td></td><td></td></tr><tr><td></td><td></td>";		$page .= "<td align=\"right\"><input type=\"submit\" name=\"submit\" value=\"Valide\">";		$page .= "</td></tr></table></form>";    }        display($page, $title);  }
?> 