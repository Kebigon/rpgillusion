<?php 

// si ann�e ou mois ou jour est sup�rieur

function encheres (){
 
  global $userrow, $controlrow, $numqueries; 
 
   $prixquery = doquery("SELECT * FROM {{table}} WHERE name='".$userrow["weaponname"]."' OR name='".$userrow["armorname"]."' OR name='".$userrow["shieldname"]."'", "items");
   $townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
   $townrow3 = mysql_fetch_array($townquery3);
    $title = "Les encheres"; 
 
   
   
   for($i=1;$i<=3;$i++) { 
   $prix[$i] = 'Aucune';
   $lien[$i] = '';
   $lien2[$i] = '';
  }
   while($prixrow = mysql_fetch_array($prixquery)){
    $id[$prixrow['type']] = $prixrow['id'];
    $prix[$prixrow['type']] = $prixrow['buycost']; 
    $lien[$prixrow['type']] .= "<a href=index.php?do=vente2:".$prixrow['id'].">"; 
	$lien2[$prixrow['type']] .= "</a>"; 
 }


    $page .= "<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Pour mettre en vendre vos �quipements, il vous suffit de cliquer sur le bouton nomm� \"A vendre\".</td></tr></table>\n"; 
    $page .= "<table width=\"380\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" valign=\"top\">\n"; 
    $page .= "<br><br><b><img src=\"images/puce4.gif\" /> <span class=\"mauve1\">Vos �quipements:</span></b><br><br><br>\n"; 
    $page .= "<tr valign=\"top\"><td width=\"380\" align=\"left\"><img src=\"images/arme.gif\"/> <b>".$lien[1]."".$userrow["weaponname"] ."".$lien2[1]."</b> (valeur: ".$prix[1].")<br><img src=\"images/armure.gif\"/> <b>".$lien[2]."" . $userrow["armorname"] . "".$lien2[2]."</b> (valeur: ".$prix[2].")<br><img src=\"images/bouclier.gif\"/> <b>".$lien[3]."" . $userrow["shieldname"] . "".$lien2[3]."</b> (valeur: ".$prix[3].")</td></tr>\n"; 
    $page .= "</table>\n"; 
    $page .= "<br><br><a href=\"index.php\">� Retour au sommaire</a>\n"; 

 
  display($page, $title); 
}

function vente2($id) { // Confirm user's intent to purchase item. 
    
    global $userrow, $numqueries; 
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items"); 
    $itemsrow = mysql_fetch_array($itemsquery); 
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
   $townrow3 = mysql_fetch_array($townquery3);
	
	$encheresquery = doquery("SELECT * FROM {{table}} WHERE proprietaire='".$userrow['charname']."'", "encheres"); 
 
    //hop on fait une boucle pour parcourir tous les resultats au lieu d'un seul
    while($encheresrow = mysql_fetch_array($encheresquery)){
        
    if ($encheresrow["name"] == $itemsrow["name"] ){ display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Vous avez d�ja ajout� cet objet aux ench�res.<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">� retourner au sommaire de la ville</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Chez le notaire"); die(); }
 
} 
      
    $page = "<form enctype=\"multipart/form-data\" action=\"index.php?do=vente3:$id\" method=\"post\">\n"; 
    $page .= "<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Vous allez mettre en ench�re l'objet ".$itemsrow["name"].", vous �tes d'accord?<br></td></tr></table>\n"; 
   	$page .= "<table width=\"380\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" valign=\"top\">\n"; 
    $page .= "<br><br><b><img src=\"images/puce4.gif\" /> <span class=\"mauve1\">Formulaire de vente:</span></b><br><br><br>\n"; 
    $page .= "<tr valign=\"top\"><td width=\"110\"><div align=\"left\">Prix de d�part:</div></td><td><div align=\"left\"><input type=\"text\" name=\"prix\" size=\"10\" maxlength=\"100\" value=\"".$itemsrow["buycost"]."\"/> ".$townrow3["monnaie"]."</div><br></td></tr>\n"; 
    $page .= "<tr valign=\"top\"><td width=\"110\"><div align=\"left\">Fin dans:</div></td><td><div align=\"left\"><select name=\"findans\"/><option value=\"1\">1</option><option value=\"10\">10</option><option value=\"30\">30</option></select> jour(s)<br><br><input type=\"submit\" name=\"submit\" value=\"Valider\" /> <input type=\"reset\" name=\"cancel\" value=\"Annuler\" /></div></td></tr>\n"; 
    $page .= "</table>\n";

    
    $title = "Mettre en ench�re"; 
    display($page, $title); 
    
} 

