<?php // admin.php :: Administration du script.

include('./lib.php');
include('./cookies.php');
$link = opendb();
$userrow = checkcookies();
if ($userrow == false) { die("Merci de vous loger dans le <a href=\"./login.php?do=login\">jeu</a> avant d'utiliser le panneau de commande."); }
if ($userrow["authlevel"] != 1) { die("Vous devez avoir des privilèges d'administrateur pour employer le panneau de commande."); }
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

if (isset($_GET["do"])) {
    $do = explode(":",$_GET["do"]);
    
    if ($do[0] == "main") { main(); }
    elseif ($do[0] == "items") { items(); }
    elseif ($do[0] == "edititem") { edititem($do[1]); }
    elseif ($do[0] == "drops") { drops(); }
    elseif ($do[0] == "editdrop") { editdrop($do[1]); }
    elseif ($do[0] == "towns") { towns(); }
    elseif ($do[0] == "edittown") { edittown($do[1]); }
    elseif ($do[0] == "monsters") { monsters(); }
    elseif ($do[0] == "editmonster") { editmonster($do[1]); }
    elseif ($do[0] == "levels") { levels(); }
    elseif ($do[0] == "editlevel") { editlevel(); }
    elseif ($do[0] == "spells") { spells(); }
    elseif ($do[0] == "editspell") { editspell($do[1]); }
    elseif ($do[0] == "users") { users(); }
    elseif ($do[0] == "edituser") { edituser($do[1]); }
    elseif ($do[0] == "news") { addnews(); }
    elseif ($do[0] == "sondage") { addsondage(); }
    elseif ($do[0] == "blocs") { blocs(); }
	elseif ($do[0] == "babble") { babble(); }
    elseif ($do[0] == "message") { message(); }
    elseif ($do[0] == "newsaccueil") { newsaccueil(); }
	elseif ($do[0] == "carte") { carte(); }
    elseif ($do[0] == "visu_map") { visu_map(); }
    
} else { donothing(); }

function donothing() {
    
    $page = "Bienvenue sur la page d'admin de RPG illusion. Ici vous pouvez modifier ou éditer librement plusieurs paramètres. <br><br> En cas de problème, veuillez contactez l'auteur de script à cette adresse : webmaster@rpgillusion.com<br><br><br><center><img src=\"./images/im_admin.gif\"/><br><br>Pour que RPG illusion perdure et que nous puissions financer de meilleurs services, nous vous invitons à faire un don du montant de votre choix. <font color=cc0000><b>Ceci est très important, car sans ces donations, le RPG pourrait <u>perdre sa licence open source et devenir payant</u> pour financer le développement du jeu.</b></font></span><br><br>
	<form action=https://www.paypal.com/cgi-bin/webscr method=post>
<input type=hidden name=cmd value=_xclick>
<input type=hidden name=business value=ffstory1@hotmail.com>
<input type=hidden name=item_name value=RPG illusion donation>
<input type=hidden name=no_note value=1>
<input type=hidden name=currency_code value=EUR>
<input type=hidden name=tax value=0>
<input type=hidden name=bn value=PP-DonationsBF>
<input type=image src=https://www.paypal.com/fr_FR/i/btn/x-click-but21.gif border=0 name=submit alt=Effectuez vos paiements via PayPal : une solution rapide, gratuite et sécurisée !>
</form>
	</center>";
	
	admindisplay($page, "Administration");
    
}

function main() {
    
    if (isset($_POST["submit"])) {
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($gamename == "") { $errors++; $errorlist .= "Le nom de jeu est exigé.<br />"; }
        if (($gamesize % 5) != 0) { $errors++; $errorlist .= "La taille de carte doit être divisible par cinq.<br />"; }
        if (!is_numeric($gamesize)) { $errors++; $errorlist .= "La taille de la carte doit être un nombre.<br />"; }
        if ($forumtype == 2 && $forumaddress == "") { $errors++; $errorlist .= "Vous devez indiquer l'adresse du forum externe.<br />"; }
        if ($class1name == "") { $errors++; $errorlist .= "Le nom de la classe 1 est exigé.<br />"; }
        if ($class2name == "") { $errors++; $errorlist .= "Le nom de la classe 2 est exigé.<br />"; }
        if ($class3name == "") { $errors++; $errorlist .= "Le nom de la classe 3 est exigé.<br />"; }
        if ($diff1name == "") { $errors++; $errorlist .= "Le nom de la difficulté 1 est exigé.<br />"; }
        if ($diff2name == "") { $errors++; $errorlist .= "Le nom de la difficulté 2 est exigé.<br />"; }
        if ($diff3name == "") { $errors++; $errorlist .= "Le nom de la difficulté 3 est exigé.<br />"; }
        if ($diff2mod == "") { $errors++; $errorlist .= "La valeur de la difficulté 2 est exigée.<br />"; }
        if ($diff3mod == "") { $errors++; $errorlist .= "La valeur de la difficulté 3 est exigée.<br />"; }
        
		$gamename = addslashes($gamename);
        if ($errors == 0) { 
		
            $query = doquery("UPDATE {{table}} SET gamename='$gamename',gamesize='$gamesize',forumtype='$forumtype',forumaddress='$forumaddress',compression='$compression',class1name='$class1name',class2name='$class2name',class3name='$class3name',diff1name='$diff1name',diff2name='$diff2name',diff3name='$diff3name',diff2mod='$diff2mod',diff3mod='$diff3mod',gameopen='$gameopen',verifyemail='$verifyemail',gameurl='$gameurl',adminemail='$adminemail',shownews='$shownews',showonline='$showonline',showbabble='$showbabble' WHERE id='1' LIMIT 1", "control");
            admindisplay("Réglages mis à jour.","Main Settings");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Menu des réglages");
        }
    }
    
    global $controlrow;
    
$page = <<<END
<b><u>Menu des réglages</u></b><br />
Ces options commandent plusieurs paramètres principaux du jeu.<br /><br />
<form action="admin.php?do=main" method="post">
<table width="90%">
<tr><td width="20%"><span class="highlight">Statut du jeu:</span></td><td><select name="gameopen"><option value="1" {{open1select}}>Ouvert</option><option value="0" {{open0select}}>Fermé</option></select><br /><span class="small">Fermez le jeu si vous êtes faites de la maintance dessus.</span></td></tr>
<tr><td width="20%">Nom du jeu:</td><td><input type="text" name="gamename" size="30" maxlength="50" value="{{gamename}}" /><br /><span class="small">Le nom du jeu par default est "RPG illusion". Mais vous pouvez librement le modifier.</span></td></tr>
<tr><td width="20%">URL du jeu:</td><td><input type="text" name="gameurl" size="50" maxlength="100" value="{{gameurl}}" /><br /><span class="small">Veuillez indiquer l'URL complète du jeu("http://www.votre_site.com/repertoire_du_jeu/index.php").</span></td></tr>
<tr><td width="20%">Email de l'admin:</td><td><input type="text" name="adminemail" size="30" maxlength="100" value="{{adminemail}}" /><br /><span class="small">Veuillez indiquer votre adresse email.  Les utilisateurs qui auront besoin d'aide utiliseront cette adresse pour vous écrire.</span></td></tr>
<tr><td width="20%">Taille de la carte:</td><td><input type="text" name="gamesize" size="3" maxlength="3" value="{{gamesize}}" /><br /><span class="small">250 par défault. C'est la taille de la carte en longitude et en latitude. Notez aussi que les niveaux des monstres augmentent tous les 5 espaces, ainsi vous devriez vous assurer que la valeur actuelle de la carte est supérieur à 5. Sinon il y aura quasiment aucun monstre. Avec une taille de carte de 250, vous devriez avoir le total de 50 niveaux de monstre.</span></td></tr>
<tr><td width="20%">Type du forum:</td><td><select name="forumtype"><option value="0" {{selecttype0}}>Aucun</option><option value="1" {{selecttype1}}>Interne</option><option value="2" {{selecttype2}}>Externe</option></select><br /><span class="small">'Aucun' retire le forum du jeu. 'Interne' utilise le forum inclus dans RPG illusion. 'Externe' utilise un forum qui se situe à l'exterieur du jeu. Pour cela vous devrez indiquer une URL ci dessous.</span></td></tr>
<tr><td width="20%">Forum externe:</td><td><input type="text" name="forumaddress" size="30" maxlength="200" value="{{forumaddress}}" /><br /><span class="small">Si la valeur ci-dessus est placée à 'Externe,' veuillez indiquer l'URL complète du forum externe.</span></td></tr>
<tr><td width="20%">Pages compressée:</td><td><select name="compression"><option value="0" {{selectcomp0}}>Aucune</option><option value="1" {{selectcomp1}}>Activé</option></select><br /><span class="small">Si vous compressez les pages du jeu, ceci réduira considérablement la quantité de largeur de bande passante exigée par le jeu.</span></td></tr>
<tr><td width="20%">Email de vérification:</td><td><select name="verifyemail"><option value="0" {{selectverify0}}>Aucun</option><option value="1" {{selectverify1}}>Activé</option></select><br /><span class="small">Incitez les utilisateurs à vérifier leur adresse email pour plus de sécuritée.</span></td></tr>
<tr><td width="20%">Afficher la nouvelle:</td><td><select name="shownews"><option value="0" {{selectnews0}}>Non</option><option value="1" {{selectnews1}}>Oui</option></select><br /><span class="small">Afficher la dernière nouvelle dans les villes.</td></tr>
<tr><td width="20%">Afficher "Qui est en ligne?":</td><td><select name="showonline"><option value="0" {{selectonline0}}>Non</option><option value="1" {{selectonline1}}>Oui</option></select><br /><span class="small">Afficher "Qui est en ligne?" dans les villes.</span></td></tr>
<tr><td width="20%">Afficher la boite de dialogue:</td><td><select name="showbabble"><option value="0" {{selectbabble0}}>Non</option><option value="1" {{selectbabble1}}>Oui</option></select><br /><span class="small">Afficher la boite de dialogue dans les villes.</span></td></tr>
<tr><td width="20%">Nom de la classe 1:</td><td><input type="text" name="class1name" size="20" maxlength="50" value="{{class1name}}" /><br /></td></tr>
<tr><td width="20%">Nom de la classe 2:</td><td><input type="text" name="class2name" size="20" maxlength="50" value="{{class2name}}" /><br /></td></tr>
<tr><td width="20%">Nom de la classe 3:</td><td><input type="text" name="class3name" size="20" maxlength="50" value="{{class3name}}" /><br /></td></tr>
<tr><td width="20%">Nom de la difficulté 1:</td><td><input type="text" name="diff1name" size="20" maxlength="50" value="{{diff1name}}" /><br /></td></tr>
<tr><td width="20%">Nom de la difficulté 2:</td><td><input type="text" name="diff2name" size="20" maxlength="50" value="{{diff2name}}" /><br /></td></tr>
<tr><td width="20%">Valeur de la difficulté 1:</td><td><input type="text" name="diff2mod" size="3" maxlength="3" value="{{diff2mod}}" /><br /><span class="small">1.2 par défault. Indiquez une valeur pour la difficultée moyenne ici.</span></td></tr>
<tr><td width="20%">Nom de la difficulté 3:</td><td><input type="text" name="diff3name" size="20" maxlength="50" value="{{diff3name}}" /><br /></td></tr>
<tr><td width="20%">Valeur De la difficulté 3:</td><td><input type="text" name="diff3mod" size="3" maxlength="3" value="{{diff3mod}}" /><br /><span class="small">1.5 par défault. Indiquez une valeur pour la difficultée la plus haute ici.</span></td></tr>
</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;

    if ($controlrow["forumtype"] == 0) { $controlrow["selecttype0"] = "selected=\"selected\" "; } else { $controlrow["selecttype0"] = ""; }
    if ($controlrow["forumtype"] == 1) { $controlrow["selecttype1"] = "selected=\"selected\" "; } else { $controlrow["selecttype1"] = ""; }
    if ($controlrow["forumtype"] == 2) { $controlrow["selecttype2"] = "selected=\"selected\" "; } else { $controlrow["selecttype2"] = ""; }
    if ($controlrow["compression"] == 0) { $controlrow["selectcomp0"] = "selected=\"selected\" "; } else { $controlrow["selectcomp0"] = ""; }
    if ($controlrow["compression"] == 1) { $controlrow["selectcomp1"] = "selected=\"selected\" "; } else { $controlrow["selectcomp1"] = ""; }
    if ($controlrow["verifyemail"] == 0) { $controlrow["selectverify0"] = "selected=\"selected\" "; } else { $controlrow["selectverify0"] = ""; }
    if ($controlrow["verifyemail"] == 1) { $controlrow["selectverify1"] = "selected=\"selected\" "; } else { $controlrow["selectverify1"] = ""; }
    if ($controlrow["shownews"] == 0) { $controlrow["selectnews0"] = "selected=\"selected\" "; } else { $controlrow["selectnews0"] = ""; }
    if ($controlrow["shownews"] == 1) { $controlrow["selectnews1"] = "selected=\"selected\" "; } else { $controlrow["selectnews1"] = ""; }
    if ($controlrow["showonline"] == 0) { $controlrow["selectonline0"] = "selected=\"selected\" "; } else { $controlrow["selectonline0"] = ""; }
    if ($controlrow["showonline"] == 1) { $controlrow["selectonline1"] = "selected=\"selected\" "; } else { $controlrow["selectonline1"] = ""; }
    if ($controlrow["showbabble"] == 0) { $controlrow["selectbabble0"] = "selected=\"selected\" "; } else { $controlrow["selectbabble0"] = ""; }
    if ($controlrow["showbabble"] == 1) { $controlrow["selectbabble1"] = "selected=\"selected\" "; } else { $controlrow["selectbabble1"] = ""; }
    if ($controlrow["gameopen"] == 1) { $controlrow["open1select"] = "selected=\"selected\" "; } else { $controlrow["open1select"] = ""; }
    if ($controlrow["gameopen"] == 0) { $controlrow["open0select"] = "selected=\"selected\" "; } else { $controlrow["open0select"] = ""; }

    $page = parsetemplate($page, $controlrow);
    admindisplay($page, "Réglages principaux");

}


