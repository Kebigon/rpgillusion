<?php // bank.php :: Les dernieres fonctions de la banque


function stockobjets() { // List maps the user can buy
    global $userrow, $numqueries; 	
	$page .= "Bienvenue dans la salle des coffres, vous avez un coffre pour chaque equipement.
	<br><br><br><b><u> Retirer un equipement :</u></b><br><br> 
	Coffre 1 :<img src=\"images/icon_weapon.gif\" alt=\"Arme\" /><a href='index.php?do=stockobjets21'> $userrow[stock1name]</a><br>
	Coffre 2 :<img src=\"images/icon_armor.gif\" alt=\"Armure\" /><a href='index.php?do=stockobjets22'> $userrow[stock2name]</a><br> 
	Coffre 3 :<img src=\"images/icon_shield.gif\" alt=\"Bouclier\" /><a href='index.php?do=stockobjets23'> $userrow[stock3name]</a><br>
	<br><br><br><b><u> Deposser un equipement :</u></b><br><br> 
	<img src=\"images/icon_weapon.gif\" alt=\"Arme\" /><a href='index.php?do=stockobjets31'> $userrow[weaponname]</a><br>
	<img src=\"images/icon_armor.gif\" alt=\"Armure\" /><a href='index.php?do=stockobjets32'> $userrow[armorname]</a><br> 
	<img src=\"images/icon_shield.gif\" alt=\"Bouclier\" /><a href='index.php?do=stockobjets33'> $userrow[shieldname]</a><br>
	</table>\n";
	display($page, "Deposser votre arme ou armures"); 
    } 

