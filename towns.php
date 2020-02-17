<?php // towns.php :: Handles all actions you can do in town. 

function service() { // Modules service allopass officiel ! 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,chiffreptlevel, codeptlevel, chiffrexp, codexp, chiffrebanque, codebanque, chiffreniveau, codeniveau, interets, innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
	$townrow = mysql_fetch_array($townquery); 
   
    $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br>";
    $page .= "<table width=\"490\"><tr><td>Bienvenue dans la rubrique des cheats. Ici vous allez pouvoir améliorer votre personnage via un simple appel téléphonique.<br>Voici les étapes à suivre:<br><br>1- Appelez le 08 97 12 59 39<br>2- Ecoutez et marquez (pour ne pas l'oublier) le code que l'on vous donnera<br>3- Enfin entrez le code que l'on vous a donné, dans le cheat que vous désirez activer<br><br><br></td></tr></table>";
    $page .= "<table width=\"490\"><tr><td><b>» Recevoir " .$townrow["chiffrebanque"] ." ".$townrow3["monnaie"]." du banquier:</b><br><br>Le banquier est de très bonne humeur ces jours ci. Il a l'intention de vous offrir <b>" .$townrow["chiffrebanque"] ." ".$townrow3["monnaie"]."</b>. <br>Pour les recevoir entrer le code ci dessous:<br><br>"; 
    $page .= "<font color=\"cc0000\">" .$townrow["codebanque"] ."</font></td></tr></table><br><br>";
	$page .= "<table width=\"490\"><tr><td><b>» Augmenter de " .$townrow["chiffreniveau"] ." niveaux le personnage:</b><br><br>Vous pouvez faire gagner à votre personnage <b>" .$townrow["chiffreniveau"] ." niveaux</b>. Pour cela entrez le code ci dessous:<br><br>"; 
    $page .= "<font color=\"cc0000\">" .$townrow["codeniveau"] ."</font></td></tr></table>";
	$page .= "<p><table width=\"490\"><tr><td><b>» Augmenter de " .$townrow["chiffrexp"] ." xp le personnage:</b><br><br>Vous pouvez faire gagner à votre personnage <b>" .$townrow["chiffrexp"] ." xp</b>. Pour cela entrez le code ci dessous:<br><br>"; 
    $page .= "<font color=\"cc0000\">" .$townrow["codexp"] ."</font></td></tr></table>";
	$page .= "<p><table width=\"490\"><tr><td><b>» Augmenter de " .$townrow["chiffreptlevel"] ." pointniveaux le personnage:</b><br><br>Vous pouvez faire gagner à votre personnage <b>" .$townrow["chiffreptlevel"] ." pointniveaux</b>. Pour cela entrez le code ci dessous:<br><br>"; 
    $page .= "<font color=\"cc0000\">" .$townrow["codeptlevel"] ."</font></td></tr></table>";
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

	   $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Bravo, vous venez de recevoir vos ".$townrow3["monnaie"]."<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>"; 
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
   
   function cheatptlevel() { // Staying at the inn resets all expendable stats to their max values. 

    global $userrow, $numqueries; 

   $townquery = doquery("SELECT pointlvl,id FROM {{table}} WHERE  id='$id'  LIMIT 1", "users"); 
   $townquery2 = doquery("SELECT name,innprice, chiffreptlevel FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");  
    $townrow = mysql_fetch_array($townquery);     
	$townrow2 = mysql_fetch_array($townquery2);   
    
    if (isset($_POST["submit"])) {
	if ($userrow["currentaction"] == "En ville" ) {

        
       $newlevel = $userrow["pointlvl"] + $townrow2["chiffreptlevel"]; 
       $query = doquery("UPDATE {{table}} SET pointlvl='$newlevel' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
	   $title = "Bravo"; 

	   $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Bravo, vous venez de recevoir vos pointlevel<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>"; 
         } else {display("<table width=\"490\"><tr><td>C'est pas bien de vouloir tricher<br><br><br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>", "Auberge"); die(); }
    
	} elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Validez votre code"; 
        $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Votre code a été validé avec succès!<br><br>Pour augmenter votre personnage de <b>" .$townrow2["chiffreptlevel"] ." point perso</b> vous devez accepter. Dans le cas contraire cliquez sur refuser.</td></tr></table><br><br>\n"; 
        $page .= "<form action=\"index.php?do=cheatptlevel\" method=\"post\">\n"; 
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Accepter\" /> <input type=\"submit\" name=\"cancel\" value=\"Refuser\" />\n"; 
        $page .= "</form>\n"; 
        
    } 
    
    display($page, $title); 
   
   } 
   
   function cheatxp() { // Staying at the inn resets all expendable stats to their max values. 

    global $userrow, $numqueries; 

   $townquery = doquery("SELECT experience,id FROM {{table}} WHERE  id='$id'  LIMIT 1", "users"); 
   $townquery2 = doquery("SELECT name,innprice, chiffrexp FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");  
    $townrow = mysql_fetch_array($townquery);     
	$townrow2 = mysql_fetch_array($townquery2);   
    
    if (isset($_POST["submit"])) {
	if ($userrow["currentaction"] == "En ville" ) {

        
       $newlevel = $userrow["experience"] + $townrow2["chiffrexp"]; 
       $query = doquery("UPDATE {{table}} SET experience='$newlevel' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
	   $title = "Bravo"; 

	   $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Bravo, vous venez de recevoir vos xp<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>"; 
         } else {display("<table width=\"490\"><tr><td>C'est pas bien de vouloir tricher<br><br><br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>", "Auberge"); die(); }
    
	} elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Validez votre code"; 
        $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Votre code a été validé avec succès!<br><br>Pour augmenter votre personnage de <b>" .$townrow2["chiffrexp"] ." xp</b> vous devez accepter. Dans le cas contraire cliquez sur refuser.</td></tr></table><br><br>\n"; 
        $page .= "<form action=\"index.php?do=cheatxp\" method=\"post\">\n"; 
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

		$page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Bravo, vous venez de recevoir vos ".$townrow3["monnaie"]."<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>"; 
         } else {display("<table width=\"490\"><tr><td>C'est pas bien de vouloir tricher<br><br><br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">» retourner au sommaire de la ville</a></td></tr></table>", "Auberge"); die(); }
    
	} elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Validez votre code"; 

	    $page = "<table height=\"1\"><tr><td><img src=\"images/allopass.jpg\"/></td></tr></table><br><table width=\"490\"><tr><td>Votre code a été validé avec succès!<br><br>Pour obtenir vos <b>" .$townrow2["chiffrebanque"] ." ".$townrow3["monnaie"]."</b> vous devez accepter le don du banquier. Dans le cas contraire cliquez sur refuser.</td></tr></table><br><br>\n"; 
        $page .= "<form action=\"index.php?do=cheatbanque\" method=\"post\">\n"; 
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Accepter\" /> <input type=\"submit\" name=\"cancel\" value=\"Refuser\" />\n"; 
        $page .= "</form>\n"; 
        
    } 
    
    display($page, $title); 
   
   } 

 function bank() { // system de gestion de compte simple, retrait, depots.

	global $userrow, $numqueries;
    $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3); 
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
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.jpg\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier2.gif\" alt=\"Banquier\" /></center><br><center> Vous retirez $_POST[withdraw] ".$townrow3["monnaie"]." de votre compte!";
					$page .="Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
				}

			} elseif ($_POST['deposit']) {
				if ($_POST['deposit'] <= 0)
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier4.gif\" alt=\"Banquier\" /></center><br><center> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
     			elseif ($_POST['deposit'] > $userrow['gold'])
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier4.gif\" alt=\"Banquier\" /></center><br><center> Vous ne possédez pas autant ".$townrow3["monnaie"]." sur vous!<br>Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
   				else {
					$newgold = $userrow['gold'] - $_POST['deposit'];
					$newbank = $userrow['bank'] + $_POST['deposit'];
					doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
					doquery("UPDATE {{table}} SET bank='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
					$page = "<bgsound src=\"music/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier3.gif\" alt=\"Banquier\" /></center><br><center> Vous déposez $_POST[deposit] ".$townrow3["monnaie"]." sur votre compte!";
					$page .="Vous pouvez retourner en  <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=bank\">Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
				}
			}
		} else {
			$title = "Banque";
			$page = "<bgsound src=\"musiques/026-Town04.mid\" loop=10><center><img src=\"images/gold.gif\" alt=\"Banque\" /></center><br><br><br><center><img src=\"images/personnages/banquier.gif\" alt=\"Banquier\" /></center><br />";
			$page .= "<center>Vous possedez $userrow[bank] ".$townrow3["monnaie"]." sur votre compte.";
			$page .= "<form action=index.php?do=bank method=post><br />";
			$page .= "Deposer :<input type=text name=deposit><br />";
			$page .= "Retirer :<input type=text name=withdraw><br />";
			$page .= "<input type=submit value=Valider name=bank></form><br>";
            $page .= "<br>Vous pouvez aussi déposer des objets dans <a href='index.php?do=stockobjets'>les coffres de la banque</a>, <a href='index.php?do=sendgold'>Envoyé de l'argent</a>,<a href='index.php?do=sendeat'>Envoyé des pommes</a>,<a href='index.php?do=sendpotion'>Envoyé Potion</a> ou retourner en  <a href=\"index.php\">Ville</a>, Ou utiliser le menu de gauche pour repartir en exploration.</center>";
		}

	display($page, $title);

}





