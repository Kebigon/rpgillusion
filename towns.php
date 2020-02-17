<?php // towns.php :: Les fonctions des villes.

function inn() { // Auberge.
    
global $userrow;

  $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
  $townrow = mysql_fetch_array($townquery);
	
  $page ='<img src="images/jeu/actions/auberge.jpg" width="580" height="82" alt="L\'auberge de '.$townrow['name'].'"><br><br>';
      
  if (isset($_POST["submit"])) {
  
  if ($userrow["gold"] < $townrow["innprice"]) { 
  $page .='<b>Vous ne pouvez pas vous reposer dans l\'auberge!</b><br><br> Vous possédez seulement <span class="alerte">'.$userrow['gold'].' rubis</span>. Le repos dans cette auberge coûte <span class="alerte">'.$townrow['innprice'].' rubis</span>. Revenez lorsque vous aurez suffisament de rubis.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au menu des villes</a>';
  }elseif(($userrow['currenthp'] == $userrow['maxhp'])&&($userrow['currentmp'] == $userrow['maxmp'])&&($userrow['currenttp'] == $userrow['maxtp'])){
  $page .='Vos points de <span class="mauve2"><b>HP</b></span>, <span class="mauve1"><b>MP</b></span> et <span class="rouge1"><b>TP</b></span> sont déja au maximum. Dormir dans cette auberge ne vous sera d\'aucunes utilité.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au menu des villes</a>';
  }elseif($userrow['currentaction'] != 'En ville'){
  $page .='<span class="alerte">Erreur de manipulation!</span><br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a>';
  }else{
  $debit = $userrow['gold'] - $townrow['innprice']; 
  $update = doquery("UPDATE {{table}} SET gold='".$debit."',currenthp='".$userrow['maxhp']."',currentmp='".$userrow['maxmp']."',currenttp='".$userrow['maxtp']."' WHERE id='".$userrow['id']."' LIMIT 1", "users"); 
  $history = doquery("INSERT INTO {{table}} SET time='".time()."', content='<p><span class=\"mauve1\">".$userrow['charname']."</span> vient de se reposer à l\'auberge de <b>".$townrow['name']."</b></p>', charname='".$userrow['charname']."'", "history"); 

  $page .='<b>Vous venez dormir dans l\'auberge de '.$townrow['name'].'!</b><br><br> Après ce repos mérité, vos points de <span class="mauve2"><b>HP</b></span>, <span class="mauve1"><b>MP</b></span> et <span class="rouge1"><b>TP</b></span> ont été remplit au maximum. De même '.$townrow['innprice'].' rubis ont été débités de votre compte. 
  <br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au menu des villes</a>';
  }
  }else{
  
  // Classement des auberges
  $toptownquery = doquery ("SELECT name, innprice FROM {{table}} ORDER by innprice ASC LIMIT 8","towns"); 
 
  $count = 1;
  $top ='';
 
  while ($toptownrow = mysql_fetch_array($toptownquery))
  {
  $top .= '<span class="mauve1"><b>'.$count.'</b></span> '.$toptownrow['name'].' <span class="taille1"><i>(<span class="rose3">'.$toptownrow['innprice'].'</span> rubis)</i></span><br>';
  $count++;
  }
  
  $page .='<form enctype="multipart/form-data" action="" method="post"><div style="background-image: url(images/jeu/fond_auberge.jpg); background-repeat: no-repeat; background-position: center top">Pour vous reposer dans l\'auberge de '.$townrow['name'].' vous devez absolument avoir <b>'.$townrow['innprice'].' rubis</b>.<br><br><br>Souhaitez vous, vous reposer dans l\'auberge?<br><br>
  <div style="text-align: center"><input type="submit" name="submit" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'index.php\'"></div>
  <br><br></div></form><img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Le classement des auberges de la planète Paradis:</b></span><br><br>'.$top;
  }
    
  display($page, 'Auberge');
      
 }
 
 
 function buy() { // Visualisation du magasin.
    
    global $userrow;
    
    $townquery = doquery("SELECT name,itemslist FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
    $townrow = mysql_fetch_array($townquery);
	
	$page ='<img src="images/jeu/actions/magasin.jpg" width="580" height="82" alt="Le magasin"><br><br>';
	$page.='Pour acheter un objet, il vous suffit de cliquer sur nom. Attention vérifiez bien que vous possédez assez de rubis. Les objets disponibles dans les magasins varient en fonction des villes.<br><br><span class="alerte">Note:</span> Le signe (*) signifie que l\'objet a un attribut spécial, qui change directement après l\'achat, un paramètre de votre personnage. L\'attribut vous sera indiqué juste après l\'achat de l\'objet.<br><br><br>';

    $itemslist = explode(",",$townrow["itemslist"]);
    $querystring = "";
    foreach($itemslist as $a=>$b) {
        $querystring .= "id='$b' OR ";
    }
    $querystring = rtrim($querystring, " OR ");
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE $querystring ORDER BY id", "items");
	
    while ($itemsrow = mysql_fetch_array($itemsquery)) {
        if ($itemsrow['special'] != "Aucun") { $special = '*'; } else { $special = ''; } 
		if ($itemsrow['type'] == 1) { $categorie = "Pouvoir d'attaque:"; } else  { $categorie = "Pouvoir de défense:"; } 
        if ($itemsrow['type'] == 1) { $type = 'Arme'; $pouvoir ='d\'attaque';} 
        if ($itemsrow['type'] == 2) { $type = 'Armure'; $pouvoir ='de défense'; } 
        if ($itemsrow['type'] == 3) { $type = 'Bouclier'; $pouvoir ='de défense'; } 
        if ($userrow['weaponid'] == $itemsrow['id'] || $userrow['armorid'] == $itemsrow['id'] || $userrow['shieldid'] == $itemsrow['id']) { 
      $page .='<div class="bloc_rose"><div style="float:left"><img src="images/objets/'.$itemsrow['id'].'.jpg" alt="'.$itemsrow['name'].'"></div><b><span class="mauve2">'.$itemsrow['name'].'<span class="alerte">'.$special.'</span></span></b> - <i>type: <span class="mauve1">'.$type.'</span> - Pouvoir '.$pouvoir.': <span class="mauve1">'.$itemsrow['attribute'].'</span></i> <span class="alerte"><blink>(Déja acheté)</blink></span><br><span class="taille1">'.$itemsrow['description'].'</span></div><br>'; 
        } else { 
      $page .='<div class="bloc_rose"><div style="float:left"><img src="images/objets/'.$itemsrow['id'].'.jpg" alt="'.$itemsrow['name'].'"></div><a href="?do=buy2:'.$itemsrow['id'].'"><b><span class="mauve2">'.$itemsrow['name'].'<span class="alerte">'.$special.'</span></span></b></a> - <i>type: <span class="mauve1">'.$type.'</span> - Pouvoir '.$pouvoir.': <span class="mauve1">'.$itemsrow['attribute'].'</span></i> <span class="alerte">('.$itemsrow['buycost'].' rubis)</span><br><span class="taille1">'.$itemsrow['description'].'</span></div><br>'; } 
      }
    
	$page .='<br><a href="index.php">» retourner au menu des villes</a><br><br>'; 

    
  display($page, 'Le magasin d\'objets');
    
}


function buy2($id) { // Achat dans  magasin.
    
    global $userrow;
    
    $townquery = doquery("SELECT name,itemslist FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
    $townrow = mysql_fetch_array($townquery);
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items");
    $itemsrow = mysql_fetch_array($itemsquery);
	
	$page ='<img src="images/jeu/actions/magasin.jpg" width="580" height="82" alt="Le magasin"><br><br>';
    
    if ($userrow["gold"] < $itemsrow["buycost"]) {   
	$page .= 'Désolé vous ne possédez pas assez de rubis pour acheter l\'objet nommé <b>'.$itemsrow['name'].'</b>. Il vous faut absolument <span class="alerte">'.$itemsrow['buycost'].' rubis</span>, or vous possédez seulement <span class="alerte">'.$userrow['gold'].' rubis</span>.<br><br>Maintenant vous pouvez:<br><br><a href="?do=buy">» retourner au magasin</a><br><a href="index.php">» retourner au menu des villes</a>';
	}else{
	
    if ($itemsrow["type"] == 1) {
        if ($userrow["weaponid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["weaponid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
			
            $page .= '<form enctype="multipart/form-data" action="?do=buy3:'.$id.'" method="post"><div>Avant d\'acheter l\'objet nommé <b>'.$itemsrow['name'].'</b>, un marchant habitant à '.$townrow['name'].' souhaite racheter votre ancienne arme nommé <b>'.$itemsrow2['name'].'</b>, pour un montant de <b>'.ceil($itemsrow2["buycost"]/2).' rubis</b><br><br><br>Acceptez vous le marché?<br><br>
            <div style="text-align: center"><input type="submit" name="achat" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'?do=buy\'"></div></div></form>';

        } else {
            $page .= '<form enctype="multipart/form-data" action="?do=buy3:'.$id.'" method="post"><div>Vous avez choisi l\'objet nommé <b>'.$itemsrow['name'].'</b>. Celui-ci coûte <span class="alerte">'.$itemsrow['buycost'].' rubis</span><br><br><br>Souhaitez vous l\'acheter?<br><br>
            <div style="text-align: center"><input type="submit" name="achat" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'?do=buy\'"></div></div></form>';

        }
    } elseif ($itemsrow["type"] == 2) {
        if ($userrow["armorid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["armorid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
			
            $page .= '<form enctype="multipart/form-data" action="?do=buy3:'.$id.'" method="post"><div>Avant d\'acheter l\'objet nommé <b>'.$itemsrow['name'].'</b>, un marchant habitant à '.$townrow['name'].' souhaite racheter votre ancienne armure nommé <b>'.$itemsrow2['name'].'</b>, pour un montant de <b>'.ceil($itemsrow2["buycost"]/2).' rubis</b><br><br><br>Acceptez vous le marché?<br><br>
            <div style="text-align: center"><input type="submit" name="achat" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'?do=buy\'"></div></div></form>';

        } else {
            $page .= '<form enctype="multipart/form-data" action="?do=buy3:'.$id.'" method="post"><div>Vous avez choisi l\'objet nommé <b>'.$itemsrow['name'].'</b>. Celui-ci coûte <span class="alerte">'.$itemsrow['buycost'].' rubis</span><br><br><br>Souhaitez vous l\'acheter?<br><br>
            <div style="text-align: center"><input type="submit" name="achat" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'?do=buy\'"></div></div></form>';
        }
    } elseif ($itemsrow["type"] == 3) {
        if ($userrow["shieldid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["shieldid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
			
            $page .= '<form enctype="multipart/form-data" action="?do=buy3:'.$id.'" method="post"><div>Avant d\'acheter l\'objet nommé <b>'.$itemsrow['name'].'</b>, un marchant habitant à '.$townrow['name'].' souhaite racheter votre ancien bouclier nommé <b>'.$itemsrow2['name'].'</b>, pour un montant de <b>'.ceil($itemsrow2["buycost"]/2).' rubis</b><br><br><br>Acceptez vous le marché?<br><br>
            <div style="text-align: center"><input type="submit" name="achat" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'?do=buy\'"></div></div></form>';

        } else {
            $page .= '<form enctype="multipart/form-data" action="?do=buy3:'.$id.'" method="post"><div>Vous avez choisi l\'objet nommé <b>'.$itemsrow['name'].'</b>. Celui-ci coûte <span class="alerte">'.$itemsrow['buycost'].' rubis</span><br><br><br>Souhaitez vous l\'acheter?<br><br>
            <div style="text-align: center"><input type="submit" name="achat" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'?do=buy\'"></div></div></form>';

        }
    }
}
	
  display($page, 'Le magasin d\'objets');
   
}


function buy3($id) { // Update users après achat.
    
    global $userrow;
    
    $townquery = doquery("SELECT name,itemslist FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
    $townrow = mysql_fetch_array($townquery);
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items");
    $itemsrow = mysql_fetch_array($itemsquery);
	
	$page ='<img src="images/jeu/actions/magasin.jpg" width="580" height="82" alt="Le magasin"><br><br>';

    if($userrow['currentaction'] != 'En ville'){
    $page .='<span class="alerte">Erreur de manipulation!</span><br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a>';
    }elseif($userrow["gold"] < $itemsrow["buycost"]) {   
	$page .= 'Désolé vous ne possédez pas assez de rubis pour acheter l\'objet nommé <b>'.$itemsrow['name'].'</b>. Il vous faut absolument <span class="alerte">'.$itemsrow['buycost'].' rubis</span>, or vous possédez seulement <span class="alerte">'.$userrow['gold'].' rubis</span>.<br><br>Maintenant vous pouvez:<br><br><a href="?do=buy">» retourner au magasin</a><br><a href="index.php">» retourner au menu des villes</a>';
	}else{
	
	$buybonus = null;
	$buybonus2 = null;
	$special = '<br><br>Cette objet ne contient pas d\'attribut spécial, donc aucunes modifications ne sera éffectué sur votre personnage.';
    
    if ($itemsrow["type"] == 1) { // Armes.

        if ($userrow["weaponid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["weaponid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
       
       $buybonus ='Un marchant vous à également racheté l\'objet <b>'.$itemsrow2["name"].'</b>, pour un montant de <b>'.ceil($itemsrow2["buycost"]/2).' rubis. </b>';
	   $buybonus2='et crédité de <b>'.ceil($itemsrow2["buycost"]/2).' rubis</b>,';
	   } else {
	   
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun");
        }
        
        $specialchange1 = "";
        $specialchange2 = "";
        if ($itemsrow["special"] != "Aucun") {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $userrow[$tochange] = $userrow[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$userrow[$tochange]."',";
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; }
			$special = '<br><br>Cet objet possède un attribut spécial. La propriété <b>'.$special[0].'</b> de votre personnage sera augmenté (ou diminué si signe (-) devant) de <b>'.$special[1].' point(s)</b>.';
        }
        if ($itemsrow2["special"] != "Aucun") {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',";
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; }
        
		}
        
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"];
        $newattack = $userrow["attackpower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
        $newid = $itemsrow["id"];
        $newname = $itemsrow["name"];
        $userid = $userrow["id"];
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; }
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; }
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; }
        
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', attackpower='$newattack', weaponid='$newid', weaponname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users");
        
    } elseif ($itemsrow["type"] == 2) { // Armures.

        if ($userrow["armorid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["armorid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
			
			$buybonus ='Un marchant vous à également racheté l\'objet <b>'.$itemsrow2["name"].'</b>, pour un montant de <b>'.ceil($itemsrow2["buycost"]/2).' rubis. </b>';
	        $buybonus2='et crédité de <b>'.ceil($itemsrow2["buycost"]/2).' rubis</b>,';
        } else {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun");
        }
        
        $specialchange1 = "";
        $specialchange2 = "";
        if ($itemsrow["special"] != "Aucun") {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $userrow[$tochange] = $userrow[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$userrow[$tochange]."',";
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; }
			$special = '<br><br>Cet objet possède un attribut spécial. La propriété <b>'.$special[0].'</b> de votre personnage sera augmenté (ou diminué si signe (-) devant) de <b>'.$special[1].' point(s)</b>.';
        }
        if ($itemsrow2["special"] != "Aucun") {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',";
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; }
        }
        
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"];
        $newdefense = $userrow["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
        $newid = $itemsrow["id"];
        $newname = $itemsrow["name"];
        $userid = $userrow["id"];
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; }
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; }
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; }
        
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', armorid='$newid', armorname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users");

    } elseif ($itemsrow["type"] == 3) { // Boucliers.

        if ($userrow["shieldid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["shieldid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
			
			$buybonus ='Un marchant vous à également racheté l\'objet <b>'.$itemsrow2["name"].'</b>, pour un montant de <b>'.ceil($itemsrow2["buycost"]/2).' rubis. </b>';
	        $buybonus2='et crédité de <b>'.ceil($itemsrow2["buycost"]/2).' rubis</b>,';
        } else {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"Aucun");
        }
        
        $specialchange1 = "";
        $specialchange2 = "";
        if ($itemsrow["special"] != "Aucun") {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $userrow[$tochange] = $userrow[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$userrow[$tochange]."',";
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; }
			$special = '<br><br>Cet objet possède un attribut spécial. La propriété <b>'.$special[0].'</b> de votre personnage sera augmenté (ou diminué si signe (-) devant) de <b>'.$special[1].' point(s)</b>.';
        }
        if ($itemsrow2["special"] != "Aucun") {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',";
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; }
        }
        
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"];
        $newdefense = $userrow["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
        $newid = $itemsrow["id"];
        $newname = $itemsrow["name"];
        $userid = $userrow["id"];
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; }
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; }
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; }

        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', shieldid='$newid', shieldname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "users");        
    
    }
  
  $page .= 'Bravo, vous venez d\'acheter l\'objet nommé <b>'.$itemsrow['name'].'</b>. '.$buybonus.'Votre compte vient d\'être débité de <span class="alerte">'.$itemsrow['buycost'].' rubis</span>, '.$buybonus2.' il s\'élève désormais à <span class="alerte">'.$newgold.' rubis</span>.'.$special.'<br><br>Maintenant vous pouvez:<br><br><a href="?do=buy">» retourner au magasin</a><br><a href="index.php">» retourner au menu des villes</a>';
}
  display($page, 'Le magasin d\'objets');

}