function items() {
    
    $query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "items");
    $page = "<b><u>Editer les objets</u></b><br />Cliquez sur le nom d'un objet pour le modifier.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=edititem:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=edititem:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 1; }
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas d'objets trouvés.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Editer objets");
    
}

function edititem($id) {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Le nom est exigé.<br />"; }
        if ($buycost == "") { $errors++; $errorlist .= "Le prix est exigé.<br />"; }
        if (!is_numeric($buycost)) { $errors++; $errorlist .= "Le prix doit être un nombre!.<br />"; }
        if ($attribute == "") { $errors++; $errorlist .= "L'attribut est exigé.<br />"; }
        if (!is_numeric($attribute)) { $errors++; $errorlist .= "L'attribut doit être un nombre.<br />"; }
        if ($special == "" || $special == " ") { $special = "X"; }
        
		
        $name = addslashes($name); 
		$description = addslashes($description);

        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',type='$type',buycost='$buycost',description='$description',attribute='$attribute',special='$special' WHERE id='$id' LIMIT 1", "items");
            admindisplay("Objet mis à jour.","Editer objets");
        } else {
            admindisplay("<b>Erreur:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Edit Items");
        }        
        
    }   
        
    
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Editer Items</u></b><br /><br />
<form action="admin.php?do=edititem:$id" method="post">
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<br /><br />
<tr><td width="20%">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="{{name}}" /></td></tr>
<tr><td width="20%">Image:</td><td><img src="./images/items/{{image}}.gif"/></td></tr>
<tr><td width="20%">Type:</td><td><select name="type"><option value="1" {{type1select}}>Arme</option><option value="2" {{type2select}}>Armure</option><option value="3" {{type3select}}>Protection</option></select></td></tr>
<tr><td width="20%">Prix:</td><td><input type="text" name="buycost" size="5" maxlength="10" value="{{buycost}}" /> rubis</td></tr>
<tr><td width="20%">Description:</td><td><textarea name="description" type="text" rows="5" cols="50">{{description}}</textarea></td></tr>
<tr><td width="20%">Attribut:</td><td><input type="text" name="attribute" size="5" maxlength="10" value="{{attribute}}" /><br /><span class="small">Le nombre de points que l'objet ajoute au pouvoir d'attaque (armes) ou au pouvoir de défense (armures/protections).</span></td></tr>
<tr><td width="20%">Special:</td><td><input type="text" name="special" size="30" maxlength="50" value="{{special}}" /><br /><span class="small">Laissez <span class="highlight">X</span> pour donner aucun codes spéciaux à l'objet.</span></td></tr>
</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
<b>Codes spéciaux:</b><br />
Des codes spéciaux peuvent être ajoutés à tous les objets, ce qui a pour but de leurs donner plus ou moins de valeur. Par exemple si vous voulez qu'un objet donne 50 HP à un personnage, il suffit d'écrire <span class="highlight">maxhp,50</span>. Ceci marche aussi dans le sens négatif. Donc si vous voulez qu'un objet enlève 50 HP à un personnage, il suffit d'écrire <span class="highlight">maxhp,-50</span>.<br /><br />
Voici les codes spéciaux:<br />
maxhp - Donner des points hit (HP)<br />
maxmp - Donner des points de magie (MP)<br />
maxtp - Donner un max de points de voyages<br />
goldbonus - Donner un bonnus de rubis (en pourcentage)<br />
expbonus - Donner un bonnus d'expérience (en pourcentage)<br />
strength - Donner de la force (qui s'ajoute également au pouvoir d'attaque)<br />
dexterity - Donner de la dextérité (qui s'ajoute également au pouvoir de défense)<br />
attackpower - Donner un pouvoir d'attaque<br />
defensepower - Donner un pouvoir de défense
END;
    
    if ($row["type"] == 1) { $row["type1select"] = "selected=\"selected\" "; } else { $row["type1select"] = ""; }
    if ($row["type"] == 2) { $row["type2select"] = "selected=\"selected\" "; } else { $row["type2select"] = ""; }
    if ($row["type"] == 3) { $row["type3select"] = "selected=\"selected\" "; } else { $row["type3select"] = ""; }
    
    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer objets");
    
}



function drops() {
    
    $query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "drops");
    $page = "<b><u>Editer les objets perdus</u></b><br />Cliquez ici pour éditer un objet perdu.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=editdrop:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=editdrop:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 1; }
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas d'objets trouvés.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Editer objets perdus");
    
}

function editdrop($id) {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Le nom est exigé.<br />"; }
        if ($mlevel == "") { $errors++; $errorlist .= "Le niveau du monstre est exigé.<br />"; }
        if (!is_numeric($mlevel)) { $errors++; $errorlist .= "Le niveau du monstre doit être en chiffre.<br />"; }
        if ($attribute1 == "" || $attribute1 == " " || $attribute1 == "X") { $errors++; $errorlist .= "Le premier attribut est exigé.<br />"; }
        if ($attribute2 == "" || $attribute2 == " ") { $attribute2 = "X"; }
        
		$name = addslashes($name); 
		
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',mlevel='$mlevel',attribute1='$attribute1',attribute2='$attribute2' WHERE id='$id' LIMIT 1", "drops");
            admindisplay("Objet midifié.","Editer objets perdus");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les objets perdus");
        }        
        
    }   
        
    
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "drops");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Editer les objets perdus</u></b><br /><br />
<form action="admin.php?do=editdrop:$id" method="post">
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<tr><td width="20%">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="{{name}}" /></td></tr>
<tr><td width="20%">Niveau du monstre:</td><td><input type="text" name="mlevel" size="5" maxlength="10" value="{{mlevel}}" /><br /><span class="small">Niveau de probabilité pour qu'un monstre laisse tomber cet objet.</span></td></tr>
<tr><td width="20%">Attribut 1:</td><td><input type="text" name="attribute1" size="30" maxlength="50" value="{{attribute1}}" /><br /><span class="small">Doit être un code spécial.  Le premier attribut ne peut pas être vide.Éditez ce champ très soigneusement, parce que les erreurs d'orthographe peuvent créer des problèmes dans le jeu.</span></td></tr>
<tr><td width="20%">Attribut 2:</td><td><input type="text" name="attribute2" size="30" maxlength="50" value="{{attribute2}}" /><br /><span class="small">Laissez  <span class="highlight">X</span> pour ne mettre aucun code spécial. Sinon éditez ce champ très soigneusement, parce que les erreurs d'orthographe peuvent créer des problèmes dans le jeu.</span></td></tr>
</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
<b>Codes spéciaux:</b><br />
Des codes spéciaux peuvent être ajoutés à tous les objets, ce qui a pour but de leurs donner plus ou moins de valeur. Par exemple si vous voulez qu'un objet donne 50 HP à un personnage, il suffit d'écrire <span class="highlight">maxhp,50</span>. Ceci marche aussi dans le sens négatif. Donc si vous voulez qu'un objet enlève 50 HP à un personnage, il suffit d'écrire <span class="highlight">maxhp,50</span>.<br /><br />
Voici les codes spéciaux:<br />
maxhp - Donner des points hit (HP)<br />
maxmp - Donner des points de magie (MP)<br />
maxtp - Donner un max de points de voyages<br />
goldbonus - Donner un bonnus de rubis (en pourcentage)<br />
expbonus - Donner un bonnus d'expérience (en pourcentage)<br />
strength - Donner de la force (qui s'ajoute également au pouvoir d'attaque)<br />
dexterity - Donner de la dextérité (qui s'ajoute également au pouvoir de défense)<br />
attackpower - Donner un pouvoir d'attaque<br />
defensepower - Donner un pouvoir de défense
END;
    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer objets perdus");
    
}

function towns() {
    
    $query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "towns");
    $page = "<b><u>Editer les villes</u></b><br />Cliquez sur un nom de ville pour l'éditer.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=edittown:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=edittown:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 1; }
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas de villes trouvées.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Editer villes");
    
}

