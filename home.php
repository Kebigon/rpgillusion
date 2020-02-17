<?php // towns.php :: Handles all actions you can do in town. 

function travelto($id, $usepoints=true) { // Send a user to a town from the Travel To menu. 
    
    global $userrow, $numqueries; 
    
    $homequery = doquery("SELECT name,latitude,longitude FROM {{table}} WHERE id='$id' LIMIT 1", "maison"); 
    $homerow = mysql_fetch_array($homequery); 
    
    if ($usepoints==true) { 
        if ($userrow["currenttp"] < 1) { 
            display("<img src=\"././images/desole.gif\"/><br>Vous n'avez pas assez de TP pour vous rendre � cette maison. <br>Veuillez retourner et essayer encore quand vous aurez plus de PT.", "Se rendre �"); die(); 
        } 
    } 
    
    if (($userrow["latitude"] == $homerow["latitude"]) && ($userrow["longitude"] == $homerow["longitude"])) { display("<img src=\"././images/bienvenue.gif\"/><br>Vous �tes d�j� dans cette maison. <br><a href=\"index.php\">Cliquez ici</a> pour retourner au menu principal de cette ville.", "Se rendre �"); die(); } 
    
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
    
    $page = "<img src=\"././images/bienvenue.gif\"/><br>Bienvenue dans la maison de ".$homerow["name"].". <br>Vous pouvez maintenant <a href=\"index.php\">entrer chez lui</a>."; 
    display($page, "Se rendre �"); 
    
} 
    
function reposhome() { // Staying at the inn resets all expendable stats to their max values.
    
    global $userrow, $numqueries;

    $homequery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "maison");
    $homerow = mysql_fetch_array($homequery);
    
    if ($userrow["gold"] < $homerow["innprice"]) { display("Vous n'avez pas assez de gils pour dormir dans cette maison ce soir.<br /><br />Vous pouvez <a href=\"index.php\">retourner � l'accueil</a>, ou utiliser les boutons directionnel de gauche pour continuer � explorer le monde.", "Dormir dans la chambre"); die(); }
    
    if (isset($_POST["submit"])) {
        
        $newgold = $userrow["gold"] - $homerow["innprice"];
        $query = doquery("UPDATE {{table}} SET gold='$newgold',currenthp='".$userrow["maxhp"]."',currentmp='".$userrow["maxmp"]."',currenttp='".$userrow["maxtp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
        $title = "Auberge";
        $page = "Vous vous �tes r�veill� avec le sentiment d'�tre r�g�n�r�. Vous �tes pr�t pour le combat! <br /><br />Vous pouvez <a href=\"index.php\">retourner � l'accueil</a>, ou utiliser les boutons directionnel de gauche pour continuer � explorer le monde.";
        
    } elseif (isset($_POST["cancel"])) {
        
        header("Location: index.php"); die();
         
    } else {
        
        $title = "Auberge";
        $page = "Le repos dans la chambre remplira vos barres de HP, MP, et TP � leurs niveaux maximum.<br /><br />\n";
        $page .= "Une nuit dans cette chambre vous co�tera <b>" . $homerow["innprice"] . " gils</b>. Est ce que vous acceptez?<br /><br />\n";
        $page .= "<form action=\"index.php?do=reposhome\" method=\"post\">\n";
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Oui\" /> <input type=\"submit\" name=\"cancel\" value=\"Non\" />\n";
        $page .= "</form>\n";
        $page .= "<br><center><img src=\"././images/auberge.gif\"/></center>\n";
    }
    
    display($page, $title);
    
}

function msghome() { // Envoi de messages 

  global $userrow, $numqueries; 
   $townquery = doquery("SELECT name,innprice,homeprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns"); 
    $townrow = mysql_fetch_array($townquery); 

    if ($userrow["gold"] < $townrow["homeprice"]) { display("<center><img src=\"images/nomaison.jpg\"/></center><br> Vous n'avez pas assez de gils pour cr�er cette maison.<br />Il faut imp�rativement " . $townrow["homeprice"] . " gils pour en cr�er une.<br><br />Vous pouvez <a href=\"index.php\">retourner � la ville</a>, ou utiliser les boutons directionnel de gauche pour continuer � explorer le monde.", "Cr�er une maison"); die(); } 
   

      if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($msg == "") { $errors++; $errorlist .= "Le message est obligatoire.<br />"; }
	        
        
        if ($errors == 0) { 
         	$msg = addslashes($msg); 
         $query = doquery("INSERT INTO {{table}} SET msg='$msg WHERE id='" . $homerow["name"] . "' LIMIT 1", "maison"); 
		        $title = "Auberge"; 
       }  $page = "Votre m�ssage a �t� envoy� avec succ�s! <br /><br />Vous pouvez <a href=\"index.php\">retourner � l'accueil</a>, ou utiliser les boutons directionnel de gauche pour continuer � explorer le monde."; 
        
    } elseif (isset($_POST["cancel"])) { 
        
        header("Location: index.php"); die(); 
          
    } else { 
        
        $title = "Cr�er sa maison"; 
        $page = "Ici vous avez la possiblit� de laisser un m�ssage au propri�taire de la maison de " . $homerow["name"] . ".<BR><br />\n"; 
        $page .= "<form action=\"index.php?do=msghome\" method=\"post\">\n"; 
		$page .= "Votre message: <input type=\"text\" name=\"msg\" size=\"12\" row=\"3\"><br />\n"; 
        $page .= "<input type=\"submit\" name=\"submit\" value=\"Cr�er\"><input type=\"submit\" name=\"reset\" value=\"Annuler\"></form>\n"; 
         
    } 
    
    display($page, $title); 
    
}
?>