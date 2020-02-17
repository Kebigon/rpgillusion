<?php // towns.php :: Handles all actions you can do in town. 

function service() { // Modules service allopass officiel ! 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name, chiffrebanque, codebanque, chiffreniveau, codeniveau, interets, innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
	$townrow = mysql_fetch_array($townquery); 
   
    $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br>";
    $page .= "<table width=\"490\"><tr><td>Bienvenue dans la rubrique des cheats. Ici vous allez pouvoir améliorer votre personnage via un simple appel téléphonique.<br>Voici les étapes à suivre:<br><br>1- Appelez le 08 97 12 59 39<br>2- Ecoutez et marquez (pour ne pas l'oublier) le code que l'on vous donnera<br>3- Enfin entrez le code que l'on vous a donné, dans le cheat que vous désirez activer<br><br><br></td></tr></table>";
    $page .= "<table width=\"490\"><tr><td><b>» Recevoir " .$townrow["chiffrebanque"] ." gils du banquier:</b><br><br>Le banquier est de très bonne humeur ces jours ci. Il a l'intention de vous offrir <b>" .$townrow["chiffrebanque"] ." gils</b>. <br>Pour les recevoir entrer le code ci dessous:<br><br>"; 
    $page .= "<center><font color=\"cc0000\">" .$townrow["codebanque"] ."</font></center></td></tr></table><br><br>";
	$page .= "<table width=\"490\"><tr><td><b>» Augmenter de " .$townrow["chiffreniveau"] ." niveaux le personnage:</b><br><br>Vous pouvez faire gagner à votre personnage <b>" .$townrow["chiffreniveau"] ." niveaux</b>. Pour cela entrez le code ci dessous:<br><br>"; 
    $page .= "<center><font color=\"cc0000\">" .$townrow["codeniveau"] ."</font></center></td></tr></table>";
    $page .= "<br><br><a href=\"index.php\">» Retour au sommaire de la ville</a>";

   
    display($page, "Les cheats"); 
    
} 

function cheatniveau() { // Staying at the inn resets all expendable stats to their max values. 

    global $userrow, $numqueries; 

   $townquery = doquery("SELECT level,id FROM {{table}} WHERE  id='$id'  LIMIT 1", "users"); 
   $townquery2 = doquery("SELECT name,innprice, chiffreniveau FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");  
    $townrow = mysql_fetch_array($townquery);     
	$townrow2 = mysql_fetch_array($townquery2);   
    
    if (isset($_POST["submit"])) {
	if ($userrow["currentaction"] == "En ville" ) {

        
       $newlevel = $userrow["level"] + $townrow2["chiffreniveau"]; 
       $query = doquery("UPDATE {{table}} SET level='$newlevel' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
	   $title = "Bravo"; 

	   $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Bravo, vous venez de recevoir vos gils<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>"; 
         } else {display("<table width=\"490\"><tr><td>C'est pas bien de vouloir tricher<br><br><br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>", "Auberge"); die(); }
    
	} elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Validez votre code"; 
        $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Votre code a été validé avec succès!<br><br>Pour augmenter votre personnage de <b>" .$townrow2["chiffreniveau"] ." niveaux</b> vous devez accepter. Dans le cas contraire cliquez sur refuser.</td></tr></table><br><br>\n"; 
        $page .= "<form action=\"index.php?do=cheatniveau\" method=\"post\">\n"; 
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Accepter\" /> <input type=\"submit\" name=\"cancel\" value=\"Refuser\" />\n"; 
        $page .= "</form>\n"; 
        
    } 
    
    display($page, $title); 
   
   } 
 