function vente3($id) { // Update user profile with new item & stats. 
   
global $userrow; 
   
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id'", "items"); 
    $itemsrow = mysql_fetch_array($itemsquery);   
	$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
    $townrow3 = mysql_fetch_array($townquery3);
	$timeactuel = mktime(0,0,0,date("m") ,date("d"),date("Y")    );
    $timefin = mktime(0,0,0,date("m") ,date("d") + $_POST['findans']   ,date("Y")    );   

	$encheresquery = doquery("SELECT * FROM {{table}} WHERE proprietaire='".$userrow['charname']."'", "encheres"); 
 
    //hop on fait une boucle pour parcourir tous les resultats au lieu d'un seul
    while($encheresrow = mysql_fetch_array($encheresquery)){
        
    if ($encheresrow["name"] == $itemsrow["name"] ){ display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Vous avez d�ja ajout� cet objet aux ench�res.<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">� retourner au sommaire de la ville</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Chez le notaire"); die(); }
 
} 
	
	if (isset($_POST["cancel"])) { header("Location: index.php?do=encheres"); die(); } 
	
	$prix = $_POST['prix'] ;
 
  if (isset($_POST['submit'])) {
  
   if ( empty($_POST['prix'])){ display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Votre ench�re est innexistante. Veuillez recommencer!.<br><br>Maintenant vous pouvez:<br><br><a href=\"Javascript:history.go(-1)\">� retourner au formulaire d'ench�re</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Ajouter un objet aux ench�res"); die(); }  

	else  {
	
	$description = addslashes($itemsrow["description"]);
	
         $query = doquery("INSERT INTO {{table}} SET  posttime='$timeactuel' , idobjet='".$itemsrow["id"]."', name='".$itemsrow["name"]."', datefin='$timefin', type='".$itemsrow["type"]."', buycost='$prix', attribute='".$itemsrow["attribute"]."', image='".$itemsrow["image"]."', special='".$itemsrow["special"]."', description='$description', proprietaire='".$userrow["charname"]."' ", "encheres");
              $title = "Ajouter un objet aux ench�res"; 
        }
 
   }
   
   display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">".$row["name"]."Votre ench�re a �t� valid�e. Elle est visible dans la liste des objets � vendre.<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">� retourner au sommaire de la ville</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Enchere ajout�"); 

} 