function edittown($id) {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Le nom est exigé.<br />"; }
		if ($homeprice == "") { $errors++; $errorlist .= "Le prix des maisons est exigé.<br />"; }
        if ($latitude == "") { $errors++; $errorlist .= "La latitude est exigée.<br />"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "La latitude doit être un nombre.<br />"; }
        if ($longitude == "") { $errors++; $errorlist .= "La longitude est exigée.<br />"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "La longitude doit être un nombre.<br />"; }
        if ($innprice == "") { $errors++; $errorlist .= "Le prix de l'auberge est exigé.<br />"; }
        if (!is_numeric($innprice)) { $errors++; $errorlist .= "Le prix de l'auberge doir être un nombre.<br />"; }
        if ($mapprice == "") { $errors++; $errorlist .= "Le prix de la carte est exigé.<br />"; }
        if (!is_numeric($mapprice)) { $errors++; $errorlist .= "Le prix de la carte doit être un nombre.<br />"; }

        if ($travelpoints == "") { $errors++; $errorlist .= "Les points de voyages sont exigés.<br />"; }
        if (!is_numeric($travelpoints)) { $errors++; $errorlist .= "Les points de voyages doivent êtres des nombres.<br />"; }
        if ($itemslist == "") { $errors++; $errorlist .= "La liste des objets est exigée.<br />"; }
        
		$name = addslashes($name); 
        $allopass = addslashes($allopass);  
		$alloprice = addslashes($alloprice);  
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',homeprice='$homeprice',chiffreniveau='$chiffreniveau' , chiffrebanque='$chiffrebanque'  ,codebanque='$codebanque', codeniveau='$codeniveau', latitude='$latitude',longitude='$longitude',innprice='$innprice',mapprice='$mapprice',travelpoints='$travelpoints',itemslist='$itemslist' WHERE id='$id' LIMIT 1", "towns");
            admindisplay("Ville mise à jour.","Editer villes");
        } else {
            admindisplay("<b>Errors:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les villes");
        }        
        
    }   
        
    
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "towns");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Editer villes</u></b><br /><br />
<form action="admin.php?do=edittown:$id" method="post">
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<tr><td width="20%">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="{{name}}" /></td></tr>
<tr><td width="20%">Latitude:</td><td><input type="text" name="latitude" size="5" maxlength="10" value="{{latitude}}" /><br /><span class="small">Positive or negative integer.</span></td></tr>
<tr><td width="20%">Longitude:</td><td><input type="text" name="longitude" size="5" maxlength="10" value="{{longitude}}" /><br /><span class="small">Positive or negative integer.</span></td></tr>
<tr><td width="20%">Prix de l'auberge:</td><td><input type="text" name="innprice" size="5" maxlength="10" value="{{innprice}}" /> gold</td></tr>
<tr><td width="20%">Prix des maisons:</td><td><input type="text" name="homeprice" size="5" maxlength="10" value="{{homeprice}}" /> gold</td></tr>
<tr><td width="20%">Montant allopass:</td><td><input type="text" name="chiffrebanque" size="5" maxlength="10" value="{{chiffrebanque}}" /> gold</td></tr>
<tr><td width="20%">Niv allopass:</td><td><input type="text" name="chiffreniveau" size="5" maxlength="10" value="{{chiffreniveau}}" /> gold</td></tr>
<tr><td width="20%">Code allopass banque:</td><td><textarea name="codebanque" rows="7" cols="30">{{codebanque}}</textarea><br><b>URL de la page d'accès:</b> " http://www.votresite.com/demonstration/index.php "<br><b>URL du document:</b> "http://www.votresite.com/index.php?do=cheatbanque "<br></td></tr>
<tr><td width="20%">Code allopass niv:</td><td><textarea name="codeniveau" rows="7" cols="30">{{codeniveau}}</textarea><br><b>URL de la page d'accès:</b> " http://www.votresite.com/demonstration/index.php "<br><b>URL du document:</b> "http://www.votresite.com/index.php?do=cheatniveau "<br></td></tr>
<tr><td width="20%">Prix de la carte:</td><td><input type="text" name="mapprice" size="5" maxlength="10" value="{{mapprice}}" /> gold<br /><span class="small">Prix de la carte de cette ville.</span></td></tr>
<tr><td width="20%">Points de voyage:</td><td><input type="text" name="travelpoints" size="5" maxlength="10" value="{{travelpoints}}" /><br /><span class="small">Nombre de Points de voyage (TP) consommés pour aller à cette ville.</span></td></tr>
<tr><td width="20%">Liste des objets:</td><td><input type="text" name="itemslist" size="30" maxlength="200" value="{{itemslist}}" /><br /><span class="small">Liste des objets disponible dans le magasin de cette ville. (Example: <span class="highlight">1,2,3,6,9,10,13,20</span>)</span> Note: L'objet numéro 1 correspond à l'ID numéro 1 (pour voir l'ID des objets rendez vous dans la rubrique <span class="highlight">Editer objets</span>).</td></tr>
</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;
    
    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer villes");
    
}


function monsters() {
    
    global $controlrow;
    
    $statquery = doquery("SELECT * FROM {{table}} ORDER BY level DESC LIMIT 1", "monsters");
    $statrow = mysql_fetch_array($statquery);
    
    $query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "monsters");
    $page = "<b><u>Editer les monstres</u></b><br />";
    
    if (($controlrow["gamesize"]/5) != $statrow["level"]) {
        $page .= "<span class=\"highlight\">Note:</span> Le niveau élevé des monstre ne s'assortit pas avec le taille de la carte.  Le niveau le plus élevé de monstre devrait être ".($controlrow["gamesize"]/5).", le votre est ".$statrow["level"].". Veuillez modifier la valeur avant d'ouvrir le jeu au public.<br /><br />";
    } else { $page .= "Le niveau du monstre correspont parfaitement avec la taille de la carte, aucunes modifications n'est exigé.<br /><br />"; }
    
    $page .= "Cliquez sur le nom d'un monstre pour l'éditer.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=editmonster:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=editmonster:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 1; }
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas villes trouvés.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Editer monstres");
    
}

function editmonster($id) {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Le nom est exigé.<br />"; }
        if ($maxhp == "") { $errors++; $errorlist .= "Le max de HP est exigé.<br />"; }
        if (!is_numeric($maxhp)) { $errors++; $errorlist .= "Le max de HP doit être un nombre.<br />"; }
        if ($maxdam == "") { $errors++; $errorlist .= "Le max de dommage est exigé.<br />"; }
        if (!is_numeric($maxdam)) { $errors++; $errorlist .= "Le max de dommage doit être un nombre.<br />"; }
        if ($armor == "") { $errors++; $errorlist .= "Le niveau de l'armure est exigé.<br />"; }
        if (!is_numeric($armor)) { $errors++; $errorlist .= "Le niveau de l'armure doir être un nombre.<br />"; }
        if ($level == "") { $errors++; $errorlist .= "Le niveau du monstre est exigé.<br />"; }
        if (!is_numeric($level)) { $errors++; $errorlist .= "Le niveau du monstre doit être un nombre.<br />"; }
        if ($maxexp == "") { $errors++; $errorlist .= "Le max d'expérience est exigé.<br />"; }
        if (!is_numeric($maxexp)) { $errors++; $errorlist .= "Le max d'expérience doit être un nombre.<br />"; }
        if ($maxgold == "") { $errors++; $errorlist .= "Le max de rubis est exigé.<br />"; }
        if (!is_numeric($maxgold)) { $errors++; $errorlist .= "Le max de rubis doit être un nombre.<br />"; }
        
		$name = addslashes($name); 
		
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',maxhp='$maxhp',maxdam='$maxdam',armor='$armor',level='$level',maxexp='$maxexp',maxgold='$maxgold',immune='$immune' WHERE id='$id' LIMIT 1", "monsters");
            admindisplay("Monstre mis à jour.","Editer monstres");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les monstres");
        }        
        
    }   
        
    
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "monsters");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Editer les monstres</u></b><br /><br />
<form action="admin.php?do=editmonster:$id" method="post">
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<tr><td width="20%">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="{{name}}" /></td></tr>
<tr><td width="20%">Portait:</td><td><img src="./images/monstre/{{image}}.jpg"  width="71" height="59"></td></tr>
<tr><td width="20%">Max de HP:</td><td><input type="text" name="maxhp" size="5" maxlength="10" value="{{maxhp}}" /></td></tr>
<tr><td width="20%">Max de dommages:</td><td><input type="text" name="maxdam" size="5" maxlength="10" value="{{maxdam}}" /><br /><span class="small">Comparez au pouvoir d'attaque du joueur.</span></td></tr>
<tr><td width="20%">Armures:</td><td><input type="text" name="armor" size="5" maxlength="10" value="{{armor}}" /><br /><span class="small">Comparez au pouvoir de défense du joueur.</span></td></tr>
<tr><td width="20%">Niveau du monstre:</td><td><input type="text" name="level" size="5" maxlength="10" value="{{level}}" /><br /><span class="small">Determines spawn location and item drops.</span></td></tr>
<tr><td width="20%">Max d'experience:</td><td><input type="text" name="maxexp" size="5" maxlength="10" value="{{maxexp}}" /><br /><span class="small">Le maximum d'expérience qui sera donné au joueur, après avoir battu le monstre.</span></td></tr>
<tr><td width="20%">Max de rubis:</td><td><input type="text" name="maxgold" size="5" maxlength="10" value="{{maxgold}}" /><br /><span class="small">Le maximum de rubis qui sera donné au joueur, après avoir battu le monstre.</span></td></tr>
<tr><td width="20%">Immunisé contre le sort:</td><td><select name="immune"><option value="0" {{immune0select}}>Aucune</option><option value="1" {{immune1select}}>Attaque</option><option value="2" {{immune2select}}>Attaque & Sommeil</option></select><br /><span class="small">Quelques monstres peuvent ne pas être blessés par certains sorts.</span></td></tr>
</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;
    
    if ($row["immune"] == 1) { $row["immune1select"] = "selected=\"selected\" "; } else { $row["immune1select"] = ""; }
    if ($row["immune"] == 2) { $row["immune2select"] = "selected=\"selected\" "; } else { $row["immune2select"] = ""; }
    if ($row["immune"] == 3) { $row["immune3select"] = "selected=\"selected\" "; } else { $row["immune3select"] = ""; }
    
    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer monstres");
    
}

function spells() {
    
    $query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "spells");
    $page = "<b><u>Editer les sorts</u></b><br />Cliquez sur le nom d'un sort pour l'éditer.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=editspell:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=editspell:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 1; }
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas de sorts trouvés.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Editer sorts");
    
}