function cheatbanque() { // Staying at the inn resets all expendable stats to their max values. 

    global $userrow, $numqueries; 

   $townquery = doquery("SELECT gold,id FROM {{table}} WHERE  id='$id'  LIMIT 1", "users"); 
   $townquery2 = doquery("SELECT name,innprice, chiffrebanque FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");  
    $townrow = mysql_fetch_array($townquery);     
	$townrow2 = mysql_fetch_array($townquery2);   
    
    if (isset($_POST["submit"])) {
	if ($userrow["currentaction"] == "En ville" ) {

        
       $newbank = $userrow["bank"] + $townrow2["chiffrebanque"]; 
       $query = doquery("UPDATE {{table}} SET bank='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
	   $title = "Bravo"; 

		$page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Bravo, vous venez de recevoir vos gils<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>"; 
         } else {display("<table width=\"490\"><tr><td>C'est pas bien de vouloir tricher<br><br><br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>", "Auberge"); die(); }
    
	} elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Validez votre code"; 

	    $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Votre code a été validé avec succès!<br><br>Pour obtenir vos <b>" .$townrow2["chiffrebanque"] ." gils</b> vous devez accepter le don du banquier. Dans le cas contraire cliquez sur refuser.</td></tr></table><br><br>\n"; 
        $page .= "<form action=\"index.php?do=cheatbanque\" method=\"post\">\n"; 
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Accepter\" /> <input type=\"submit\" name=\"cancel\" value=\"Refuser\" />\n"; 
        $page .= "</form>\n"; 
        
    } 
    
    display($page, $title); 
   
   } 

 function bank() { // system de gestion de compte simple, retrait, depots.

	global $userrow, $numqueries;
    $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
	if (mysql_num_rows($townquery) != 1) { display("Tentative de Triche detectée.<br /><br />Bannissement proche , attention.<br /><br />", "Error"); }

		if (isset($_POST['bank'])) {
			$title = "Bank";

			if ($_POST['withdraw']) {
				if ($_POST['withdraw'] <= 0)
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><img src=\"images/gold.gif\" alt=\"banque\" /><center><img src=\"images/gold.jpg\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier4.gif\" alt=\"Banquier\" /></center><br><center> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
     		  elseif ($_POST['withdraw'] > $userrow['bank'])
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><img src=\"images/gold.gif\" alt=\"banque\" /><center><img src=\"images/gold.jpg\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier4.gif\" alt=\"Banquier\" /></center><br><center> Vous n'avez pas autant sur votre compte!<br>Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
     			else {
					$newgold = $userrow['gold'] + $_POST['withdraw'];
					$newbank = $userrow['bank'] - $_POST['withdraw'];
					doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
					doquery("UPDATE {{table}} SET bank='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.jpg\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier2.gif\" alt=\"Banquier\" /></center><br><center> Vous retirez $_POST[withdraw] Pièces d'Or de votre compte!";
					$page .="Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
				}

			} elseif ($_POST['deposit']) {
				if ($_POST['deposit'] <= 0)
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier4.gif\" alt=\"Banquier\" /></center><br><center> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
     			elseif ($_POST['deposit'] > $userrow['gold'])
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier4.gif\" alt=\"Banquier\" /></center><br><center> Vous ne possédez pas autant d'or sur vous!<br>Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
   				else {
					$newgold = $userrow['gold'] - $_POST['deposit'];
					$newbank = $userrow['bank'] + $_POST['deposit'];
					doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
					doquery("UPDATE {{table}} SET bank='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier3.gif\" alt=\"Banquier\" /></center><br><center> Vous déposez $_POST[deposit] Pièces d'Or sur votre compte!";
					$page .="Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
				}
			}
		} else {
			$title = "Banque";
			$page = "<bgsound src=\"musiques/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"Banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier.gif\" alt=\"Banquier\" /></center><br />";
			$page .= "<center>Vous possedez $userrow[bank] Pièces d'or sur votre compte.";
			$page .= "<form action=index.php?do=bank method=post><br />";
			$page .= "Deposer :<input type=text name=deposit><br />";
			$page .= "Retirer :<input type=text name=withdraw><br />";
			$page .= "<input type=submit value=Valider name=bank></form><br>";
            $page .= "<br>Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
		}

	display($page, $title);

}





function inn() { // Staying at the inn resets all expendable stats to their max values. 

    global $userrow, $numqueries; 

    $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 

    
    if ($userrow["gold"] < $townrow["innprice"]) { display("<center><img src=\"././/images/aub.gif\"/></center><br> Vous n'avez pas assez de gils pour dormir dans cette auberge ce soir.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Auberge"); die(); } 
    
    if (isset($_POST["submit"])) {
	if ($userrow["currentaction"] == "En ville" ) {

        
        $newgold = $userrow["gold"] - $townrow["innprice"]; 
        $query = doquery("UPDATE {{table}} SET gold='$newgold',currenthp='".$userrow["maxhp"]."',currentmp='".$userrow["maxmp"]."',currenttp='".$userrow["maxtp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
        $title = "Auberge"; 
        $page = "<img src=\"././/images/aub.gif\"/><br>Vous vous êtes réveillé avec le sentiment d'être régénéré. Vous êtes prêt pour le combat! <br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde."; 
         } else {display("C'est pas bien de vouloir tricher<br /><br />Utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Auberge"); die(); }
    
	} elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Auberge"; 
        $page = "<img src=\"././/images/aub.gif\"/><br>Le repos à l'auberge remplira vos barres de HP, MP, et TP à leurs niveaux maximum.<br /><br />\n"; 
        $page .= "Une nuit dans cette auberge vous coûtera <b>" . $townrow["innprice"] . " gils</b>. Est ce que vous acceptez?<br /><br />\n"; 
        $page .= "<form action=\"index.php?do=inn\" method=\"post\">\n"; 
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" />\n"; 
        $page .= "</form>\n"; 
        $page .= "<br><center><img src=\"././images/auberge.gif\"/></center>\n"; 
    } 
    
    display($page, $title); 
   
   }  


function home() { // Staying at the inn resets all expendable stats to their max values. 

  global $userrow, $numqueries; 
   $townquery = doquery("SELECT name,homeprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 

    if ($userrow["gold"] < $townrow["homeprice"]) { display("<center><img src=\"images/nomaison.jpg\"/></center><br> Vous n'avez pas assez de gils pour créer cette maison.<br />Il faut impérativement " . $townrow["homeprice"] . " gils pour en créer une.<br><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Créer une maison"); die(); } 
   

      if (isset($_POST["submit"])) {
	  
	   extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Le nom est obligatoire.<br />"; }
	        if ($longitude == "") { $errors++; $errorlist .= "La latitude est obligatoire.<br />"; }
		        if ($latitude == "") { $errors++; $errorlist .= "La longitude est obligatoire.<br />"; }
        
	  
        
        if ($errors == 0) { 
		
		$newgold = $userrow["gold"] - $townrow["homeprice"]; 
         $query = doquery("UPDATE {{table}} SET gold='$newgold' LIMIT 1", "users"); 
         $query = doquery("INSERT INTO {{table}} SET id='',name='$name',buvette='$buvette',innprice='$innprice',msg='$msg',longitude='$longitude',latitude='$latitude'", "maison");
		        $title = "Auberge"; 
       }  $page = "Votre maison à été crée avec succès! <br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde."; 
        
    } elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Créer sa maison"; 
        $page = "Ici vous avez la possiblité de créer votre propre maison pour " . $townrow["homeprice"] . " gils et de gagner grace à elle des gils<BR><br />\n"; 
        $page .= "<form action=\"index.php?do=home\" method=\"post\">\n"; 
		$page .= "Votre pseudo: <input type=\"text\" name=\"name\" size=\"12\"><br />\n"; 
		$page .= "Cout de la chambre: <input type=\"text\" name=\"innprice\" size=\"2\"><br />\n"; 
		$page .= "Cout de la buvette: <input type=\"text\" name=\"buvette\" size=\"2\"><br />\n"; 
     	$page .= "Latitude choisie: <input type=\"text\" name=\"latitude\" size=\"4\"><br />\n"; 
        $page .= "Longitude choisie: <input type=\"text\" name=\"longitude\" size=\"4\"><br />\n"; 
        $page .= "Cout d'un entrainement chez vous: <input type=\"text\" name=\"training\" size=\"2\"><br />\n"; 
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Créer\"><input type=\"submit\" name=\"reset\" value=\"Annuler\"></form>\n"; 
         
    } 
    
    display($page, $title); 
    
} 

function buy() { // Displays a list of available items for purchase. 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,itemslist FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 
    
    $itemslist = explode(",",$townrow["itemslist"]); 
    $querystring = ""; 
    foreach($itemslist as $a=>$b) { 
        $querystring .= "id='$b' OR "; 
    } 
    $querystring = rtrim($querystring, " OR "); 
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE $querystring ORDER BY id", "items"); 
    $page = "<img src=\"././images/shop.gif\"/><br>En achetant des armes, vous augmenterez votre pouvoir d'attaque et lorsque vous acheterez des armures ou des protections  vous augmenterez votre pouvoir de défense.<br /><br />Cliquez sur le nom d'un objet pour l'acheter.<br /><br />Les objets suivants sont disponibles dans cette ville:<br /><br />\n"; 
    $page .= "<table width=\"80%\">\n"; 
    while ($itemsrow = mysql_fetch_array($itemsquery)) { 
        if ($itemsrow["type"] == 1) { $attrib = "Pouvoir d'attaque:"; } else  { $attrib = "Pouvoir de défense:"; } 
        $page .= "<tr><td width=\"4%\">"; 
        if ($itemsrow["type"] == 1) { $page .= "<img src=\"images/icon_weapon.gif\" alt=\"arme\" /></td>"; } 
        if ($itemsrow["type"] == 2) { $page .= "<img src=\"images/icon_armor.gif\" alt=\"armure\" /></td>"; } 
        if ($itemsrow["type"] == 3) { $page .= "<img src=\"images/icon_shield.gif\" alt=\"protection\" /></td>"; } 
        if ($userrow["weaponid"] == $itemsrow["id"] || $userrow["armorid"] == $itemsrow["id"] || $userrow["shieldid"] == $itemsrow["id"]) { 
            $page .= "<td width=\"32%\"><span class=\"light\">".$itemsrow["name"]."</span></td><td width=\"32%\"><span class=\"light\">$attrib ".$itemsrow["attribute"]."</span></td><td width=\"32%\"><span class=\"light\">Déjà acheté</span></td></tr>\n"; 
        } else { 
            if ($itemsrow["special"] != "Aucun") { $specialdot = "<span class=\"highlight\">*</span>"; } else { $specialdot = ""; } 
             $page .= "<td width=\"32%\"><b><a href=\"index.php?do=buy2:".$itemsrow["id"]."\">".$itemsrow["name"]."</a>$specialdot</b></td><td width=\"32%\">$attrib <b>".$itemsrow["attribute"]."</b></td><td width=\"32%\">Prix: <b>".$itemsrow["buycost"]." gils</b></td></tr><tr><br><td colspan=4><b>Description:&nbsp; </b>".$itemsrow["description"]."</td></tr>\n"; } 
    } 
    $page .= "</table><br />\n"; 
    $page .= "Si vous avez changé d'avis, vous pouvez également <a href=\"index.php\">retourner à la ville</a>.\n"; 
    $title = "Acheter des objets"; 
    
    display($page, $title); 
    
} 

function buy2($id) { // Confirm user's intent to purchase item. 
    
    global $userrow, $numqueries; 
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items"); 
    $itemsrow = mysql_fetch_array($itemsquery); 
    
    if ($userrow["gold"] < $itemsrow["buycost"]) { display("<img src=\"././images/shop.gif\"/><br>Vous n'avez pas assez de gils pour acheter cet objet.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=buy\">au magasin</a>, ou utilisez les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter objets"); die(); } 
    
    if ($itemsrow["type"] == 1) { 
        if ($userrow["weaponid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["weaponid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
            $page = "<img src=\"././images/shop.gif\"/><br>Si vous achetez le ".$itemsrow["name"].", alors j'achèterai le votre ".$itemsrow2["name"]." pour ".ceil($itemsrow2["buycost"]/2)." gils. Vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } else { 
            $page = "<img src=\"././images/shop.gif\"/><br>Vous allez acheter ".$itemsrow["name"].", vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } 
    } elseif ($itemsrow["type"] == 2) { 
        if ($userrow["armorid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["armorid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
            $page = "<img src=\"././images/shop.gif\"/><br>Si vous achetez le ".$itemsrow["name"].", alors j'achèterai le votre ".$itemsrow2["name"]." pour ".ceil($itemsrow2["buycost"]/2)." gils. Vous êtes d'acord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } else { 
            $page = "<img src=\"././images/shop.gif\"/><br>Vous allez acheter ".$itemsrow["name"].", vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } 
    } elseif ($itemsrow["type"] == 3) { 
        if ($userrow["shieldid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["shieldid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
            $page = "<img src=\"././images/shop.gif\"/><br>Si vous achetez le ".$itemsrow["name"].", alors j'achèterai le votre ".$itemsrow2["name"]." pour ".ceil($itemsrow2["buycost"]/2)." gils. Vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } else { 
            $page = "<img src=\"././images/shop.gif\"/><br>Vous allez acheter ".$itemsrow["name"].", vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } 
    } 
    
    $title = "Acheter objets"; 
    display($page, $title); 
    
} 

function buy3($id) { // Update user profile with new item & stats. 
    
    if (isset($_POST["cancel"])) { header("Location: index.php"); die(); } 
    
    global $userrow; 
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items"); 
    $itemsrow = mysql_fetch_array($itemsquery); 
    
    if ($userrow["gold"] < $itemsrow["buycost"]) { display("<img src=\"././images/shop.gif\"/><br>Vous n'avez pas assez de gils pour acheter cet objet.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=buy\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter objets"); die(); } 
    
    if ($itemsrow["type"] == 1) { // weapon 
        
       // Check if they already have an item in the slot. 
        if ($userrow["weaponid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["weaponid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
        } else { 
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun"); 
        } 
        
        // Special item fields. 
        $specialchange1 = ""; 
        $specialchange2 = ""; 
        if ($itemsrow["special"] != "Aucun") { 
            $special = explode(",",$itemsrow["special"]); 
            $tochange = $special[0]; 
            $userrow[$tochange] = $userrow[$tochange] + $special[1]; 
            $specialchange1 = "$tochange='".$userrow[$tochange]."',"; 
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; } 
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; } 
        } 
        if ($itemsrow2["special"] != "Aucun") { 
            $special2 = explode(",",$itemsrow2["special"]); 
            $tochange2 = $special2[0]; 
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1]; 
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',"; 
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; } 
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; } 
        } 
        
        // New stats. 
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"]; 
        $newattack = $userrow["attackpower"] + $itemsrow["attribute"] - $itemsrow2["attribute"]; 
        $newid = $itemsrow["id"]; 
        $newname = $itemsrow["name"]; 
        $userid = $userrow["id"]; 
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; } 
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; } 
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; } 
        
        // Final update. 
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', attackpower='$newattack', weaponid='$newid', weaponname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users"); 
        
    } elseif ($itemsrow["type"] == 2) { // Armor 

       // Check if they already have an item in the slot. 
        if ($userrow["armorid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["armorid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
        } else { 
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun"); 
        } 
        
        // Special item fields. 
        $specialchange1 = ""; 
        $specialchange2 = ""; 
        if ($itemsrow["special"] != "Aucun") { 
            $special = explode(",",$itemsrow["special"]); 
            $tochange = $special[0]; 
            $userrow[$tochange] = $userrow[$tochange] + $special[1]; 
            $specialchange1 = "$tochange='".$userrow[$tochange]."',"; 
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; } 
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; } 
        } 
        if ($itemsrow2["special"] != "Aucun") { 
            $special2 = explode(",",$itemsrow2["special"]); 
            $tochange2 = $special2[0]; 
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1]; 
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',"; 
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; } 
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; } 
        } 
        
        // New stats. 
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"]; 
        $newdefense = $userrow["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"]; 
        $newid = $itemsrow["id"]; 
        $newname = $itemsrow["name"]; 
        $userid = $userrow["id"]; 
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; } 
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; } 
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; } 
        
        // Final update. 
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', armorid='$newid', armorname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users"); 

    } elseif ($itemsrow["type"] == 3) { // Shield 

       // Check if they already have an item in the slot. 
        if ($userrow["shieldid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["shieldid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
        } else { 
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun"); 
        } 
        
        // Special item fields. 
        $specialchange1 = ""; 
        $specialchange2 = ""; 
        if ($itemsrow["special"] != "Aucun") { 
            $special = explode(",",$itemsrow["special"]); 
            $tochange = $special[0]; 
            $userrow[$tochange] = $userrow[$tochange] + $special[1]; 
            $specialchange1 = "$tochange='".$userrow[$tochange]."',"; 
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; } 
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; } 
        } 
        if ($itemsrow2["special"] != "Aucun") { 
            $special2 = explode(",",$itemsrow2["special"]); 
            $tochange2 = $special2[0]; 
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1]; 
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',"; 
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; } 
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; } 
        } 
        
        // New stats. 
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"]; 
        $newdefense = $userrow["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"]; 
        $newid = $itemsrow["id"]; 
        $newname = $itemsrow["name"]; 
        $userid = $userrow["id"]; 
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; } 
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; } 
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; } 
        
        // Final update. 
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', shieldid='$newid', shieldname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users");        
    
    } 
    
    display("<img src=\"././images/shop.gif\"/><br>Merci d'avoir acheté cet objet.<br /><br />Vous pouvez maintenant <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=buy\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter objets"); 

} 

