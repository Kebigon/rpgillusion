<?php // display.php :: Affichage du jeu.

function display($content, $title, $leftnav=true) { 
    
global $userrow, $controlrow;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
   
    $template = gettemplate("primary");
    
    if ($leftnav == true) { $leftnav = gettemplate("leftnav"); } else { $leftnav = ""; }
	      
	$userquery = doquery("SELECT * FROM {{table}} WHERE id='".$_SESSION['id']."' LIMIT 1", "users");
    unset($userrow);
    $userrow = mysql_fetch_array($userquery);
       
    $styles='<link rel="stylesheet" href="styles/css_jeu.css" type="text/css">
    <script type="text/javascript" src="styles/js_jeu.js"></script>';
	$load_classement=null;
	
	$townslist = explode(",",$userrow["towns"]);
        $townquery2 = doquery("SELECT * FROM {{table}} ORDER BY id", "towns");
        $userrow["townslist"] = "";
        while ($townrow2 = mysql_fetch_array($townquery2)) {
            $town = false;
            foreach($townslist as $a => $b) {
                if ($b == $townrow2["id"]) { $town = true; }
            }
            if ($town == true) { 
                $userrow["townslist"] .= '<img src="images/jeu/puce2.gif" alt=""> <a href="index.php?do=gotown:'.$townrow2["id"].'">'.$townrow2['name'].'</a> ('.$townrow2['longitude'].';'.$townrow2['latitude'].')<br>'; 
            }
        }
		if($userrow["townslist"] == null){$userrow["townslist"] .= '<img src="images/jeu/puce2.gif" alt=""> Aucune carte<br>';}
		 
	if ($userrow["authlevel"] == 1) { $userrow["adminlink"] ='<img src="images/jeu/puce.jpg" alt="">&nbsp;<a href="javascript:classement(\'1\');"><b>Administration</b></a><br>';} else { $userrow["adminlink"] = ""; }
        $userrow["adminmenu"] ='- <a href="admin.php?do=main">Réglages principaux</a><br>- <a href="admin.php?do=items">Editer les objets</a><br>- <a href="admin.php?do=drops">Editer les objets perdus</a><br>
        - <a href="admin.php?do=towns">Editer les villes</a><br>- <a href="admin.php?do=monsters">Editer les monstres</a><br>
        - <a href="admin.php?do=spells">Editer les sorts</a><br>- <a href="admin.php?do=levels">Editer les niveaux</a><br>- <a href="admin.php?do=users">Editer les utilisateurs</a><br>
        - <a href="admin.php?do=addpoll">Editer le sondage</a><br>- <a href="admin.php?do=editcopyright">Editer le copyright</a><br>- <a href="admin.php?do=editbabblebox">Vider le t\'chat</a><br>- <a href="admin.php?do=addnewsletter">Editer une newsletter</a><br>- <a href="admin.php?do=addnews">Editer les news d\'acceuil</a><br>
        - <a href="admin.php?do=editpartner">Editer les partenaires</a><br>- <a href="admin.php?do=editmenuusers">Editer menu users</a><br><br><br>';	

    $finalarray = array(
        "rpgname"=>$controlrow["gamename"],
		"copyright"=>$controlrow["copyright"],
        "title"=>$title,
		"styles"=>$styles,
		"load_classement"=>$load_classement,
        "content"=>$content,
		"leftnavlog"=>null,
		"leftnav"=>parsetemplate($leftnav,$userrow),

	   );
    $page = parsetemplate($template, $finalarray);
    
    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo stripslashes($page);
    die();
    
}

?>