function maps() { // Visualisation du magasin.
    
    global $userrow;
	
	$townquery = doquery("SELECT * FROM {{table}} ORDER BY id", "towns");
        
    $page ='<img src="images/jeu/actions/magasin.jpg" width="580" height="82" alt="Le magasin"><br><br>';
	$page.='Pour acheter une carte, il vous suffit de cliquer sur son nom. Attention vérifiez bien que vous possédez assez de rubis. Les cartes disponibles dans les magasins varient en fonction des villes.<br><br> Les cartes vous permet de vous téléporter de ville en ville, mais cette fonction utilise beaucoup de points de voyage (<span class="rouge1"><b>TP</b></span>).<br><br><br>';

    $mappedtowns = explode(",",$userrow["towns"]);

    while ($townrow = mysql_fetch_array($townquery)) {
        
        if ($townrow["latitude"] >= 0) { $latitude = $townrow["latitude"] . "N,"; } else { $latitude = ($townrow["latitude"]*-1) . "S,"; }
        if ($townrow["longitude"] >= 0) { $longitude = $townrow["longitude"] . "E"; } else { $longitude = ($townrow["longitude"]*-1) . "W"; }
        
        $mapped = false;
        foreach($mappedtowns as $a => $b) {
            if ($b == $townrow["id"]) { $mapped = true; }
        }
        if ($mapped == false) {
            $page .='<div class="bloc_rose"><a href="index.php?do=maps2:'.$townrow["id"].'"><b><span class="mauve2">Carte de '.$townrow["name"].'</span></b></a> (Location: caché; <span class="rouge1"><b>TP</b>: caché</span>) - <span class="alerte">('.$townrow['mapprice'].' rubis)</span><br></div><br>'; 

		} else {
            $page .='<div class="bloc_rose"><b><span class="mauve2">Carte de '.$townrow["name"].'</span></b> (Location: '.$latitude.' '.$longitude.'; <span class="rouge1"><b>TP</b>: '.$townrow['travelpoints'].'</span>) - <span class="alerte"><blink>(Déja acheté)</blink></span><br></div><br>'; 

		}
        
    }
    
	$page .='<br><a href="index.php">» retourner au menu des villes</a><br><br>'; 
    
  display($page, 'Le magasin de cartes');
    
}