function editspell($id) {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Le nom est exigé.<br />"; }
        if ($mp == "") { $errors++; $errorlist .= "Les MP sont exigés.<br />"; }
        if (!is_numeric($mp)) { $errors++; $errorlist .= "Les MP doivent êtres des nombres.<br />"; }
        if ($attribute == "") { $errors++; $errorlist .= "L'attribut est exigé.<br />"; }
        if (!is_numeric($attribute)) { $errors++; $errorlist .= "L'attribut doit être un nombre.<br />"; }
        
		$name = addslashes($name); 
		
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',mp='$mp',attribute='$attribute',type='$type' WHERE id='$id' LIMIT 1", "spells");
            admindisplay("Sort mis à jour.","Editer sorts");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les sorts");
        }        
        
    }   
        
    
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "spells");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Editer les sorts</u></b><br /><br />
<form action="admin.php?do=editspell:$id" method="post">
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<tr><td width="20%">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="{{name}}" /></td></tr>
<tr><td width="20%">Points de magie:</td><td><input type="text" name="mp" size="5" maxlength="10" value="{{mp}}" /><br /><span class="small">MP requis pour éxécuter ce sort.</span></td></tr>
<tr><td width="20%">Attribut:</td><td><input type="text" name="attribute" size="5" maxlength="10" value="{{attribute}}" /><br /><span class="small">Valeur numérique du type de sorts que vous avez choisi ci-dessous.</span></td></tr>
<tr><td width="20%">Type:</td><td><select name="type"><option value="1" {{type1select}}>Soin</option><option value="2" {{type2select}}>Attaque</option><option value="3" {{type3select}}>Sommeil</option><option value="4" {{type4select}}>Attaque d'Uber</option><option value="5" {{type5select}}>Défense d'Uber</option></select><br /><span class="small">- "Soin" redonne des HP au joueur.<br />- "Attaque" cause des dommages au monstre.<br />- "Sommeil" endort le monstre. Note: Si vous mettez l'attribut du sommeil sur 2, le monstre aura très peu de chance de s'endormir, par contre si vous le mettez sur 15, le monstre s'endormira certainement (l'attribut du sommeil varie de 1 à 15).<br>- L'attaque d'Uber augmente les dommages d'attaque totale par 50% par exemple si vous mettez dans les attributs 50.<br>- La défense d'Uber augmente la défense totale sur une attaque par 50% par exemple si vous mettez dans les attributs 50. 
</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;

    if ($row["type"] == 1) { $row["type1select"] = "selected=\"selected\" "; } else { $row["type1select"] = ""; }
    if ($row["type"] == 2) { $row["type2select"] = "selected=\"selected\" "; } else { $row["type2select"] = ""; }
    if ($row["type"] == 3) { $row["type3select"] = "selected=\"selected\" "; } else { $row["type3select"] = ""; }
    if ($row["type"] == 4) { $row["type4select"] = "selected=\"selected\" "; } else { $row["type4select"] = ""; }
    if ($row["type"] == 5) { $row["type5select"] = "selected=\"selected\" "; } else { $row["type5select"] = ""; }
    
    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer sorts");
    
}

function levels() {

    $query = doquery("SELECT id FROM {{table}} ORDER BY id DESC LIMIT 1", "levels");
    $row = mysql_fetch_array($query);
    
    $options = "";
    for($i=2; $i<$row["id"]; $i++) {
        $options .= "<option value=\"$i\">$i</option>\n";
    }
    
$page = <<<END
<b><u>Editer les niveaux du jeu</u></b><br />Modifier le niveau du jeu à partir du menu déroulant ci-dessous.<br /><br />
<form action="admin.php?do=editlevel" method="post">
<select name="level">
$options
</select> 
<input type="submit" name="go" value="Valider" />
</form>
END;

    admindisplay($page, "Editer niveaux");
    
}

function editlevel() {

    if (!isset($_POST["level"])) { admindisplay("Pas de niveaux à éditer.", "Editer les niveaux du jeu"); die(); }
    $id = $_POST["level"];
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($_POST["1_exp"] == "") { $errors++; $errorlist .= "L'expérience de la classe 1 est exigée.<br />"; }
        if ($_POST["1_hp"] == "") { $errors++; $errorlist .= "Le HP de la classe 1 est exigé.<br />"; }
        if ($_POST["1_mp"] == "") { $errors++; $errorlist .= "Le MP de la classe 1 est exigé.<br />"; }
        if ($_POST["1_tp"] == "") { $errors++; $errorlist .= "Le TP de la classe 1 est exigé.<br />"; }
        if ($_POST["1_strength"] == "") { $errors++; $errorlist .= "La force de la classe 1 est exigée.<br />"; }
        if ($_POST["1_dexterity"] == "") { $errors++; $errorlist .= "La dextérité de la classe 1 est exigée.<br />"; }
        if ($_POST["1_spells"] == "") { $errors++; $errorlist .= "Le sort de la classe 1 est exigée.<br />"; }
        if (!is_numeric($_POST["1_exp"])) { $errors++; $errorlist .= "L'expérience de la classe 1 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["1_hp"])) { $errors++; $errorlist .= "Le HP de la classe 1 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["1_mp"])) { $errors++; $errorlist .= "Le MP de la classe 1 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["1_tp"])) { $errors++; $errorlist .= "Le TP de la classe 1 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["1_strength"])) { $errors++; $errorlist .= "La force de la classe 1 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["1_dexterity"])) { $errors++; $errorlist .= "La dextérité de la classe 1 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["1_spells"])) { $errors++; $errorlist .= "Le sort de la classe 1 doit être un nombre.<br />"; }

        if ($_POST["2_exp"] == "") { $errors++; $errorlist .= "L'expérience de la classe 2 est exigée.<br />"; }
        if ($_POST["2_hp"] == "") { $errors++; $errorlist .= "Le HP de la classe 2 est exigé.<br />"; }
        if ($_POST["2_mp"] == "") { $errors++; $errorlist .= "Le MP de la classe 2 est exigé.<br />"; }
        if ($_POST["2_tp"] == "") { $errors++; $errorlist .= "Le TP de la classe 2 est exigé.<br />"; }
        if ($_POST["2_strength"] == "") { $errors++; $errorlist .= "La force de la classe 2 est exigée.<br />"; }
        if ($_POST["2_dexterity"] == "") { $errors++; $errorlist .= "La dextérité de la classe 2 est exigée.<br />"; }
        if ($_POST["2_spells"] == "") { $errors++; $errorlist .= "Le sort de la classe 2 est exigé.<br />"; }
        if (!is_numeric($_POST["2_exp"])) { $errors++; $errorlist .= "L'expérience de la classe 2 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["2_hp"])) { $errors++; $errorlist .= "Le HP de la classe 2 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["2_mp"])) { $errors++; $errorlist .= "Le MP de la classe 2 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["2_tp"])) { $errors++; $errorlist .= "Le TP de la classe 2 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["2_strength"])) { $errors++; $errorlist .= "La force de la classe 2 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["2_dexterity"])) { $errors++; $errorlist .= "La dextérité de la classe 2 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["2_spells"])) { $errors++; $errorlist .= "Le sort de la classe 2 doit être un nombre.<br />"; }
                
        if ($_POST["3_exp"] == "") { $errors++; $errorlist .= "L'expérience de la classe 3 est exigée.<br />"; }
        if ($_POST["3_hp"] == "") { $errors++; $errorlist .= "Le HP de la classe 3 est exigé.<br />"; }
        if ($_POST["3_mp"] == "") { $errors++; $errorlist .= "Le MP de la classe 3 est exigé.<br />"; }
        if ($_POST["3_tp"] == "") { $errors++; $errorlist .= "Le TP de la classe 3 est exigé.<br />"; }
        if ($_POST["3_strength"] == "") { $errors++; $errorlist .= "La force de la classe 3 est exigée.<br />"; }
        if ($_POST["3_dexterity"] == "") { $errors++; $errorlist .= "La dextérité de la classe 3 est exigée.<br />"; }
        if ($_POST["3_spells"] == "") { $errors++; $errorlist .= "Le sort de la classe 3 est exigé.<br />"; }
        if (!is_numeric($_POST["3_exp"])) { $errors++; $errorlist .= "L'expérience de la classe 3 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["3_hp"])) { $errors++; $errorlist .= "Le HP de la classe 3 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["3_mp"])) { $errors++; $errorlist .= "Le MP de la classe 3 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["3_tp"])) { $errors++; $errorlist .= "Le TP de la classe 3 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["3_strength"])) { $errors++; $errorlist .= "La force de la classe 3 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["3_dexterity"])) { $errors++; $errorlist .= "La dextérité de la classe 3 doit être un nombre.<br />"; }
        if (!is_numeric($_POST["3_spells"])) { $errors++; $errorlist .= "Le sort de la classe 3 doit être un nombre.<br />"; }

        if ($errors == 0) { 
$updatequery = <<<END
UPDATE {{table}} SET
1_exp='$1_exp', 1_hp='$1_hp', 1_mp='$1_mp', 1_tp='$1_tp', 1_strength='$1_strength', 1_dexterity='$1_dexterity', 1_spells='$1_spells',
2_exp='$2_exp', 2_hp='$2_hp', 2_mp='$2_mp', 2_tp='$2_tp', 2_strength='$2_strength', 2_dexterity='$2_dexterity', 2_spells='$2_spells',
3_exp='$3_exp', 3_hp='$3_hp', 3_mp='$3_mp', 3_tp='$3_tp', 3_strength='$3_strength', 3_dexterity='$3_dexterity', 3_spells='$3_spells'
WHERE id='$id' LIMIT 1
END;
			$query = doquery($updatequery, "levels");
            admindisplay("Niveau mis à jour.","Editer niveaux");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les sorts");
        }        
        
    }   
        
    
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "levels");
    $row = mysql_fetch_array($query);
    global $controlrow;
    $class1name = $controlrow["class1name"];
    $class2name = $controlrow["class2name"];
    $class3name = $controlrow["class3name"];

$page = <<<END
<b><u>Editer les niveaux</u></b><br /><br />
Nous vous déconseillons fortement de modifier les valeurs du 5ème paliers (niveau, expérience, force...), car le jeu a fait un calcul précis pour arriver à ces résulats. Si vous changez ces valeurs des erreurs peuvent se produirent.<br /><br />
<form action="admin.php?do=editlevel" method="post">
<input type="hidden" name="level" value="$id" />
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">Experience du $class1name:</td><td><input type="text" name="1_exp" size="10" maxlength="8" value="{{1_exp}}" /></td></tr>
<tr><td width="20%">HP du $class1name:</td><td><input type="text" name="1_hp" size="5" maxlength="5" value="{{1_hp}}" /></td></tr>
<tr><td width="20%">MP du $class1name:</td><td><input type="text" name="1_mp" size="5" maxlength="5" value="{{1_mp}}" /></td></tr>
<tr><td width="20%">TP du $class1name:</td><td><input type="text" name="1_tp" size="5" maxlength="5" value="{{1_tp}}" /></td></tr>
<tr><td width="20%">Force du $class1name:</td><td><input type="text" name="1_strength" size="5" maxlength="5" value="{{1_strength}}" /></td></tr>
<tr><td width="20%">Dextérité du $class1name:</td><td><input type="text" name="1_dexterity" size="5" maxlength="5" value="{{1_dexterity}}" /></td></tr>
<tr><td width="20%">Sorts du $class1name:</td><td><input type="text" name="1_spells" size="5" maxlength="3" value="{{1_spells}}" /></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">Expérience du $class2name:</td><td><input type="text" name="2_exp" size="10" maxlength="8" value="{{2_exp}}" /></td></tr>
<tr><td width="20%">HP du $class2name:</td><td><input type="text" name="2_hp" size="5" maxlength="5" value="{{2_hp}}" /></td></tr>
<tr><td width="20%">MP du $class2name:</td><td><input type="text" name="2_mp" size="5" maxlength="5" value="{{2_mp}}" /></td></tr>
<tr><td width="20%">TP du $class2name:</td><td><input type="text" name="2_tp" size="5" maxlength="5" value="{{2_tp}}" /></td></tr>
<tr><td width="20%">Force du $class2name:</td><td><input type="text" name="2_strength" size="5" maxlength="5" value="{{2_strength}}" /></td></tr>
<tr><td width="20%">Dextérité du $class2name:</td><td><input type="text" name="2_dexterity" size="5" maxlength="5" value="{{2_dexterity}}" /></td></tr>
<tr><td width="20%">Sorts du $class2name:</td><td><input type="text" name="2_spells" size="5" maxlength="3" value="{{2_spells}}" /></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">Experience du $class3name:</td><td><input type="text" name="3_exp" size="10" maxlength="8" value="{{3_exp}}" /></td></tr>
<tr><td width="20%">HP du $class3name:</td><td><input type="text" name="3_hp" size="5" maxlength="5" value="{{3_hp}}" /></td></tr>
<tr><td width="20%">MP du $class3name:</td><td><input type="text" name="3_mp" size="5" maxlength="5" value="{{3_mp}}" /></td></tr>
<tr><td width="20%">TP du $class3name:</td><td><input type="text" name="3_tp" size="5" maxlength="5" value="{{3_tp}}" /></td></tr>
<tr><td width="20%">Force du $class3name:</td><td><input type="text" name="3_strength" size="5" maxlength="5" value="{{3_strength}}" /></td></tr>
<tr><td width="20%">Dextérité du $class3name:</td><td><input type="text" name="3_dexterity" size="5" maxlength="5" value="{{3_dexterity}}" /></td></tr>
<tr><td width="20%">Sorts du $class3name:</td><td><input type="text" name="3_spells" size="5" maxlength="3" value="{{3_spells}}" /></td></tr>
</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;
    
    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer niveaux");
    
}