function afficheencheres ()
{  //Fonction affichage des ench�res.

  global $userrow, $numqueries, $controlrow;

  $encheresquery = doquery("SELECT * FROM {{table}} ORDER by id DESC LIMIT 20", "encheres");
  $townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
  $townrow3 = mysql_fetch_array($townquery3);

  $page = "<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Voici la liste des objets � vendre. Vous pouvez les encherir ou �galement revendre les votre en <a href=\"index.php?do=encheres\"><b>cliquant ici</b></a>.<br><br>Chaque objet est en vente sur une p�riode d�termin� par le vendeur. Si vous �tes la derni�re personne � avoir encherit sur un objet, il sera plac� sur votre compte.<br><br><br><img src=\"images/puce4.gif\"/> <span class=\"mauve1\"><b>La liste des objets � vendre:</b></span><br><br></td></tr></table><br>";
  $count = 1;

  if ( @mysql_num_rows($encheresquery) == 0 )
  {
    $title = "Les ench�res";
    $page .= "<table align=\"left\"><tr><td>Aucunes ench�res</td></tr></table><br><br>";
    $page .= "<br><br><a href=\"index.php\">� Retour au sommaire</a>\n"; 
 }

  else
  {

    while($row = mysql_fetch_array($encheresquery))
    {

      $timeactuel = date("d-m-Y", $row["posttime"]);
      $timefin = date("d-m-Y", $row["datefin"] );
      $title = "Les ench�res";

      //debut


      if ($row["posttime"] > $row["datefin"] )
      {

        $acheteurquery = doquery("SELECT * FROM {{table}} WHERE posttime>='".$row["datefin"]."'", "encheres");
        $acheteurrow = mysql_fetch_array($acheteurquery);

        $acheteurquery2 = doquery("SELECT * FROM {{table}} WHERE charname='".$acheteurrow["acheteur"]."'", "users");
        $acheteurrow2 = mysql_fetch_array($acheteurquery2);

        $acheteurquery3 = doquery("SELECT * FROM {{table}} WHERE charname='".$acheteurrow["proprietaire"]."'", "users");
        $acheteurrow3 = mysql_fetch_array($acheteurquery3);

        $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='".$acheteurrow["idobjet"]."' LIMIT 1", "items");
        $itemsrow = mysql_fetch_array($itemsquery);


        if ($row["type"] == 1 and $row["acheteur"] != "Aucun" )
        { // weapon
		
		
          if ($acheteurrow2["weaponid"] != 0)
          {

            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$acheteurrow["idobjet"]."'", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
 
          }
          else
          {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun");
          }


          // Special item fields.
          $specialchange1 = "";
          $specialchange2 = "";
          if ($itemsrow["special"] != "Aucun")
		  // if ($itemsrow2["special"] != "Aucun" && $itemsrow2['special'] != '')    
		  
          {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $acheteurrow2[$tochange] = $acheteurrow2[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$acheteurrow2[$tochange]."',";
            if ($tochange == "strength") { $acheteurrow2["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $acheteurrow2["defensepower"] += $special[1]; }
          }


		 if ($itemsrow2["special"] != "Aucun")
          {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $acheteurrow2[$tochange2] = $acheteurrow2[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$acheteurrow2[$tochange2]."',";
            if ($tochange2 == "strength") { $acheteurrow2["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $acheteurrow2["defensepower"] -= $special2[1]; }
          }

          // New stats.
          $newattack2 = $acheteurrow3["attackpower"] - $itemsrow["attribute"] ;
          $newgold2 = $acheteurrow3["gold"] + $acheteurrow["buycost"];
          $newname2 = "Aucun";
          $newid2 = 0;
          $newgold = $acheteurrow2["gold"] - $acheteurrow["buycost"];
          $newattack = $acheteurrow2["attackpower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
          $newid = $itemsrow["id"];
          $newname = $itemsrow["name"];
          $userid = $acheteurrow2["id"];
          if ($acheteurrow2["currenthp"] > $acheteurrow2["maxhp"]) { $newhp = $acheteurrow2["maxhp"]; }
          else { $newhp = $acheteurrow2["currenthp"]; }
          if ($acheteurrow2["currentmp"] > $acheteurrow2["maxmp"]) { $newmp = $acheteurrow2["maxmp"]; }
          else { $newmp = $acheteurrow2["currentmp"]; }
          if ($acheteurrow2["currenttp"] > $acheteurrow2["maxtp"]) { $newtp = $acheteurrow2["maxtp"]; }
          else { $newtp = $acheteurrow2["currenttp"]; }

          // Final update.
          $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', attackpower='$newattack', weaponid='$newid', weaponname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users");
          $updatequery2 = doquery("UPDATE {{table}} SET gold='$newgold2', attackpower='$newattack2', weaponid='$newid2', weaponname='$newname2' WHERE charname='".$acheteurrow["proprietaire"]."'", "users");
        }
        elseif ($itemsrow["type"] == 2 and $row["acheteur"] != "Aucun" )
        { // Armor

          // Check if they already have an item in the slot.
          if ($acheteurrow2["armorid"] != 0)
          {

            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$acheteurrow["idobjet"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);

          }
          else
          {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun");
          }

          // Special item fields.
          $specialchange1 = "";
          $specialchange2 = "";
          if ($itemsrow["special"] != "Aucun")
          {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $acheteurrow2[$tochange] = $acheteurrow2[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$acheteurrow2[$tochange]."',";
            if ($tochange == "strength") { $acheteurrow2["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $acheteurrow2["defensepower"] += $special[1]; }
          }
          if ($itemsrow2["special"] != "Aucun")
          {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $acheteurrow2[$tochange2] = $acheteurrow2[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$acheteurrow2[$tochange2]."',";
            if ($tochange2 == "strength") { $acheteurrow2["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $acheteurrow2["defensepower"] -= $special2[1]; }
          }

          // New stats.
          $newdefense2 = $acheteurrow3["attackpower"] - $itemsrow["attribute"] ;
          $newgold2 = $acheteurrow3["gold"] + $acheteurrow["buycost"];
          $newname2 = "Aucun";
          $newid2 = 0;
          $newgold = $acheteurrow2["gold"] - $acheteurrow["buycost"];
          $newdefense = $acheteurrow2["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
          $newid = $itemsrow["id"];
          $newname = $itemsrow["name"];
          $userid = $acheteurrow2["id"];
          if ($acheteurrow2["currenthp"] > $acheteurrow2["maxhp"]) { $newhp = $acheteurrow2["maxhp"]; }
          else { $newhp = $acheteurrow2["currenthp"]; }
          if ($acheteurrow2["currentmp"] > $acheteurrow2["maxmp"]) { $newmp = $acheteurrow2["maxmp"]; }
          else { $newmp = $acheteurrow2["currentmp"]; }
          if ($acheteurrow2["currenttp"] > $acheteurrow2["maxtp"]) { $newtp = $acheteurrow2["maxtp"]; }
          else { $newtp = $acheteurrow2["currenttp"]; }

          // Final update.

          $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', armorid='$newid', armorname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users");
          $updatequery2 = doquery("UPDATE {{table}} SET gold='$newgold2', defensepower='$newdefense2', armorid='$newid2', armorname='$newname2' WHERE charname='".$acheteurrow["proprietaire"]."'", "users");
        }
        elseif ($itemsrow["type"] == 3 and $row["acheteur"] != "Aucun")
        { // Shield

          // Check if they already have an item in the slot.
          if ($acheteurrow2["shieldid"] != 0)
          {

            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$acheteurrow["idobjet"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);

          }
          else
          {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun");
          }

          // Special item fields.
          $specialchange1 = "";
          $specialchange2 = "";
          if ($itemsrow["special"] != "Aucun")
          {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $acheteurrow2[$tochange] = $acheteurrow2[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$acheteurrow2[$tochange]."',";
            if ($tochange == "strength") { $acheteurrow2["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $acheteurrow2["defensepower"] += $special[1]; }
          }
          if ($itemsrow2["special"] != "Aucun")
          {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $acheteurrow2[$tochange2] = $acheteurrow2[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$acheteurrow2[$tochange2]."',";
            if ($tochange2 == "strength") { $acheteurrow2["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $acheteurrow2["defensepower"] -= $special2[1]; }
          }


          // New stats.
          $newdefense2 = $acheteurrow3["attackpower"] - $itemsrow["attribute"] ;
          $newgold2 = $acheteurrow3["gold"] + $acheteurrow["buycost"];
          $newname2 = "Aucun";
          $newid2 = 0;
          $newgold = $acheteurrow2["gold"] - $acheteurrow["buycost"];
          $newdefense = $acheteurrow2["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
          $newid = $itemsrow["id"];
          $newname = $itemsrow["name"];
          $userid = $acheteurrow2["id"];
          if ($acheteurrow2["currenthp"] > $acheteurrow2["maxhp"]) { $newhp = $acheteurrow2["maxhp"]; }
          else { $newhp = $acheteurrow2["currenthp"]; }
          if ($acheteurrow2["currentmp"] > $acheteurrow2["maxmp"]) { $newmp = $acheteurrow2["maxmp"]; }
          else { $newmp = $acheteurrow2["currentmp"]; }
          if ($acheteurrow2["currenttp"] > $acheteurrow2["maxtp"]) { $newtp = $acheteurrow2["maxtp"]; }
          else { $newtp = $acheteurrow2["currenttp"]; }

          // Final update.

          $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', shieldid='$newid', shieldname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users");
          $updatequery2 = doquery("UPDATE {{table}} SET gold='$newgold2', defensepower='$newdefense2', shieldid='$newid2', shieldname='$newname2' WHERE charname='".$acheteurrow["proprietaire"]."'", "users");
        }

// liste des destinataires du message
$adresse="".$acheteurrow2["email"].""; 

// titre du message : zone sujet
$sujet="".$controlrow["gamename"].": Vous avez un nouvel objet! ";

// contenu du message
$corps="<html><body><font face=arial size=2>Suite � votre ench�re, vous avez remport� cet objet: ".$acheteurrow["name"]."<br><br>A bientot sur ".$controlrow["gameurl"]."</font></body></html>"; 

// Cr�ation de l'ent�te du message
// cette entete contient l'email de l'exp�diteur ainsi que l'email pour la r�ponse.
$entete="Content-type:text/html\nFrom:".$controlrow["adminemail"]."\r\nReply-To:
".$controlrow["adminemail"]."";

// envoi du mail
mail ($adresse,$sujet,$corps,$entete); 
 
$texte = "Termin�";
 
      } 
	  
else {
 
$texte = "<a href=\"index.php?do=encheres2:".$row["id"]."\">Ench�rir</a>";
 
 } 	  
	  

      if ($count == 1)
      {
        $page .= "<table width=\"570\" cellspacing=\"0\" cellpadding=\"0\">";
        $page .= "<tr>";
        $page .= "<td width=\"540\" style=\"background-color: #FFE6F5;\" align=\"left\"><img src=\"images/puce3.gif\"/> <span class=\"marron4\"><b><a onmouseover=\"return overlib('" .addslashes(htmlspecialchars($row["description"])) ." ');\" onmouseout=\"return nd();\" href=\"javascript:void(0);\">".$row["name"]."</a></b> - ".$row["buycost"]." ".$townrow3["monnaie"]."</span><br><img src=images/blog/espace.gif height=\"3\"><br><span class=\"taille1\">Mise en vente le: ".$timeactuel." par ".$row["proprietaire"].". Fin le: ".$timefin.". Derni�re ench�re par: ".$row["acheteur"].".</span><br></td><td width=\"30\" style=\"background-color: #FFE6F5;\">".$texte."</td>";
        $page .= "</tr>";
        $page .= "</table><br>";
        $count = 2;
      }
      else
      {
        $page .= "<table width=\"570\" cellspacing=\"0\" cellpadding=\"0\">";
        $page .= "<tr>";
        $page .= "<td width=\"540\" style=\"background-color: #FFF2FA;\" align=\"left\"><img src=\"images/puce3.gif\"/> <span class=\"marron4\"><b><a onmouseover=\"return overlib('" .addslashes(htmlspecialchars($row["description"])) ." ');\" onmouseout=\"return nd();\" href=\"javascript:void(0);\">".$row["name"]."</a></b> - ".$row["buycost"]." ".$townrow3["monnaie"]."</span><br><img src=images/blog/espace.gif height=\"3\"><br><span class=\"taille1\">Mise en vente le: ".$timeactuel." par ".$row["proprietaire"].". Fin le: ".$timefin.". Derni�re ench�re par: ".$row["acheteur"].".</span></td><td width=\"30\" style=\"background-color: #FFF2FA;\">".$texte."</td>";
        $page .= "</tr>";
        $page .= "</table><br>";
        $count = 1;
      }
    }
	$page .= "<br><br><a href=\"index.php\">� Retour au sommaire</a>\n"; 

	$timeactuel = mktime(0,0,0,date("m") ,date("d"),date("Y")    ); //postime actuel
	
    // efface toutes les lignes dans la table enchere avec une datefin plus grande que posttime
    $updatequery3 = doquery("DELETE FROM {{table}} WHERE $timeactuel>datefin", "encheres");
  }


  display($page, $title);
}


function encheres2($id) { // Confirm user's intent to purchase item. 
    
    global $userrow, $numqueries; 
    
    $encheresquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "encheres"); 
    $encheresrow = mysql_fetch_array($encheresquery); 
	
	if ($userrow["charname"] == $encheresrow["proprietaire"] )
      { 
	  display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Vous ne pouvez pas ench�rir cet objet car vous �tes le vendeur.<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">� retourner au sommaire de la ville</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Encherir un objet"); 
	 }
	 
	 if ($encheresrow["posttime"] > $encheresrow["datefin"] )
      { 
	 $page .= "<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Cette ench�re est termin�e. L'objet a �t� remport� par ".$encheresrow["acheteur"].".<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">� retourner au sommaire de la ville</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>\n";  
	 }else{ 
          
    $page = "<form enctype=\"multipart/form-data\" action=\"index.php?do=encheres3:$id\" method=\"post\">\n"; 
    $page .= "<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Vous allez encherir l'objet nomm� ".$encheresrow["name"].".<br></td></tr></table>\n"; 
   	$page .= "<table width=\"380\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" valign=\"top\">\n"; 
    $page .= "<br><br><b><img src=\"images/puce4.gif\" /> <span class=\"mauve1\">Formulaire d'ench�re:</span></b><br><br><br>\n"; 
    $page .= "<tr valign=\"top\"><td width=\"110\"><div align=\"left\">Votre prix:</div></td><td><div align=\"left\"><input type=\"text\" name=\"enchere\" size=\"10\" maxlength=\"100\" value=\"".$encheresrow["buycost"]."\"/> ".$townrow3["monnaie"]."<br><br><input type=\"submit\" name=\"submit\" value=\"Valider\" /> <input type=\"reset\" name=\"cancel\" value=\"Annuler\" /></div></td></tr>\n";
    $page .= "</table>\n";
    $page .= "<br><br><a href=\"index.php\">� Retour au sommaire</a>\n"; 
    
    
    $title = "Encherir un objet"; 
}
    display($page, $title); 
  
} 

function encheres3($id) { // Update user profile with new item & stats. 
    
    $encheresquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "encheres"); 
    $encheresrow = mysql_fetch_array($encheresquery);   
	
	if (isset($_POST["cancel"])) { header("Location: index.php?do=afficheencheres"); die(); } 
    
    global $userrow; 
			 
  if (isset($_POST['submit'])) {
  
  if ($userrow["bank"] > 0){ 
  $texte = "Vous poss�dez ".$userrow["bank"]." ".$townrow3["monnaie"]." en banque. Si vous souhaitez les retirer <a href=\"index.php?do=bank\">cliquez ici</a>";
  } else{
  $texte = "Malheuresement vous ne poss�dez rien sur votre compte en banque. Par cons�quent il vous faut attendre, pour faire une ench�re sur cet objet";
  }
  
  if ($userrow["gold"] < $_POST['enchere'] ){ display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Vous n'avez pas assez d'argent sur votre compte. Votre ench�re ne peut d�passer ".$userrow["gold"]." ".$townrow3["monnaie"].".<br><br>".$texte.".<br><br>Maintenant vous pouvez:<br><br><a href=\"index.php\">� retourner au sommaire de la ville</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Erreur d'ench�re"); die(); }

  if ( empty($_POST['enchere'])){ display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Votre ench�re est innexistante. Veuillez recommencer!.<br><br>Maintenant vous pouvez:<br><br><a href=\"Javascript:history.go(-1)\">� retourner au formulaire d'ench�re</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Ench�rir un objet"); die(); }  
  if ($_POST['enchere'] <= $encheresrow["buycost"] ){ display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Votre ench�re est inf�rieure � celle d�ja propos�. Vous devez inscrire une ench�re surp�rieure � ".$encheresrow["buycost"].".<br><br>Maintenant vous pouvez:<br><br><a href=\"Javascript:history.go(-1)\">� retourner au formulaire d'ench�re</a><br><a href=\"index.php?do=afficheencheres\">� retourner dans la salle d'ench�res</a></td></tr></table>", "Ench�rir un objet"); die(); } 

else {

         $query = doquery("UPDATE {{table}} SET  buycost='".$_POST['enchere']."', acheteur='".$userrow['charname']."' WHERE id='".$encheresrow["id"]."'", "encheres");

		$title = "Enchere ajout�"; 
  }
 
   }
   
   display("<table height=\"1\"><tr><td><img src=\"images/lesencheres.jpg\"/></td></tr></table><br><table width=\"380\"><tr><td align=\"left\">Votre ench�re a �t� valid�e. Elle est visible dans la liste des objets � vendre.<br><br>Maintenant vous pouvez :<br><br><a href=\"index.php\">� retourner � la ville</a></td></tr></table>", "Enchere ajout�"); 

} 




?>