function maps2($id) { // Achat carte.
    
    global $userrow;
    
    $townquery = doquery("SELECT name,mapprice FROM {{table}} WHERE id='$id' LIMIT 1", "towns");
    $townrow = mysql_fetch_array($townquery);
	
	$page ='<img src="images/jeu/actions/magasin.jpg" width="580" height="82" alt="Le magasin"><br><br>';
 
    if ($userrow["gold"] < $townrow["mapprice"]) {
	$page .= 'Désolé vous ne possédez pas assez de rubis pour acheter la carte de <b>'.$townrow['name'].'</b>. Il vous faut absolument <span class="alerte">'.$townrow['mapprice'].' rubis</span>, or vous possédez seulement <span class="alerte">'.$userrow['gold'].' rubis</span>.<br><br>Maintenant vous pouvez:<br><br><a href="?do=maps">» retourner au magasin</a><br><a href="index.php">» retourner au menu des villes</a>';
    }else{
	
    $page .= '<form enctype="multipart/form-data" action="?do=maps3:'.$id.'" method="post"><div>Vous avez choisi d\'acheter la carte de <b>'.$townrow['name'].'</b>. Celui-ci coûte <span class="alerte">'.$townrow['mapprice'].' rubis</span><br><br><br>Souhaitez vous l\'acheter?<br><br>
            <div style="text-align: center"><input type="submit" name="achat" value="Oui"> <input type="button" value="Non" OnClick="javascript:location=\'?do=maps\'"></div></div></form>';
}
	
  display($page, 'Le magasin de cartes');
    
}