function users() {
    
    $query = doquery("SELECT id,username FROM {{table}} ORDER BY id", "users");
    $page = "<b><u>Editer les utilisateurs</u></b><br />Cliquez sur le nom d'un utilisateur pour éditer son compte.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=edituser:".$row["id"]."\">".$row["username"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=edituser:".$row["id"]."\">".$row["username"]."</a></td></tr>\n"; $count = 1; }
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas de sorts trouvés.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Editer utilisateurs");

}

function edituser($id) {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";

        if ($email == "") { $errors++; $errorlist .= "L'Email est exigé.<br />"; }
        if ($verify == "") { $errors++; $errorlist .= "La vérification de l'email est exigée.<br />"; }
        if ($charname == "") { $errors++; $errorlist .= "Le nom du personnage est exigé.<br />"; }
        if ($authlevel == "") { $errors++; $errorlist .= "Le niveau d'accès est exigé.<br />"; }
        if ($latitude == "") { $errors++; $errorlist .= "La latitude est exigée.<br />"; }
        if ($longitude == "") { $errors++; $errorlist .= "La longitude est exigée.<br />"; }
        if ($difficulty == "") { $errors++; $errorlist .= "La difficulté est exigée.<br />"; }
        if ($charclass == "") { $errors++; $errorlist .= "La classe du personnagee est exigée.<br />"; }
        if ($currentaction == "") { $errors++; $errorlist .= "L'action actuel est exigée.<br />"; }
        if ($currentfight == "") { $errors++; $errorlist .= "Le combat en cours est exigé.<br />"; }
        
        if ($currentmonster == "") { $errors++; $errorlist .= "L'ID du monstre actuel est exigé.<br />"; }
        if ($currentmonsterhp == "") { $errors++; $errorlist .= "Le HP du monstre actuel est exigé.<br />"; }
        if ($currentmonstersleep == "") { $errors++; $errorlist .= "L'ID des sorts du monstre actuel est exigés.<br />"; }
        if ($currentmonsterimmune == "") { $errors++; $errorlist .= "L'immunité du monstre actuel est exigée.<br />"; }
        if ($currentuberdamage == "") { $errors++; $errorlist .= "Le dommage actuel d'Uber est exigé.<br />"; }
        if ($currentuberdefense == "") { $errors++; $errorlist .= "La défense actuel d'Uber est exigé.<br />"; }
        if ($currenthp == "") { $errors++; $errorlist .= "Le HP actuel est exigé.<br />"; }
        if ($currentmp == "") { $errors++; $errorlist .= "Le MP actuel est exigé.<br />"; }
        if ($currenttp == "") { $errors++; $errorlist .= "Le TP actuel est exigé.<br />"; }
        if ($maxhp == "") { $errors++; $errorlist .= "Le HP max est exigé.<br />"; }

        if ($maxmp == "") { $errors++; $errorlist .= "Le MP max est exigé.<br />"; }
        if ($maxtp == "") { $errors++; $errorlist .= "Le TP max est exigé.<br />"; }
        if ($level == "") { $errors++; $errorlist .= "Le niveau est exigé.<br />"; }
        if ($gold == "") { $errors++; $errorlist .= "Les rubis sont exigés.<br />"; }
        if ($experience == "") { $errors++; $errorlist .= "L'experience est exigée.<br />"; }
        if ($goldbonus == "") { $errors++; $errorlist .= "Les rubis bonnus sont exigés.<br />"; }
        if ($expbonus == "") { $errors++; $errorlist .= "L'experience Bonus est exigé.<br />"; }
        if ($strength == "") { $errors++; $errorlist .= "La force est exigée.<br />"; }
        if ($dexterity == "") { $errors++; $errorlist .= "La dextérité est exigée.<br />"; }
        if ($attackpower == "") { $errors++; $errorlist .= "Le pouvoir d'attaque est exigé.<br />"; }

        if ($defensepower == "") { $errors++; $errorlist .= "Le pouvoir de défense est exigé.<br />"; }
        if ($weaponid == "") { $errors++; $errorlist .= "L'ID de l'arme est exigé.<br />"; }
        if ($armorid == "") { $errors++; $errorlist .= "L'ID de l'armure est exigé.<br />"; }
        if ($shieldid == "") { $errors++; $errorlist .= "L'ID de la protection est exigé.<br />"; }
        if ($slot1id == "") { $errors++; $errorlist .= "L'ID de la fente 1 est exigé.<br />"; }
        if ($slot2id == "") { $errors++; $errorlist .= "L'ID de la fente 2 est exigé.<br />"; }
        if ($slot3id == "") { $errors++; $errorlist .= "L'ID de la fente 3 est exigé.<br />"; }
        if ($weaponname == "") { $errors++; $errorlist .= "Le nom de l'arme est exigé.<br />"; }
        if ($armorname == "") { $errors++; $errorlist .= "Le nom de l'armure est exigé.<br />"; }
        if ($shieldname == "") { $errors++; $errorlist .= "Le nom de la protection est exigé.<br />"; }

        if ($slot1name == "") { $errors++; $errorlist .= "Le nom de la fente 1 est exigé.<br />"; }
        if ($slot2name == "") { $errors++; $errorlist .= "Le nom de la fente 2 est exigé.<br />"; }
        if ($slot3name == "") { $errors++; $errorlist .= "Le nom de la fente 2 est exigé.<br />"; }
        if ($dropcode == "") { $errors++; $errorlist .= "Le code drop est exigé.<br />"; }
        if ($spells == "") { $errors++; $errorlist .= "L'ID des sorts sont exigés.<br />"; }
        if ($towns == "") { $errors++; $errorlist .= "Les villes sont exigées.<br />"; }
        
        if (!is_numeric($authlevel)) { $errors++; $errorlist .= "Le niveau d'accès doit être un nombre.<br />"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "La latitude doit être un nombre.<br />"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "La longitude doit être un nombre.<br />"; }
        if (!is_numeric($difficulty)) { $errors++; $errorlist .= "La difficultée doit être un nombre.<br />"; }
        if (!is_numeric($charclass)) { $errors++; $errorlist .= "La classe du personnage doit être un nombre.<br />"; }
        if (!is_numeric($currentfight)) { $errors++; $errorlist .= "Le combat en cours doit être un nombre.<br />"; }
        if (!is_numeric($currentmonster)) { $errors++; $errorlist .= "L'ID monstre actuel doit être un nombre.<br />"; }
        if (!is_numeric($currentmonsterhp)) { $errors++; $errorlist .= "Le HP du monstre actuel doit être un nombre.<br />"; }
        if (!is_numeric($currentmonstersleep)) { $errors++; $errorlist .= "L'ID des sorts du monstre actuel doit être un nombre.<br />"; }
        
        if (!is_numeric($currentmonsterimmune)) { $errors++; $errorlist .= "L'immunité du monstre actuel doit être nombre.<br />"; }
        if (!is_numeric($currentuberdamage)) { $errors++; $errorlist .= "Le dommage actuel d'Uber doit être un nombre.<br />"; }
        if (!is_numeric($currentuberdefense)) { $errors++; $errorlist .= "La défense actuel d'Uber doit être un nombre.<br />"; }
        if (!is_numeric($currenthp)) { $errors++; $errorlist .= "Le HP actuel doit être un nombre.<br />"; }
        if (!is_numeric($currentmp)) { $errors++; $errorlist .= "Le MP actuel doit être un nombre.<br />"; }
        if (!is_numeric($currenttp)) { $errors++; $errorlist .= "Le TP actuel doit être un nombre.<br />"; }
        if (!is_numeric($maxhp)) { $errors++; $errorlist .= "Le HP Max doit àtre un nombre.<br />"; }
        if (!is_numeric($maxmp)) { $errors++; $errorlist .= "Le MP Max doit àtre un nombre.<br />"; }
        if (!is_numeric($maxtp)) { $errors++; $errorlist .= "Le TP Max doit àtre un nombre.<br />"; }
        if (!is_numeric($level)) { $errors++; $errorlist .= "Le niveau doit être un nombre.<br />"; }
        
        if (!is_numeric($gold)) { $errors++; $errorlist .= "Les rubis doivent êtres des nombres.<br />"; }
        if (!is_numeric($experience)) { $errors++; $errorlist .= "L'expérience doit être un nombre.<br />"; }
        if (!is_numeric($goldbonus)) { $errors++; $errorlist .= "Les rubis bonnus doivent êtres des nombres.<br />"; }
        if (!is_numeric($expbonus)) { $errors++; $errorlist .= "L'expérience bonnus doit être un nombre.<br />"; }
        if (!is_numeric($strength)) { $errors++; $errorlist .= "La force doit être un nombre.<br />"; }
        if (!is_numeric($dexterity)) { $errors++; $errorlist .= "La dextérité doit être un nombre.<br />"; }
        if (!is_numeric($attackpower)) { $errors++; $errorlist .= "Le pouvoir d'attaque doit être un nombre.<br />"; }
        if (!is_numeric($defensepower)) { $errors++; $errorlist .= "Le pouvoir de défense doit être un nombre.<br />"; }
        if (!is_numeric($weaponid)) { $errors++; $errorlist .= "L'ID de la l'arme doit être un nombre.<br />"; }
        if (!is_numeric($armorid)) { $errors++; $errorlist .= "L'ID de l'armure doit être un nombre.<br />"; }
        
        if (!is_numeric($shieldid)) { $errors++; $errorlist .= "L'ID de la protection doit tre un nombre.<br />"; }
        if (!is_numeric($slot1id)) { $errors++; $errorlist .= "L'ID de la fente 1 doit être un nombre.<br />"; }
        if (!is_numeric($slot2id)) { $errors++; $errorlist .= "L'ID de la fente 2 doit être un nombre.<br />"; }
        if (!is_numeric($slot3id)) { $errors++; $errorlist .= "L'ID de la fente 3 doit être un nombre.<br />"; }
        if (!is_numeric($dropcode)) { $errors++; $errorlist .= "Le code drop doit être un nombre.<br />"; }
        
        if ($errors == 0) { 
$updatequery = <<<END
UPDATE {{table}} SET
email="$email", verify="$verify", charname="$charname", authlevel="$authlevel", latitude="$latitude",
longitude="$longitude", difficulty="$difficulty", charclass="$charclass", currentaction="$currentaction", currentfight="$currentfight",
currentmonster="$currentmonster", currentmonsterhp="$currentmonsterhp", currentmonstersleep="$currentmonstersleep", currentmonsterimmune="$currentmonsterimmune", currentuberdamage="$currentuberdamage",
currentuberdefense="$currentuberdefense", currenthp="$currenthp", currentmp="$currentmp", currenttp="$currenttp", maxhp="$maxhp",
maxmp="$maxmp", maxtp="$maxtp", level="$level", gold="$gold", experience="$experience",
goldbonus="$goldbonus", expbonus="$expbonus", strength="$strength", dexterity="$dexterity", attackpower="$attackpower",
defensepower="$defensepower", weaponid="$weaponid", armorid="$armorid", shieldid="$shieldid", slot1id="$slot1id",
slot2id="$slot2id", slot3id="$slot3id", weaponname="$weaponname", armorname="$armorname", shieldname="$shieldname",
slot1name="$slot1name", slot2name="$slot2name", slot3name="$slot3name", dropcode="$dropcode", spells="$spells",
towns="$towns" WHERE id="$id" LIMIT 1
END;
			$query = doquery($updatequery, "users");
            admindisplay("Utilisateur mis à jour.","Editer utilisateurs");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les utilsateurs");
        }        
        
    }   
        
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "users");
    $row = mysql_fetch_array($query);
    global $controlrow;
    $diff1name = $controlrow["diff1name"];
    $diff2name = $controlrow["diff2name"];
    $diff3name = $controlrow["diff3name"];
    $class1name = $controlrow["class1name"];
    $class2name = $controlrow["class2name"];
    $class3name = $controlrow["class3name"];