function maps() { // List maps the user can buy. 
    
    global $userrow, $numqueries; 
    
    $mappedtowns = explode(",",$userrow["towns"]); 
    
    $page = "<img src=\"././images/carte.gif\"/><br>Lorsque vous achetez la carte d'une ville, vous pourrez par la suite vous téléporter à cette endroit lorsque vous le souhaiterez. Cela vous coutera moins de TP que lorsque vous êtes à pied.<br /><br />\n"; 
    $page .= "Cliquez sur le nom d'un ville pour acheter sa carte.<br /><br />\n"; 
    $page .= "<table width=\"90%\">\n"; 
    
    $townquery = doquery("SELECT * FROM {{table}} ORDER BY id", "towns"); 
    while ($townrow = mysql_fetch_array($townquery)) { 
        
        if ($townrow["latitude"] >= 0) { $latitude = $townrow["latitude"] . "N,"; } else { $latitude = ($townrow["latitude"]*-1) . "S,"; } 
        if ($townrow["longitude"] >= 0) { $longitude = $townrow["longitude"] . "E"; } else { $longitude = ($townrow["longitude"]*-1) . "O"; } 
        
        $mapped = false; 
        foreach($mappedtowns as $a => $b) { 
            if ($b == $townrow["id"]) { $mapped = true; } 
        } 
        if ($mapped == false) { 
            $page .= "<tr><td width=\"25%\"><a href=\"index.php?do=maps2:".$townrow["id"]."\">".$townrow["name"]."</a></td><td width=\"25%\">Prix: ".$townrow["mapprice"]." gils</td><td width=\"50%\" colspan=\"2\">Achetez la carte pour avoir des infos.</td></tr>\n"; 
        } else { 
            $page .= "<tr><td width=\"25%\"><span class=\"light\">".$townrow["name"]."</span></td><td width=\"25%\"><span class=\"light\">Déja acheté.</span></td><td width=\"35%\"><span class=\"light\">Location: $latitude $longitude</span></td><td width=\"15%\"><span class=\"light\">TP: ".$townrow["travelpoints"]."</span></td></tr>\n"; 
        } 
        
    } 
    
    $page .= "</table><br />\n"; 
    $page .= "<br>Si vous avez changé d'avis, vous pouvez également <a href=\"index.php\">retourner à la ville</a>.\n"; 
    
    display($page, "Acheter cartes"); 
    
} 

