<?php // admin.php :: Adminstration du jeu.

error_reporting(E_ALL);
session_start();

include('kernel/functions.php');
include('kernel/display.php');
include('class/bbcode.php');

$link = opendb();
$page ='<img src="images/jeu/actions/administration.jpg" width="580" height="82" alt="Administration"><br><br>';

$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

if ($_SESSION == true) {
$userquery = doquery("SELECT authlevel, email FROM {{table}} WHERE id='".addslashes($_SESSION['id'])."' LIMIT 1", "users");
$userrow = mysql_fetch_array($userquery);
}else{
$userrow = null;
}

if ($userrow == false) { die('Identifiez vous à cette adresse : <a href="../login.php?do=login">game</a>, pour pouvoir accéder au panneau d\'administration.'); }
if ($userrow["authlevel"] != 1) { die('Vous devez avoir les privilèges d\'administrateur pour accéder au panneau d\'administration.'); }

if(isset($_GET["do"])) {
  $do = explode(":",$_GET["do"]);
  switch ($do[0]) {
  case 'main': main(); break;
  case 'items': items(); break;
  case 'edititem': edititem($do[1]); break;
  case 'drops': drops(); break;
  case 'editdrop': editdrop($do[1]); break;
  case 'towns': towns(); break;
  case 'edittown': edittown($do[1]); break;
  case 'monsters': monsters(); break;
  case 'editmonster': editmonster($do[1]); break;
  case 'spells': spells(); break;
  case 'editspell': editspell($do[1]); break;
  case 'levels': levels(); break;
  case 'editlevel': editlevel(); break;
  case 'users': users(); break;
  case 'edituser': edituser($do[1]); break;
  case 'addnews': addnews(); break;
  case 'addpoll': addpoll(); break;
  case 'addnewsletter': addnewsletter(); break;
  case 'editpartner': editpartner(); break;
  case 'editcopyright': editcopyright(); break;
  case 'editbabblebox': editbabblebox(); break;
  case 'editmenuusers': editmenuusers(); break;
  }  
} 