$page = <<<END
<b><u>Editer les utilsateurs</u></b><br /><br />
<form action="admin.php?do=edituser:$id" method="post">
<table width="90%">
<tr><td width="20%">Joueur numéro:</td><td>{{id}}</td></tr>
<tr><td width="20%">ID:</td><td>{{username}}</td></tr>
<tr><td width="20%">Avatar classe:</td><td><img src="./images/avatar/num-{{avatar}}.gif" width="71" height="66"></td></tr>
<tr><td width="20%">Email:</td><td><input type="text" name="email" size="30" maxlength="100" value="{{email}}" /></td></tr>
<tr><td width="20%">Verifié:</td><td><input type="text" name="verify" size="30" maxlength="8" value="{{verify}}" /></td></tr>
<tr><td width="20%">Nom du personnage:</td><td><input type="text" name="charname" size="30" maxlength="30" value="{{charname}}" /></td></tr>
<tr><td width="20%">Date d'inscription:</td><td>{{regdate}}</td></tr>
<tr><td width="20%">Dernière fois en ligne:</td><td>{{onlinetime}}</td></tr>
<tr><td width="20%">Niv. d'accès:</td><td><select name="authlevel"><option value="0" {{auth0select}}>Simple joueur</option><option value="1" {{auth1select}}>Administrateur</option><option value="2" {{auth2select}}>Bloqué</option></select><br /><span class="small">Sélectionnez "bloqué" pour empêcher un utilisateur d'accèder au jeu.</span></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">Latitude:</td><td><input type="text" name="latitude" size="5" maxlength="6" value="{{latitude}}" /></td></tr>
<tr><td width="20%">Longitude:</td><td><input type="text" name="longitude" size="5" maxlength="6" value="{{longitude}}" /></td></tr>
<tr><td width="20%">Difficulté:</td><td><select name="difficulty"><option value="1" {{diff1select}}>$diff1name</option><option value="2" {{diff2select}}>$diff2name</option><option value="3" {{diff3select}}>$diff3name</option></select></td></tr>
<tr><td width="20%">Classe du personnage:</td><td><select name="charclass"><option value="1" {{class1select}}>$class1name</option><option value="2" {{class2select}}>$class2name</option><option value="3" {{class3select}}>$class3name</option></select></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">Action en cours:</td><td><input type="text" name="currentaction" size="30" maxlength="30" value="{{currentaction}}" /></td></tr>
<tr><td width="20%">Combat en cours:</td><td><input type="text" name="currentfight" size="5" maxlength="4" value="{{currentfight}}" /></td></tr>
<tr><td width="20%">ID du monstre:</td><td><input type="text" name="currentmonster" size="5" maxlength="6" value="{{currentmonster}}" /></td></tr>
<tr><td width="20%">HP du monstre:</td><td><input type="text" name="currentmonsterhp" size="5" maxlength="6" value="{{currentmonsterhp}}" /></td></tr>
<tr><td width="20%">ID des sorts du monstre:</td><td><input type="text" name="currentmonsterimmune" size="5" maxlength="3" value="{{currentmonsterimmune}}" /></td></tr>
<tr><td width="20%">Immunité du monstre:</td><td><input type="text" name="currentmonstersleep" size="5" maxlength="3" value="{{currentmonstersleep}}" /></td></tr>
<tr><td width="20%">Dommage actuel d'Uber:</td><td><input type="text" name="currentuberdamage" size="5" maxlength="3" value="{{currentuberdamage}}" /></td></tr>
<tr><td width="20%">Défense actuel d'Uber:</td><td><input type="text" name="currentuberdefense" size="5" maxlength="3" value="{{currentuberdefense}}" /></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">HP actuel:</td><td><input type="text" name="currenthp" size="5" maxlength="6" value="{{currenthp}}" /></td></tr>
<tr><td width="20%">MP actuel:</td><td><input type="text" name="currentmp" size="5" maxlength="6" value="{{currentmp}}" /></td></tr>
<tr><td width="20%">TP actuel:</td><td><input type="text" name="currenttp" size="5" maxlength="6" value="{{currenttp}}" /></td></tr>
<tr><td width="20%">Max HP:</td><td><input type="text" name="maxhp" size="5" maxlength="6" value="{{maxhp}}" /></td></tr>
<tr><td width="20%">Max MP:</td><td><input type="text" name="maxmp" size="5" maxlength="6" value="{{maxmp}}" /></td></tr>
<tr><td width="20%">Max TP:</td><td><input type="text" name="maxtp" size="5" maxlength="6" value="{{maxtp}}" /></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">Niveau:</td><td><input type="text" name="level" size="5" maxlength="5" value="{{level}}" /></td></tr>
<tr><td width="20%">Gils:</td><td><input type="text" name="gold" size="10" maxlength="8" value="{{gold}}" /></td></tr>
<tr><td width="20%">Experience:</td><td><input type="text" name="experience" size="10" maxlength="8" value="{{experience}}" /></td></tr>
<tr><td width="20%">Bonnus rubis:</td><td><input type="text" name="goldbonus" size="5" maxlength="5" value="{{goldbonus}}" /></td></tr>
<tr><td width="20%">Bonnus experience :</td><td><input type="text" name="expbonus" size="5" maxlength="5" value="{{expbonus}}" /></td></tr>
<tr><td width="20%">Force:</td><td><input type="text" name="strength" size="5" maxlength="5" value="{{strength}}" /></td></tr>
<tr><td width="20%">Dextérité:</td><td><input type="text" name="dexterity" size="5" maxlength="5" value="{{dexterity}}" /></td></tr>
<tr><td width="20%">Pouvoir d'attaque:</td><td><input type="text" name="attackpower" size="5" maxlength="5" value="{{attackpower}}" /></td></tr>
<tr><td width="20%">Pouvoir de défense:</td><td><input type="text" name="defensepower" size="5" maxlength="5" value="{{defensepower}}" /></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">ID de l'arme:</td><td><input type="text" name="weaponid" size="5" maxlength="5" value="{{weaponid}}" /></td></tr>
<tr><td width="20%">ID del'armure:</td><td><input type="text" name="armorid" size="5" maxlength="5" value="{{armorid}}" /></td></tr>
<tr><td width="20%">ID de la protection:</td><td><input type="text" name="shieldid" size="5" maxlength="5" value="{{shieldid}}" /></td></tr>
<tr><td width="20%">ID de la fente 1:</td><td><input type="text" name="slot1id" size="5" maxlength="5" value="{{slot1id}}" /></td></tr>
<tr><td width="20%">ID de la fente 2:</td><td><input type="text" name="slot2id" size="5" maxlength="5" value="{{slot2id}}" /></td></tr>
<tr><td width="20%">ID de la fente 3:</td><td><input type="text" name="slot3id" size="5" maxlength="5" value="{{slot3id}}" /></td></tr>
<tr><td width="20%">Nom de l'arme:</td><td><input type="text" name="weaponname" size="30" maxlength="30" value="{{weaponname}}" /></td></tr>
<tr><td width="20%">Nom de l'armure:</td><td><input type="text" name="armorname" size="30" maxlength="30" value="{{armorname}}" /></td></tr>
<tr><td width="20%">Nom de la protec.:</td><td><input type="text" name="shieldname" size="30" maxlength="30" value="{{shieldname}}" /></td></tr>
<tr><td width="20%">Nom de la fente 1:</td><td><input type="text" name="slot1name" size="30" maxlength="30" value="{{slot1name}}" /></td></tr>
<tr><td width="20%">Nom de la fente 2:</td><td><input type="text" name="slot2name" size="30" maxlength="30" value="{{slot2name}}" /></td></tr>
<tr><td width="20%">Nom de la fente 3:</td><td><input type="text" name="slot3name" size="30" maxlength="30" value="{{slot3name}}" /></td></tr>

<tr><td colspan="2" style="background-color:#cccccc;">&nbsp;</td></tr>

<tr><td width="20%">Code drop:</td><td><input type="text" name="dropcode" size="5" maxlength="8" value="{{dropcode}}" /></td></tr>
<tr><td width="20%">Sorts:</td><td><input type="text" name="spells" size="50" maxlength="50" value="{{spells}}" /></td></tr>
<tr><td width="20%">Ville:</td><td><input type="text" name="towns" size="50" maxlength="50" value="{{towns}}" /></td></tr>

</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;

    if ($row["authlevel"] == 0) { $row["auth0select"] = "selected=\"selected\" "; } else { $row["auth0select"] = ""; }
    if ($row["authlevel"] == 1) { $row["auth1select"] = "selected=\"selected\" "; } else { $row["auth1select"] = ""; }
    if ($row["authlevel"] == 2) { $row["auth2select"] = "selected=\"selected\" "; } else { $row["auth2select"] = ""; }
    if ($row["charclass"] == 1) { $row["class1select"] = "selected=\"selected\" "; } else { $row["class1select"] = ""; }
    if ($row["charclass"] == 2) { $row["class2select"] = "selected=\"selected\" "; } else { $row["class2select"] = ""; }
    if ($row["charclass"] == 3) { $row["class3select"] = "selected=\"selected\" "; } else { $row["class3select"] = ""; }
    if ($row["difficulty"] == 1) { $row["diff1select"] = "selected=\"selected\" "; } else { $row["diff1select"] = ""; }
    if ($row["difficulty"] == 2) { $row["diff2select"] = "selected=\"selected\" "; } else { $row["diff2select"] = ""; }
    if ($row["difficulty"] == 3) { $row["diff3select"] = "selected=\"selected\" "; } else { $row["diff3select"] = ""; }
    
    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer utilisateurs");
    
}