function stockobjets31() { 
global $userrow; 
$latitude = $userrow["latitude"]; 
$longitude = $userrow["longitude"]; 
doquery("UPDATE {{table}} SET stock1name='".$userrow["weaponname"]."', stock1id='".$userrow["weaponid"]."', weaponname='Aucun', weaponid='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<br><br>Vous venez de placer votre arme dans le coffre..</center></table>"; // Output 
display($page, "Felicitation"); 
die(); 
$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
header("Location: index.php"); 
} 

function stockobjets32() { 
global $userrow; 
$latitude = $userrow["latitude"]; 
$longitude = $userrow["longitude"]; 
doquery("UPDATE {{table}} SET stock2name='".$userrow["armorname"]."', stock2id='".$userrow["armorid"]."', armorname='Aucun', armorid='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<br><br>Vous venez de placer votre armure dans le coffre..</center></table>"; // Output 
display($page, "Felicitation"); 
die(); 
$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
header("Location: index.php"); 
} 

function stockobjets33() { 
global $userrow; 
$latitude = $userrow["latitude"]; 
$longitude = $userrow["longitude"]; 
doquery("UPDATE {{table}} SET stock3name='".$userrow["shieldname"]."', stock3id='".$userrow["shieldid"]."', shieldname='Aucun', shieldid='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<br><br>Vous venez de placer votre bouclier dans le coffre..</center></table>"; // Output 
display($page, "Felicitation"); 
die(); 
$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
header("Location: index.php"); 
} 

function stockobjets21() { 
global $userrow; 
$latitude = $userrow["latitude"]; 
$longitude = $userrow["longitude"]; 
doquery("UPDATE {{table}} SET  weaponname='".$userrow["stock1name"]."', weaponid='".$userrow["stock1id"]."', stock1name='aucun', stock1id='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<br><br>Vous venez de retirer votre arme du coffre..</center></table>"; // Output 
display($page, "Felicitation"); 
die(); 
$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
header("Location: index.php"); 
} 

function stockobjets22() { 
global $userrow; 
$latitude = $userrow["latitude"]; 
$longitude = $userrow["longitude"]; 
doquery("UPDATE {{table}} SET  armorname='".$userrow["stock2name"]."', armorid='".$userrow["stock2id"]."', stock2name='aucun', stock2id='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<br><br>Vous venez de retirer votre armure du coffre..</center></table>"; // Output 
display($page, "Felicitation"); 
die(); 
$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
header("Location: index.php"); 
} 

function stockobjets23() { 
global $userrow; 
$latitude = $userrow["latitude"]; 
$longitude = $userrow["longitude"]; 
doquery("UPDATE {{table}} SET  shieldname='".$userrow["stock3name"]."', shieldid='".$userrow["stock3id"]."', stock3name='aucun', stock3id='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<br><br>Vous venez de retirer votre bouclier du coffre..</center></table>"; // Output 
display($page, "Felicitation"); 
die(); 
$updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
header("Location: index.php"); 
} 

function sendgold() {

global $userrow;
$maximumgold = $userrow[gold];
$checkquery = doquery("SELECT * FROM {{table}} WHERE charname='".$_POST['reciever']."' LIMIT 1", "users");
$rec = mysql_fetch_assoc($checkquery);
if (isset($_POST["sendgold"])) {

extract($_POST);
$errors = 0;
$errorlist = "";
if ($sender == "") { $errors++; $errorlist .= "The sender name is required.<br />"; }
if (!is_numeric($goldsent)) { $errors++; $errorlist .= "The amount of gold sent needs to be a number.<br />"; }
if ($goldsent == "") { $errors++; $errorlist .= "The amount of gold is required.<br />"; }
if ($reciever == "") { $errors++; $errorlist .= "The reciever's name is required.<br />"; }
if ($goldsent > $maximumgold) { $errors++; $errorlist .= "You're trying to send more gold than what you have.<br />"; }
if ($goldsent == "0") { $errors++; $errorlist .= "You need to send more gold than just zero.<br />"; }
if ($goldsent < "0") { $errors++; $errorlist .= "<font color='ffffff'>Le montant doit etre positif.<br />"; }
if ($reciever == $sender) { $errors++; $errorlist .= "There is no need to be sending gold to yourself."; }
if (!$rec) { $errors++; $errorlist .= "Character name doesn't exist."; }
if ($rec == $userrow[charname]) { $errors++; $errorlist .= "There is no need to be sending gold to yourself."; }


if ($errors == 0) {
$query = doquery("UPDATE {{table}} SET gold=gold-$goldsent WHERE charname='$sender'","users");
$query2 = doquery("UPDATE {{table}} SET gold=gold+$goldsent WHERE charname='$reciever'","users");
display("Transaction réussie.<br /><br /><a href='index.php'>Retourner en ville.</a>","Envoie de gils");
} else {
display("<b>Erreurs:</b><br /><div style='color:red;'>$errorlist</div><br />Merci de cliquer sur precedant et de recommancer.<br /><a href='index.php?do=sendgold'>Go back</a><br />", "Envoie de gils");
}

}
$page = <<<END
<img src="images/gold.gif"><br>
<b><u>Envoie de gils</u></b><br />
Vous pouvez envoyez une somme precis de gils a un autre joueur.<br />
<table width="100%">
<form method='post' action="index.php?do=sendgold">
<input name="sender" type="hidden" value="$userrow[charname]" id="sender" />
<tr><td width="30%">Quantité:</td><td><input name="goldsent" type="text" size="12" maxlength="12" /> gold.<br /></td></tr>
<tr><td width="30%">Pseudo du receveur:</td><td><input name="reciever" type="text" size="20" /><br /></td></tr>
<tr><td width="30%"><input name="sendgold" type='submit' value='submit' />
</form>
<tr><td colspan="2"><a href='index.php'>Retourner en ville</a></td></tr></table>
END;

display($page,"Envoie de gils");

}

function sendpotion() {

	global $userrow;
$maximumgold = $userrow[itemsac1qt];
 $checkquery = doquery("SELECT * FROM {{table}} WHERE charname='".$_POST['reciever']."' LIMIT 1", "users");
        $rec = mysql_fetch_assoc($checkquery);
if (isset($_POST["sendpotion"])) {
        
		extract($_POST);
		$errors = 0;
		$errorlist = "";
        	if ($sender == "") { $errors++; $errorlist .= "The sender name is required.<br />"; }
       		if (!is_numeric($goldsent)) { $errors++; $errorlist .= "The amount of gold sent needs to be a number.<br />"; }
		if ($goldsent == "") { $errors++; $errorlist .= "The amount of gold is required.<br />"; }
		if ($reciever == "") { $errors++; $errorlist .= "The reciever's name is required.<br />"; }
		if ($goldsent > $maximumgold) { $errors++; $errorlist .= "You're trying to send more gold than what you have.<br />"; }
		if ($goldsent == "0") { $errors++; $errorlist .= "You need to send more gold than just zero.<br />"; }
		if ($reciever == $sender) { $errors++; $errorlist .= "There is no need to be sending gold to yourself."; }
		if (!$rec) { $errors++; $errorlist .= "Character name doesn't exist."; }
		if ($rec == $userrow[charname]) { $errors++; $errorlist .= "There is no need to be sending gold to yourself."; }
        
		if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET itemsac1qt=itemsac1qt-$goldsent WHERE charname='$sender'","users");
            $query2 = doquery("UPDATE {{table}} SET itemsac1qt=itemsac1qt+$goldsent WHERE charname='$reciever'","users");
				display("Transaction réussie.<br /><br /><a href=\"index.php\">Retourner en ville.</a>","Envoie de gils");
        } else {
            display("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Merci de cliquer sur precedant et de recommancer.<br /><a href=\"index.php?do=sendgold\">Retour</a><br /></table>", "Envoie de gils");
        }        
        
    } 
$page = <<<END
<b><u>Envoie de pillule enrgetique</u></b><br />
Vous pouvez envoyez un nombre precis de pillule energetique a un autre joueur.<br />
<table width="100%">
<form method="post" action="index.php?do=sendgold">
<input name="sender" type="hidden" value="$userrow[charname]" id="sender" />
<tr><td width="30%">Quantité:</td><td><input name="goldsent" type="text" size="12" maxlength="12" /> <br /></td></tr>
<tr><td width="30%">Pseudo du receveur:</td><td><input name="reciever" type="text" size="20" /><br /></td></tr>
<tr><td width="30%"><input name="sendgold" type="submit" value="Submit" />
</form>
<tr><td colspan="2"><a href="index.php">Retourner en ville</a></td></tr></table></table>
END;

display($page,"Envoie de potion");

}

function sendeat() {

	global $userrow;
$maximumgold = $userrow[itemsac1qt];
 $checkquery = doquery("SELECT * FROM {{table}} WHERE charname='".$_POST['reciever']."' LIMIT 1", "users");
        $rec = mysql_fetch_assoc($checkquery);
if (isset($_POST["sendpotion"])) {
        
		extract($_POST);
		$errors = 0;
		$errorlist = "";
        	if ($sender == "") { $errors++; $errorlist .= "The sender name is required.<br />"; }
       		if (!is_numeric($goldsent)) { $errors++; $errorlist .= "The amount of gold sent needs to be a number.<br />"; }
		if ($goldsent == "") { $errors++; $errorlist .= "The amount of gold is required.<br />"; }
		if ($reciever == "") { $errors++; $errorlist .= "The reciever's name is required.<br />"; }
		if ($goldsent > $maximumgold) { $errors++; $errorlist .= "You're trying to send more gold than what you have.<br />"; }
		if ($goldsent == "0") { $errors++; $errorlist .= "You need to send more gold than just zero.<br />"; }
		if ($reciever == $sender) { $errors++; $errorlist .= "There is no need to be sending gold to yourself."; }
		if (!$rec) { $errors++; $errorlist .= "Character name doesn't exist."; }
		if ($rec == $userrow[charname]) { $errors++; $errorlist .= "There is no need to be sending gold to yourself."; }
        
		if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET itemsac6qt=itemsac6qt-$goldsent WHERE charname='$sender'","users");
            $query2 = doquery("UPDATE {{table}} SET itemsac6qt=itemsac6qt+$goldsent WHERE charname='$reciever'","users");
				display("Transaction réussie.<br /><br /><a href=\"index.php\">Retourner en ville.</a>","Envoie de gils");
        } else {
            display("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Merci de cliquer sur precedant et de recommancer.<br /><a href=\"index.php?do=sendgold\">Retour</a><br /></table>", "Envoie de gils");
        }        
        
    } 
$page = <<<END
<b><u>Envoie de bol de ramen</u></b><br />
Vous pouvez envoyez un nombre precis de bol de ramen a un autre joueur.<br />
<table width="100%">
<form method="post" action="index.php?do=sendgold">
<input name="sender" type="hidden" value="$userrow[charname]" id="sender" />
<tr><td width="30%">Quantité:</td><td><input name="goldsent" type="text" size="12" maxlength="12" /> <br /></td></tr>
<tr><td width="30%">Pseudo du receveur:</td><td><input name="reciever" type="text" size="20" /><br /></td></tr>
<tr><td width="30%"><input name="sendgold" type="submit" value="Submit" />
</form>
<tr><td colspan="2"><a href="index.php">Retourner en ville</a></td></tr></table></table>
END;

display($page,"Envoie de bol de ramen");

}
?>