function main() {//Réglages principaux.

global $controlrow, $page;
   
     if (isset($_POST['submit'])) {
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if (trim($gamename) == "") { $errors++; $errorlist .= "- Le nom de jeu est exigé.<br>"; }
		if (trim($gameurl) == "") { $errors++; $errorlist .= "- L'url du jeu est exigé.<br>"; }
        if (($gamesize % 5) != 0) { $errors++; $errorlist .= "- La taille de carte doit être divisible par cinq.<br>"; }
        if (!is_numeric($gamesize)) { $errors++; $errorlist .= "- La taille de la carte doit être un nombre.<br>"; }
        if (trim($class1name) == "") { $errors++; $errorlist .= "- Le nom de la classe 1 est exigé.<br>"; }
        if (trim($class2name) == "") { $errors++; $errorlist .= "- Le nom de la classe 2 est exigé.<br>"; }
        if (trim($class3name) == "") { $errors++; $errorlist .= "- Le nom de la classe 3 est exigé.<br>"; }
        if (trim($diff1name) == "") { $errors++; $errorlist .= "- Le nom de la difficulté 1 est exigé.<br>"; }
        if (trim($diff2name) == "") { $errors++; $errorlist .= "- Le nom de la difficulté 2 est exigé.<br>"; }
        if (trim($diff3name) == "") { $errors++; $errorlist .= "- Le nom de la difficulté 3 est exigé.<br>"; }
        if (trim($diff2mod) == "") { $errors++; $errorlist .= "- La valeur de la difficulté 2 est exigée.<br>"; }
        if (trim($diff3mod) == "") { $errors++; $errorlist .= "- La valeur de la difficulté 3 est exigée.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $gamename)==1) { $errors++; $errorlist .= "- Le nom du jeu doit être écrit en caractères alphanumériques.<br>"; }
        if (preg_match("/[\^*+<>?#]/", $class1name)==1) { $errors++; $errorlist .= "- Le nom de la classe 1 doit être écrit en caractères alphanumériques.<br>"; }
        if (preg_match("/[\^*+<>?#]/", $class2name)==1) { $errors++; $errorlist .= "- Le nom de la classe 2 doit être écrit en caractères alphanumériques.<br>"; }
   		if (preg_match("/[\^*+<>?#]/", $class3name)==1) { $errors++; $errorlist .= "- Le nom de la classe 3 doit être écrit en caractères alphanumériques.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $diff1name)==1) { $errors++; $errorlist .= "- Le nom de la difficulté 1 doit être écrit en caractères alphanumériques.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $diff2name)==1) { $errors++; $errorlist .= "- Le nom de la difficulté 2 doit être écrit en caractères alphanumériques.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $diff3name)==1) { $errors++; $errorlist .= "- Le nom de la difficulté 3 doit être écrit en caractères alphanumériques.<br>"; }

        if ($errors == 0) { 
		
            $update = doquery("UPDATE {{table}} SET gamename='".addslashes($gamename)."',gamesize='$gamesize',compression='$compression',class1name='".addslashes($class1name)."',class2name='".addslashes($class2name)."',class3name='".addslashes($class3name)."',diff1name='".addslashes($diff1name)."',diff2name='".addslashes($diff2name)."',diff3name='".addslashes($diff3name)."',showbabble='$showbabble',showonline='$showonline',diff2mod='$diff2mod',diff3mod='$diff3mod',gameopen='$gameopen',verifyemail='$verifyemail',gameurl='$gameurl',adminemail='".addslashes($adminemail)."' WHERE id='1' LIMIT 1", "control");
            $page .='Les réglages principaux ont été mis à jours!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
            $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=main">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }
    } else
  { 

    if ($controlrow['compression'] == 0) { $controlrow['selectcomp0'] = 'selected="selected" '; } else { $controlrow['selectcomp0'] = ""; }
    if ($controlrow['compression'] == 1) { $controlrow['selectcomp1'] = 'selected="selected" '; } else { $controlrow['selectcomp1'] = ""; }
    if ($controlrow['verifyemail'] == 0) { $controlrow['selectverify0'] = 'selected="selected" '; } else { $controlrow['selectverify0'] = ""; }
    if ($controlrow['verifyemail'] == 1) { $controlrow['selectverify1'] = 'selected="selected" '; } else { $controlrow['selectverify1'] = ""; }
    if ($controlrow['gameopen'] == 1) { $controlrow['open1select'] = 'selected="selected" '; } else { $controlrow['open1select'] = ""; }
    if ($controlrow['gameopen'] == 0) { $controlrow['open0select'] = 'selected="selected" '; } else { $controlrow['open0select'] = ""; }
    if ($controlrow["showbabble"] == 0) { $controlrow["selectbabble0"] = 'selected="selected" '; } else { $controlrow['selectbabble0'] = ""; }
    if ($controlrow["showbabble"] == 1) { $controlrow["selectbabble1"] = 'selected="selected" '; } else { $controlrow['selectbabble1'] = ""; }
    if ($controlrow["showonline"] == 0) { $controlrow["selectonline0"] = 'selected="selected" '; } else { $controlrow["selectonline0"] = ""; }
    if ($controlrow["showonline"] == 1) { $controlrow["selectonline1"] = 'selected="selected" '; } else { $controlrow["selectonline1"] = ""; }
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Les réglages principaux:</b></span><br><br>
<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">

<tr valign="top"><td style="width:110px">Statut du jeu:</td><td><select name="gameopen"><option value="1" '.$controlrow['open1select'].'>Ouvert</option><option value="0" '.$controlrow['open0select'].'>Fermé</option></select><br>Fermez le jeu si vous êtes faites de la maintance dessus.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom du jeu:</td><td><input type="text" name="gamename" size="30" maxlength="50" value="'.$controlrow['gamename'].'"><br>Le nom du jeu par defaut est "RPG illusion". Mais vous pouvez librement le modifier.<br><br></td></tr>
<tr valign="top"><td style="width:110px">URL du jeu:</td><td><input type="text" name="gameurl" size="50" maxlength="100" value="'.$controlrow['gameurl'].'"><br>Veuillez indiquer l\'URL complète du jeu("http://www.votre_site.com/repertoire_du_jeu/").<br><br></td></tr>
<tr valign="top"><td style="width:110px">E-mail admin:</td><td><input type="text" name="adminemail" size="30" maxlength="100" value="'.$controlrow['adminemail'].'"><br>Veuillez indiquer votre adresse e-mail.  Les utilisateurs qui auront besoin d\'aide utiliseront cette adresse pour vous écrire.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Taille carte:</td><td><input type="text" name="gamesize" size="3" maxlength="3" value="'.$controlrow['gamesize'].'"><br>250 par défault. C\'est la taille de la carte en longitude et en latitude. Notez aussi que les niveaux des monstres augmentent tous les 5 espaces, ainsi vous devriez vous assurer que la valeur actuelle de la carte est supérieur à 5. Dans le cas contraire le nombre de monstres seront très limités. Avec une taille de carte de 250, vous aurez 50 niveaux de monstre.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Compréssion:</td><td><select name="compression"><option value="0" '.$controlrow['selectcomp0'].'>Aucune</option><option value="1" '.$controlrow['selectcomp1'].'>Activé</option></select><br>Si vous compressez les pages du jeu, ceci réduira considérablement la bande passante utilisée par le jeu.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Email de vérification:</td><td><select name="verifyemail"><option value="0" '.$controlrow['selectverify0'].'>Aucun</option><option value="1" '.$controlrow['selectverify1'].'>Activé</option></select><br>Incitez les utilisateurs à vérifier leur adresse e-mail pour plus de sécuritée.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Babble box activé:</td><td><select name="showbabble"><option value="1" '.$controlrow["selectbabble1"].'>Oui</option><option value="0" '.$controlrow["selectbabble0"].'>Non</option></select><br>Cette option permet d\'afficher ou non la babble box dans toutes les villes.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Online activé:</td><td><select name="showonline"><option value="1" '.$controlrow["selectonline1"].'>Oui</option><option value="0" '.$controlrow["selectonline0"].'>Non</option></select><br>Cette option permet d\'afficher ou non les connectés dans toutes les villes.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom classe 1:</td><td><input type="text" name="class1name" size="20" maxlength="50" value="'.$controlrow['class1name'].'"><br><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom classe 2:</td><td><input type="text" name="class2name" size="20" maxlength="50" value="'.$controlrow['class2name'].'"><br><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom classe 3:</td><td><input type="text" name="class3name" size="20" maxlength="50" value="'.$controlrow['class3name'].'"><br><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom difficulté 1:</td><td><input type="text" name="diff1name" size="20" maxlength="50" value="'.$controlrow['diff1name'].'"><br><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom difficulté 2:</td><td><input type="text" name="diff2name" size="20" maxlength="50" value="'.$controlrow['diff2name'].'"><br><br><br></td></tr>
<tr valign="top"><td style="width:110px">Valeur difficulté 2:</td><td><input type="text" name="diff2mod" size="3" maxlength="3" value="'.$controlrow['diff2mod'].'"><br>1.2 par défault. Indiquez une valeur pour la difficultée moyenne ici.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom difficulté 3:</td><td><input type="text" name="diff3name" size="20" maxlength="50" value="'.$controlrow['diff3name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Valeur difficulté 3:</td><td><input type="text" name="diff3mod" size="3" maxlength="3" value="'.$controlrow['diff2mod'].'"><br>1.2 par défault. Indiquez une valeur pour la difficultée optimale ici.<br><br></td></tr>

<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>

</form><br><br>';
  }

  display(parsetemplate($page, $controlrow), 'Réglages principaux', true);

}


function items() {// Visualisation des objets.

global $page;
    
    $itemsquery = doquery("SELECT * FROM {{table}} ORDER BY name", "items");
    $page .='<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les objets:</b></span><br><br>Pour éditer un objet, cliquez sur celui de votre choix, dans la liste ci-dessous.<br><br>(<span class="alerte">*</span>) signifie que l\'objet possède un attribut spécial.<br><br>';
    while ($itemsrow = mysql_fetch_array($itemsquery)) {
        if ($itemsrow['special'] != "Aucun") { $special = '*'; } else { $special = ''; } 
		if ($itemsrow['type'] == 1) { $categorie = "Pouvoir d'attaque:"; } else  { $categorie = "Pouvoir de défense:"; } 
        if ($itemsrow['type'] == 1) { $type = 'Arme'; $pouvoir ='d\'attaque';} 
        if ($itemsrow['type'] == 2) { $type = 'Armure'; $pouvoir ='de défense'; } 
        if ($itemsrow['type'] == 3) { $type = 'Bouclier'; $pouvoir ='de défense'; } 
   
   $page .='<div class="bloc_rose"><div style="float:left"><img src="images/objets/'.$itemsrow['id'].'.jpg" alt="'.$itemsrow['name'].'"></div><a href="?do=edititem:'.$itemsrow['id'].'"><b><span class="mauve2">'.$itemsrow['name'].'<span class="alerte">'.$special.'</span></span></b></a> - <i>type: <span class="mauve1">'.$type.'</span> - Pouvoir '.$pouvoir.': <span class="mauve1">'.$itemsrow['attribute'].'</span></i> <span class="alerte">('.$itemsrow['buycost'].' rubis)</span><br><span class="taille1">'.$itemsrow['description'].'</span></div><br>';
   }
   
   if (mysql_num_rows($itemsquery) == 0) { $page .= '<span class="alerte"> Il y a aucun objets trouvé!</span><br><br>'; }
   $page .='<br><a href="index.php">» retourner au jeu</a><br><br>';
   
  display($page, "Editer les objets");
    
}


function edititem($id) {// Edition des objets.

global $page;

$itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items");
$itemsrow = mysql_fetch_array($itemsquery);
    
     if (isset($_POST['submit'])) {
      extract($_POST);
      $errors = 0;
      $errorlist = "";
     if (trim($name) == "") { $errors++; $errorlist .= "- Le nom de l'objet est exigé.<br>"; }
      if (preg_match("/[\^*+<>?#]/", $name)==1) { $errors++; $errorlist .= "- Le nom de l'objet doit être écrit en caractères alphanumériques.<br>"; }
      if (trim($buycost) == "") { $errors++; $errorlist .= "- Le prix est exigé.<br>"; }
      if (!is_numeric($buycost)) { $errors++; $errorlist .= "- Le prix doit être un nombre!<br>"; }
      if (trim($attribute) == "") { $errors++; $errorlist .= "- L'attribut est exigé.<br>"; }
      if (!is_numeric($attribute)) { $errors++; $errorlist .= "- L'attribut doit être un nombre.<br>"; }
      if (trim($special) == "") { $special = "Aucun"; }
	  if (trim($description) == "") { $description = "Aucune description"; }
      if ($errors == 0) { 
           
      $update = doquery("UPDATE {{table}} SET name='".addslashes($name)."',type='$type',buycost='$buycost',description='".addslashes($description)."',attribute='$attribute',special='$special' WHERE id=$id LIMIT 1", "items");
      $page .='L\'objet '.$itemsrow['name'].' a été mis à jour!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
      } else {
      $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=edititem:'.$id.'">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
      }   	
    }else{  
	
	if ($itemsrow["type"] == 1) { $itemsrow["type1select"] = "selected=\"selected\" "; } else { $itemsrow["type1select"] = ""; }
    if ($itemsrow["type"] == 2) { $itemsrow["type2select"] = "selected=\"selected\" "; } else { $itemsrow["type2select"] = ""; }
    if ($itemsrow["type"] == 3) { $itemsrow["type3select"] = "selected=\"selected\" "; } else { $itemsrow["type3select"] = ""; }

$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les objets:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td>'.$itemsrow['id'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="'.$itemsrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Image:</td><td><img src="images/objets/'.$itemsrow['id'].'.jpg" alt="'.$itemsrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Type:</td><td><select name="type"><option value="1" '.$itemsrow['type1select'].'>Arme</option><option value="2" '.$itemsrow['type2select'].'>Armure</option><option value="3" '.$itemsrow['type3select'].'>Protection</option></select><br><br></td></tr>
<tr valign="top"><td style="width:110px">Prix:</td><td><input type="text" name="buycost" size="5" maxlength="10" value="'.$itemsrow['buycost'].'"> rubis<br><br></td></tr>
<tr valign="top"><td style="width:110px">Description:</td><td><textarea name="description" rows="5" cols="50">'.$itemsrow['description'].'</textarea><br><br></td></tr>
<tr valign="top"><td style="width:110px">Attribut:</td><td><input type="text" name="attribute" size="5" maxlength="10" value="'.$itemsrow['attribute'].'"><br>Le nombre de points que l\'objet ajoute au pouvoir d\'attaque (armes) ou au pouvoir de défense (armures/protections).<br><br></td></tr>
<tr valign="top"><td style="width:110px">Special:</td><td><input type="text" name="special" size="30" maxlength="50" value="'.$itemsrow['special'].'"><br>Laissez "Aucun" pour donner aucun attribut spécial à l\'objet.<br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>

</form><br>
<span class="mauve1"><b>Attributs spéciaux des objets:</b></span><br>
Des attributs spéciaux peuvent être ajoutés à tous les objets, ce qui a pour but d\'augmenter les capacités des personnages. Par exemple si vous voulez qu\'un objet donne 50 HP à un personnage, il suffit d\'écrire maxhp,50. Ceci marche aussi dans le sens négatif. Donc si vous voulez qu\'un objet enlève 50 HP à un personnage, il suffit d\'écrire maxhp,-50.<br><br>

<img src="images/jeu/puce4.gif" alt=""> <b>maxhp:</b> Donne des points hit (HP)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>maxmp:</b> Donne des points de magie (MP)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>maxtp:</b> Donne des points de voyages<br>
<img src="images/jeu/puce4.gif" alt=""> <b>goldbonus:</b> Donne un bonnus de rubis (en pourcentage)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>expbonus:</b> Donne un bonnus d\'expérience (en pourcentage)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>strength:</b> Donne de la force (qui s\'ajoute également au pouvoir d\'attaque)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>dexterity:</b> Donne de la dextérité (qui s\'ajoute également au pouvoir de défense)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>attackpower:</b> Donne un pouvoir d\'attaque<br>
<img src="images/jeu/puce4.gif" alt=""> <b>defensepower:</b> Donne un pouvoir de défense<br><br>
';
}
   
    display($page, "Editer les objets");
    
}


function drops() {// Visualisation objets perdus.

global $page;
    
    $dropsquery = doquery("SELECT id, name, attribute1, attribute2 FROM {{table}} ORDER BY name", "drops");
    $page .='<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les objets perdus:</b></span><br><br>Pour éditer un objet, cliquez sur celui de votre choix, dans la liste ci-dessous.<br><br>';
     
  while ($dropsrow = mysql_fetch_array($dropsquery)) {

  $page .='<div class="bloc_rose"><div style="float:left"><img src="images/objets/'.$dropsrow['id'].'.jpg" alt="'.$dropsrow['name'].'"></div><a href="?do=editdrop:'.$dropsrow['id'].'"><b><span class="mauve2">'.$dropsrow['name'].'</span></b></a> - <i>Attribut 1: <span class="mauve1">'.$dropsrow['attribute1'].'</span> - Attribut 2: <span class="mauve1">'.$dropsrow['attribute2'].'</span></i> <br><span class="taille1">Description bientot ici</span></div><br>';

  }
  if (mysql_num_rows($dropsquery) == 0) { $page .= '<span class="alerte"> Il y a aucun objets perdus de trouvé!</span><br><br>'; }
  $page .='<br><a href="index.php">» retourner au jeu</a><br><br>';
  
  display($page, 'Editer les objets perdus');
    
}


function editdrop($id) {// Edition objets perdus.

global $page;
    
$dropsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "drops");
$dropsrow = mysql_fetch_array($dropsquery);	
	
if (isset($_POST['submit'])) {
        
      extract($_POST);
      $errors = 0;
      $errorlist = "";
      if (trim($name) == "") { $errors++; $errorlist .= "- Le nom de l'objet est exigé.<br>"; }
      if (preg_match("/[\^*+<>?#]/", $name)==1) { $errors++; $errorlist .= "- Le nom de l'objet doit être écrit en caractères alphanumériques.<br>"; }
      if (trim($mlevel) == "") { $errors++; $errorlist .= "- Le niveau de l'objet est exigé.<br>"; }
      if (!is_numeric($mlevel)) { $errors++; $errorlist .= "- Le niveau de l'objet doit être en chiffre.<br>"; }
      if (trim($attribute1) == ""|| $attribute1 == "Aucun") { $errors++; $errorlist .= "- Le premier attribut est exigé.<br>"; }
      if (trim($attribute2) == "") { $attribute2 = "Aucun"; }
		
      if ($errors == 0) { 
          $update = doquery("UPDATE {{table}} SET name='".addslashes($name)."',mlevel='$mlevel',attribute1='$attribute1',attribute2='$attribute2' WHERE id='".$dropsrow['id']."' LIMIT 1", "drops");
      $page .='L\'objet perdu '.$dropsrow['name'].' a été mis à jour!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
      } else {
      $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=editdrop:'.$id.'">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }        
 }else{
   
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les objets perdus (par les monstres):</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td>'.$dropsrow['id'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="'.$dropsrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Image:</td><td><img src="images/objets/'.$dropsrow['id'].'.jpg" alt="'.$dropsrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Niveau du monstre:</td><td><input type="text" name="mlevel" size="5" maxlength="10" value="'.$dropsrow['mlevel'].'"><br>Niveau de probabilité pour qu\'un monstre laisse tomber cet objet.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Attribut 1:</td><td><input type="text" name="attribute1" size="30" maxlength="50" value="'.$dropsrow['attribute1'].'"><br>Doit être un code spécial.  Le premier attribut ne peut pas être vide. Éditez ce champ très soigneusement, parce que les erreurs d\'orthographe peuvent créer des problèmes dans le jeu.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Attribut 2:</td><td><input type="text" name="attribute2" size="30" maxlength="50" value="'.$dropsrow['attribute2'].'"><br>Laissez "Aucun" pour ne mettre aucun attribut spécial. Sinon éditez ce champ très soigneusement, parce que les erreurs d\'orthographe peuvent créer des problèmes dans le jeu.<br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>

</form><br>
<span class="mauve1"><b>Attributs spéciaux des objets:</b></span><br>
Des attributs spéciaux peuvent être ajoutés à tous les objets, ce qui a pour but d\'augmenter les capacités des personnages. Par exemple si vous voulez qu\'un objet donne 50 HP à un personnage, il suffit d\'écrire maxhp,50. Ceci marche aussi dans le sens négatif. Donc si vous voulez qu\'un objet enlève 50 HP à un personnage, il suffit d\'écrire maxhp,-50.<br><br>

<img src="images/jeu/puce4.gif" alt=""> <b>maxhp:</b> Donne des points hit (HP)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>maxmp:</b> Donne des points de magie (MP)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>maxtp:</b> Donne des points de voyages<br>
<img src="images/jeu/puce4.gif" alt=""> <b>goldbonus:</b> Donne un bonnus de rubis (en pourcentage)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>expbonus:</b> Donne un bonnus d\'expérience (en pourcentage)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>strength:</b> Donne de la force (qui s\'ajoute également au pouvoir d\'attaque)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>dexterity:</b> Donne de la dextérité (qui s\'ajoute également au pouvoir de défense)<br>
<img src="images/jeu/puce4.gif" alt=""> <b>attackpower:</b> Donne un pouvoir d\'attaque<br>
<img src="images/jeu/puce4.gif" alt=""> <b>defensepower:</b> Donne un pouvoir de défense<br><br>
';
 } 
    
 display($page, 'Editer les objets perdus');
    
}


function towns() {// Visualisation des villes.

global $page;
    
  $townquery = doquery("SELECT id, name, latitude, longitude, innprice FROM {{table}} ORDER BY id", "towns");
  $page .='<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les villes:</b></span><br><br>Pour éditer une ville, cliquez sur celle de votre choix, dans la liste ci-dessous.<br><br>';
  
  while ($townrow = mysql_fetch_array($townquery)) {
  $page .='<div class="bloc_rose"><a href="?do=edittown:'.$townrow['id'].'"><b><span class="mauve2">'.$townrow['name'].'</span></b></a> - <i>Lat.: <span class="mauve1">'.$townrow['latitude'].'</span> - Long.: <span class="mauve1">'.$townrow['longitude'].'</span></i> <span class="alerte">('.$townrow['innprice'].' rubis l\'auberge)</span></div><br>';
  }
  if (mysql_num_rows($townquery) == 0) { $page .= '<span class="alerte"> Il y a aucune ville de trouvé!</span><br><br>'; }
  $page .='<br><a href="index.php">» retourner au jeu</a><br><br>';
  
  display($page, 'Editer les villes');
    
}


function edittown($id) {// Edition des villes.

global $page;

$townquery = doquery("SELECT * FROM {{table}} WHERE id='$id' ", "towns");
$townrow = mysql_fetch_array($townquery);
    
   if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if (trim($name) == "") { $errors++; $errorlist .= "- Le nom est exigé.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $name)==1) { $errors++; $errorlist .= "- Le nom de la ville doit être écrit en caractères alphanumériques.<br>"; }
        if (trim($latitude) == "") { $errors++; $errorlist .= "- La latitude est exigée.<br>"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "- La latitude doit être un nombre.<br>"; }
        if (trim($longitude) == "") { $errors++; $errorlist .= "- La longitude est exigée.<br>"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "- La longitude doit être un nombre.<br>"; }
        if (trim($innprice) == "") { $errors++; $errorlist .= "- Le prix de l'auberge est exigé.<br>"; }
        if (!is_numeric($innprice)) { $errors++; $errorlist .= "- Le prix de l'auberge doir être un nombre.<br>"; }
        if (trim($mapprice) == "") { $errors++; $errorlist .= "- Le prix de la carte est exigé.<br>"; }
        if (!is_numeric($mapprice)) { $errors++; $errorlist .= "- Le prix de la carte doit être un nombre.<br>"; }
        if (trim($travelpoints) == "") { $errors++; $errorlist .= "- Les points de voyages sont exigés.<br>"; }
        if (!is_numeric($travelpoints)) { $errors++; $errorlist .= "- Les points de voyages doivent êtres des nombres.<br>"; }
        if (trim($itemslist) == "") { $errors++; $errorlist .= "- La liste des objets est exigée.<br>"; }
        
        if ($errors == 0) { 
            $update = doquery("UPDATE {{table}} SET name='".addslashes($name)."', latitude='$latitude',longitude='$longitude',innprice='$innprice',mapprice='$mapprice',travelpoints='$travelpoints',itemslist='$itemslist' WHERE id='".$townrow['id']."' LIMIT 1", "towns");
        $page .='La ville '.$townrow['name'].' a été mis à jour!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
        $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=edittown:'.$id.'">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }         
    }else{
   
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les villes:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td>'.$townrow['id'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="'.$townrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Latitude:</td><td><input type="text" name="latitude" size="5" maxlength="10" value="'.$townrow['latitude'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Longitude:</td><td><input type="text" name="longitude" size="5" maxlength="10" value="'.$townrow['longitude'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Prix de l\'auberge:</td><td><input type="text" name="innprice" size="5" maxlength="10" value="'.$townrow['innprice'].'"> rubis<br><br></td></tr>
<tr valign="top"><td style="width:110px">Prix de la carte:</td><td><input type="text" name="mapprice" size="5" maxlength="10" value="'.$townrow['mapprice'].'"> rubis<br>Prix de la carte de cette ville.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Points de voyage:</td><td><input type="text" name="travelpoints" size="5" maxlength="10" value="'.$townrow['travelpoints'].'"><br>Nombre de Points de voyage (TP) consommés pour aller à cette ville.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Liste des objets:</td><td><input type="text" name="itemslist" size="30" maxlength="200" value="'.$townrow['itemslist'].'"><br>Liste des objets disponible dans le magasin de cette ville. (Exemple: 1,2,3,6,9,10,13,20) Note: L\'objet numéro 1 correspond à l\'ID numéro 1 (pour voir l\'ID des objets rendez vous dans la rubrique Editer objets).<br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>
</form><br><br>';
 }
 
  display($page, 'Editer les villes');
 
}


function monsters() {// Visualisation des monstres.
    
global $controlrow, $page;
    
  $statquery = doquery("SELECT level FROM {{table}} ORDER BY level DESC LIMIT 1", "monsters");
  $statrow = mysql_fetch_array($statquery);
    
  $monstersquery = doquery("SELECT id, name, immune, level, maxhp FROM {{table}} ORDER BY name", "monsters");
  $page .='<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les monstres:</b></span><br><br>Pour éditer un monstre, cliquez sur celui de votre choix, dans la liste ci-dessous.<br><br>';
    
  if (($controlrow['gamesize']/5) != $statrow['level']) {
       $page .= '<b>Note:</b> Le niveau élevé des monstre ne s\'assortit pas avec le taille de la carte.  Le niveau le plus élevé de monstre devrait être '.($controlrow['gamesize']/5).', le votre est '.$statrow['level'].'. Veuillez modifier la valeur avant d\'ouvrir le jeu au public.<br><br>';
  } else { $page .= 'Le niveau des monstres correspondent parfaitement avec la taille de la carte, aucunes modifications n\'est exigé.<br><br>'; }
     
    while ($monstersrow = mysql_fetch_array($monstersquery)) {
     if ($monstersrow['immune'] == 0) {$immune = "rien"; }
	 if ($monstersrow['immune'] == 1) {$immune = "Attaques"; }
     if ($monstersrow['immune'] == 2) {$immune = "Attaques et sommeils"; }
  $page .='<div class="bloc_rose"><div style="float:left"><img src="images/monstres/'.$monstersrow['id'].'.jpg" alt="'.$monstersrow['name'].'"></div><a href="?do=editmonster:'.$monstersrow['id'].'"><b><span class="mauve2">'.$monstersrow['name'].'</span></b></a> - <i>Niveau: <span class="mauve1">'.$monstersrow['level'].'</span> - Maxhp: <span class="mauve1">'.$monstersrow['maxhp'].'</span> - Immunisé contre: <span class="mauve1">'.$immune.'</span></i><br></div><br>';
    }
  if (mysql_num_rows($monstersquery) == 0) { $page .= '<span class="alerte"> Il y a aucun monstres de trouvé!</span><br><br>'; }
  $page .='<br><a href="index.php">» retourner au jeu</a><br><br>';
  
  display($page, "Editer les monstres");
    
}


function editmonster($id) {// Edition des monstres.


global $page;

$monstersquery = doquery("SELECT * FROM {{table}} WHERE id='$id' ", "monsters");
$monstersrow = mysql_fetch_array($monstersquery);
    
      if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
         if (trim($name) == "") { $errors++; $errorlist .= "- Le nom est exigé.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $name)==1) { $errors++; $errorlist .= "- Le nom du monstre doit être écrit en caractères alphanumériques.<br>"; }
         if (trim($maxhp) == "") { $errors++; $errorlist .= "- Le max de HP est exigé.<br>"; }
        if (!is_numeric($maxhp)) { $errors++; $errorlist .= "- Le max de HP doit être un nombre.<br>"; }
         if (trim($maxdam) == "") { $errors++; $errorlist .= "- Le max de dommage est exigé.<br>"; }
        if (!is_numeric($maxdam)) { $errors++; $errorlist .= "- Le max de dommage doit être un nombre.<br>"; }
         if (trim($armor) == "") { $errors++; $errorlist .= "- Le niveau de l'armure est exigé.<br>"; }
        if (!is_numeric($armor)) { $errors++; $errorlist .= "- Le niveau de l'armure doir être un nombre.<br>"; }
         if (trim($level) == "") { $errors++; $errorlist .= "- Le niveau du monstre est exigé.<br>"; }
        if (!is_numeric($level)) { $errors++; $errorlist .= "- Le niveau du monstre doit être un nombre.<br>"; }
         if (trim($maxexp) == "") { $errors++; $errorlist .= "- Le max d'expérience est exigé.<br>"; }
        if (!is_numeric($maxexp)) { $errors++; $errorlist .= "- Le max d'expérience doit être un nombre.<br>"; }
         if (trim($maxgold) == "") { $errors++; $errorlist .= "- Le max de rubis est exigé.<br>"; }
        if (!is_numeric($maxgold)) { $errors++; $errorlist .= "- Le max de rubis doit être un nombre.<br>"; }
		
        if ($errors == 0) { 
            $update = doquery("UPDATE {{table}} SET name='".addslashes($name)."',maxhp='$maxhp',maxdam='$maxdam',armor='$armor',level='$level',maxexp='$maxexp',maxgold='$maxgold',immune='$immune' WHERE id='".$monstersrow['id']."' LIMIT 1", "monsters");
        $page .='Le monstre '.$monstersrow['name'].' a été mis à jour!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
        $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=editmonster:'.$id.'">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }          
    }else{
 
  if ($monstersrow['immune'] == 0) { $monstersrow['immune0select'] = 'selected="selected" '; } else { $monstersrow['immune0select'] = ""; }
  if ($monstersrow['immune'] == 1) { $monstersrow['immune1select'] = 'selected="selected" '; } else { $monstersrow['immune1select'] = ""; }
  if ($monstersrow['immune'] == 2) { $monstersrow['immune2select'] = 'selected="selected" '; } else { $monstersrow['immune2select'] = ""; }
  if ($monstersrow['immune'] == 3) { $monstersrow['immune3select'] = 'selected="selected" '; } else { $monstersrow['immune3select'] = ""; }

  
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les monstres:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td>'.$monstersrow['id'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="'.$monstersrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Portait:</td><td><img src="images/monstres/'.$monstersrow['image'].'.jpg"  width="71" height="59" alt="'.$monstersrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Max de HP:</td><td><input type="text" name="maxhp" size="5" maxlength="10" value="'.$monstersrow['maxhp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Max de dommages:</td><td><input type="text" name="maxdam" size="5" maxlength="10" value="'.$monstersrow['maxdam'].'"><br>Agit en fonction du pouvoir d\'attaque du joueur.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Armures:</td><td><input type="text" name="armor" size="5" maxlength="10" value="'.$monstersrow['armor'].'"><br>Agit en fonction du pouvoir de défense du joueur.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Niveau du monstre:</td><td><input type="text" name="level" size="5" maxlength="10" value="'.$monstersrow['level'].'"><br>Plus le niveau sera élevé, plus les joueurs seront confronté au monstre sur une latitude et une longitude élevée.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Max d\'experience:</td><td><input type="text" name="maxexp" size="5" maxlength="10" value="'.$monstersrow['maxexp'].'"><br>Le maximum d\'expérience qui sera donné au joueur, après avoir battu le monstre.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Max de rubis:</td><td><input type="text" name="maxgold" size="5" maxlength="10" value="'.$monstersrow['maxgold'].'"><br>Le maximum de rubis qui sera donné au joueur, après avoir battu le monstre.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Immunisé contre les sorts:</td><td><select name="immune"><option value="0" '.$monstersrow['immune0select'].'>Aucuns sorts</option><option value="1" '.$monstersrow['immune1select'].'>Sorts d\'attaques</option><option value="2" '.$monstersrow['immune2select'].'>Sorts d\'attaques & Sommeils</option></select><br>Déterminez à quels types de sorts le monstre sera immunisé.<br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>
</form><br><br>
';
  } 
    
 display($page, 'Editer les monstres');
    
}


function spells() {// Visualisation des sorts.

global $page;
    
$spellsquery = doquery("SELECT id, name, attribute, type FROM {{table}} ORDER BY name", "spells");
$page .='<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les sorts:</b></span><br><br>Pour éditer un objet, cliquez sur celui de votre choix, dans la liste ci-dessous.<br><br>';
    
  while ($spellsrow = mysql_fetch_array($spellsquery)) {
   
     if ($spellsrow['type'] == 1) {$type = "Soin"; }
	 if ($spellsrow['type'] == 2) {$type = "Attaque"; }
     if ($spellsrow['type'] == 3) {$type = "Sommeil"; }
     if ($spellsrow['type'] == 4) {$type = "Attaque d'Uber"; }
     if ($spellsrow['type'] == 5) {$type = "Défense d'Uber"; }
	 
    $page .='<div class="bloc_rose"><a href="?do=editspell:'.$spellsrow['id'].'"><b><span class="mauve2">'.$spellsrow['name'].'</span></b></a> - <i>Attribut.: <span class="mauve1">'.$spellsrow['attribute'].'</span> - Type: <span class="mauve1">'.$type.'</span></i></div><br>';    }
  if (mysql_num_rows($spellsquery) == 0) { $page .= '<span class="alerte"> Il y a aucun sorts de trouvé!</span><br><br>'; }
  $page .='<br><a href="index.php">» retourner au jeu</a><br><br>';
   
 display($page, 'Editer les sorts');
    
}


function editspell($id) {// Edition des sorts.

global $page;
 
$spellsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' ", "spells");
$spellsrow = mysql_fetch_array($spellsquery);
  
  if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
         if (trim($name) == "") { $errors++; $errorlist .= "- Le nom est exigé.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $name)==1) { $errors++; $errorlist .= "- Le nom du sorts doit être écrit en caractères alphanumériques.<br>"; }
         if (trim($mp) == "") { $errors++; $errorlist .= "- Les MP sont exigés.<br>"; }
        if (!is_numeric($mp)) { $errors++; $errorlist .= "- Les MP doivent êtres des nombres.<br>"; }
         if (trim($attribute) == "") { $errors++; $errorlist .= "- L\'attribut est exigé.<br>"; }
        if (!is_numeric($attribute)) { $errors++; $errorlist .= "- L\'attribut doit être un nombre.<br>"; } 
		
        if ($errors == 0) { 
            $update = doquery("UPDATE {{table}} SET name='".addslashes($name)."',mp='$mp',attribute='$attribute',type='$type' WHERE id='".$spellsrow['id']."' LIMIT 1", "spells");
        $page .='Le sorts '.$spellsrow['name'].' a été mis à jour!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
        $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=editspell:'.$id.'">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }           
    }else{
  
  if ($spellsrow['type'] == 1) { $spellsrow['type1select'] = 'selected="selected" '; } else { $spellsrow['type1select'] = ""; }
  if ($spellsrow['type'] == 2) { $spellsrow['type2select'] = 'selected="selected" '; } else { $spellsrow['type2select'] = ""; }
  if ($spellsrow['type'] == 3) { $spellsrow['type3select'] = 'selected="selected" '; } else { $spellsrow['type3select'] = ""; }
  if ($spellsrow['type'] == 4) { $spellsrow['type4select'] = 'selected="selected" '; } else { $spellsrow['type4select'] = ""; }
  if ($spellsrow['type'] == 5) { $spellsrow['type5select'] = 'selected="selected" '; } else { $spellsrow['type5select'] = ""; }

	
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les sorts:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td>'.$spellsrow['id'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="'.$spellsrow['name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Points de magie:</td><td><input type="text" name="mp" size="5" maxlength="10" value="'.$spellsrow['mp'].'"><br>MP requis pour éxécuter ce sort.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Attribut:</td><td><input type="text" name="attribute" size="5" maxlength="10" value="'.$spellsrow['attribute'].'"><br>Valeur numérique du type de sorts que vous avez choisi ci-dessous.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Type:</td><td><select name="type"><option value="1" '.$spellsrow['type1select'].'>Soin</option><option value="2" '.$spellsrow['type2select'].'>Attaque</option><option value="3" '.$spellsrow['type3select'].'>Sommeil</option><option value="4" '.$spellsrow['type4select'].'>Attaque d\'Uber</option><option value="5" '.$spellsrow['type5select'].'>Défense d\'Uber</option></select><br>- "Soin" redonne des HP au joueur.<br>- "Attaque" cause des dommages au monstre.<br>- "Sommeil" endort le monstre. Note: Si vous mettez l\'attribut du sommeil sur 2, le monstre aura très peu de chance de s\'endormir, par contre si vous le mettez sur 15, le monstre s\'endormira plus facilement (l\'attribut du sommeil varie de 1 à 15).<br>- L\'attaque d\'Uber augmente les dommages d\'attaque totale de 50% sur le monstre, si vous mettez par exemple dans les attributs 50.<br>- La défense d\'Uber augmente la défense totale du perso de 50%, si par exemple vous mettez dans les attributs 50.<br><br> 
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>
</form><br><br>';  
 } 
    
  display($page, 'Editer les sorts');
    
}


function levels() {// Visualisation des niveaux.

global $page;

  $levelsquery = doquery("SELECT id FROM {{table}} ORDER BY id DESC LIMIT 1", "levels");
  $levelsrow = mysql_fetch_array($levelsquery);

  $options = '';
  for($i=2; $i<$levelsrow['id']; $i++) {
  $options .= '<option value="'.$i.'">'.$i.'</option>';
  }
    
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les niveaux:</b></span><br><br>

<form enctype="multipart/form-data" action="admin.php?do=editlevel" method="post">
<div>Niveau à éditer : <select name="level">
'.$options.'
</select><br><br></div>
<div style="text-align: center"><input type="submit" name="validation" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div>
</form><br><br>';

 display($page, 'Editer les niveaux');
    
}


function editlevel() {// Edition des niveaux.

global $controlrow, $page;
    
        if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if (trim($_POST['exp_1']) == "") { $errors++; $errorlist .= "- L'expérience de la classe 1 est exigée.<br>"; }
        if (trim($_POST['hp_1']) == "") { $errors++; $errorlist .= "- Le HP de la classe 1 est exigé.<br>"; }
        if (trim($_POST['mp_1']) == "") { $errors++; $errorlist .= "- Le MP de la classe 1 est exigé.<br>"; }
        if (trim($_POST['tp_1']) == "") { $errors++; $errorlist .= "- Le TP de la classe 1 est exigé.<br>"; }
        if (trim($_POST['strength_1']) == "") { $errors++; $errorlist .= "- La force de la classe 1 est exigée.<br>"; }
        if (trim($_POST['dexterity_1']) == "") { $errors++; $errorlist .= "- La dextérité de la classe 1 est exigée.<br>"; }
        if (trim($_POST['spells_1']) == "") { $errors++; $errorlist .= "- Le sort de la classe 1 est exigée.<br>"; }
        if (!is_numeric($_POST['exp_1'])) { $errors++; $errorlist .= "- L'expérience de la classe 1 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['hp_1'])) { $errors++; $errorlist .= "- Le HP de la classe 1 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['mp_1'])) { $errors++; $errorlist .= "- Le MP de la classe 1 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['tp_1'])) { $errors++; $errorlist .= "- Le TP de la classe 1 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['strength_1'])) { $errors++; $errorlist .= "- La force de la classe 1 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['dexterity_1'])) { $errors++; $errorlist .= "- La dextérité de la classe 1 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['spells_1'])) { $errors++; $errorlist .= "- Le sort de la classe 1 doit être un nombre.<br>"; }

       if (trim($_POST['exp_2']) == "") { $errors++; $errorlist .= "- L'expérience de la classe 2 est exigée.<br>"; }
       if (trim($_POST['hp_2']) == "") { $errors++; $errorlist .= "- Le HP de la classe 2 est exigé.<br>"; }
       if (trim($_POST['mp_2']) == "") { $errors++; $errorlist .= "- Le MP de la classe 2 est exigé.<br>"; }
       if (trim($_POST['tp_2']) == "") { $errors++; $errorlist .= "- Le TP de la classe 2 est exigé.<br>"; }
       if (trim($_POST['strength_2']) == "") { $errors++; $errorlist .= "- La force de la classe 2 est exigée.<br>"; }
       if (trim($_POST['dexterity_2']) == "") { $errors++; $errorlist .= "- La dextérité de la classe 2 est exigée.<br>"; }
       if (trim($_POST['spells_2']) == "") { $errors++; $errorlist .= "- Le sort de la classe 2 est exigé.<br>"; }
        if (!is_numeric($_POST['exp_2'])) { $errors++; $errorlist .= "- L'expérience de la classe 2 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['hp_2'])) { $errors++; $errorlist .= "- Le HP de la classe 2 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['mp_2'])) { $errors++; $errorlist .= "- Le MP de la classe 2 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['tp_2'])) { $errors++; $errorlist .= "- Le TP de la classe 2 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['strength_2'])) { $errors++; $errorlist .= "- La force de la classe 2 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['dexterity_2'])) { $errors++; $errorlist .= "- La dextérité de la classe 2 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['spells_2'])) { $errors++; $errorlist .= "- Le sort de la classe 2 doit être un nombre.<br>"; }
                
       if (trim($_POST['exp_3']) == "") { $errors++; $errorlist .= "- L'expérience de la classe 3 est exigée.<br>"; }
       if (trim($_POST['hp_3']) == "") { $errors++; $errorlist .= "- Le HP de la classe 3 est exigé.<br>"; }
       if (trim($_POST['mp_3']) == "") { $errors++; $errorlist .= "- Le MP de la classe 3 est exigé.<br>"; }
       if (trim($_POST['tp_3']) == "") { $errors++; $errorlist .= "- Le TP de la classe 3 est exigé.<br>"; }
       if (trim($_POST['strength_3']) == "") { $errors++; $errorlist .= "- La force de la classe 3 est exigée.<br>"; }
       if (trim($_POST['dexterity_3']) == "") { $errors++; $errorlist .= "- La dextérité de la classe 3 est exigée.<br>"; }
       if (trim($_POST['spells_3']) == "") { $errors++; $errorlist .= "- Le sort de la classe 3 est exigé.<br>"; }
        if (!is_numeric($_POST['exp_3'])) { $errors++; $errorlist .= "- L'expérience de la classe 3 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['hp_3'])) { $errors++; $errorlist .= "- Le HP de la classe 3 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['mp_3'])) { $errors++; $errorlist .= "- Le MP de la classe 3 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['tp_3'])) { $errors++; $errorlist .= "- Le TP de la classe 3 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['strength_3'])) { $errors++; $errorlist .= "- La force de la classe 3 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['dexterity_3'])) { $errors++; $errorlist .= "- La dextérité de la classe 3 doit être un nombre.<br>"; }
        if (!is_numeric($_POST['spells_3'])) { $errors++; $errorlist .= "- Le sort de la classe 3 doit être un nombre.<br>"; }

        if ($errors == 0) {
	
$update = doquery("UPDATE {{table}} SET
        1_exp='$exp_1', 1_hp='$hp_1', 1_mp='$mp_1', 1_tp='$tp_1', 1_strength='$strength_1', 1_dexterity='$dexterity_1', 1_spells='$spells_1',
        2_exp='$exp_2', 2_hp='$hp_2', 2_mp='$mp_2', 2_tp='$tp_2', 2_strength='$strength_2', 2_dexterity='$dexterity_2', 2_spells='$spells_2',
        3_exp='$exp_3', 3_hp='$hp_3', 3_mp='$mp_3', 3_tp='$tp_3', 3_strength='$strength_3', 3_dexterity='$dexterity_3', 3_spells='$spells_3'
        WHERE id='".$_POST['id']."' LIMIT 1", "levels");

         $page .='Le niveau '.$_POST['id'].' a été mis à jour!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
         $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=levels">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }        
        
    }else{
    $levelquery = doquery("SELECT * FROM {{table}} WHERE id='".$_POST['level']."' LIMIT 1", "levels");
    $levelrow = mysql_fetch_array($levelquery);	
  	
    $class1name = $controlrow['class1name'];
    $class2name = $controlrow['class2name'];
    $class3name = $controlrow['class3name'];

$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les niveaux:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td> '.$levelrow['id'].'<input type="hidden" name="id" size="5"  value="'.$levelrow['id'].'"><br><br></td></tr>

<tr><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">Experience du '.$class1name.':</td><td><input type="text" name="exp_1" size="10" maxlength="8" value="'.$levelrow['1_exp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">HP du '.$class1name.':</td><td><input type="text" name="hp_1" size="5" maxlength="5" value="'.$levelrow['1_hp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">MP du '.$class1name.':</td><td><input type="text" name="mp_1" size="5" maxlength="5" value="'.$levelrow['1_mp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">TP du '.$class1name.':</td><td><input type="text" name="tp_1" size="5" maxlength="5" value="'.$levelrow['1_tp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Force du '.$class1name.':</td><td><input type="text" name="strength_1" size="5" maxlength="5" value="'.$levelrow['1_strength'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Dextérité du '.$class1name.':</td><td><input type="text" name="dexterity_1" size="5" maxlength="5" value="'.$levelrow['1_dexterity'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Sorts du '.$class1name.':</td><td><input type="text" name="spells_1" size="5" maxlength="3" value="'.$levelrow['1_spells'].'"><br><br></td></tr>

<tr><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">Expérience du '.$class2name.':</td><td><input type="text" name="exp_2" size="10" maxlength="8" value="'.$levelrow['2_exp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">HP du '.$class2name.':</td><td><input type="text" name="hp_2" size="5" maxlength="5" value="'.$levelrow['2_hp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">MP du '.$class2name.':</td><td><input type="text" name="mp_2" size="5" maxlength="5" value="'.$levelrow['2_mp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">TP du '.$class2name.':</td><td><input type="text" name="tp_2" size="5" maxlength="5" value="'.$levelrow['2_tp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Force du '.$class2name.':</td><td><input type="text" name="strength_2" size="5" maxlength="5" value="'.$levelrow['2_strength'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Dextérité du '.$class2name.':</td><td><input type="text" name="dexterity_2" size="5" maxlength="5" value="'.$levelrow['2_dexterity'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Sorts du '.$class2name.':</td><td><input type="text" name="spells_2" size="5" maxlength="3" value="'.$levelrow['2_spells'].'"><br><br></td></tr>

<tr><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">Experience du '.$class3name.':</td><td><input type="text" name="exp_3" size="10" maxlength="8" value="'.$levelrow['3_exp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">HP du '.$class3name.':</td><td><input type="text" name="hp_3" size="5" maxlength="5" value="'.$levelrow['3_hp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">MP du '.$class3name.':</td><td><input type="text" name="mp_3" size="5" maxlength="5" value="'.$levelrow['3_mp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">TP du '.$class3name.':</td><td><input type="text" name="tp_3" size="5" maxlength="5" value="'.$levelrow['3_tp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Force du '.$class3name.':</td><td><input type="text" name="strength_3" size="5" maxlength="5" value="'.$levelrow['3_strength'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Dextérité du '.$class3name.':</td><td><input type="text" name="dexterity_3" size="5" maxlength="5" value="'.$levelrow['3_dexterity'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Sorts du '.$class3name.':</td><td><input type="text" name="spells_3" size="5" maxlength="3" value="'.$levelrow['3_spells'].'"><br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"><input type="hidden" name="validation"></div></td></tr>
</table>
</form><br><br>';              
    
 }
    
 display($page, 'Editer les niveaux');
    
}


function users() {// Visualisation des utilisateurs.

global $controlrow, $page;

if( isset($_GET['page']) && is_numeric($_GET['page']) ){
$nav = $_GET['page'];
}else{
$nav = 1;
}  
$pagination = 10;
$limit_start = ($nav - 1) * $pagination;

$usersquery = doquery("SELECT id, charname, charclass, level, currentaction, currentmp, currenttp, currenthp FROM {{table}} ORDER BY charname ASC LIMIT $limit_start, $pagination", "users");

$page .='<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les utilisateurs:</b></span><br><br>Pour éditer un utilisateur, cliquez sur celui de votre choix, dans la liste ci-dessous.<br><br>';

   while ($usersrow = mysql_fetch_array($usersquery)) {
	 if ($usersrow['charclass'] == 1) {$class = $controlrow['class1name']; }
	 if ($usersrow['charclass'] == 2) {$class = $controlrow['class2name']; }
     if ($usersrow['charclass'] == 3) {$class = $controlrow['class3name']; }
	 
    $page .='<div class="bloc_rose"><a href="?do=edituser:'.$usersrow['id'].'"><b><span class="mauve2">'.$usersrow['charname'].'</span></b></a> - <i>Niv.: <span class="mauve1">'.$usersrow['level'].'</span> - Classe: <span class="mauve1">'.$class.'</span> - Actuellement: <span class="mauve1">'.$usersrow['currentaction'].'</span> - <span class="mauve2"><b>HP</b></span>: <span class="mauve1">'.$usersrow['currenthp'].'</span> - <span class="mauve1"><b>MP</b></span>: <span class="mauve1">'.$usersrow['currentmp'].'</span> - <span class="rouge1"><b>TP</b></span>: <span class="mauve1">'.$usersrow['currenttp'].'</span></i></div><br>';
    }
	
if (mysql_num_rows($usersquery) == 0) { $page .= '<span class="alerte"> Il y a aucun utilisateur de trouvé!</span><br><br>'; }
	
mysql_free_result($usersquery);	

$nb_total = doquery("SELECT COUNT(*) AS nb_total FROM {{table}} ORDER BY id", "users");
$nb_total = mysql_fetch_array($nb_total);
$nb_total = $nb_total['nb_total'];

$nb_pages  = ceil($nb_total / $pagination);

$page .='[ Page : ';

for ($i = 1 ; $i <= $nb_pages ; $i++) {
  if ($i == $nav ){
$page .= '<b>'.$i.'</b> ';
  }else{
$page .='<a href="?do=users&amp;page='.$i.'">'.$i.'</a> ';}
}
$page .=' ]<br>';

$page .='<br><a href="index.php">» retourner au jeu</a><br><br>';
  
  display($page, 'Editer les utilisateurs');

}


function edituser($id) {// Edition des utilisateurs.

global $controlrow, $page;

$usersquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "users");
$usersrow = mysql_fetch_array($usersquery);
  
  if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";

       if (trim($email) == "") { $errors++; $errorlist .= "- L'Email est exigé.<br>"; }
       if (trim($verify) == "") { $errors++; $errorlist .= "- La vérification de l'email est exigée.<br>"; }
       if (trim($charname) == "") { $errors++; $errorlist .= "- Le nom du personnage est exigé.<br>"; }
       if (trim($authlevel) == "") { $errors++; $errorlist .= "- Le niveau d'accès est exigé.<br>"; }
       if (trim($latitude) == "") { $errors++; $errorlist .= "- La latitude est exigée.<br>"; }
       if (trim($longitude) == "") { $errors++; $errorlist .= "- La longitude est exigée.<br>"; }
       if (trim($difficulty) == "") { $errors++; $errorlist .= "- La difficulté est exigée.<br>"; }
       if (trim($charclass) == "") { $errors++; $errorlist .= "- La classe du personnagee est exigée.<br>"; }
       if (trim($currentaction) == "") { $errors++; $errorlist .= "- L'action actuel est exigée.<br>"; }
       if (trim($currentfight) == "") { $errors++; $errorlist .= "- Le combat en cours est exigé.<br>"; }
        
       if (trim($currentmonster) == "") { $errors++; $errorlist .= "- L'ID du monstre actuel est exigé.<br>"; }
       if (trim($currentmonsterhp) == "") { $errors++; $errorlist .= "- Le HP du monstre actuel est exigé.<br>"; }
       if (trim($currentmonstersleep) == "") { $errors++; $errorlist .= "- L'ID des sorts du monstre actuel est exigés.<br>"; }
       if (trim($currentmonsterimmune) == "") { $errors++; $errorlist .= "- L'immunité du monstre actuel est exigée.<br>"; }
       if (trim($currentuberdamage) == "") { $errors++; $errorlist .= "- Le dommage actuel d'Uber est exigé.<br>"; }
       if (trim($currentuberdefense) == "") { $errors++; $errorlist .= "- La défense actuel d'Uber est exigé.<br>"; }
       if (trim($currenthp) == "") { $errors++; $errorlist .= "- Le HP actuel est exigé.<br>"; }
       if (trim($currentmp) == "") { $errors++; $errorlist .= "- Le MP actuel est exigé.<br>"; }
       if (trim($currenttp) == "") { $errors++; $errorlist .= "- Le TP actuel est exigé.<br>"; }
       if (trim($maxhp) == "") { $errors++; $errorlist .= "- Le HP max est exigé.<br>"; }

       if (trim($maxmp) == "") { $errors++; $errorlist .= "- Le MP max est exigé.<br>"; }
       if (trim($maxtp) == "") { $errors++; $errorlist .= "- Le TP max est exigé.<br>"; }
       if (trim($level) == "") { $errors++; $errorlist .= "- Le niveau est exigé.<br>"; }
       if (trim($gold) == "") { $errors++; $errorlist .= "- Les rubis sont exigés.<br>"; }
       if (trim($experience) == "") { $errors++; $errorlist .= "- L'experience est exigée.<br>"; }
       if (trim($goldbonus) == "") { $errors++; $errorlist .= "- Les rubis bonnus sont exigés.<br>"; }
       if (trim($expbonus) == "") { $errors++; $errorlist .= "- L'experience Bonus est exigé.<br>"; }
       if (trim($strength) == "") { $errors++; $errorlist .= "- La force est exigée.<br>"; }
       if (trim($dexterity) == "") { $errors++; $errorlist .= "- La dextérité est exigée.<br>"; }
       if (trim($attackpower) == "") { $errors++; $errorlist .= "- Le pouvoir d'attaque est exigé.<br>"; }

       if (trim($defensepower) == "") { $errors++; $errorlist .= "- Le pouvoir de défense est exigé.<br>"; }
       if (trim($weaponid) == "") { $weaponid == "Aucun"; }
       if (trim($armorid) == "") { $armorid == "Aucun"; }
       if (trim($shieldid) == "") { $shieldid == "Aucun"; }
       if (trim($slot1id) == "") { $slot1id = 0; }
       if (trim($slot2id) == "") { $slot2id = 0; }
       if (trim($slot3id) == "") { $slot3id = 0; }
       if (trim($weaponname) == "") { $weaponname = "Aucun"; }
       if (trim($armorname) == "") { $armorname = "Aucun";; }
       if (trim($shieldname) == "") { $shieldname = "Aucun";; }

       if (trim($slot1name) == "") { $slot1name	= "Aucun"; }
       if (trim($slot2name) == "") { $slot2name	= "Aucun";; }
       if (trim($slot3name) == "") { $slot3name	= "Aucun";; }
       if (trim($dropcode) == "") { $dropcode = 0; }
       if (trim($spells) == "") { $spells = 0; }
       if (trim($towns) == "") { $towns = 0; }

        if (!is_numeric($authlevel)) { $errors++; $errorlist .= "- Le niveau d'accès doit être un nombre.<br>"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "- La latitude doit être un nombre.<br>"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "- La longitude doit être un nombre.<br>"; }
        if (!is_numeric($difficulty)) { $errors++; $errorlist .= "- La difficultée doit être un nombre.<br>"; }
        if (!is_numeric($charclass)) { $errors++; $errorlist .= "- La classe du personnage doit être un nombre.<br>"; }
        if (!is_numeric($currentfight)) { $errors++; $errorlist .= "- Le combat en cours doit être un nombre.<br>"; }
        if (!is_numeric($currentmonster)) { $errors++; $errorlist .= "- L'ID monstre actuel doit être un nombre.<br>"; }
        if (!is_numeric($currentmonsterhp)) { $errors++; $errorlist .= "- Le HP du monstre actuel doit être un nombre.<br>"; }
        if (!is_numeric($currentmonstersleep)) { $errors++; $errorlist .= "- L'ID des sorts du monstre actuel doit être un nombre.<br>"; }
        
        if (!is_numeric($currentmonsterimmune)) { $errors++; $errorlist .= "- L'immunité du monstre actuel doit être nombre.<br>"; }
        if (!is_numeric($currentuberdamage)) { $errors++; $errorlist .= "- Le dommage actuel d'Uber doit être un nombre.<br>"; }
        if (!is_numeric($currentuberdefense)) { $errors++; $errorlist .= "- La défense actuel d'Uber doit être un nombre.<br>"; }
        if (!is_numeric($currenthp)) { $errors++; $errorlist .= "- Le HP actuel doit être un nombre.<br>"; }
        if (!is_numeric($currentmp)) { $errors++; $errorlist .= "- Le MP actuel doit être un nombre.<br>"; }
        if (!is_numeric($currenttp)) { $errors++; $errorlist .= "- Le TP actuel doit être un nombre.<br>"; }
        if (!is_numeric($maxhp)) { $errors++; $errorlist .= "- Le HP Max doit àtre un nombre.<br>"; }
        if (!is_numeric($maxmp)) { $errors++; $errorlist .= "- Le MP Max doit àtre un nombre.<br>"; }
        if (!is_numeric($maxtp)) { $errors++; $errorlist .= "- Le TP Max doit àtre un nombre.<br>"; }
        if (!is_numeric($level)) { $errors++; $errorlist .= "- Le niveau doit être un nombre.<br>"; }
        
        if (!is_numeric($gold)) { $errors++; $errorlist .= "- Les rubis doivent êtres des nombres.<br>"; }
        if (!is_numeric($experience)) { $errors++; $errorlist .= "- L'expérience doit être un nombre.<br>"; }
        if (!is_numeric($goldbonus)) { $errors++; $errorlist .= "- Les rubis bonnus doivent êtres des nombres.<br>"; }
        if (!is_numeric($expbonus)) { $errors++; $errorlist .= "- L'expérience bonnus doit être un nombre.<br>"; }
        if (!is_numeric($strength)) { $errors++; $errorlist .= "- La force doit être un nombre.<br>"; }
        if (!is_numeric($dexterity)) { $errors++; $errorlist .= "- La dextérité doit être un nombre.<br>"; }
        if (!is_numeric($attackpower)) { $errors++; $errorlist .= "- Le pouvoir d'attaque doit être un nombre.<br>"; }
        if (!is_numeric($defensepower)) { $errors++; $errorlist .= "- Le pouvoir de défense doit être un nombre.<br>"; }
        if (!is_numeric($weaponid)) { $errors++; $errorlist .= "- L'ID de la l'arme doit être un nombre.<br>"; }
        if (!is_numeric($armorid)) { $errors++; $errorlist .= "- L'ID de l'armure doit être un nombre.<br>"; }
        
        if (!is_numeric($shieldid)) { $errors++; $errorlist .= "- L'ID de la protection doit tre un nombre.<br>"; }
        if (!is_numeric($slot1id)) { $errors++; $errorlist .= "- L'ID de la fente 1 doit être un nombre.<br>"; }
        if (!is_numeric($slot2id)) { $errors++; $errorlist .= "- L'ID de la fente 2 doit être un nombre.<br>"; }
        if (!is_numeric($slot3id)) { $errors++; $errorlist .= "- L'ID de la fente 3 doit être un nombre.<br>"; }
        if (!is_numeric($dropcode)) { $errors++; $errorlist .= "Drop Code must be a number.<br />"; }

        if ($errors == 0) { 

$update = doquery("UPDATE {{table}} SET
email='".addslashes($email)."', verify='$verify', charname='".addslashes($charname)."', authlevel='$authlevel', latitude='$latitude',
longitude='$longitude', difficulty='$difficulty', charclass='$charclass', currentaction='$currentaction', currentfight='$currentfight',
currentmonster='$currentmonster', currentmonsterhp='$currentmonsterhp', currentmonstersleep='$currentmonstersleep', currentmonsterimmune='$currentmonsterimmune', currentuberdamage='$currentuberdamage',
currentuberdefense='$currentuberdefense', currenthp='$currenthp', currentmp='$currentmp', currenttp='$currenttp', maxhp='$maxhp',
maxmp='$maxmp', maxtp='$maxtp', level='$level', gold='$gold', experience='$experience',
goldbonus='$goldbonus', expbonus='$expbonus', strength='$strength', dexterity='$dexterity', attackpower='$attackpower',
defensepower='$defensepower', weaponid='$weaponid', armorid='$armorid', shieldid='$shieldid', slot1id='$slot1id',
slot2id='$slot2id', slot3id='$slot3id', weaponname='".addslashes($weaponname)."', armorname='".addslashes($armorname)."', shieldname='".addslashes($shieldname)."',
slot1name='".addslashes($slot1name)."', slot2name='".addslashes($slot2name)."', slot3name='".addslashes($slot3name)."', dropcode='$dropcode', spells='$spells',
towns='$towns' WHERE id='".$usersrow['id']."' LIMIT 1", "users");
			
         $page .='L\'utilisateur '.addslashes($charname).' a été mis à jour!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
         $page .= 'La mise à jour n\'a pas pu se faire, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=edituser:'.$id.'">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }           
    }else{   
    
    $diff1name = $controlrow['diff1name'];
    $diff2name = $controlrow['diff2name'];
    $diff3name = $controlrow['diff3name'];
    $class1name = $controlrow['class1name'];
    $class2name = $controlrow['class2name'];
    $class3name = $controlrow['class3name'];
	
	if ($usersrow['authlevel'] == 0) { $usersrow['auth0select'] = 'selected="selected" '; } else { $usersrow['auth0select'] = ""; }
    if ($usersrow['authlevel'] == 1) { $usersrow['auth1select'] = 'selected="selected" '; } else { $usersrow['auth1select'] = ""; }
    if ($usersrow['authlevel'] == 2) { $usersrow['auth2select'] = 'selected="selected" '; } else { $usersrow['auth2select'] = ""; }
    if ($usersrow['charclass'] == 1) { $usersrow['class1select'] = 'selected="selected" '; } else { $usersrow['class1select'] = ""; }
    if ($usersrow['charclass'] == 2) { $usersrow['class2select'] = 'selected="selected" '; } else { $usersrow['class2select'] = ""; }
    if ($usersrow['charclass'] == 3) { $usersrow['class3select'] = 'selected="selected" '; } else { $usersrow['class3select'] = ""; }
    if ($usersrow['difficulty'] == 1) { $usersrow['diff1select'] = 'selected="selected" '; } else { $usersrow['diff1select'] = ""; }
    if ($usersrow['difficulty'] == 2) { $usersrow['diff2select'] = 'selected="selected" '; } else { $usersrow['diff2select'] = ""; }
    if ($usersrow['difficulty'] == 3) { $usersrow['diff3select'] = 'selected="selected" '; } else { $usersrow['diff3select'] = ""; }


$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les utilisateurs:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Joueur numéro:</td><td>'.$usersrow['id'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">ID:</td><td>'.$usersrow['username'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Avatar:</td><td><img src="images/avatars/jeu/'.$usersrow['avatar'].'.gif" alt="'.$usersrow['charname'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Email:</td><td><input type="text" name="email" size="30" maxlength="100" value="'.$usersrow['email'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Verifié:</td><td><input type="text" name="verify" size="30" maxlength="8" value="'.$usersrow['verify'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Pseudo:</td><td><input type="text" name="charname" size="30" maxlength="30" value="'.$usersrow['charname'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Date d\'inscription:</td><td>'.$usersrow['regdate'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Dernière fois en ligne:</td><td>'.$usersrow['onlinetime'].'<br><br></td></tr>
<tr valign="top"><td style="width:110px">Niv. d\'accès:</td><td><select name="authlevel"><option value="0" '.$usersrow['auth0select'].'>Simple joueur</option><option value="1" '.$usersrow['auth1select'].'>Administrateur</option><option value="2" '.$usersrow['auth2select'].'>Bloqué</option></select><br>Sélectionnez "bloqué" pour empêcher un utilisateur d\'accèder au jeu.<br><br></td></tr>

<tr valign="top"><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">Latitude:</td><td><input type="text" name="latitude" size="5" maxlength="6" value="'.$usersrow['latitude'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Longitude:</td><td><input type="text" name="longitude" size="5" maxlength="6" value="'.$usersrow['longitude'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Difficulté:</td><td><select name="difficulty"><option value="1" '.$usersrow['diff1select'].'>'.$diff1name.'</option><option value="2" '.$usersrow['diff2select'].'>'.$diff2name.'</option><option value="3" '.$usersrow['diff3select'].'>'.$diff3name.'</option></select><br><br></td></tr>
<tr valign="top"><td style="width:110px">Classe du personnage:</td><td><select name="charclass"><option value="1" '.$usersrow['class1select'].'>'.$class1name.'</option><option value="2" '.$usersrow['class2select'].'>'.$class2name.'</option><option value="3" '.$usersrow['class3select'].'>'.$class3name.'</option></select><br><br></td></tr>

<tr valign="top"><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">Action en cours:</td><td><input type="text" name="currentaction" size="30" maxlength="30" value="'.$usersrow['currentaction'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Combat en cours:</td><td><input type="text" name="currentfight" size="5" maxlength="4" value="'.$usersrow['currentfight'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">ID du monstre:</td><td><input type="text" name="currentmonster" size="5" maxlength="6" value="'.$usersrow['currentmonster'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">HP du monstre:</td><td><input type="text" name="currentmonsterhp" size="5" maxlength="6" value="'.$usersrow['currentmonsterhp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">ID des sorts du monstre:</td><td><input type="text" name="currentmonsterimmune" size="5" maxlength="3" value="'.$usersrow['currentmonsterimmune'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Immunité du monstre:</td><td><input type="text" name="currentmonstersleep" size="5" maxlength="3" value="'.$usersrow['currentmonstersleep'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Dommage actuel d\'Uber:</td><td><input type="text" name="currentuberdamage" size="5" maxlength="3" value="'.$usersrow['currentuberdamage'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Défense actuel d\'Uber:</td><td><input type="text" name="currentuberdefense" size="5" maxlength="3" value="'.$usersrow['currentuberdefense'].'"><br><br></td></tr>

<tr valign="top"><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">HP actuel:</td><td><input type="text" name="currenthp" size="5" maxlength="6" value="'.$usersrow['currenthp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">MP actuel:</td><td><input type="text" name="currentmp" size="5" maxlength="6" value="'.$usersrow['currentmp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">TP actuel:</td><td><input type="text" name="currenttp" size="5" maxlength="6" value="'.$usersrow['currenttp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Max HP:</td><td><input type="text" name="maxhp" size="5" maxlength="6" value="'.$usersrow['maxhp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Max MP:</td><td><input type="text" name="maxmp" size="5" maxlength="6" value="'.$usersrow['maxmp'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Max TP:</td><td><input type="text" name="maxtp" size="5" maxlength="6" value="'.$usersrow['maxtp'].'"><br><br></td></tr>

<tr valign="top"><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">Niveau:</td><td><input type="text" name="level" size="5" maxlength="5" value="'.$usersrow['level'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Rubis:</td><td><input type="text" name="gold" size="10" maxlength="8" value="'.$usersrow['gold'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Experience:</td><td><input type="text" name="experience" size="10" maxlength="8" value="'.$usersrow['experience'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Bonnus rubis:</td><td><input type="text" name="goldbonus" size="5" maxlength="5" value="'.$usersrow['goldbonus'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Bonnus experience :</td><td><input type="text" name="expbonus" size="5" maxlength="5" value="'.$usersrow['expbonus'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Force:</td><td><input type="text" name="strength" size="5" maxlength="5" value="'.$usersrow['strength'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Dextérité:</td><td><input type="text" name="dexterity" size="5" maxlength="5" value="'.$usersrow['dexterity'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Pouvoir d\'attaque:</td><td><input type="text" name="attackpower" size="5" maxlength="5" value="'.$usersrow['attackpower'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Pouvoir de défense:</td><td><input type="text" name="defensepower" size="5" maxlength="5" value="'.$usersrow['defensepower'].'"><br><br></td></tr>

<tr valign="top"><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">ID de l\'arme:</td><td><input type="text" name="weaponid" size="5" maxlength="5" value="'.$usersrow['weaponid'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">ID del\'armure:</td><td><input type="text" name="armorid" size="5" maxlength="5" value="'.$usersrow['armorid'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">ID de la protection:</td><td><input type="text" name="shieldid" size="5" maxlength="5" value="'.$usersrow['shieldid'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">ID de la fente 1:</td><td><input type="text" name="slot1id" size="5" maxlength="5" value="'.$usersrow['slot1id'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">ID de la fente 2:</td><td><input type="text" name="slot2id" size="5" maxlength="5" value="'.$usersrow['slot2id'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">ID de la fente 3:</td><td><input type="text" name="slot3id" size="5" maxlength="5" value="'.$usersrow['slot3id'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom de l\'arme:</td><td><input type="text" name="weaponname" size="30" maxlength="30" value="'.$usersrow['weaponname'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom de l\'armure:</td><td><input type="text" name="armorname" size="30" maxlength="30" value="'.$usersrow['armorname'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom de la protec.:</td><td><input type="text" name="shieldname" size="30" maxlength="30" value="'.$usersrow['shieldname'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom de la fente 1:</td><td><input type="text" name="slot1name" size="30" maxlength="30" value="'.$usersrow['slot1name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom de la fente 2:</td><td><input type="text" name="slot2name" size="30" maxlength="30" value="'.$usersrow['slot2name'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom de la fente 3:</td><td><input type="text" name="slot3name" size="30" maxlength="30" value="'.$usersrow['slot3name'].'"><br><br></td></tr>

<tr valign="top"><td colspan="2" class="rose2">&nbsp;</td></tr>

<tr valign="top"><td style="width:110px">Code drop:</td><td><input type="text" name="dropcode" size="5" maxlength="8" value="'.$usersrow['dropcode'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Sorts:</td><td><input type="text" name="spells" size="50" maxlength="50" value="'.$usersrow['spells'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Ville:</td><td><input type="text" name="towns" size="50" maxlength="50" value="'.$usersrow['towns'].'"><br><br><br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>
</form><br><br>';
 
 }
    
display($page, 'Editer les utilisateurs');
    
}


function addnews() {// Edition des news.

global $controlrow, $page;

    if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
		if (trim($titre) == "") { $errors++; $errorlist .= "- Le titre de la news exigé.<br>"; }
        if (trim($resume) == "") { $errors++; $errorlist .= "- Le résumé de la news est exigé.<br>"; }
         
        if ($errors == 0) { 
           $update = doquery("INSERT INTO {{table}} SET id='',date='".time()."',title='$titre', resume='$resume', content='$message'", "news");
		   $page .='La news vient d\'être posté!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
           $page .= 'La news n\'a pas pu être posté, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=addnews">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }            
    }else{

if(isset($_POST['previsualiser'])) {
	$texte = new texte();
	$bbcode  = $texte->ms_format($_POST['message']);
	  
    }else{
	$bbcode = $_POST['message'] = $_POST['resume'] = $_POST['titre'] = null;
	}	
          
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer une news:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post" name="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Titre:</td><td><input type="text" name="titre" size="40" value="'.$_POST['titre'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Résumé:</td><td><textarea name="resume" rows="5" cols="54">'.$_POST['resume'].'</textarea><br><br></td></tr>
<tr valign="top"><td style="width:110px">BBcode:</td><td><select class="taille2" onchange="bbfontstyle(\'[color=\' + this.form.couleur.options[this.form.couleur.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" name="couleur"><option style="color: black;" value="#000000">Couleur</option><option style="color: red;" value="#FF0000">Rouge</option><option style="color: orange;" value="#FFA500">Orange</option><option style="color: yellow;" value="#FFFF00">Jaune</option><option style="color: green;" value="#008000">Vert</option><option style="color: violet;" value="#EE82EE">Violet</option><option style="color: blue;" value="#0000FF">Bleu</option><option style="color: indigo;" value="#4B0082">Indigo</option></select> <select onchange="bbfontstyle(\'[size=\' + this.form.taille.options[this.form.taille.selectedIndex].value + \']\', \'[/size]\')" name="taille"> <option value="9">Très petit</option> <option value="10">Petit</option> <option value=3 selected>Normal</option> <option value="14">Grand</option> <option value="20">Très grand</option></select><input onclick="bbstyle(0)" type="button" value="G" class="taille2" style="font-weight: bold;"> <input onclick="bbstyle(2)" type="button" value="I" class="taille2" style="font-style: italic;"> <input onclick="bbstyle(4)" type="button" value="U" class="taille2" style="text-decoration: underline;"> <input onclick="bbstyle(6)" type="button" value="Url" class="taille2"> <input onclick="bbstyle(8)" type="button" value="Image" class="taille2"></td></tr>
<tr valign="top"><td style="width:110px"></td><td style="height:4px"></td></tr>
<tr valign="top"><td style="width:110px"></td><td><a href="javascript:emoticon(\':D\')"><img src="images/jeu/blog/smileys/sourire.gif" style="border:0"  alt=""></a> <a href="javascript:emoticon(\';\)\')"><img src="images/jeu/blog/smileys/clin.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':\(\')"><img src="images/jeu/blog/smileys/triste.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':surpris:\')"><img src="images/jeu/blog/smileys/yeuxrond.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':o\')"><img src="images/jeu/blog/smileys/etonne.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':confus:\')"><img src="images/jeu/blog/smileys/confus.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':lol:\')"><img src="images/jeu/blog/smileys/lol.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':fire:\')"><img src="images/jeu/blog/smileys/flame.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':splif:\')"><img src="images/jeu/blog/smileys/petard.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':bigsmile:\')"><img src="images/jeu/blog/smileys/green.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':x\')"><img src="images/jeu/blog/smileys/mad.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':roll:\')"><img src="images/jeu/blog/smileys/rolleyes.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':bigcry:\')"><img src="images/jeu/blog/smileys/crying.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':colere:\')"><img src="images/jeu/blog/smileys/colere.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':P\')"><img src="images/jeu/blog/smileys/razz.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\'8\)\')"><img src="images/jeu/blog/smileys/lunettes.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':\)\')"><img src="images/jeu/blog/smileys/sourire2.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':oops:\')"><img src="images/jeu/blog/smileys/redface.gif" style="border:0" alt=""></a><br><br></td></tr>
<tr valign="top"><td style="width:110px">News complète:</td><td><textarea name="message" rows="5" cols="54">'.$_POST['message'].'</textarea><br><br></td></tr>
<tr valign="top"><td style="width:110px"></td><td><input type="submit" name="submit" value="Envoyer"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"> <input type="submit" name="previsualiser" value="Prévisualiser"><br><br></td></tr>
<tr valign="top"><td style="width:110px"></td><td style="width:340px">'.$bbcode.'</td></tr>
</table>
</form><br><br>
';
} 
   
display($page, 'Editer les news');

} 


function addpoll() {// Edition du sondage.

global $page;

    if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if (trim($question) == "") { $errors++; $errorlist .= "- La question est obligatoire.<br>"; }
	    if (trim($answer1) == "") { $errors++; $errorlist .= "- La réponse 1  est obligatoire.<br>"; }
		if (trim($answer2) == "") { $errors++; $errorlist .= "- La réponse 2 est obligatoire.<br>"; }
		if (preg_match("/[\^*+<>#]/", $question)==1) { $errors++; $errorlist .= "- La question doit être écrit en caractères alphanumériques.<br>"; }
        if (preg_match("/[\^*+<>#]/", $answer1)==1) { $errors++; $errorlist .= "- La réponse 1 doit être écrit en caractères alphanumériques.<br>"; }
        if (preg_match("/[\^*+<>#]/", $answer2)==1) { $errors++; $errorlist .= "- La réponse 2 doit être écrit en caractères alphanumériques.<br>"; }
		if (preg_match("/[\^*+<>#]/", $answer3)==1) { $errors++; $errorlist .= "- La réponse 3 doit être écrit en caractères alphanumériques.<br>"; }
		if (preg_match("/[\^*+<>#]/", $answer4)==1) { $errors++; $errorlist .= "- La réponse 4 doit être écrit en caractères alphanumériques.<br>"; }

		
        if ($errors == 0) { 
           $update = doquery("INSERT INTO {{table}} SET id='',question='".addslashes($question)."',answer1='".addslashes($answer1)."',answer2='".addslashes($answer2)."',answer3='".addslashes($answer3)."',answer4='".addslashes($answer4)."'", "poll");
           $page .='Le sondage vient d\'être posté!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
           $page .= 'Le sondage n\'a pas pu être posté, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=addpoll">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }            
    }else{   
             
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Ajouter un sondage:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Question :</td><td><input type="text" name="question" size="20"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Réponse 1 :</td><td><input type="text" name="answer1" size="20" maxlength="18"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Réponse 2 :</td><td><input type="text" name="answer2" size="20" maxlength="18"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Réponse 3 :</td><td><input type="text" name="answer3" size="20" maxlength="18"> ( si nécéssaire)<br><br></td></tr>
<tr valign="top"><td style="width:110px">Réponse 4 :</td><td><input type="text" name="answer4" size="20" maxlength="18"> ( si nécéssaire)<br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Créer"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>
</form><br><br>';
}  
     
display($page, 'Editer le sondage');

}


function addnewsletter() {// Edition des newsletters.

global $controlrow, $page, $userrow;
  
    if (isset($_POST['submit'])) {
   
        extract($_POST);
        $errors = 0;
        $errorlist = "";
		if (trim($expediteur) == "") { $errors++; $errorlist .= "- L'adresse de l'expéditeur est exigée.<br>"; }
		if (! is_email($expediteur)) { $errors++; $errorlist .= "- L'adresse de l'expéditeur est invalide.<br>"; }
        if (trim($sujet) == "") { $errors++; $errorlist .= "- Le sujet du mail est exigé.<br>"; }
	    if (trim($message) == "") { $errors++; $errorlist .= "- Le message du mail est exigé.<br>"; }
        if (preg_match('/[<>\[\]]/',  $message)==1 && $format == "plain"){ $errors++; $errorlist .= "- Le message est incorrect au format texte.<br>"; }
 
        
        if ($errors == 0) {
		if ($format == 'html') { 
	
		 $texte = new texte();
		
		 $body= $texte->ms_format($_POST['message']).'<br><br>A bientot sur <a href='.$controlrow['gameurl'].'>'.$controlrow['gamename'].'</a>'; 
		
		}else {
		
		 $body = $_POST['message']."\n \n A bientot sur ".$controlrow['gamename']."(".$controlrow['gameurl'].")"; 
		
		}
   $usersquery = doquery("SELECT * FROM {{table}} WHERE verify=1", "users");  
     
   while ($usersrow=mysql_fetch_array($usersquery)){
	 
       $to = $usersrow['email'];		   
       $title = $controlrow['gamename'].' : '.$_POST['sujet']; 
       $head  = 'De:'.$_POST['expediteur'].'\n'; 
       $head .= "MIME-version: 1.0\n"; 
       $head .= 'Content-type: text/'.$format.'; charset= iso-8859-1\n';
       $body;
	   
	   mail($to,$title,$body,$head); 
   }
           $page .='La newsletter vient d\'être posté!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
           $page .= 'La newsletter n\'a pas pu être posté, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=addnewsletter">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }            
    }else{
	
	if(isset($_POST['previsualiser'])&& $_POST['format'] == 'html') {
	$texte = new texte();
	$bbcode  = $texte->ms_format($_POST['message']);
	  
    }elseif(isset($_POST['previsualiser'])&& $_POST['format'] == 'plain') {
	
	$bbcode = nl2br($_POST['message']);
	
	}else{
	$bbcode = $_POST['message'] = $_POST['sujet'] = null;
	}
	
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer une newsletter:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post" name="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Expéditeur:</td><td><input type="text" name="expediteur" size="20" value="'.$userrow['email'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Sujet du mail:</td><td><input type="text" name="sujet" size="40" value="'.$_POST['sujet'].'"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Format:</td><td><input type="radio" value="plain" name="format">Texte <span class="alerte">(pas de BBcode)</span> <input type="radio" value="html" name="format" checked>Html<br><br></td></tr>
<tr valign="top"><td style="width:110px">BBcode:</td><td><select class="taille2" onchange="bbfontstyle(\'[color=\' + this.form.couleur.options[this.form.couleur.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" name="couleur"><option style="color: black;" value="#000000">Couleur</option><option style="color: red;" value="#FF0000">Rouge</option><option style="color: orange;" value="#FFA500">Orange</option><option style="color: yellow;" value="#FFFF00">Jaune</option><option style="color: green;" value="#008000">Vert</option><option style="color: violet;" value="#EE82EE">Violet</option><option style="color: blue;" value="#0000FF">Bleu</option><option style="color: indigo;" value="#4B0082">Indigo</option></select> <select onchange="bbfontstyle(\'[size=\' + this.form.taille.options[this.form.taille.selectedIndex].value + \']\', \'[/size]\')" name="taille"> <option value="9">Très petit</option> <option value="10">Petit</option> <option value=3 selected>Normal</option> <option value="14">Grand</option> <option value="20">Très grand</option></select><input onclick="bbstyle(0)" type="button" value="G" class="taille2" style="font-weight: bold;"> <input onclick="bbstyle(2)" type="button" value="I" class="taille2" style="font-style: italic;"> <input onclick="bbstyle(4)" type="button" value="U" class="taille2" style="text-decoration: underline;"> <input onclick="bbstyle(6)" type="button" value="Url" class="taille2"> <input onclick="bbstyle(8)" type="button" value="Image" class="taille2"></td></tr>
<tr valign="top"><td style="width:110px"></td><td style="height:4px"></td></tr>
<tr valign="top"><td style="width:110px"></td><td><a href="javascript:emoticon(\':D\')"><img src="images/jeu/blog/smileys/sourire.gif" style="border:0"  alt=""></a> <a href="javascript:emoticon(\';\)\')"><img src="images/jeu/blog/smileys/clin.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':\(\')"><img src="images/jeu/blog/smileys/triste.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':surpris:\')"><img src="images/jeu/blog/smileys/yeuxrond.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':o\')"><img src="images/jeu/blog/smileys/etonne.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':confus:\')"><img src="images/jeu/blog/smileys/confus.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':lol:\')"><img src="images/jeu/blog/smileys/lol.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':fire:\')"><img src="images/jeu/blog/smileys/flame.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':splif:\')"><img src="images/jeu/blog/smileys/petard.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':bigsmile:\')"><img src="images/jeu/blog/smileys/green.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':x\')"><img src="images/jeu/blog/smileys/mad.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':roll:\')"><img src="images/jeu/blog/smileys/rolleyes.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':bigcry:\')"><img src="images/jeu/blog/smileys/crying.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':colere:\')"><img src="images/jeu/blog/smileys/colere.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':P\')"><img src="images/jeu/blog/smileys/razz.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\'8\)\')"><img src="images/jeu/blog/smileys/lunettes.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':\)\')"><img src="images/jeu/blog/smileys/sourire2.gif" style="border:0" alt=""></a> <a href="javascript:emoticon(\':oops:\')"><img src="images/jeu/blog/smileys/redface.gif" style="border:0" alt=""></a><br><br></td></tr>
<tr valign="top"><td style="width:110px">Message :</td><td><textarea name="message" rows="5" cols="54">'.$_POST['message'].'</textarea><br><br></td></tr>
<tr valign="top"><td style="width:110px"></td><td><input type="submit" name="submit" value="Envoyer"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"> <input type="submit" name="previsualiser" value="Prévisualiser"><br><br></td></tr>
<tr valign="top"><td style="width:110px"></td><td style="width:340px">'.$bbcode.'</td></tr>
</table>
</form><br><br>
';
}

display($page, 'Editer les newsletters');

}


function editpartner() {// Edition des partenaires.

global $page;
    
    if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
		if (trim($name) == "") { $errors++; $errorlist .= "- Le nom du site est exigé.<br>"; }
        if (trim($url) == "") { $errors++; $errorlist .= "- L'adresse du site est exigée.<br>"; }
		if (trim($description) == "") { $errors++; $errorlist .= "- La description du site est exigée.<br>"; }
		if (preg_match("/[\^*+<>?#]/", $name)==1) { $errors++; $errorlist .= "- Le nom du site doit être écrit en caractères alphanumériques.<br>"; }
        if (preg_match("/[\^*+<>#]/", $url)==1) { $errors++; $errorlist .= "- L'adresse du site est incorrecte.<br>"; }
        if (preg_match("/[\^*+<>?#\"']/", $description)==1) { $errors++; $errorlist .= "- La description du site doit être écrit en caractères alphanumériques.<br>"; }
        if (preg_match("/[\^*+<>#\"']/", $button)==1) { $errors++; $errorlist .= "- L'adresse du bouton du site est incorrect.<br>"; }

        if ($errors == 0) { 
           $update = doquery("INSERT INTO {{table}} SET id='',name='$name', description='$description', url='$url', button='$button'", "partners");
           $page .='Le partenaire '.$name.' vient d\'être ajouté!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
           $page .= 'Le partenaire n\'a pas pu être ajouté, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=editpartner">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }          
    }else{  
          
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer les partenaires:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Nom du site:</td><td><input type="text" name="name" size="20"><br><br></td></tr>
<tr valign="top"><td style="width:110px">URL du site:</td><td><input type="text" name="url" size="20"> avec (http://)<br><br></td></tr>
<tr valign="top"><td style="width:110px">URL du bouton:</td><td><input type="text" name="button" size="20"> taille: 81x31<br><br></td></tr>
<tr valign="top"><td style="width:110px">Description:</td><td><textarea name="description" rows="5" cols="54"></textarea><br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Ajouter"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>
</form><br><br>';
} 
    
display($page, 'Editer les partenaires');
  
} 


function editcopyright() {// Edition du copyright.

global $controlrow, $page;
    
    if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
		if (trim($copyright) == "") { $errors++; $errorlist .= "- Le copyright est obligatoire.<br>"; }
        if (preg_match('/[<>\[\]]/', $copyright)==1) { $errors++; $errorlist .= "- Le copyright doit être écrit en caractères alphanumériques.<br>"; }

       if ($errors == 0) { 
           $update = doquery("UPDATE {{table}} SET copyright='".addslashes($copyright)."'", "control");
           $page .='Le copyright vient d\'être modifié!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
           $page .= 'Le copyright n\'a pas pu être modifié, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=editcopyright">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }             
    }else{  
 
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer le copyright:</b></span><br><br>

<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Nouveau: </td><td><input type="text" name="copyright" size="40" value=""><br>Merci de laisser la mention "© RPGillusion.net", pour le bien de la communauté Open Source(GNU/ GPL).<br><br></td></tr>
<tr valign="top"><td style="width:110px">Ancien: </td><td><input type="text" name="ancien" size="40" value="'.$controlrow['copyright'].'"><br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>

<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div></td></tr>
</table>
</form><br><br>';
}

display($page, 'Editer le copyright');

}  


function editbabblebox() {// Edition du t'chat (vider).    

global $page;

  if (isset($_POST['submit'])) {
        
	$delete = doquery("DELETE FROM {{table}}", "babble");
           
    $page .='Le t\'chat vient d\'être vidé!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
         
    }else{ 
	
$page .= '
	
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer le copyright:</b></span><br><br>Pour vider le t\'chat il vous suffit de cliquer sur le bouton nommé "vider".<br><br><span class="alerte">Note:</span> Cette action est irréversible.<br><br>

<form enctype="multipart/form-data" action="" method="post">
<div style="text-align: center"><input type="submit" name="submit" value="Vider"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"></div>
</form><br><br> 
';
}	

display($page, 'Editer le t\'chat (vider)');

}


function editmenuusers() {// Edition du contenu du menu users.

global $page;

$menuquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "menu_users");
$menurow = mysql_fetch_array($menuquery);

    if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
		if (trim($content) == "") { $errors++; $errorlist .= "- Le contenu du menu est exigé.<br>"; }
         
        if ($errors == 0) { 
           $update = doquery("UPDATE {{table}} SET content='$content' WHERE id='1' LIMIT 1", "menu_users");
		   $page .='Le contenu vient d\'être posté!<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a><br>» Sélectionner une autre rubrique à administrer';  
        } else {
           $page .= 'La contenu n\'a pas pu être posté, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=editmenuusers">» retourner et réessayer</a><br><a href="index.php">» retourner au jeu</a>'; 
        }            
    }else{	
          
$page .= '
<img src="images/jeu/puce4.gif" alt=""> <span class="mauve2"><b>Editer le menu users:</b></span><br><br>Vous pouvez ajouter dans le menu "Users" des publicités ou d\'autres contenus Un minimum de connaissance en language HTML est requis en cas d\'ajout d\'une publucité.<br><br>

<form enctype="multipart/form-data" action="" method="post" name="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Le contenu:</td><td><textarea name="content" rows="5" cols="54">'.$menurow['content'].'</textarea><br><br></td></tr>
<tr valign="top"><td style="width:110px"></td><td><input type="submit" name="submit" value="Envoyer"> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"><br><br></td></tr>
</table>
</form><br><br>
';
} 
   
display($page, 'Editer le menu users');

}


?>