function addnews() {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($content == "") { $errors++; $errorlist .= "Vous devez écrire une nouvelle.<br />"; }
        
		 $content = addslashes($content);
        if ($errors == 0) { 
            $query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),content='$content'", "news");
            admindisplay("La nouvelle vient d'êtres ajouté.","Ajouter une nouvelle");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Ajouter une nouvelle");
        }        
        
    }   
        
$page = <<<END
<b><u>Ajouter une nouvelle</u></b><br /><br />
<form action="admin.php?do=news" method="post">
Après avoir rédigé votre nouvelle, cliquez sur Envoyer pour l'afficher tout de suite dans toutes les villes.<br />
<textarea name="content" rows="5" cols="50"></textarea><br />
<input type="submit" name="submit" value="Envoyer" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;
    
    admindisplay($page, "Ajouter une nouvelle");
    
}

function addsondage() {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($question == "") { $errors++; $errorlist .= "La question est obligatoire.<br />"; }
	        if ($reponse1 == "") { $errors++; $errorlist .= "La réponse 1  est obligatoire.<br />"; }
		        if ($reponse2 == "") { $errors++; $errorlist .= "La réponse 2 est obligatoire.<br />"; }
        
        if ($errors == 0) { 
           $query = doquery("INSERT INTO {{table}} SET id='',question='$question',reponse1='$reponse1',reponse2='$reponse2',reponse3='$reponse3',reponse4='$reponse4'", "sondage");
            admindisplay("Le sondage vient d'êtres ajouté.","Ajouter un sondage");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Ajouter un sondage");
        }        
        
    }   
        
        
$page = '
<b><u>Ajouter un sondage</u></b><br /><br />
<form method="post" action="admin.php?do=sondage">
Question : <input type="text" name="question" size="20"><br>
Réponse 1 : <input type="text" name="reponse1" size="20"><br>
Réponse 2 : <input type="text" name="reponse2" size="20"><br>
Réponse 3 (si nécessaire) : <input type="text" name="reponse3" size="20"><br>
Réponse 4 (si nécessaire) : <input type="text" name="reponse4" size="20"><br>
<br><input type="submit" name="submit" value="Créer">
</form>
';
    
    admindisplay($page, "Ajouter un sondage");
    
}
 
function blocs() {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
	        if ($bloc3 == "") { $errors++; $errorlist .= "Le bloc 3 est obligatoire! (copyright).<br />"; }
        	$bloc1 = addslashes($bloc1);
		$bloc2 = addslashes($bloc2);
		$bloc3 = addslashes($bloc3);
		$bloc4 = addslashes($bloc4);
		$bloc5 = addslashes($bloc5);
		
        if ($errors == 0) { 
           $query = doquery("INSERT INTO {{table}} SET id='',bloc1='$bloc1',bloc2='$bloc2',bloc3='$bloc3',bloc4='$bloc4',bloc5='$bloc5'", "blocs");
            admindisplay("Les blocs ont été modifiés.","Editer les blocs");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les blocs");
        }        
        
    }   
        
        
$page = '
<b><u>Editer les blocs</u></b><br /><br />
<form method="post" action="admin.php?do=blocs">
Bloc 1 : <input type="text" name="bloc1" size="20"><br>Indiquez l\'url du deuxième logo de la sociétée (optionnel)<br>
Bloc 2 : <input type="text" name="bloc2" size="20"><br>Indiquez l\'url du logo de la sociétée (optionnel)<br>
Bloc 3 : <input type="text" name="bloc3" size="20"><br>Indiquez le texte copyright de la sociétée (oligatoire)<br>
Bloc 4:  <input type="text" name="bloc4" size="20"><br>Indiquez le deuxième texte copyright de la sociétée (optionnel)<br>
Bloc 5 : <input type="text" name="bloc5" size="20"><br>Indiquez le troisième texte copyright de la sociétée (optionnel)<br>
<br><input type="submit" name="submit" value="Valider"><br><br><b>Attention:</b> Vous ne pouvez pas modifier une seule info. Vous devez réinsérer tous les liens des logos et le texte du copyright (indispensable) en même temps.
</form>
';
    
    admindisplay($page, "Editer blocs du bas");
    
}  

function babble() 
{    
if (isset($_POST["submit"])) 
{ 
mysql_query("TRUNCATE TABLE `rpg_babble`"); 
} 
$page = ' 
<b><u> Vider Le Chat box </u></b><br /><br /> 
<form method="post" action="admin.php?do=babble"> 
<input type="submit" name="submit" value="Valider" /> 
<br><br><b><font color="red">! Attention !</font></b> Vider le babble entrenera la perte de tout les messages figurant dedans, il sera impossible de les récupérer ! 
</form> 
'; 
  if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        
        if ($errors == 0) { 
           
            admindisplay("La chatbox à été vidée","vider le chatbox");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les blocs");
        }        
        
    } 
  admindisplay($page, "vider le chatbox"); 
} 

function message() 
{ 
    if (!isset ($_POST['envoi'])){ 
 $page = '<b><u> Envoyer un mail </u></b><br /><br /> 
    <form action="'.$_SERVER['PHP_SELF'].'?do=message" method=POST> 
    Email de l\'expediteur:<input type=text name=email_expediteur size=20><br>Sujet du mail:<input type=text name=sujet_mail size=20><br> 
    <br>Message <br><textarea rows=5 name=message_envoi cols=50></textarea><br><br><input type=submit name=envoi value="Envoyer le message"></form>'; 
    } 
    else{ 
    //On regarde si tous les champs ont été remplis 
   if (empty ($_POST['email_expediteur']) || empty ($_POST['sujet_mail']) || empty ($_POST['message_envoi'])){ 
   echo '<script language=javascript>alert ("Vous devez remplir tous les champs!!")</script>'; 
       echo '<script language=javascript>window.location="'.$_SERVER['PHP_SELF'].'?do=message"</script>'; 
   } 
   else{ 
   //On sélectionne tous les emails et on envoie le message 
   $selection="select * from rpg_users where verify=1"; 
   $sql=mysql_query($selection); 
       while ($a_row=mysql_fetch_assoc($sql)){ 
        //La récupération étant terminée, on envoie le message à chaque membre! 
       $to = "$a_row[email]"; 
       $sujet = "$_POST[sujet_mail]"; 
       //--- la structure du mail ----// 
       $from  = "From:$_POST[email_expediteur]\n"; 
       $from .= "MIME-version: 1.0\n"; 
       $from .= "Content-type: text/html; charset= iso-8859-1\n"; 
 //--- Corps du message ---// 
       $message_def="$_POST[message_envoi]\n"; 
       //--- on envoie l'email ---// 
       mail($to,$sujet,$message_def,$from); 
       } 
    if (isset($_POST["envoi"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($email_expediteur == "") { $errors++; $errorlist .= "Entrez l'email de l'expediteur.<br />"; }
	        if ($message_envoi == "") { $errors++; $errorlist .= "Entrez votre message.<br />"; }
        
        if ($errors == 0) { 
           
            admindisplay("Le mail a été envoyé","Editer un mail");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les blocs");
        }        
        
    } 
   } 
    } 

  
  admindisplay($page, "Editer un mail"); 
} 

function newsaccueil() {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
         $content = addslashes($content);
		 $titre = addslashes($titre);
        if ($errors == 0) { 
           $query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),titre='$titre', content='$content'", "newsaccueil");
            admindisplay("La new a été Ajoutée.","Editer la new 1");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer la new");
        }        
        
    }   
    
        
$page = '
<b><u>Editer les news</u></b><br /><br />
<form method="post" action="admin.php?do=newsaccueil">
<input type="text" name="titre" size="20" value="titre new"><br>
Ecrivez l\'intégralité de la new ci dessous<br>
<textarea name="content" rows="5" cols="50"></textarea><br>
<input type="submit" name="submit" value="Valider">
<input type="submit" name="reset" value="Annuler"><br><br>Vous pouvez ajouter une image dans la news en ajoutant ce code: <b>img src="url de l\'image"></b> . N\'oubliez pas le <b><</b> devant le img! <br><b>Attention :</b> Si vous avez actuellement 5 news sur la page d\'accueil, celle-ci effacera la plus ancienne.
</form>
';
    
    admindisplay($page, "Editer les news");
    
} 