function maps2($id) { // Confirm user's intent to purchase map. 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,mapprice FROM {{table}} WHERE id='$id' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 
    
    if ($userrow["gold"] < $townrow["mapprice"]) { display("Vous n'avez pas assez de gils pour acheter cette carte.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=maps\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter cartes"); die(); } 
    
    $page = "<img src=\"././images/carte.gif\"/><br>Vous allez acheter la carte de ".$townrow["name"]." . Vous êtes d'accord?<br /><br /><form action=\"index.php?do=maps3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
    
    display($page, "Acheter cartes"); 
    
} 

function maps3($id) { // Add new map to user's profile. 
    
    if (isset($_POST["cancel"])) { header("Location: index.php"); die(); } 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,mapprice FROM {{table}} WHERE id='$id' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 
    
    if ($userrow["gold"] < $townrow["mapprice"]) { display("Vous n'avez pas assez de gils pour acheter cette carte.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=maps\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter cartes"); die(); } 
    
    $mappedtowns = $userrow["towns"].",$id"; 
    $newgold = $userrow["gold"] - $townrow["mapprice"]; 
    
    $updatequery = doquery("UPDATE {{table}} SET towns='$mappedtowns',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
    
    display("<br>Merci pour l'achat de cette carte.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=maps\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter carte"); 
    
} 

function travelto($id, $usepoints=true) { // Send a user to a town from the Travel To menu. 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,travelpoints,latitude,longitude FROM {{table}} WHERE id='$id' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 
    
    if ($usepoints==true) { 
        if ($userrow["currenttp"] < $townrow["travelpoints"]) { 
            display("<img src=\"././images/desole.gif\"/><br>Vous n'avez pas assez de TP pour vous téléporter dans cette ville. <br>Veuillez retourner et essayer encore quand vous aurez plus de TP.", "Se téléporter à"); die(); 
        } 
    } 
    
    if (($userrow["latitude"] == $townrow["latitude"]) && ($userrow["longitude"] == $townrow["longitude"])) { display("<img src=\"././images/bienvenue.gif\"/><br>Vous êtes déjà dans cette ville. <br><a href=\"index.php\">Cliquez ici</a> pour retourner au menu principal de cette ville.", "Se téléporter à"); die(); } 
    
    if ($usepoints == true) { $newtp = $userrow["currenttp"] - $townrow["travelpoints"]; } else { $newtp = $userrow["currenttp"]; } 
    
    $newlat = $townrow["latitude"]; 
    $newlon = $townrow["longitude"]; 
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
    
    $updatequery = doquery("UPDATE {{table}} SET currentaction='En ville',$mapped currenttp='$newtp',latitude='$newlat',longitude='$newlon' WHERE id='$newid' LIMIT 1", "users"); 
    
    $page = "<img src=\"././images/bienvenue.gif\"/><br>Bienvenue à ".$townrow["name"].". <br>Vous pouvez maintenant <a href=\"index.php\">entrer dans cette ville</a>."; 
    display($page, "Se téléporter à"); 
    
} 
    

?>