function maps3($id) { // Update users après achat.
        
    global $userrow;
    
    $townquery = doquery("SELECT name,mapprice FROM {{table}} WHERE id='$id' LIMIT 1", "towns");
    $townrow = mysql_fetch_array($townquery);
	
	$page ='<img src="images/jeu/actions/magasin.jpg" width="580" height="82" alt="Le magasin"><br><br>';
    if($userrow['currentaction'] != 'En ville'){
    $page .='<span class="alerte">Erreur de manipulation!</span><br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a>';
    }elseif($userrow["gold"] < $townrow["mapprice"]) {
	$page .= 'Désolé vous ne possédez pas assez de rubis pour acheter la carte de <b>'.$townrow['name'].'</b>. Il vous faut absolument <span class="alerte">'.$townrow['mapprice'].' rubis</span>, or vous possédez seulement <span class="alerte">'.$userrow['gold'].' rubis</span>.<br><br>Maintenant vous pouvez:<br><br><a href="?do=maps">» retourner au magasin</a><br><a href="index.php">» retourner au menu des villes</a>';
    }else{
    
    $mappedtowns = $userrow["towns"].",$id";
    $newgold = $userrow["gold"] - $townrow["mapprice"];
    
    $updatequery = doquery("UPDATE {{table}} SET towns='$mappedtowns',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
    
    $page .= 'Bravo, vous venez d\'acheter la carte de <b>'.$townrow['name'].'</b>. Votre compte vient d\'être débité de <span class="alerte">'.$townrow['mapprice'].' rubis</span>, il s\'élève désormais à <span class="alerte">'.$newgold.' rubis</span>.<br><br>Maintenant vous pouvez:<br><br><a href="?do=maps">» retourner au magasin</a><br><a href="index.php">» retourner au menu des villes</a>';
}

	display($page, 'Le magasin de cartes');

}


function travelto($id, $usepoints=true) { // Envois de l'utilisateur vers le menu de ville.
    
    global $userrow;
    
    if ($userrow["currentaction"] == "En combat") { header("Location: index.php?do=fight"); die(); }
    
    $townquery = doquery("SELECT name,travelpoints,latitude,longitude FROM {{table}} WHERE id='$id' LIMIT 1", "towns");
    $townrow = mysql_fetch_array($townquery);
	
	$page = '<img src="images/jeu/actions/exploration.jpg" width="580" height="82" alt="En exploration"><br><br>';
	
	if (($userrow["latitude"] == $townrow["latitude"]) && ($userrow["longitude"] == $townrow["longitude"])) { 
	display($page .='<span class="alerte">Erreur:</span> Vous êtes déja dans cette ville!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a>', "En exploration");
	    }

	if($usepoints==true) { 
        if ($userrow["currenttp"] < $townrow["travelpoints"]) { 
       	display($page .= 'Vous n\'avez pas assez de points de voyage (<span class="rouge1"><b>TP</b></span>) pour vous téléporter ici. Revenez en arrière et essayez de nouveau lorsque vous obtiendrez au minimum <b>'.$townrow['travelpoints'].' TP</b>.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner sur mes pas</a>', "En exploration");
	   }
        $mapped = explode(",",$userrow["towns"]);
        if (!in_array($id, $mapped)) { 
		display($page .='<span class="alerte">Erreur de manipulation!</span><br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a>', "En exploration");
		}
    
	}
	
    if ($usepoints == true) { $newtp = $userrow["currenttp"] - $townrow["travelpoints"]; } else { $newtp = $userrow["currenttp"]; }
    
    $newlat = $townrow["latitude"];
    $newlon = $townrow["longitude"];
    $newid = $userrow["id"];
    
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
    
	$page .= 'Vous voici en face de la ville de <b>'.$townrow['name'].'</b>, son chef vous souhaite la bienvenue!.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» entrer dans la ville</a>';


    display($page, "En exploration");
    
}
 
 
?>