function carte() {
    
    if (isset($_POST['submit'])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
	    if ($longitude1 == "") { $errors++; $errorlist .= "- La latitude est exigée sur le premier champ.<br />"; }
        if ($latitude1 == "") { $errors++; $errorlist .= "- La longitude est exigée sur le premier champ.<br />"; }
		if (preg_match("/[^0-9_\-]/", $longitude1)==1) { $errors++; $errorlist .= "- La longitude doit être écrit en valeurs numériques.<br />"; }
        if (preg_match("/[<>\[\]]/", $latitude1)==1) { $errors++; $errorlist .= "- La latitude doit être écrit en valeurs numériques.<br />"; }

        if ($errors == 0) { 
		
		 if ($longitude1 && $latitude1 !=''){
		 $update1 = doquery("INSERT INTO {{table}} SET id='',nom='$nom1', lati='$latitude1', longi='$longitude1', passable='$passable1'", "sol");
         }
		 if ($longitude2 && $latitude2 !=''){
		 $update2 = doquery("INSERT INTO {{table}} SET id='',nom='$nom2', lati='$latitude2', longi='$longitude2', passable='$passable2'", "sol");
         }
		 if ($longitude3 && $latitude3 !=''){
		 $update3 = doquery("INSERT INTO {{table}} SET id='',nom='$nom3', lati='$latitude3', longi='$longitude3', passable='$passable3'", "sol");
         }
		 if ($longitude4 && $latitude4 !=''){
		 $update4 = doquery("INSERT INTO {{table}} SET id='',nom='$nom4', lati='$latitude4', longi='$longitude4', passable='$passable4'", "sol");
         }
		  if ($longitude5 && $latitude5 !=''){
		 $update5 = doquery("INSERT INTO {{table}} SET id='',nom='$nom5', lati='$latitude5', longi='$longitude5', passable='$passable5'", "sol");
         }
		  if ($longitude6 && $latitude6 !=''){
		 $update6 = doquery("INSERT INTO {{table}} SET id='',nom='$nom6', lati='$latitude6', longi='$longitude6', passable='$passable6'", "sol");
         }
		  if ($longitude7 && $latitude7 !=''){
		 $update7 = doquery("INSERT INTO {{table}} SET id='',nom='$nom7', lati='$latitude7', longi='$longitude7', passable='$passable7'", "sol");
         }
		  if ($longitude8 && $latitude8 !=''){
		 $update8 = doquery("INSERT INTO {{table}} SET id='',nom='$nom8', lati='$latitude8', longi='$longitude8', passable='$passable8'", "sol");
         }
		  if ($longitude9 && $latitude9 !=''){
		 $update9 = doquery("INSERT INTO {{table}} SET id='',nom='$nom9', lati='$latitude9', longi='$longitude9', passable='$passable9'", "sol");
         }
		  if ($longitude10 && $latitude10 !=''){
		 $update10 = doquery("INSERT INTO {{table}} SET id='',nom='$nom10', lati='$latitude10', longi='$longitude10', passable='$passable10'", "sol");
         }
		 
		 admindisplay('La carte a été modifiée avec succès!<br /><br />Maintenant vous pouvez:<br /><br /><a href="admin.php?do=carte">» retourner pour éditer la map</a><br /><a href="index.php">» retourner au jeu</a>','Editer la carte');
        } else {
            admindisplay('<b>Erreurs:</b><br /><br /><span class="alerte">'.$errorlist.'</span><br /><a href="admin.php?do=carte">Veuillez retourner et essayer encore</a>.', 'Editer la carte');
        }          
    }   
          
$page = '
<b><u><span class="mauve1">Editer la carte</span></u></b><br /><br /><u>Légende:</u> Arbre = <img src="images/carte/arbre.gif" width="15" height="15"> Fleur = <img src="images/carte/fleur.jpg" width="15" height="15"> Fleur2 =  <img src="images/carte/fleur1.jpg" width="15" height="15"> Rocher =  <img src="images/carte/rocher.jpg" width="15" height="15"> Eau =  <img src="images/carte/mer.jpg" width="15" height="15"><br /><br />
<form method="post" action="admin.php?do=carte">
<table width="586" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:500px">Type: <select name="nom1"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude1" size="4" maxlength="3"> Latitude: <input type="text" name="latitude1" size="4" maxlength="3"> Passable: <select name="passable1"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom2"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude2" size="4" maxlength="3"> Latitude: <input type="text" name="latitude2" size="4" maxlength="3"> Passable: <select name="passable2"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom3"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude3" size="4" maxlength="3"> Latitude: <input type="text" name="latitude3" size="4" maxlength="3"> Passable: <select name="passable3"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom4"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude4" size="4" maxlength="3"> Latitude: <input type="text" name="latitude4" size="4" maxlength="3"> Passable: <select name="passable4"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom5"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude5" size="4" maxlength="3"> Latitude: <input type="text" name="latitude5" size="4" maxlength="3"> Passable: <select name="passable5"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom6"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude6" size="4" maxlength="3"> Latitude: <input type="text" name="latitude6" size="4" maxlength="3"> Passable: <select name="passable6"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom7"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude7" size="4" maxlength="3"> Latitude: <input type="text" name="latitude7" size="4" maxlength="3"> Passable: <select name="passable7"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom8"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude8" size="4" maxlength="3"> Latitude: <input type="text" name="latitude8" size="4" maxlength="3"> Passable: <select name="passable8"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom9"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude9" size="4" maxlength="3"> Latitude: <input type="text" name="latitude9" size="4" maxlength="3"> Passable: <select name="passable9"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px">Type: <select name="nom10"><option value="arbre">Arbre</option><option value="fleur">Fleur</option><option value="rocher">Rocher</option><option value="mer">Eau</option><option value="quete">Quete</option></select> Longitude: <input type="text" name="longitude10" size="4" maxlength="3"> Latitude: <input type="text" name="latitude10" size="4" maxlength="3"> Passable: <select name="passable10"><option value="1">Oui</option><option value="0">Non</option></select></td></tr>
<tr valign="top"><td style="width:500px"><br /><br /><input type="submit" name="submit" value="Valider" /> <input type="button" value="Retour" OnClick="javascript:location=\'index.php\'"/</td></tr>
</table><br />
<b><u><span class="mauve1">Visualiser la map</span></u></b><br />Selectionner la zone de votre choix (le temps de chargement varie de 10 à 30 secondes en moyenne).
<br /><br /><img src="images/carte/quadrillage.jpg" usemap="#carte" border="0">
<map name="carte">
  <area shape="rect" coords="126,128,148,149" href="#" onClick="window.open(\'?do=visu_map&latitude=-254&longitude=-256\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="101,127,124,148" href="#" onClick="window.open(\'?do=visu_map&latitude=-254&longitude=128\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="77,127,98,149" href="#" onClick="window.open(\'?do=visu_map&latitude=-254&longitude=44\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="51,124,73,149" href="#" onClick="window.open(\'?do=visu_map&latitude=-254&longitude=-40\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="28,126,48,147" href="#" onClick="window.open(\'?do=visu_map&latitude=-254&longitude=-124\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="2,129,22,147" href="#" onClick="window.open(\'?do=visu_map&latitude=-254&longitude=-208\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="128,102,149,124" href="#" onClick="window.open(\'?do=visu_map&latitude=-128&longitude=254\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="102,102,124,123" href="#" onClick="window.open(\'?do=visu_map&latitude=-128&longitude=128\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="77,102,99,124" href="#" onClick="window.open(\'?do=visu_map&latitude=-128&longitude=44\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="52,100,71,121" href="#" onClick="window.open(\'?do=visu_map&latitude=-128&longitude=-40\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="27,101,49,125" href="#" onClick="window.open(\'?do=visu_map&latitude=-128&longitude=-124\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="2,102,23,127" href="#" onClick="window.open(\'?do=visu_map&latitude=-128&longitude=-208\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="128,78,147,99" href="#" onClick="window.open(\'?do=visu_map&latitude=-44&longitude=254\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="102,76,124,99" href="#" onClick="window.open(\'?do=visu_map&latitude=-44&longitude=128\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="78,76,99,99" href="#" onClick="window.open(\'?do=visu_map&latitude=-44&longitude=44\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="53,77,73,97" href="#" onClick="window.open(\'?do=visu_map&latitude=-44&longitude=-40\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="28,76,49,97" href="#" onClick="window.open(\'?do=visu_map&latitude=-44&longitude=-124\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="3,76,24,99" href="#" onClick="window.open(\'?do=visu_map&latitude=-44&longitude=-208\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="127,53,140,74" href="#" onClick="window.open(\'?do=visu_map&latitude=40&longitude=254\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="105,53,123,74" href="#" onClick="window.open(\'?do=visu_map&latitude=40&longitude=128\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="80,52,98,75" href="#" onClick="window.open(\'?do=visu_map&latitude=40&longitude=44\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="53,51,74,73" href="#" onClick="window.open(\'?do=visu_map&latitude=40&longitude=-40\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="28,52,46,73" href="#" onClick="window.open(\'?do=visu_map&latitude=40&longitude=-124\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="2,55,23,73" href="#" onClick="window.open(\'?do=visu_map&latitude=40&longitude=-208\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="130,29,149,50" href="#" onClick="window.open(\'?do=visu_map&latitude=124&longitude=254\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="102,27,124,51" href="#" onClick="window.open(\'?do=visu_map&latitude=124&longitude=128\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="78,26,96,49" href="#" onClick="window.open(\'?do=visu_map&latitude=124&longitude=44\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="54,27,73,49" href="#" onClick="window.open(\'?do=visu_map&latitude=124&longitude=-40\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="26,24,50,49" href="#" onClick="window.open(\'?do=visu_map&latitude=124&longitude=-124\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="1,25,22,49" href="#" onClick="window.open(\'?do=visu_map&latitude=124&longitude=-208\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="128,3,149,23" href="#" onClick="window.open(\'?do=visu_map&latitude=208&longitude=254\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="104,3,124,23" href="#" onClick="window.open(\'?do=visu_map&latitude=208&longitude=128\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="78,1,97,22" href="#" onClick="window.open(\'?do=visu_map&latitude=208&longitude=44\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="53,3,74,21" href="#" onClick="window.open(\'?do=visu_map&latitude=208&longitude=-40\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="27,1,46,21" href="#" onClick="window.open(\'?do=visu_map&latitude=208&longitude=-124\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  <area shape="rect" coords="0,0,21,23" href="#" onClick="window.open(\'?do=visu_map&latitude=208&longitude=-208\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=, copyhistory=0, menuBar=0, width=890, height=890\');return(false)">
  </map>
</form>
';
    
    admindisplay($page, 'Editeur de map');
    
}

function visu_map() { // Visualisation de la map

if(isset($_GET['longitude'])&&($_GET['latitude'])){

$latmax = $_GET['latitude'] + 42;
$longmax = $_GET['longitude'] + 42;
$latmin = $_GET['latitude'] - 42;
$longmin = $_GET['longitude'] - 42;

$latitude = $latmax;
$page = '<body>
<div id="dek" style="z-index: 500; visibility: hidden; position: absolute"></div><script language="javascript" type="text/javascript" src="infobulle.js"></script>
<style type="text/css">
table {
  color: black;
  font: 10px verdana;
}</style>';

$page .= '<table width="63" height="63" border="0" cellspacing="0" cellpadding="0" style="background-image:url(images/carte/herbe.jpg)" align="center">';
$page .= '<tr><td align="center" valign="middle">';
$page .= '<table cellspacing="0" cellpadding="0">';
$latitude = $latmax;
$page .= '<table cellspacing="0" cellpadding="0" bordercolor="#FFFFFF" border="1">';
while ($latitude >= $latmin ) {
$page .= '<tr bordercolor="#000000">';
$longitude = $longmin;
while ($longitude <= $longmax) {

//infos map
$query2 = doquery("SELECT nom FROM {{table}} WHERE lati='$latitude' AND longi='$longitude' LIMIT 1", "sol");
$fetcht = mysql_fetch_array($query2);
$map = $fetcht['nom'];

// infos Villes
$query4 = doquery("SELECT name FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "towns");
$fetchx = mysql_fetch_array($query4);
$villes = $fetchx['name'];

if($villes !=''){
$page .= '<td><a onMouseOver="popup(\'Longitude: '.$longitude.'; Latitude: '.$latitude.'<br> Ville: '.$villes.'\',\'#FFFFF9\')" onMouseOut=kill() ;><img src="images/carte/ville.jpg" width="9" height="9"></a></td>'; }
elseif($map =='arbre'){
$page .= '<td><a onMouseOver="popup(\'Longitude: '.$longitude.'; Latitude: '.$latitude.'\',\'#FFFFF9\')" onMouseOut=kill() ;><img src="images/carte/arbre.gif" width="9" height="9"></a></td>'; }
elseif($map =='mer'){
$page .= '<td><a onMouseOver="popup(\'Longitude: '.$longitude.'; Latitude: '.$latitude.'\',\'#FFFFF9\')" onMouseOut=kill() ;><img src="images/carte/mer.jpg" width="9" height="9"></a></td>'; }
else{
$page .= '<td><a onMouseOver="popup(\'Longitude: '.$longitude.'; Latitude: '.$latitude.'\',\'#FFFFF9\')" onMouseOut=kill() ;><img src="images/leftnav_log/click-guide.gif" width="9" height="9"></a></td>';
}
$longitude++;
}
$page .= '</tr>';
$latitude--;
}
$page .= '</table>';

$page .= '</td>
  </tr>
</table></body>';
$page .='<input type=button name=bouton value="Recharger la page" onclick=\'parent.location="javascript:location.reload()"\'> Cliquez sur le bouton pour recharger la page après vos modifications';

}else{

$page .='Erreur de manipulation';}

echo $page;

} 
?>