function inn() { // Staying at the inn resets all expendable stats to their max values. 

    global $userrow, $numqueries; 

    $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3); 
    
    if ($userrow["gold"] < $townrow["innprice"]) { display("<center><img src=\"././/images/aub.gif\"/></center><br> Vous n'avez pas assez de ".$townrow3["monnaie"]." pour dormir dans cette auberge ce soir.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Auberge"); die(); } 
    
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
        $page .= "Une nuit dans cette auberge vous coûtera <b>" . $townrow["innprice"] . " ".$townrow3["monnaie"]."</b>. Est ce que vous acceptez?<br /><br />\n"; 
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
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3);

    if ($userrow["gold"] < $townrow["homeprice"]) { display("<center><img src=\"images/nomaison.jpg\"/></center><br> Vous n'avez pas assez de ".$townrow3["monnaie"]." pour créer cette maison.<br />Il faut impérativement " . $townrow["homeprice"] . " ".$townrow3["monnaie"]." pour en créer une.<br><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Créer une maison"); die(); } 
   

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
        $page = "Ici vous avez la possiblité de créer votre propre maison pour " . $townrow["homeprice"] . " ".$townrow3["monnaie"]." et de gagner grace à elle des ".$townrow3["monnaie"]."<BR><br />\n"; 
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
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3);
    
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
             $page .= "<td width=\"32%\"><b><a href=\"index.php?do=buy2:".$itemsrow["id"]."\">".$itemsrow["name"]."</a>$specialdot</b></td><td width=\"32%\">$attrib <b>".$itemsrow["attribute"]."</b></td><td width=\"32%\">Prix: <b>".$itemsrow["buycost"]." ".$townrow3["monnaie"]."</b></td></tr><tr><br><td colspan=4><b>Description:&nbsp; </b>".$itemsrow["description"]."</td></tr>\n"; } 
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
    
    if ($userrow["gold"] < $itemsrow["buycost"]) { display("<img src=\"././images/shop.gif\"/><br>Vous n'avez pas assez de ".$townrow3["monnaie"]." pour acheter cet objet.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=buy\">au magasin</a>, ou utilisez les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter objets"); die(); } 
    
    if ($itemsrow["type"] == 1) { 
        if ($userrow["weaponid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["weaponid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
            $page = "<img src=\"././images/shop.gif\"/><br>Si vous achetez le ".$itemsrow["name"].", alors j'achèterai le votre ".$itemsrow2["name"]." pour ".ceil($itemsrow2["buycost"]/2)." ".$townrow3["monnaie"].". Vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } else { 
            $page = "<img src=\"././images/shop.gif\"/><br>Vous allez acheter ".$itemsrow["name"].", vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } 
    } elseif ($itemsrow["type"] == 2) { 
        if ($userrow["armorid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["armorid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
            $page = "<img src=\"././images/shop.gif\"/><br>Si vous achetez le ".$itemsrow["name"].", alors j'achèterai le votre ".$itemsrow2["name"]." pour ".ceil($itemsrow2["buycost"]/2)." ".$townrow3["monnaie"].". Vous êtes d'acord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } else { 
            $page = "<img src=\"././images/shop.gif\"/><br>Vous allez acheter ".$itemsrow["name"].", vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
        } 
    } elseif ($itemsrow["type"] == 3) { 
        if ($userrow["shieldid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["shieldid"]."' LIMIT 1", "items"); 
            $itemsrow2 = mysql_fetch_array($itemsquery2); 
            $page = "<img src=\"././images/shop.gif\"/><br>Si vous achetez le ".$itemsrow["name"].", alors j'achèterai le votre ".$itemsrow2["name"]." pour ".ceil($itemsrow2["buycost"]/2)." ".$townrow3["monnaie"].". Vous êtes d'accord?<br /><br /><form action=\"index.php?do=buy3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
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
    
    if ($userrow["gold"] < $itemsrow["buycost"]) { display("<img src=\"././images/shop.gif\"/><br>Vous n'avez pas assez de ".$townrow3["monnaie"]." pour acheter cet objet.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=buy\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter objets"); die(); } 
    
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
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3);
    while ($townrow = mysql_fetch_array($townquery)) { 
        
        if ($townrow["latitude"] >= 0) { $latitude = $townrow["latitude"] . "N,"; } else { $latitude = ($townrow["latitude"]*-1) . "S,"; } 
        if ($townrow["longitude"] >= 0) { $longitude = $townrow["longitude"] . "E"; } else { $longitude = ($townrow["longitude"]*-1) . "O"; } 
        
        $mapped = false; 
        foreach($mappedtowns as $a => $b) { 
            if ($b == $townrow["id"]) { $mapped = true; } 
        } 
        if ($mapped == false) { 
            $page .= "<tr><td width=\"25%\"><a href=\"index.php?do=maps2:".$townrow["id"]."\">".$townrow["name"]."</a></td><td width=\"25%\">Prix: ".$townrow["mapprice"]." ".$townrow3["monnaie"]."</td><td width=\"50%\" colspan=\"2\">Achetez la carte pour avoir des infos.</td></tr>\n"; 
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
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3);
    
    if ($userrow["gold"] < $townrow["mapprice"]) { display("Vous n'avez pas assez de ".$townrow3["monnaie"]." pour acheter cette carte.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=maps\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter cartes"); die(); } 
    
    $page = "<img src=\"././images/carte.gif\"/><br>Vous allez acheter la carte de ".$townrow["name"]." . Vous êtes d'accord?<br /><br /><form action=\"index.php?do=maps3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>"; 
    
    display($page, "Acheter cartes"); 
    
} 

function maps3($id) { // Add new map to user's profile. 
    
    if (isset($_POST["cancel"])) { header("Location: index.php"); die(); } 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,mapprice FROM {{table}} WHERE id='$id' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3);
    
    if ($userrow["gold"] < $townrow["mapprice"]) { display("Vous n'avez pas assez de ".$townrow3["monnaie"]." pour acheter cette carte.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=maps\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.", "Acheter cartes"); die(); } 
    
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
    
function marche() { // affiche la liste des différents objets disponibles.

global $userrow, $numqueries;

$townquery = doquery("SELECT name,itemslistb FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
$townrow3 = mysql_fetch_array($townquery3);
if (mysql_num_rows($townquery) != 1) { display("Tentative de triche detectée.<br /><br />attention le bannissement n'est pas loin.", "Error"); }
$townrow = mysql_fetch_array($townquery);

$itemslistb = explode(",",$townrow["itemslistb"]);
$querystring = "";
foreach($itemslistb as $a=>$b) {
$querystring .= "id='$b' OR ";
}
$querystring = rtrim($querystring, " OR ");

$itemsquery = doquery("SELECT * FROM {{table}} WHERE $querystring ORDER BY id", "items2");
$page = "<bgsound src=\"musiques/030-Town08.mid\" loop=2>";
$page .= "<img src=\"images/marche.gif\" alt=\"marché\" /><br><br><br><img src=\"images/personnages/marche.gif\" alt=\"Vendeuse\" /><br>Bienvenu sur le marché, ici vous trouverez toutes sortes de produits. De la nourriture en passant par des objets magiques.<br /><br />Cliquez sur le nom d'un objet pour l'acheter.<br /><br />Les objets suivants sont disponibles ici:<br /><br />\n";
$page .= "<table width=\"80%\">\n";
while ($itemsrow = mysql_fetch_array($itemsquery)) {
if ($itemsrow["type"] == 1) { $attrib = "Type:"; } else { $attrib = "Type:"; }
$page .= "<tr><td width=\"4%\">";
if ($itemsrow["type"] == 7) { $page .= "<img src=\"images/icon_potion.gif\" alt=\"Potion\" /></td>"; }
if ($itemsrow["type"] == 8) { $page .= "<img src=\"images/icon_parchment.gif\" alt=\"sort\" /></td>"; }
if ($itemsrow["type"] == 9) { $page .= "<img src=\"images/icon_paxe.gif\" alt=\"Outil\" /></td>"; }
if ($itemsrow["type"] == 10) { $page .= "<img src=\"images/icon_ring.gif\" alt=\"Anneau\" /></td>"; }
if ($itemsrow["type"] == 11) { $page .= "<img src=\"images/icon_amulet.gif\" alt=\"Amulettes\" /></td>"; }
if ($itemsrow["type"] == 12) { $page .= "<img src=\"images/icon_drink.gif\" alt=\"Nourriture\" /></td>"; }
if ($itemsrow["special"] != "X") { $specialdot = "<span class=\"highlight\">*</span>"; } else { $specialdot = ""; }
$page .= "<td width=\"32%\"><b><a href=\"index.php?do=marche2:".$itemsrow["id"]."\">".$itemsrow["name"]."</a>$specialdot</b></td><td width=\"32%\">$attrib <b>".$itemsrow["genre"]."</b></td><td width=\"32%\">Prix: <b>".$itemsrow["buycost"]." ".$townrow3["monnaie"]."</b></td></tr>\n";
}
$page .= "</table><br />\n";
$page .= "Si vous changez d'avis, vous pouvez retourner en <a href=\"index.php\">Ville</a>.\n";
$title = "Buy Items";

display($page, $title);
}

function marche2($id) { // Confirme le choix de l'achat.

global $userrow, $numqueries;

$townquery = doquery("SELECT name,itemslistb FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
if (mysql_num_rows($townquery) != 1) { display("Tentative de Triche.<br /><br />Bannissement imminent.", "Error"); }
$townrow = mysql_fetch_array($townquery);
$townitems = explode(",",$townrow["itemslistb"]);
if (! in_array($id, $townitems)) { display("Tentative de Triche.<br /><br />Bannissement imminent.", "Error"); }

$itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items2");
$itemsrow = mysql_fetch_array($itemsquery);

if ($userrow["gold"] < $itemsrow["buycost"]) { display("<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche1.gif\" alt=\"Vendeuse\" /><br><br /><br />Vous pouvez retourner en <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=marche\">Au magasin</a>, Ou utiliser le menu de gauche pour repartir en exploration.", "Buy Items"); die(); }

if ($itemsrow["type"] == 7) {
$page = "<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche2.gif\" alt=\"Vendeuse\" /><br>Vous voulez acheter un ".$itemsrow["name"].", C'est cela ?<br /><br /><form action=\"index.php?do=marche3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>";
} elseif ($itemsrow["type"] == 8) {
$page = "<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche2.gif\" alt=\"Vendeuse\" /><br>Vous voulez acheter un ".$itemsrow["name"].", C'est cela?<br /><br /><form action=\"index.php?do=marche3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form>";
} elseif ($itemsrow["type"] == 9) {
$page = "<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche2.gif\" alt=\"Vendeuse\" /><br>Vous voulez acheter un ".$itemsrow["name"].", C'est cela?<br /><br /><form action=\"index.php?do=marche3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non \" /></form>";
} elseif ($itemsrow["type"] == 10) {
$page = "<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche2.gif\" alt=\"Vendeuse\" /><br>Vous voulez acheter un ".$itemsrow["name"].", C'est cela?<br /><br /><form action=\"index.php?do=marche3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non \" /></form>";
} elseif ($itemsrow["type"] == 11) {
$page = "<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche2.gif\" alt=\"Vendeuse\" /><br>Vous voulez acheter un ".$itemsrow["name"].", C'est cela ?<br /><br /><form action=\"index.php?do=marche3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non \" /></form>";
} elseif ($itemsrow["type"] == 12) {
$page = "<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche2.gif\" alt=\"Vendeuse\" /><br>Vous voulez acheter un ".$itemsrow["name"].", C'est cela ?<br /><br /><form action=\"index.php?do=marche3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non \" /></form>";
}
$title = "Buy Items";
display($page, $title);

}
function marche3($id) { // Ajoute l'objet a votre sac.

if (isset($_POST["cancel"])) { header("Location: index.php"); die(); }

global $userrow, $numqueries;

$itemquery = doquery("SELECT name,buycost,type FROM {{table}} WHERE id='$id' LIMIT 1", "items2");
$itemsrow = mysql_fetch_array($itemquery);

if ($userrow["gold"] < $itemrow["buycost"]) { display("<img src=\"././images/marche.gif\"/><br><br /><br><br><br><img src=\"images/personnages/marche.gif\" alt=\"Vendeuse\" /><br><br /><br />Vous pouvez retourner en <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=marche\">Au marche</a>, ou partir en exploration grace au menu de gauche.", "Acheter cartes"); die(); }

$newgold = $userrow["gold"] - $itemsrow["buycost"];

if ($itemsrow["type"] == 7) { $userrow["itemsac1qt"] = $userrow["itemsac1qt"] + 1;
} elseif ($itemsrow["type"] == 8) { $userrow["itemsac2qt"] = $userrow["itemsac2qt"] + 1;
} elseif ($itemsrow["type"] == 9) { $userrow["itemsac3qt"] = $userrow["itemsac3qt"] + 1;
} elseif ($itemsrow["type"] == 10) { $userrow["itemsac4qt"] = $userrow["itemsac4qt"] + 1;
} elseif ($itemsrow["type"] == 11) { $userrow["itemsac5qt"] = $userrow["itemsac5qt"] + 1;
} elseif ($itemsrow["type"] == 12) { $userrow["itemsac6qt"] = $userrow["itemsac6qt"] + 1;
}
$item1 = $userrow["itemsac1qt"];
$item2 = $userrow["itemsac2qt"];
$item3 = $userrow["itemsac3qt"];
$item4 = $userrow["itemsac4qt"];
$item5 = $userrow["itemsac5qt"];
$item6 = $userrow["itemsac6qt"];

$updatequery = doquery("UPDATE {{table}} SET itemsac1qt='$item1',itemsac2qt='$item2',itemsac3qt='$item3',itemsac4qt='$item4',itemsac5qt='$item5',itemsac6qt='$item6',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");

display("<img src=\"images/marche.gif\" alt=\"Marché\" /><br><br><br><img src=\"images/personnages/marche3.gif\" alt=\"Vendeuse\" /><br><br /><br />Vous pouvez retourner en <a href=\"index.php\">Ville</a>, <a href=\"index.php?do=marche\">Au marche</a>, ou partir en exploration grace au menu de gauche.", "Acheter items");

}

function revente () { // revente de votre minerais 

global $userrow, $numqueries; 
$townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns"); 
$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
$townrow3 = mysql_fetch_array($townquery3);

if (isset($_POST['bank'])) { 
$title = "Bank"; 

if ($_POST['cuivre']) { 
if ($_POST['cuivre'] <= 0) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
elseif ($_POST['cuivre'] > $userrow['cuivre']) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous n'avez pas autant de Cuivre!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
else { 
$newgold = $userrow['gold'] + $_POST['cuivre'] * 20; 
$newbank = $userrow['argent'] - $_POST['cuivre']; 
doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET cuivre='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.jpg' alt='banque' /><br><br><br><br>"; 
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
} 

} 
elseif ($_POST['fer']) { 
if ($_POST['fer'] <= 0) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
elseif ($_POST['fer'] > $userrow['fer']) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br> Vous ne possédez pas autant de Fer sur vous!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
else { 
$newgold = $userrow['gold'] + $_POST['fer'] * 30; 
$newbank = $userrow['argent'] - $_POST['fer']; 
doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET fer='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br>"; 
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
} 

} elseif ($_POST['argent']) { 
if ($_POST['argent'] <= 0) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
elseif ($_POST['argent'] > $userrow['argent']) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br> Vous ne possédez pas autant d' Argent sur vous!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
else { 
$newgold = $userrow['gold'] + $_POST['argent'] * 40; 
$newbank = $userrow['argent'] - $_POST['argent']; 
doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET argent='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br>"; 
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
} 


} elseif ($_POST['platine']) { 
if ($_POST['platine'] <= 0) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
elseif ($_POST['platine'] > $userrow['platine']) 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br> Vous ne possédez pas autant de Platine sur vous!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
else { 
$newgold = $userrow['gold'] + $_POST['platine'] * 50; 
$newbank = $userrow['argent'] - $_POST['platine']; 
doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
doquery("UPDATE {{table}} SET platine='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><br><br><br><br>"; 
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=revente'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
} 

} 
} else { 
$title = "Banque"; 
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><br><br><br><br />"; 
$page .= " 

<div align='center'> 
<table width='343' border='1'> 
<tr> 
<td width='74'>&nbsp;</td> 
<td width='55'>Cuivre</td> 
<td width='54'>Fer</td> 
<td width='58'>Argent</td> 
<td width='68'>Platine</td> 
</tr> 
<tr> 
<td>Prix a l'unité </td> 
<td><div align='center'>20</div></td> 
<td><div align='center'>30</div></td> 
<td><div align='center'>40</div></td> 
<td><div align='center'>50</div></td> 
</tr> 
</table> 
</div> 

"; 
$page .= "<div align='center'>"; 
$page .= "<form action=index.php?do=revente method=post><br />"; 
$page .= "Cuivre :<input type=text name=cuivre><br />"; 
$page .= "Fer :<input type=text name=fer><br />"; 
$page .= "Argent :<input type=text name=argent><br />"; 
$page .= "Platine :<input type=text name=platine><br />"; 
$page .= "<input type=submit value=Valider name=bank></form><br>"; 
$page .= "</div>"; 

$page .= "<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, Ou utiliser le menu de gauche pour repartir en exploration."; 
} 

display($page, $title); 

} 

function pretre() { // Passer chez le soigneur vous rends tous vos PV pour 3 gold.

global $userrow, $numqueries;

$townquery = doquery("SELECT name,prixsoigneur FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
$townrow3 = mysql_fetch_array($townquery3);
if (mysql_num_rows($townquery) != 1) { display("Tentative de triche detectée.<br /><br />attention le bannissement n'est pas loin.", "Error"); }
$townrow = mysql_fetch_array($townquery);

if ($userrow["gold"] < $townrow["prixsoigneur"]) { display("<img src=\"images/church.jpg\" alt=\"Eglise\" /><br><br><br><img src=\"images/personnages/soeur1.gif\" alt=\"soeur\" /><br>Vous avez besoin de 3 ".$townrow3["monnaie"]." pour des soins.<br /><br />Vous pouvez retourner en <a href=\"index.php\">Ville</a>, ou utiliser le menu de gauche pour explorer.", "Inn"); die(); }

if (isset($_POST['submit'])) {

$newgold = $userrow["gold"] - $townrow["prixsoigneur"];
$query = doquery("UPDATE {{table}} SET gold='$newgold',currenthp='".$userrow["maxhp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Soigneur";
$page = "<img src=\"images/title_eglise.gif\" alt=\"Eglise\" /><br><br><br><img src=\"images/personnages/soeur3.gif\" alt=\"soeur\" /><br /><br />Vous pouvez retourner <a href=\"index.php\">En ville</a>, Ou partir directement en exploration en utilisant le menu de gauche (directions).";

} elseif (isset($_POST["cancel"])) {

header("Location: index.php"); die();

} else {

$title = "Pretre";
$page = "<bgsound src=\"musiques/032-Church01.mid\" loop=2>";
$page .= "<img src=\"images/title_eglise.gif\" alt=\"Eglise\" /><br><br><br><img src=\"images/personnages/soeur.gif\" alt=\"Soeur\" /><br> Cela vous coutera 3 ".$townrow3["monnaie"]." le soin complet<br><br /><br />\n";
$page .= "<form action=\"index.php?do=pretre\" method=\"post\">\n";
$page .= "<input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" />\n";
$page .= "</form>\n";


}

display($page, $title);
}

function enchanteur() { // Passer chez l'enchanteur vous rends tous vos PM pour X gold.

global $userrow, $numqueries;

$townquery = doquery("SELECT name,prixenchanteur FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
$townrow3 = mysql_fetch_array($townquery3);
if (mysql_num_rows($townquery) != 1) { display("Tentative de triche detectée.<br /><br />attention le bannissement n'est pas loin.", "Error"); }
$townrow = mysql_fetch_array($townquery);

if ($userrow["gold"] < $townrow["prixenchanteur"]) { display("<bgsound src=\"musiques/029-Town07.mid\" loop=10><img src=\"images/title_magicienne.gif\" alt=\"Maison de la magicienne\" /><br><br><br><img src=\"images/personnages/magicienne2.gif\" alt=\"magicienne\" /><br>Vous avez besoin de 3 ".$townrow3["monnaie"]." pour reccuperer vos PM.<br /><br />Vous pouvez retourner en <a href=\"index.php\">Ville</a>, ou utiliser le menu de gauche pour explorer.", "Inn"); die(); }

if (isset($_POST['submit'])) {

$newgold = $userrow["gold"] - $townrow["prixenchanteur"];
$query = doquery("UPDATE {{table}} SET gold='$newgold',currentmp='".$userrow["maxmp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Soigneur";
$page = "<bgsound src=\"musiques/029-Town07.mid\" loop=10><img src=\"images/title_magicienne.gif\" alt=\"Maison de la magicienne\" /><br><br><br><img src=\"images/personnages/magicienne3.gif\" alt=\"Magicienne\" /><br /><br />Vous pouvez retourner <a href=\"index.php\">En ville</a>, Ou partir directement en exploration en utilisant le menu de gauche (directions).";

} elseif (isset($_POST["cancel"])) {

header("Location: index.php"); die();

} else {

$title = "Magicienne";
$page = "<bgsound src=\"musiques/029-Town07.mid\" loop=10><img src=\"images/title_magicienne.gif\" alt=\"Maison de la magicienne\" /><br><br><br><img src=\"images/personnages/magicienne.gif\" alt=\"Soeur\" /><br> Cela vous coutera 3 ".$townrow3["monnaie"]." reccuperer tout vos PM<br><br /><br />\n";
$page .= "<form action=\"index.php?do=enchanteur\" method=\"post\">\n";
$page .= "<input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" />\n";
$page .= "</form>\n";


}

display($page, $title);

}

function point($id) { // Permet d'augmentez ca force et son attaque.

global $userrow, $numqueries;
$townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");


if (isset($_POST['bank'])) {
$title = "Bank";

if ($_POST['hit']) {
if ($_POST['hit'] <= 0)
$page = "<bgsound src='musique/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
elseif ($_POST['hit'] > $userrow['pointlvl'])
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous n'avez pas autant de point!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
else {
$newgold = $userrow['pointlvl'] - $_POST['hit'];
$newbank = $userrow['maxhp'] + $_POST['hit'];
doquery("UPDATE {{table}} SET pointlvl='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
doquery("UPDATE {{table}} SET maxhp='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.jpg' alt='banque' /><br><br><br><br>";
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
}

} elseif ($_POST['magie']) {
if ($_POST['magie'] <= 0)
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
elseif ($_POST['magie'] > $userrow['pointlvl'])
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous n'avez pas autant de point!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
else {
$newgold = $userrow['pointlvl'] - $_POST['magie'];
$newbank = $userrow['maxmp'] + $_POST['magie'];
doquery("UPDATE {{table}} SET pointlvl='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
doquery("UPDATE {{table}} SET maxmp='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.jpg' alt='banque' /><br><br><br><br>";
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
}


} elseif ($_POST['travel']) {
if ($_POST['travel'] <= 0)
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
elseif ($_POST['travel'] > $userrow['pointlvl'])
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous n'avez pas autant de point!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
else {
$newgold = $userrow['pointlvl'] - $_POST['travel'];
$newbank = $userrow['maxtp'] + $_POST['travel'];
doquery("UPDATE {{table}} SET pointlvl='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
doquery("UPDATE {{table}} SET maxtp='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.jpg' alt='banque' /><br><br><br><br>";
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
}


} elseif ($_POST['dex']) {
if ($_POST['dex'] <= 0)
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
elseif ($_POST['dex'] > $userrow['pointlvl'])
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous n'avez pas autant de point!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
else {
$newgold = $userrow['pointlvl'] - $_POST['dex'];
$newbank = $userrow['dexterity'] + $_POST['dex'];
doquery("UPDATE {{table}} SET pointlvl='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
doquery("UPDATE {{table}} SET dexterity='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.jpg' alt='banque' /><br><br><br><br>";
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
}


} elseif ($_POST['force']) {
if ($_POST['force'] <= 0)
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous devez entrer un montant supérieur a 0!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
elseif ($_POST['force'] > $userrow['pointlvl'])
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.gif' alt='banque' /><img src='images/gold.jpg' alt='banque' /><br><br><br><br> Vous n'avez pas autant de point!<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
else {
$newgold = $userrow['pointlvl'] - $_POST['force'];
$newbank = $userrow['strength'] + $_POST['force'];
doquery("UPDATE {{table}} SET pointlvl='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
doquery("UPDATE {{table}} SET strength='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><img src='images/gold.jpg' alt='banque' /><br><br><br><br>";
$page .="Vous pouvez retourner en <a href='index.php'>Ville</a>, <a href='index.php?do=point'>Au guichet</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
}
}
} else {
$hit = $userrow['maxhp'] ;
$magie = $userrow['maxmp'] ;
$travel = $userrow['maxtp'] ;
$force = $userrow['strength'] ;
$dex = $userrow['dexterity'] ;
$point = $userrow['pointlvl'] ;

$title = "Banque";
$page = "<bgsound src='musiques/026-Town04.mid' loop=10><br><br><br><br />";
$page .= "<div align='center'>";
$page .= "Il vout reste encore $point à distribuer";
$page .= "
<form action=index.php?do=point method=post>
<p><br />
points vie :
<input name=hit type=text id='hit'>
($hit) </p>
<p>points de magie :
<input name=magie type=text id='magie'>
($magie) </p>
<p>points de voyage :
<input name=travel type=text id='travel'>
($travel) </p>
<p>points de force :
<input name=force type=text id='force'>
($force) </p>
<p> points de dextérité :
<input name=dex type=text id='dex'>
($dex)<br />
<input type=submit value=Valider name=bank>
</p>
</form><br>
";

$page .= "</div>";

$page .= "<br>Vous pouvez retourner en <a href='index.php'>Ville</a>, Ou utiliser le menu de gauche pour repartir en exploration.";
}

display($page, $title);
}

function profil() {

global $controlrow, $userrow;

if (isset($_POST["submit"])) {

extract($_POST);
$errors = 0;
$errorlist = "";

if ($avatar == "") { $errors++; $errorlist .= "Le numéro de l'avatar est exigé.<br />"; }
if ($email == "") { $errors++; $errorlist .= "L'Email est exigé.<br />"; }
if ($charname == "") { $errors++; $errorlist .= "Le nom de votre perso est exigée.<br />"; }

if ($errors == 0) { 

$id = $userrow["id"];
$updatequery = <<<END
UPDATE {{table}} SET
avatar="$avatar",age="$age", email="$email", charname="$charname", signature="$signature" WHERE id="$id" LIMIT 1
END;
$query = doquery($updatequery, "users");
display("<p class='Style5'>Votre profil à été mis à jour.<br><br> Retourner <a href='index.php'> au jeu</a>.","Profil");
} else {
display("<b>Erreurs:</b><br /><div style='color:red;'>$errorlist</div><br />Veuillez retourner et essayer encore.", "Profil");
}

}

$query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "users");
$row = mysql_fetch_array($query);
$name = "".$userrow["charname"].""; 
$email = "".$userrow["email"]."";
$age = "".$userrow["age"].""; 
$signature = "".$userrow["signature"].""; 


$page = <<<END
<img src='images/banmini10.gif'><br><br><p class='Style5'><b><u>Editer votre profil</u></b><br /><br />
<table width="90%">
<form action="index.php?do=profil" method="post">
<tr><td width="50%"><p class='Style5'>Avatar du perso:</td><td><select name="avatar" ><option value="num-1.gif">numéro 1</option><option value="num-2.gif">numéro 2</option><option value="num-3.gif">numéro 3</option><option value="num-4.gif">numéro 4</option><option value="num-5.gif">numéro 5</option><option value="num-6.gif">numéro 6</option><option value="num-7.gif">numéro 7</option><option value="num-8.gif">numéro 8</option><option value="num-9.gif">numéro 9</option><option value="num-10.gif">numéro 10</option>
<option value="num-11.gif">numéro 11</option><option value="num-12.gif">numéro 12</option><option value="num-13.gif">numéro 13</option><option value="num-14.gif">numéro 14</option><option value="num-15.gif">numéro 15</option><option value="num-16.gif">numéro 16</option><option value="num-17.gif">numéro 17</option><option value="num-18.gif">numéro 18</option><option value="num-19.gif">numéro 19</option><option value="num-20.gif">numéro 20</option>
<option value="num-21.gif">numéro 21</option><option value="num-22.gif">numéro 22</option><option value="num-23.gif">numéro 23</option><option value="num-24.gif">numéro 24</option><option value="num-25.gif">numéro 25</option><option value="num-26.gif">numéro 26</option><option value="num-27.gif">numéro 27</option><option value="num-28.gif">numéro 28</option><option value="num-29.gif">numéro 29</option>
<option value="num-30.gif">numéro 30</option></select></td></tr>
<tr><td colspan="2"><p class='Style5'>Pour voir tous les avatars <A HREF="#" onClick="window.open('avatar.php','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=400, height=800');return(false)">cliquez ici.</A></td></tr>
<tr><td width="50%"><p class='Style5'>Nom du personnage:</td><td><input type="text" name="charname" value="$name" size="30" maxlength="30"/></td></tr>
<tr><td width="50%"><p class='Style5'>Age du personnage:</td><td><input type="text" name="age" value="$age" size="30" maxlength="30"/></td></tr>
<tr><td width="50%"><p class='Style5'>Votre email:</td><td><input type="text" name="email" value="$email" size="30" maxlength="30"/></td></tr>
<center><p class='Style5'><a href="index.php?do=av"><b><u>Uploadez votre prore avatar</b></a></td></tr>
<center><p class='Style5'><a href="index.php?do=delete">&nbsp;<b><u>Supprimez votre compte</b></a><br><p></td></tr>
<tr><td width="50%"><p class='Style5'><b><u>Option Forum</b></u><br></tr></td>
<tr><td width="50%"><p class='Style5'>Votre signature:</td><td><textarea name="signature" size="30" maxlength="30"/>$signature</textarea><br><p class='Style5'><A HREF="#" onClick="window.open('smile.php','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=500, height=100');return(false)"><b>Smile et Bbcode</b></A><br /></td></tr> 
</table><p><p>
<input type="submit" name="submit" value="Valider" />
</form>
END;

if ($row[""] == 1) { $row[""] = "selected='selected' "; } else { $row[""] = ""; }
$page = parsetemplate($page, $row);

	  $page .= "<p class='Style5'><br><a href='index.php'> Retourner au jeu.</a>"; 
display($page, "Modifier votre profil");

}

function mag() { // List maps the user can buy
    
    global $userrow, $numqueries; 
	
    
    $mappedtowns = explode(",",$userrow["spells"]); 
    
    $page .= "Cliquez sur le nom de la technique souhaité pour acheter son parchemin.<br /><br />\n"; 
    $page .= "<table width='95%'><tr><td width='50%'>\n"; 
    
    $townquery = doquery("SELECT * FROM {{table}} ORDER BY id", "spells"); 
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3);
    while ($townrow = mysql_fetch_array($townquery)) { 
        
        if ($townrow["latitude"] >= 0) { $latitude = $townrow["latitude"] . "N,"; } else { $latitude = ($townrow["latitude"]*-1) . "S,"; } 
        if ($townrow["longitude"] >= 0) { $longitude = $townrow["longitude"] . "E"; } else { $longitude = ($townrow["longitude"]*-1) . "O"; } 
        
        $mapped = false; 
        foreach($mappedtowns as $a => $b) { 
            if ($b == $townrow["id"]) { $mapped = true; } 
        } 
        if ($mapped == false) { 
            $page .= "<a href=\"index.php?do=mag2:".$townrow["id"]."\">- ".$townrow["name"]."</a> ".$townrow["price"]." ".$townrow3["monnaie"]."<br>\n"; 
        } else { 
            $page .= "<span class=\"light\"><b>- ".$townrow["name"]."</b></span><span class=\"light\">  (".$townrow["mp"]." cha)</span><br>\n"; 
        } 
        
    } 
	
    $page .= "<br><br /><br><br><br /><br><br /><br>Vous pouvez <a href=\"index.php\">retourner à la ville</a>.</td><td><img src='images/dojo.jpg'><br />Attention un ninja ne peut apprendre que 18 techniques qui ne sont pas interchangable(les sorts Irou Ninjutsu et Shousen Jutsu sont des sorts de regeneration de chakra).<br><br />
	</td></tr></table>\n";
	  
    $page .= "</table>\n"; 
    
    display($page, "Acheter techniques"); 
    
} 

function mag2($id) { // Confirm user's intent to purchase map. 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,price FROM {{table}} WHERE id='$id' LIMIT 1", "spells"); 
    $townrow = mysql_fetch_array($townquery); 
    
    if ($userrow["gold"] < $townrow["price"]) { display("Vous n'avez pas assez de ".$townrow3["monnaie"]." pour acheter ce parchemin.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=mag\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.</table>", "Acheter cartes"); die(); } 
    
    $page = "<center><br>Vous allez acheter le parchemin de ".$townrow["name"]." . Vous êtes d'accord?<br /><br /><form action=\"index.php?do=mag3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" /></form></table>"; 
    
    display($page, "Acheter parchemin"); 
    
} 

function mag3($id) { // Add new map to user's profile. 
    
    if (isset($_POST["cancel"])) { header("Location: index.php"); die(); } 
    
    global $userrow, $numqueries; 
    
    $townquery = doquery("SELECT name,price FROM {{table}} WHERE id='$id' LIMIT 1", "spells"); 
    $townrow = mysql_fetch_array($townquery); 
    
    if ($userrow["gold"] < $townrow["price"]) { display("Vous n'avez pas assez de ".$townrow3["monnaie"]." pour acheter ce parchemin.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=mag\">à l'ecole</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.</table>", "Acheter parchemin"); die(); } 
    
    $mappedtowns = $userrow["spells"].",$id"; 
    $newgold = $userrow["gold"] - $townrow["price"]; 
    
    $updatequery = doquery("UPDATE {{table}} SET spells='$mappedtowns',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 
    
    display("<br>Merci pour l'achat de ce parchemin.<br /><br />Vous pouvez <a href=\"index.php\">retourner à la ville</a>, <a href=\"index.php?do=mag\">au magasin</a>, ou utiliser les boutons directionnel de gauche pour continuer à explorer le monde.</table>", "Acheter parchemin"); 
    
} 
  
function av() {

global $userrow;

$page .= '<div style="height:auto;margin:auto;width:300px;text-align:center;">'; 
$page .= '<form id="avatar" action="" method="post" enctype="multipart/form-data">';

(file_exists("images/avatar/".$userrow[id].".jpg") AND !file_exists("images/avatar/".$userrow[id].".gif"))? $type="jpg":$type="gif";

if(file_exists("images/avatar/".$userrow[id].".jpg") OR file_exists("images/avatar/".$userrow[id].".gif"))
{ 
$page .= ' <br /><span class="p">Votre avatar actuel : </span><br /><br />';
$page .= '<img style="border:0px;" alt="Votre avatar" src="images/avatar/'.$userrow[id].'.'.$type.'" />';

$page .= '<p><input type="submit" value="Supprimer" name="suppr" /><br /><br /></p>'; 
}

$page .= '<br /><br />';

$page .= 'Changer :<br /><input type="file" name="avatar" /><input type="submit" name="ok" value="Ok!" /></p></form></div>';

$ok = $_POST['ok'];
$typavt = $_FILES['avatar']['type'];
$sizavt = $_FILES['avatar']['size'];
$tmpavt = $_FILES['avatar']['tmp_name'];
$suppr = $_POST['suppr'];

error_reporting(0);

$tllavt = GetImageSize($tmpavt);

error_reporting(1);


$err = "";

if($typavt != "image/jpeg" AND 
$typavt != "image/pjpeg" AND 
$typavt != "image/gif" AND
!empty($avatar))
{
$err .= ' Erreur : Le format de vôtre avatar est refusé !<br />';
}

if($sizavt > 10 * 1024)
{
$err .= ' Erreur : la taille de vôtre avatar est supérieure à 10Ko ! <br />';
}

if($tllavt[0] > 128 OR 
$tllavt[1] > 128)
{
$err .= ' Erreur : vôtre avatar dépasse les dimensions maximales ( 128x128 ) ! <br />';
}
$page .= $err;

if($typavt == "image/pjpeg" OR $typavt == "image/jpeg")
{
$ext_avt = ".jpg";
}
elseif($typavt == "image/gif")
{
$ext_avt = ".gif";
}
@chmod ("avatar", 0777); 
if(isset($suppr))
{
unlink('images/avatar/'.$userrow[id].'.gif');
unlink('images/avatar/'.$userrow[id].'.jpg');
$page .= '<span class="p" style="text-align:center;">Votre avatar a bien été supprimé ! </span>';
}


if (strlen($err) < 1 && $ok == "Ok!" && !isset($suppr))
{

unlink('images/avatar/'.$userrow[id].'.gif');
unlink('images/avatar/'.$userrow[id].'.jpg');
move_uploaded_file($tmpavt,'images/avatar/'.$userrow[id].$ext_avt);
$page .= '<br /> <span class="p" style="text-align:center;">Votre avatar a bien été remplacé ! </span>';

$up = mysql_query("UPDATE rpg_users SET avatar='".$userrow[id].$ext_avt."' WHERE id='".$userrow[id]."'");

}

display($page, "Changer avatar");
}

?>