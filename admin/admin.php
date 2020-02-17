<?php // admin.php :: Administration du script.

include('../lib.php');
include('../cookies.php');
include('../bbcode.php');
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
    elseif ($do[0] == "message2") { message2(); }
	elseif ($do[0] == "historique") { historique(); }
    elseif ($do[0] == "comment") { comment(); }
    elseif ($do[0] == "message") { message(); }
    elseif ($do[0] == "newsaccueil") { newsaccueil(); }
    elseif ($do[0] == "interet") { interet(); }
    elseif ($do[0] == "items2") { items2(); } 
    elseif ($do[0] == "edititem2") { edititem2($do[1]); }
	elseif ($do[0] == "addville") { addville(); }
	elseif ($do[0] == "addsort") { addsort(); }
	elseif ($do[0] == "stats") { stats(); }
	elseif ($do[0] == "villenatal") { villenatal(); }
	elseif ($do[0] == "forum") { forum(); }
	elseif ($do[0] == "editforum") { editforum($do[1]); }
	elseif ($do[0] == "metier") { Metier(); }
	elseif ($do[0] == "metier2") { Metier2(); }
    elseif ($do[0] == "quete") { quete(); }
    elseif ($do[0] == "createquete") { createquete(); }
	elseif ($do[0] == "maisons") { maisons(); }
    elseif ($do[0] == "editmaisons") { editmaisons($do[1]); }
	elseif ($do[0] == "quetes") { quetes(); }
    elseif ($do[0] == "editquetes") { editquetes($do[1]); }



} else { donothing(); }

function donothing() {
    
    $page = "Bienvenue sur la page d'admin de RPG illusion 1.2c . Ici vous pouvez modifier ou éditer librement plusieurs paramètres. <br><br> En cas de problème, veuillez contactez l'auteur de script à cette adresse : webmaster@rpgillusion.com<br><br><br><center><img src=\"../images/im_admin.gif\"/><br><br>Pour que RPG illusion perdure et que nous puissions financer de meilleurs services, nous vous invitons à faire un don du montant de votre choix. <font color=cc0000><b>Ceci est très important, car sans ces donations, le RPG pourrait <u>perdre sa licence open source et devenir payant</u> pour financer le développement du jeu.</b></font></span><br><br>
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
if ($class1name == "") { $errors++; $errorlist .= "Le nom du Village 1 est exigé.<br />"; }
if ($class2name == "") { $errors++; $errorlist .= "Le nom du Village 2 est exigé.<br />"; }
if ($class3name == "") { $errors++; $errorlist .= "Le nom du Village 3 est exigé.<br />"; }
if ($diff1name == "") { $errors++; $errorlist .= "Le nom de la difficulté 1 est exigé.<br />"; }
if ($diff2name == "") { $errors++; $errorlist .= "Le nom de la difficulté 2 est exigé.<br />"; }
if ($diff3name == "") { $errors++; $errorlist .= "Le nom de la difficulté 3 est exigé.<br />"; }
if ($diff2mod == "") { $errors++; $errorlist .= "La valeur de la difficulté 2 est exigée.<br />"; }
if ($diff3mod == "") { $errors++; $errorlist .= "La valeur de la difficulté 3 est exigée.<br />"; }

$gamename = addslashes($gamename);
if ($errors == 0) {

$query = doquery("UPDATE {{table}} SET gamename='$gamename',gamesize='$gamesize',monnaie='$monnaie',forumtype='$forumtype',forumaddress='$forumaddress',compression='$compression',class1name='$class1name',class2name='$class2name',class3name='$class3name',diff1name='$diff1name',diff2name='$diff2name',diff3name='$diff3name',diff2mod='$diff2mod',diff3mod='$diff3mod',gameopen='$gameopen',verifyemail='$verifyemail',gameurl='$gameurl',adminemail='$adminemail',shownews='$shownews',showonline='$showonline',showbabble='$showbabble',register='$register' WHERE id='1' LIMIT 1", "control");
admindisplay("Réglages mis à jour.","Main Settings");
} else {
admindisplay("<b>Erreurs:</b><br /><div style='color:red;'>$errorlist</div><br />Veuillez retourner et essayer encore.", "Menu des réglages");
}
}

global $controlrow;

$page = <<<END
<b><u>Menu des réglages</u></b><br />
Ces options commandent plusieurs paramètres principaux du jeu.<br /><br />
<form action="admin.php?do=main" method="post">
<table width="90%">
<tr><td width="20%"><span class="highlight">Statut du jeu:</span></td><td><select name="gameopen"><option value="1" {{open1select}}>Ouvert</option><option value="0" {{open0select}}>Fermé</option></select><br /><span class="small">Fermez le jeu si vous êtes faites de la maintance dessus.</span></td></tr>
<tr><td width="20%"><span class="highlight">Inscription:</span></td><td><select name="register"><option value="1" {{open1select}}>Ouvert</option><option value="0" {{open0select}}>Fermée</option></select><br /><span class="small">Fermez les inscriptions si vous estimez que le nombre d'inscris est suffisant.</span></td></tr>
<tr><td width="20%">Nom du jeu:</td><td><input type="text" name="gamename" size="30" maxlength="50" value="{{gamename}}" /><br /><span class="small">Le nom du jeu par default est "RPG illusion". Mais vous pouvez librement le modifier.</span></td></tr>
<tr><td width="20%">URL du jeu:</td><td><input type="text" name="gameurl" size="50" maxlength="100" value="{{gameurl}}" /><br /><span class="small">Veuillez indiquer l'URL complète du jeu("http://www.votre_site.com/repertoire_du_jeu/index.php").</span></td></tr>
<tr><td width="20%">Email de l'admin:</td><td><input type="text" name="adminemail" size="30" maxlength="100" value="{{adminemail}}" /><br /><span class="small">Veuillez indiquer votre adresse email. Les utilisateurs qui auront besoin d'aide utiliseront cette adresse pour vous écrire.</span></td></tr>
<tr><td width="20%">Nom del a monnaie de votre jeu:</td><td><input type="text" name="monnaie" size="30" maxlength="100" value="{{monnaie}}" /><br /></span></td></tr>
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

if ($controlrow["forumtype"] == 0) { $controlrow["selecttype0"] = 'selected="selected" '; } else { $controlrow["selecttype0"] = ""; }
if ($controlrow["forumtype"] == 1) { $controlrow["selecttype1"] = 'selected="selected" '; } else { $controlrow["selecttype1"] = ""; }
if ($controlrow["forumtype"] == 2) { $controlrow["selecttype2"] = 'selected="selected" '; } else { $controlrow["selecttype2"] = ""; }
if ($controlrow["compression"] == 0) { $controlrow["selectcomp0"] = 'selected="selected" '; } else { $controlrow["selectcomp0"] = ""; }
if ($controlrow["compression"] == 1) { $controlrow["selectcomp1"] = 'selected="selected" '; } else { $controlrow["selectcomp1"] = ""; }
if ($controlrow["verifyemail"] == 0) { $controlrow["selectverify0"] = 'selected="selected" '; } else { $controlrow["selectverify0"] = ""; }
if ($controlrow["verifyemail"] == 1) { $controlrow["selectverify1"] = 'selected="selected" '; } else { $controlrow["selectverify1"] = ""; }
if ($controlrow["shownews"] == 0) { $controlrow["selectnews0"] = 'selected="selected" '; } else { $controlrow["selectnews0"] = ""; }
if ($controlrow["shownews"] == 1) { $controlrow["selectnews1"] = 'selected="selected" '; } else { $controlrow["selectnews1"] = ""; }
if ($controlrow["showonline"] == 0) { $controlrow["selectonline0"] = 'selected="selected" '; } else { $controlrow["selectonline0"] = ""; }
if ($controlrow["showonline"] == 1) { $controlrow["selectonline1"] = 'selected="selected" '; } else { $controlrow["selectonline1"] = ""; }
if ($controlrow["showbabble"] == 0) { $controlrow["selectbabble0"] = 'selected="selected" '; } else { $controlrow["selectbabble0"] = ""; }
if ($controlrow["showbabble"] == 1) { $controlrow["selectbabble1"] = 'selected="selected" '; } else { $controlrow["selectbabble1"] = ""; }
if ($controlrow["gameopen"] == 1) { $controlrow["open1select"] = 'selected="selected" '; } else { $controlrow["open1select"] = ""; }
if ($controlrow["gameopen"] == 0) { $controlrow["open0select"] = 'selected="selected" '; } else { $controlrow["open0select"] = ""; }
if ($controlrow["register"] == 1) { $controlrow["open1select"] = 'selected="selected" '; } else { $controlrow["open1select"] = ""; }
if ($controlrow["register"] == 0) { $controlrow["open0select"] = 'selected="selected" '; } else { $controlrow["open0select"] = ""; }

$page = parsetemplate($page, $controlrow);
admindisplay($page, "Réglages principaux");

}

function items() {

    $query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "items");
    $page = "<b><u>Editer les objets</u></b><br />Cliquez sur le nom d'un objet pour le modifier.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=edititem:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=
		
		:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 1; }
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
<tr><td width="20%">Image:</td><td><img src="../images/items/{{image}}.gif"/></td></tr>
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
        if ($latitude == "") { $errors++; $errorlist .= "La latitude est exigée.<br />"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "La latitude doit être un nombre.<br />"; }
        if ($longitude == "") { $errors++; $errorlist .= "La longitude est exigée.<br />"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "La longitude doit être un nombre.<br />"; }
        if ($innprice == "") { $errors++; $errorlist .= "Le prix de l'auberge est exigé.<br />"; }
        if (!is_numeric($innprice)) { $errors++; $errorlist .= "Le prix de l'auberge doir être un nombre.<br />"; }
        if ($mapprice == "") { $errors++; $errorlist .= "Le prix de la carte est exigé.<br />"; }
        if (!is_numeric($mapprice)) { $errors++; $errorlist .= "Le prix de la carte doit être un nombre.<br />"; }
		
		if ($interets == "") { $errors++; $errorlist .= "Le pourcentage d'interet est exigés.<br />"; }
        if (!is_numeric($interets)) { $errors++; $errorlist .= "Le pourcentage d'interet doit être un nombre.<br />"; }
		if ($prixenchanteur == "") { $errors++; $errorlist .= "Le prix de l'enchanteur est exigé.<br />"; }
        if (!is_numeric($prixenchanteur)) { $errors++; $errorlist .= "Le prix doit être un nombre.<br />"; }
		if ($prixsoigneur == "") { $errors++; $errorlist .= "Le prix de l'église est exigés.<br />"; }
        if (!is_numeric($prixsoigneur)) { $errors++; $errorlist .= "Le prix doit être un nombre.<br />"; }

        if ($travelpoints == "") { $errors++; $errorlist .= "Les points de voyages sont exigés.<br />"; }
        if (!is_numeric($travelpoints)) { $errors++; $errorlist .= "Les points de voyages doivent êtres des nombres.<br />"; }
        if ($itemslist == "") { $errors++; $errorlist .= "La liste des objets est exigée.<br />"; }

		$name = addslashes($name); 
        $allopass = addslashes($allopass);  
		$alloprice = addslashes($alloprice);
        if ($errors == 0) {
            $query = doquery("UPDATE {{table}} SET homeprice='$homeprice',itemslistb='$itemslistb',interets='$interets',name='$name',chiffreniveau='$chiffreniveau',chiffrebanque='$chiffrebanque',codebanque='$codebanque',
			codeniveau='$codeniveau',chiffrexp='$chiffrexp',codexp='$codexp',chiffreptlevel='$chiffreptlevel',codeptlevel='$codeptlevel',latitude='$latitude',longitude='$longitude',innprice='$innprice',mapprice='$mapprice',travelpoints='$travelpoints',itemslist='$itemslist',prixsoigneur='$prixsoigneur',prixenchanteur='$prixenchanteur' WHERE id='$id' LIMIT 1", "towns");
            admindisplay("Ville mise à jour.","Editer villes");
        } else {
            admindisplay("<b>Errors:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les villes");
        }

    }


    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "towns");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Edit Towns</u><br /><br />
<form action="admin.php?do=edittown:$id" method="post">
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<tr><td width="20%">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="{{name}}" /></td></tr>
<tr><td width="20%">Latitude:</td><td><input type="text" name="latitude" size="5" maxlength="10" value="{{latitude}}" /><br /><span class="small">Positive or negative integer.</span></td></tr>
<tr><td width="20%">Longitude:</td><td><input type="text" name="longitude" size="5" maxlength="10" value="{{longitude}}" /><br /><span class="small">Positive or negative integer.</span></td></tr>
<tr><td width="20%">Taux d'interets:</td><td><input type="text" name="interets" size="5" maxlength="10" value="{{interets}}" /> pourcent (%)</td></tr>

<tr><td width="20%">Prix de l'auberge:</td><td><input type="text" name="innprice" size="5" maxlength="10" value="{{innprice}}" /> gold</td></tr>
<tr><td width="20%">Prix de l'enchanteur:</td><td><input type="text" name="prixenchanteur" size="5" maxlength="10" value="{{prixenchanteur}}" /> gold</td></tr>
<tr><td width="20%">Prix de l'eglise:</td><td><input type="text" name="prixsoigneur" size="5" maxlength="10" value="{{prixsoigneur}}" /> gold</td></tr>
<tr><td width="20%">Prix de la maison:</td><td><input type="text" name="homeprice" size="5" maxlength="10" value="{{homeprice}}" /> gold</td></tr>

<tr><td width="20%">Prix de la carte:</td><td><input type="text" name="mapprice" size="5" maxlength="10" value="{{mapprice}}" /> gold<br /><span class="small">Prix de la carte de cette ville.</span></td></tr>
<tr><td width="20%">Points de voyage:</td><td><input type="text" name="travelpoints" size="5" maxlength="10" value="{{travelpoints}}" /><br /><span class="small">Nombre de Points de voyage (TP) consommés pour aller à cette ville.</span></td></tr>
<tr><td width="20%">Liste des objets:</td><td><input type="text" name="itemslist" size="30" maxlength="200" value="{{itemslist}}" /><br /><span class="small">Liste des objets disponible dans le magasin de cette ville. (Example: <span class="highlight">1,2,3,6,9,10,13,20</span>)</span> Note: L'objet numéro 1 correspond à l'ID numéro 1 (pour voir l'ID des objets rendez vous dans la rubrique <span class="highlight">Editer objets</span>).</td></tr>
<tr><td width="20%">Liste des objets dans le marché:</td><td><input type="text" name="itemslistb" size="30" maxlength="200" value="{{itemslistb}}" /><br /><span class="small">Liste des objets disponible dans le marché de cette ville. (Example: <span class="highlight">1,2,3,6,9,10,13,20</span>)</span> Note: L'objet numéro 1 correspond à l'ID numéro 1 (pour voir l'ID des objets rendez vous dans la rubrique <span class="highlight">Editer objets</span>).</td></tr>
<tr><td width="20%">Niv monnaie:</td><td><input type="text" name="chiffrebanque" size="5" maxlength="10" value="{{chiffrebanque}}" /> gold</td></tr>
<tr><td width="20%">Code allopass banque:</td><td><textarea name="codebanque" rows="7" cols="30">{{codebanque}}</textarea><br><b>URL de la page d'accès:</b> " http://www.votresite.com/demonstration/index.php "<br><b>URL du document:</b> "http://www.votresite.com/index.php?do=cheatbanque "<br></td></tr>
<tr><td width="20%">Niv allopass:</td><td><input type="text" name="chiffreniveau" size="5" maxlength="10" value="{{chiffreniveau}}" /> niveau</td></tr>
<tr><td width="20%">Code allopass niv:</td><td><textarea name="codeniveau" rows="7" cols="30">{{codeniveau}}</textarea><br><b>URL de la page d'accès:</b> " http://www.votresite.com/demonstration/index.php "<br><b>URL du document:</b> "http://www.votresite.com/index.php?do=cheatniveau "<br></td></tr>
<tr><td width="20%">Niv xp:</td><td><input type="text" name="chiffrexp" size="5" maxlength="10" value="{{chiffrexp}}" /> xp</td></tr>
<tr><td width="20%">Code allopass xp:</td><td><textarea name="codexp" rows="7" cols="30">{{codexp}}</textarea><br><b>URL de la page d'accès:</b> " http://www.votresite.com/demonstration/index.php "<br><b>URL du document:</b> "http://www.votresite.com/index.php?do=cheatxp "<br></td></tr>
<tr><td width="20%">Niv ptlevel:</td><td><input type="text" name="chiffreptlevel" size="5" maxlength="10" value="{{chiffreptlevel}}" /> level</td></tr>
<tr><td width="20%">Code allopass niv:</td><td><textarea name="codeptlevel" rows="7" cols="30">{{codeptlevel}}</textarea><br><b>URL de la page d'accès:</b> " http://www.votresite.com/demonstration/index.php "<br><b>URL du document:</b> "http://www.votresite.com/index.php?do=cheatptlevel "<br></td></tr>

<tr><td width="20%">Bannière:</td><td><img src="./images/town_{{id}}.gif" width='420'></td></tr>

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
<tr><td width="20%">Portait:</td><td><img src="../images/monstre/{{image}}.gif"  width="71" height="59"></td></tr>
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
admindisplay("<b>Erreurs:</b><br /><div style='color:red;'>$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les utilsateurs");
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
<tr><td width="20%">Avatar classe:</td><td><img src="../images/avatar/{{avatar}}" width="71" height="66"></td></tr>
<tr><td width="20%">Email:</td><td><input type="text" name="email" size="30" maxlength="100" value="{{email}}" /></td></tr>
<tr><td width="20%">Verifié:</td><td><input type="text" name="verify" size="30" maxlength="8" value="{{verify}}" /></td></tr>
<tr><td width="20%">Nom du personnage:</td><td><input type="text" name="charname" size="30" maxlength="30" value="{{charname}}" /></td></tr>
<tr><td width="20%">Date d'inscription:</td><td>{{regdate}}</td></tr>
<tr><td width="20%">Dernière fois en ligne:</td><td>{{onlinetime}}</td></tr>
<tr><td width="20%">Niv. d'accès:</td><td><select name="authlevel"><option value="0" {{auth0select}}>Simple joueur</option><option value="3" {{auth3select}}>Modérateur</option><option value="1" {{auth1select}}>Administrateur</option><option value="2" {{auth2select}}>Bloqué</option></select><br /><span class="small">Sélectionnez "bloqué" pour empêcher un utilisateur d'accèder au jeu.</span></td></tr>

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
<tr><td width="20%">Monnaie:</td><td><input type="text" name="gold" size="10" maxlength="8" value="{{gold}}" /></td></tr>
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

if ($row["authlevel"] == 0) { $row["auth0select"] = "selected='selected' "; } else { $row["auth0select"] = ""; }
if ($row["authlevel"] == 1) { $row["auth1select"] = "selected='selected' "; } else { $row["auth1select"] = ""; }
if ($row["authlevel"] == 2) { $row["auth2select"] = "selected='selected' "; } else { $row["auth2select"] = ""; }
if ($row["charclass"] == 1) { $row["class1select"] = "selected='selected' "; } else { $row["class1select"] = ""; }
if ($row["charclass"] == 2) { $row["class2select"] = "selected='selected' "; } else { $row["class2select"] = ""; }
if ($row["charclass"] == 3) { $row["class3select"] = "selected='selected' "; } else { $row["class3select"] = ""; }
if ($row["difficulty"] == 1) { $row["diff1select"] = "selected='selected' "; } else { $row["diff1select"] = ""; }
if ($row["difficulty"] == 2) { $row["diff2select"] = "selected='selected' "; } else { $row["diff2select"] = ""; }
if ($row["difficulty"] == 3) { $row["diff3select"] = "selected='selected' "; } else { $row["diff3select"] = ""; }

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
            $query = doquery("INSERT INTO {{table}} SET id='',author='$author',postdate=NOW(),content='$content'", "news");
            $texte = new texte();
			admindisplay("La nouvelle vient d'êtres ajouté.","Ajouter une nouvelle");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Ajouter une nouvelle");
        }

    }

$page = <<<END
<b><u>Ajouter une nouvelle</u></b><br /><br />
<form action="admin.php?do=news" method="post">
Après avoir rédigé votre nouvelle, cliquez sur Envoyer pour l'afficher tout de suite dans toutes les villes.<br />
<input type="text" name="author" size="20" value="Pseudo de l'auteur"><br><br>
<textarea name="content" rows="5" cols="50"></textarea><br />
Gras : [b][/b] / Italique : [i][/i] / Souligné : [u][/u] / Image : [img][\img] / Lien : [url][/url]<br>
<img src='../images/smileys/1.jpg'> :1: /
<img src='../images/smileys/2.jpg'> :2: /
<img src='../images/smileys/3.jpg'> :3: /
<img src='../images/smileys/4.jpg'> :4: /
<img src='../images/smileys/5.jpg'> :5: /
<img src='../images/smileys/6.jpg'> :6: /
<img src='../images/smileys/7.jpg'> :7: /
<img src='../images/smileys/8.jpg'> :8: /<br>
<input type="submit" name="submit" value="Envoyer" /> <input type="reset" name="reset" value="Annuler" />
</form>
END;

    admindisplay($page, "Ajouter une nouvelle");

}

function blocs() {

$townquery3 = doquery("SELECT bloc1,bloc2,bloc4,bloc5 FROM {{table}} WHERE  id='1'  LIMIT 1", "blocs"); 
$townrow3 = mysql_fetch_array($townquery3); 
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
	        if ($bloc4 == "") { $errors++; $errorlist .= "Le bloc 1 est obligatoire! (copyright).<br />"; }
		        $bloc1 = addslashes($bloc1);
				$bloc2 = addslashes($bloc2);
				$bloc5 = addslashes($bloc5);
		
        if ($errors == 0) { 
           $query = doquery("Update {{table}} SET id='1',bloc1='$bloc1',bloc2='$bloc2',bloc4='$bloc4',bloc5='$bloc5'", "blocs");
            admindisplay("Les blocs ont été modifiés.","Editer les blocs");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les blocs");
        }        
        
    }   
        
$page = '
<b><u>Editer les blocs</u></b><br /><br />
<form method="post" action="admin.php?do=blocs">
Bloc 1:  <input type="text" name="bloc1" size="20" value="'.$townrow3["bloc1"].'"><br>Indiquez le premier logo<br>
Bloc 2: <input type="text" name="bloc2" size="20" value="'.$townrow3["bloc2"].'"><br>Indiquez le deuxieme logo<br>
Bloc 3:  <input type="text" name="bloc4" size="20" value="'.$townrow3["bloc4"].'"><br>Indiquez le premier texte copyright de la sociétée (optionnel)<br>
Bloc 4: <input type="text" name="bloc5" size="20" value="'.$townrow3["bloc5"].'"><br>Indiquez le deuxieme texte copyright de la sociétée (optionnel)<br>
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

function message2()
{
if (isset($_POST["submit"]))
{
mysql_query("TRUNCATE TABLE `rpg_msg`");
}
$page = '
<b><u> Vider Les messageries </u></b><br /><br />
<form method="post" action="admin.php?do=message2">
<input type="submit" name="submit" value="Valider" />
<br><br><b><font color="red">! Attention !</font></b> Vider les messagerie entrenera la perte de tout les messages figurant dedans, il sera impossible de les récupérer !
</form>
';
  if (isset($_POST["submit"])) {

        extract($_POST);
        $errors = 0;
        $errorlist = "";

        if ($errors == 0) {

            admindisplay("Les msg à été vidée","vider le forum");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les blocs");
        }

    }
  admindisplay($page, "vider les messageries");
}

function comment() 
{    
if (isset($_POST["submit"])) 
{ 
mysql_query("TRUNCATE TABLE `rpg_comments`"); 
} 
$page = ' 
<b><u> Vider Les commentaires </u></b><br /><br /> 
<form method="post" action="admin.php?do=comment"> 
<input type="submit" name="submit" value="Valider" /> 
<br><br><b><font color="red">! Attention !</font></b> Vider les commentaires entrenera la perte de tout les messages figurant dedans, il sera impossible de les récupérer ! 
</form> 
'; 
  if (isset($_POST["submit"])) { 
        
        extract($_POST); 
        $errors = 0; 
        $errorlist = ""; 
        
        if ($errors == 0) { 
            
            admindisplay("Les comentaires ont été vidées","vider les commentaires"); 
        } else { 
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les blocs"); 
        }        
        
    } 
  admindisplay($page, "vider les commentaires"); 
} 



function message()
{
$texte = new texte();
    if (!isset ($_POST["envoi"])){
 $page = '<b><u> Envoyer un mail </u></b><br /><br />
    <form action="'.$_SERVER['PHP_SELF'].'?do=message" method=POST>
    Email de l\'expediteur:<input type=text name=email_expediteur size=20><br>Sujet du mail:<input type=text name=sujet_mail size=20><br>
	Gras : [b][/b] / Italique : [i][/i] / Souligné : [u][/u] / Image : [img][\img] / Lien : [url][/url]<br>
<img src="images/smileys/1.jpg"> :1: /
<img src="images/smileys/2.jpg"> :2: /
<img src="images/smileys/3.jpg"> :3: /
<img src="images/smileys/4.jpg"> :4: /
<img src="images/smileys/5.jpg"> :5: /
<img src="images/smileys/6.jpg"> :6: /
<img src="images/smileys/7.jpg"> :7: /
<img src="images/smileys/8.jpg"> :8: /<br>
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
           $query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),titre='$titre', content='$content', auteur='$auteur'", "newsaccueil");
		   $texte = new texte();
            admindisplay("La new a été Ajoutée.","Editer la new 1");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer la new");
        }

    }


$page = '
<b><u>Editer les news</u></b><br /><br />
<form method="post" action="admin.php?do=newsaccueil">
<input type="text" name="titre" size="20" value="Titre de la News"><br><br>
<input type="text" name="auteur" size="20" value="Pseudo de lauteur"><br><br>
Ecrivez l\'intégralité de la new ci dessous<br>
<textarea name="content" rows="5" cols="50"></textarea><br>
Gras : [b][/b] / Italique : [i][/i] / Souligné : [u][/u] / Image : [img][\img] / Lien : [url][/url]<br>
<img src="../images/smileys/1.jpg"> :1: /
<img src="../images/smileys/2.jpg"> :2: /
<img src="../images/smileys/3.jpg"> :3: /
<img src="../images/smileys/4.jpg"> :4: /
<img src="../images/smileys/5.jpg"> :5: /
<img src="../images/smileys/6.jpg"> :6: /
<img src="../images/smileys/7.jpg"> :7: /
<img src="../images/smileys/8.jpg"> :8: /<br>
<input type="submit" name="submit" value="Valider">
<input type="submit" name="reset" value="Annuler"><br><br>Vous pouvez ajouter une image dans la news en ajoutant ce code: <b>img src="url de l\'image"></b> . N\'oubliez pas le <b><</b> devant le img! <br><b>Attention :</b> Si vous avez actuellement 5 news sur la page d\'accueil, celle-ci effacera la plus ancienne.
</form>
';

    admindisplay($page, "Editer les news");

}

function interet() {
if (isset($_POST["submit"])) {
mysql_query ("UPDATE rpg_users SET bank = bank + (bank * 0.03 )") or die(mysql_error());
admindisplay("Les interets ont bien été ajouté", "Interets");
}
$page = '
<b><u>Interet</u></b><br /><br />
<form method="post" action="admin.php?do=interet">
Pour déclencher les interets il suffit de cliquer sur le bouton ci-dessous
<input type="submit" name="submit" value="Déclencher les interets">
</form>
';

admindisplay($page, "Interets");
}

function items2() { 
    
    $query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "items2"); 
    $page = "<b><u>Editer les objets</u></b><br />Cliquez sur le nom d'un objet pour le modifier.<br /><br /><table width=\"50%\">\n"; 
    $count = 1; 
    while ($row = mysql_fetch_array($query)) { 
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=edititem2:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 2; } 
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=edititem2:".$row["id"]."\">".$row["name"]."</a></td></tr>\n"; $count = 1; } 
    } 
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas d'objets trouvés.</td></tr>\n"; } 
    $page .= "</table>"; 
    admindisplay($page, "Editer objets"); 
    
} 

function edititem2($id) {
     if (isset($_POST["submit"])) {

        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Le nom est exigé.<br />"; }
        if ($buycost == "") { $errors++; $errorlist .= "Le prix est exigé.<br />"; }
        if (!is_numeric($buycost)) { $errors++; $errorlist .= "Le prix doit être un nombre!.<br />"; }


        $name = addslashes($name);
                $description = addslashes($description);

        if ($errors == 0) {
            $query = doquery("UPDATE {{table}} SET name='$name',type='$type',buycost='$buycost',description='$description' WHERE id='$id' LIMIT 1", "items2");
            admindisplay("Objet mis à jour.","Editer objets");
        } else {
            admindisplay("<b>Erreur:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Edit Items2");
        }

    }


    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items2");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Editer Items</u></b><br /><br />
<form action="admin.php?do=edititem2:$id" method="post">
<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<br /><br />
<tr><td width="20%">Nom:</td><td><input type="text" name="name" size="30" maxlength="30" value="{{name}}" /></td></tr>
<tr><td width="20%">Type:</td><td><select name="type"><option value="1" {{type1select}}>Arme</option><option value="2" {{type2select}}>Armure</option><option value="3" {{type3select}}>Protection</option></select></td></tr>
<tr><td width="20%">Prix:</td><td><input type="text" name="buycost" size="5" maxlength="10" value="{{buycost}}" /> rubis</td></tr>
<tr><td width="20%">Description:</td><td><textarea name="description" type="text" rows="5" cols="50">{{description}}</textarea></td></tr>


</table>
<input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</form>

END;

    if ($row["type"] == 1) { $row["type1select"] = "selected=\"selected\" "; } else { $row["type1select"] = ""; }
    if ($row["type"] == 2) { $row["type2select"] = "selected=\"selected\" "; } else { $row["type2select"] = ""; }
    if ($row["type"] == 3) { $row["type3select"] = "selected=\"selected\" "; } else { $row["type3select"] = ""; }

    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer objets");

}

function addville() {

if (isset($_POST["submit"])) {

extract($_POST);
$errors = 0;
$errorlist = "";

if ($name == "") { $errors++; $errorlist .= "Le nom de la ville est exigé.<br />"; }
if ($codebanque == "") { $errors++; $errorlist .= "Le codebanque est exigée.<br />"; }
if ($codeniveau == "") { $errors++; $errorlist .= "Le codeniveau est exigé.<br />"; }
if ($interets == "") { $errors++; $errorlist .= "Les intérêts sont exigés.<br />"; }
if ($chiffrebanque == "") { $errors++; $errorlist .= "Le chiffrebanque est exigée.<br />"; }
if ($chiffreniveau == "") { $errors++; $errorlist .= "Le chiffreniveau est exigée.<br />"; }
if ($latitude == "") { $errors++; $errorlist .= "La latitude est exigée.<br />"; }
if ($longitude == "") { $errors++; $errorlist .= "La longitude est exigée.<br />"; }
if ($innprice == "") { $errors++; $errorlist .= "Le prix de l'hôtel est exigée.<br />"; }
if ($mapprice == "") { $errors++; $errorlist .= "Le prix de la carte est exigé.<br />"; }
if ($homeprice == "") { $errors++; $errorlist .= "Le prix de la maison est exigé.<br />"; }
if ($travelpoints == "") { $errors++; $errorlist .= "Les points de voyages sont exigés.<br />"; }
if ($itemslist == "") { $errors++; $errorlist .= "La liste des objets est exigée.<br />"; }

if ($errors == 0) {
$updatequery = <<<END
INSERT INTO rpg_towns (id, name, codebanque, codeniveau, interets, chiffrebanque, chiffreniveau, latitude, longitude, innprice, mapprice, homeprice, travelpoints, itemslist) VALUES('', '$name', '$codebanque', '$codeniveau', '$interers', '$chiffrebanque', '$chiffreniveau', '$latitude', '$longitude', '$innprice', '$mapprice', '$homeprice', '$travelpoints', '$itemlist');
END;
$query = doquery($updatequery, "towns");
admindisplay("Utilisateur mis à jour.","Ajouter une ville");
} else {
admindisplay("<b>Erreurs :</b><br /><div style='color:red;'>$errorlist</div><br />Veuillez retourner et essayer encore.", "Ajouter une ville");
}

}



$page = <<<END
<b><u>Ajouter une ville</u></b><br/><br/>
<form method="POST" action="admin.php?do=addville">
<p>ID de la ville : <input type="text" name="id" size="20"></p>
<p></p>
<p>Nom de la ville : <input type="text" name="name" size="20"></p>
<p>Code banque : <input type="text" name="codebanque" size="20" value="Service non disponible">
Par Défaut : Service non disponible.</p>
<p>Code niveau : <input type="text" name="codeniveau" size="20" value="Service non disponible">
Par Défaut : Service non disponible.</p>
<p>Intérêts : <input type="text" name="interets" size="20" value="0"> Intérêts
pour la banque.</p>
<p>Chiffre banque : <input type="text" name="chiffrebanque" size="20" value="5000"></p>
<p>Chiffre niveau : <input type="text" name="chiffreniveau" size="20" value="5"></p>
<p>Latitude : <input type="text" name="latitude" size="20"></p>
<p>Longitude : <input type="text" name="longitude" size="20"></p>
<p>Prix de l&acute;Hôtel : <input type="text" name="innprice" size="20" value="5"></p>
<p>Prix de la Carte : <input type="text" name="mapprice" size="20" value="0"></p>
<p>Prix de la Maison : <input type="text" name="homeprice" size="20" value="1000"> Prix
pour construire une maison.</p>
<p>Points de Voyage : <input type="text" name="travelpoints" size="20" value="0"></p>
<p>Liste des Objets : <input type="text" name="itemslist" size="20"> Les objets pour les
magasins.</p>
<p><center><input type="submit" name="submit" value="Valider">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset" value="Annuler"> </center></p>
</form>
END;

if ($row[""] == 0) {
$row[""] = "selected='selected' ";
}
else {
$row[""] = "";
}


$page = parsetemplate($page, $row);
admindisplay($page, "Ajouter une ville");

}

function addsort() {

if (isset($_POST["submit"])) {

extract($_POST);
$errors = 0;
$errorlist = "";

if ($name == "") { $errors++; $errorlist .= "Le nom du est exigé.<br />"; }
if ($mp == "") { $errors++; $errorlist .= "Le mp est exigée.<br />"; }
if ($attribute == "") { $errors++; $errorlist .= "L'attribute est exigé.<br />"; }
if ($type == "") { $errors++; $errorlist .= "Les type est exigés.<br />"; }
if ($price == "") { $errors++; $errorlist .= "Le prix est exigée.<br />"; }
if ($errors == 0) { 
$updatequery = <<<END
INSERT INTO rpg_spells (id, name, mp, attribute, type, price) VALUES('', '$name', '$mp', '$attribute', '$type', '$price');
END;
$query = doquery($updatequery, "spells");
admindisplay("Sort ajouté","Ajouter un sort");
} else {
admindisplay("<b>Erreurs:</b><br /><div style='color:red;'>$errorlist</div><br />Veuillez retourner et essayer encore.", "Ajouter une ville");
} 

} 



$page = <<<END
<b><u>Ajouter un sort</u></b><br/><br/>
<form method="POST" action="admin.php?do=addsort">
ID:<input type="text" name="id" size="20"></p>
<p>Nom:<input type="text" name="name" size="20"></p>
<p>mp:<input type="text" name="mp" size="20"> Pour les domages!</p>
<p>attribute:<input type="text" name="attribute" size="20"></p>
<p>type:<input type="text" name="type" size="20"></p>
<p>Price:<input type="text" name="price" size="20"> Prix</p>
<p><input type="submit" name="submit" value="Valider">
<input type="reset" name="reset" value="Annuler"> </p>
</form>
END;

if ($row[""] == 0) { $row[""] = "selected='selected' "; } else { $row[""] = ""; }

$page = parsetemplate($page, $row);
admindisplay($page, "Ajouter un sort");

}

function stats() {
$stats_users_actif_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_users WHERE verify='1'") or die (mysql_error());
$stats_users_actif_donnee = mysql_fetch_array($stats_users_actif_sql);
$stats_users_actif = $stats_users_actif_donnee["id"];

$stats_users_admin_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_users WHERE authlevel='1'") or die (mysql_error());
$stats_users_admin_donnee = mysql_fetch_array($stats_users_admin_sql);
$stats_users_admin = $stats_users_admin_donnee["id"];

$stats_users_membre_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_users WHERE verify='1'") or die (mysql_error());
$stats_users_membre_donnee = mysql_fetch_array($stats_users_membre_sql);
$stats_users_membre = $stats_users_membre_donnee["id"];

$stats_users_inactif_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_users WHERE verify='0'") or die (mysql_error());
$stats_users_inactif_donnee = mysql_fetch_array($stats_users_inactif_sql);
$stats_users_inactif = $stats_users_inactif_donnee["id"];

$stats_forum_sujets_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_forum WHERE parent='0'") or die (mysql_error());
$stats_forum_sujets_donnee = mysql_fetch_array($stats_forum_sujets_sql);
$stats_forum_sujets = $stats_forum_sujets_donnee["id"];

$stats_forum_messages_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_forum WHERE parent='1'") or die (mysql_error());
$stats_forum_messages_donnee = mysql_fetch_array($stats_forum_messages_sql);
$stats_forum_messages = $stats_forum_messages_donnee["id"];

$stats_userlieu_ville_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_users WHERE currentaction='En ville'") or die (mysql_error());
$stats_userlieu_ville_donnee = mysql_fetch_array($stats_userlieu_ville_sql);
$stats_userlieu_ville = $stats_userlieu_ville_donnee["id"];

$stats_userlieu_balade_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_users WHERE currentaction='En exploration'") or die (mysql_error());
$stats_userlieu_balade_donnee = mysql_fetch_array($stats_userlieu_balade_sql);
$stats_userlieu_balade = $stats_userlieu_balade_donnee["id"];

$stats_lieu_villes_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_towns") or die (mysql_error());
$stats_lieu_villes_donnee = mysql_fetch_array($stats_lieu_villes_sql);
$stats_lieu_villes = $stats_lieu_villes_donnee["id"];

$stats_userlieu_combat_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_users WHERE currentaction='En combat'") or die (mysql_error());
$stats_userlieu_combat_donnee = mysql_fetch_array($stats_userlieu_combat_sql);
$stats_userlieu_combat = $stats_userlieu_combat_donnee["id"];

$stats_lieu_maisons_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_maison") or die (mysql_error());
$stats_lieu_maisons_donnee = mysql_fetch_array($stats_lieu_maisons_sql);
$stats_lieu_maisons = $stats_lieu_maisons_donnee["id"];

$stats_perso_monstre_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_monsters") or die (mysql_error());
$stats_perso_monstre_donnee = mysql_fetch_array($stats_perso_monstre_sql);
$stats_perso_monstre = $stats_perso_monstre_donnee["id"];

$stats_perso_level_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_levels") or die (mysql_error());
$stats_perso_level_donnee = mysql_fetch_array($stats_perso_level_sql);
$stats_perso_level = $stats_perso_level_donnee["id"];

$stats_tchat_msg_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_babble") or die (mysql_error());
$stats_tchat_msg_donnee = mysql_fetch_array($stats_tchat_msg_sql);
$stats_tchat_msg = $stats_tchat_msg_donnee["id"];

$stats_news_commentaires_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_comments") or die (mysql_error());
$stats_news_commentaires_donnee = mysql_fetch_array($stats_news_commentaires_sql);
$stats_news_commentaires = $stats_news_commentaires_donnee["id"];

$stats_news_total_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_newsaccueil") or die (mysql_error());
$stats_news_total_donnee = mysql_fetch_array($stats_news_total_sql);
$stats_news_total = $stats_news_total_donnee["id"];

$stats_nouvelles_total_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_news") or die (mysql_error());
$stats_nouvelles_total_donnee = mysql_fetch_array($stats_nouvelles_total_sql);
$stats_nouvelles_total = $stats_nouvelles_total_donnee["id"];

$stats_objets_perdus_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_drops") or die (mysql_error());
$stats_objets_perdus_donnee = mysql_fetch_array($stats_objets_perdus_sql);
$stats_objets_perdus = $stats_objets_perdus_donnee["id"];

$stats_sondages_total_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_sondage") or die (mysql_error());
$stats_sondages_total_donnee = mysql_fetch_array($stats_sondages_total_sql);
$stats_sondages_total = $stats_sondages_total_donnee["id"];

$stats_sondages_participation_sql = mysql_query("SELECT COUNT(*) AS id FROM rpg_sondage_ip") or die (mysql_error());
$stats_sondages_participation_donnee = mysql_fetch_array($stats_sondages_participation_sql);
$stats_sondages_participation = $stats_sondages_participation_donnee["id"];

$stats_rpg_version_sql = mysql_query("SELECT gamename FROM rpg_control") or die (mysql_error());
while ($stats_rpg_version_donnee = mysql_fetch_array($stats_rpg_version_sql) )
{
$stats_rpg_version = $stats_rpg_version_donnee['gamename'];
}
$page = <<<END
<h2><p align="center"><font color=red>Statistiques</font><p></h2>
<p><b>Nombre de membres actifs :</b> $stats_users_actif</p>
<p><b>Nombre des administrateurs :</b> $stats_users_admin</p>
<p><b>Nombre de membres actifs (total) :</b> $stats_users_membre</p>
<p><b>Nombre de membres inactifs :</b> $stats_users_inactif</p>
<p><b>Nombre de sujets dans le forum :</b> $stats_forum_sujets</p>
<p><b>Nombre de messages dans le forum :</b> $stats_forum_messages</p>
<p><b>Nombre de personnages en ville :</b> $stats_userlieu_ville</p>
<p><b>Nombre de personnage en exploration :</b> $stats_userlieu_balade</p>
<p><b>Nombre de personnage en combat :</b> $stats_userlieu_combat</p>
<p><b>Nombre de villes :</b> $stats_lieu_villes</p>
<p><b>Nombre de maisons :</b> $stats_lieu_maisons</p>
<p><b>Nombre de monstres :</b> $stats_perso_monstre</p>
<p><b>Nombre de niveaux :</b> $stats_perso_level</p>
<p><b>Nombre de messages dans le chat :</b> $stats_tchat_msg</p>
<p><b>Nombre de news :</b> $stats_news_total</p>
<p><b>Nombre de nouvelles :</b> $stats_nouvelles_total</p>
<p><b>Nombre de commentaires aux nouvelles :</b> $stats_news_commentaires</p>
<p><b>Nombre des objets perdus :</b> $stats_objets_perdus</p>
<p><b>Nombre de sondages :</b> $stats_sondages_total</p>
<p><b>Nombre de participations au sondages :</b> $stats_sondages_participation</p>
<p><b>Version du RPG :</b> $stats_rpg_version</p>
END;
admindisplay($page, "Statistiques du jeu");
}

function villenatal() {
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";

        if ($lati == "") { $errors++; $errorlist .= "Exigé.<br />"; }
		if ($long == "") { $errors++; $errorlist .= "Exigé.<br />"; }
        if ($errors == 0) { 
$updatequery = <<<END
UPDATE rpg_users SET latitude='$lati',longitude='$long' WHERE verify=1
END;
			$query = doquery($updatequery, "towns");
            admindisplay("Longitude et latitude réussie","Longitude et latitude");
        } else {
            admindisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Ajouter une ville");
        }        
        
    }   
        


$page = <<<END
<b><u>Modifier touts la position des joueurs</u></b><br/><br/>
<form method="POST" action="admin.php?do=villenatal">
  <p>Latitude:<input type="text" name="lati" size="20"></p>
  <p>Longitude:<input type="text" name="long" size="20"></p>
  <p><input type="submit" name="submit" value="Valider">
  <input type="reset" name="reset" value="Annuler"> </p>
</form>
END;

 if ($row[""] == 0) { $row[""] = "selected=\"selected\" "; } else { $row[""] = ""; }


    $page = parsetemplate($page, $row);
    admindisplay($page, "Longitude et Latitude");
    
}

function forum() { 
    
    $query = doquery("SELECT id,title,author,postdate FROM {{table}} ORDER BY id", "forum"); 
    $page = "<b><u>Editer les forums</u></b><br />Cliquez sur le nom du sujet pour le modifier.<br /><br /><table width=\"50%\">\n"; 
    $count = 1; 
    while ($row = mysql_fetch_array($query)) { 
	if ($count == 1) { 
	       $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">Id</td><td width=\"8%\" style=\"background-color: #ffffff;\">Auteur</td><td style=\"background-color: #fffffff;\">Titre</td><td style=\"background-color: #fffffff;\">Posté le :</td>";
           $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["author"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"admin.php?do=editforum:".$row["id"]."\">".$row["title"]."</a></td><td style=\"background-color: #eeeeee;\">".$row["postdate"]."</td></tr>\n"; $count = 2; } 
    else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["author"]."</td><td style=\"background-color: #ffffff;\"><a href=\"admin.php?do=editforum:".$row["id"]."\">".$row["title"]."</a></td><td style=\"background-color: #ffffff;\">".$row["postdate"]."</td></tr>\n"; $count = 1; } 
    } 
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas de sujet trouvé.</td></tr>\n"; } 
    $page .= "</table>"; 
    admindisplay($page, "Editer Forum"); 
    
} 

function editforum($id) {

  if (isset($_POST['delete'])) {
		$sql ="delete from rpg_forum where id=$id";
		mysql_query($sql) or die("MySQL error: ".mysql_error()."");
	    admindisplay("Message supprimé. <a href='admin.php?do=forum'>Retour</a>","Editer Forum");
        }
  
    if (isset($_POST["submit"])) {

        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($author == "") { $errors++; $errorlist .= "Le nom de l'auteur est exigé.<br />"; }
        if ($title == "") { $errors++; $errorlist .= "Le titre est exigé.<br />"; }
        if ($content == "") { $errors++; $errorlist .= "Le contenu est exigé.<br />"; }


        $author = addslashes($author);
        $content = addslashes($content);

        if ($errors == 0) {
            $query = doquery("UPDATE {{table}} SET author='$author',title='$title',content='$content' WHERE id='$id' LIMIT 1", "forum");
            admindisplay("Forum mis à jour. <a href='admin.php?do=forum'>Retour</a>","Editer Forum");
        } else {
            admindisplay("<b>Erreur:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer Forum");
        }

    }
		


    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "forum");
    $row = mysql_fetch_array($query);

$page = <<<END
<b><u>Editer les forums :</u></b><br /><br />
<form action="admin.php?do=editforum:$id" method="post">

<table width="90%">
<tr><td width="20%">ID:</td><td>{{id}}</td></tr>
<br /><br />
<tr><td width="20%">Auteur:</td><td><input type="text" name="author" size="30" maxlength="30" value="{{author}}" /></td></tr>
<tr><td width="20%">Titre:</td><td><input type="text" name="title" size="30" maxlength="30" value="{{title}}" /></td></tr>
<tr><td width="20%">Contenu:</td><td><textarea name="content" type="text" rows="5" cols="50">{{content}}</textarea></td></tr>
<tr><td width="20%">Supprimé:</td><td><input type="submit" value="Supprimer" name="delete"></td></tr>
</table>

<input type="submit" name="submit" value="Valider" /><input type="reset" name="reset" value="Annuler" /></form>
<input type="hidden" name="id" value="id"></form>


END;

    if ($row["type"] == 1) { $row["type1select"] = "selected=\"selected\" "; } else { $row["type1select"] = ""; }
    if ($row["type"] == 2) { $row["type2select"] = "selected=\"selected\" "; } else { $row["type2select"] = ""; }
    if ($row["type"] == 3) { $row["type3select"] = "selected=\"selected\" "; } else { $row["type3select"] = ""; }

    $page = parsetemplate($page, $row);
    admindisplay($page, "Editer Forum");

}

function metier(){
global $userrow;
admindisplay("<center>Voulez vous remetre les Metier a JOUR ?</center><center><form method='post' action='admin.php?do=metier2'><input type='submit' name='submit' value='Oui' /> <input type='submit' name='cancel' value='Non' /></p></form></center>", "remetre les metier a jour");
}
function metier2() { 
if (isset($_POST["cancel"])) { header("Location: index.php"); die(); }
global $userrow, $numqueries;
$news = $userrow["ptmetier"] + 1;
mysql_query("UPDATE rpg_users SET ptmetier=ptmetier+$news WHERE ptmetier=0 "); 
admindisplay("C'est ok !!! Les Metier sont mis a jour", "Bon travail pour demain");

}

function quetes() {

$query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "quete");
$page = '<b><u><span class="mauve1">Editer les quêtes</span></u></b><br /><br />Cliquez sur le nom d\'une quete pour la modifier.<br /><br /><table width="350">';
$count = 1;
while ($maisons = mysql_fetch_array($query)) {
if ($count == 1) { $page .= '<tr><td width="20" class="rose1">'.$maisons['id'].'</td><td class="rose1"><a href="admin.php?do=editquetes:'.$maisons['id'].'">'.$maisons['name'].'</a></td></tr>'; $count = 2; }
else { $page .= '<tr><td width="2" class="rose2">'.$maisons['id'].'</td><td class="rose2"><a href="admin.php?do=editquetes:'.$maisons['id'].'">'.$maisons['name'].'</a></td></tr>'; $count = 1; }
}
if (mysql_num_rows($query) == 0) { $page = 'Pas de quêtes trouvés.'; }
$page .= '';

admindisplay($page, 'Editer les quêtes');

}

function editquetes($id) {
 
if (isset($_POST["submit"])) {

extract($_POST);
$errors = 0;
$errorlist = "";


$charname = addslashes($charname); 

if ($errors == 0)
{
if ( empty($effacement) ) { 
$query = doquery("UPDATE {{table}} SET id='$id',name='$name',description='$description',level='$level',type='$type',monster='$monster',number='$number',longi='$longi',lati='$lati',town='$town',experience='$experience',gils='$gils' WHERE id='$id' LIMIT 1", "quete");
}
else {
$query = doquery("DELETE FROM {{table}} WHERE id='$id' LIMIT 1", "quete");
}
admindisplay('Quete mis à jour.','Editer les Quete');
}
else {
admindisplay('<b>Erreurs:</b><br /><br /><span class="alerte">'.$errorlist.'</span><br /><a href="admin.php?do=editquetes:'.$id.'">Veuillez retourner et essayer encore</a>.', 'Editer les quetes');
}


} 

$query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "quete");
$quetes = mysql_fetch_array($query);

$page = '
<b><u><span class="mauve1">Editer maisons</span></u></b><br /><br />
<form action="admin.php?do=editquetes:'.$id.'" method="post">
<table width="386" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td width="110"><span class="marron3">ID:</span></td><td>'.$id.'<br /><br /></td></tr>
<br /><br />
<tr valign="top"><td width="110"><span class="marron3">Nom de la quête:</span></td><td><input type="text" name="name" size="30" maxlength="30" value="'.stripslashes($quetes['name']).'" /><br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Texte Personnage:</span></td><td><textarea name="description" size="8" maxlength="3"/>'.stripslashes($quetes['description']).'</textarea><br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Niveau de la quete:</span></td><td><input type="text" name="level" size="8" maxlength="3" value="'.stripslashes($quetes['level']).'" /><br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Gain en xp:</span></td><td><input type="text" name="experience" size="10" maxlength="4" value="'.stripslashes($quetes['experience']).'" /> xp<br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Monnaie gagnés:</span></td><td><input type="text" name="Monnaie" size="8" maxlength="3" value="'.stripslashes($quetes['Monnaie']).'" /><br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Effacer la quete:</span></td><td><input type="checkbox" name="effacement" value="1"><br /><br /></td></tr>
<tr valign="top"><td width="110"></td><td><input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</td></tr>
</table>
</form>
'; 
$page = parsetemplate($page, $quetees);
admindisplay($page, "Editer les quetes");

}

function maisons() {

$query = doquery("SELECT id,name FROM {{table}} ORDER BY id", "maison");
$page = '<b><u><span class="mauve1">Editer les maisons</span></u></b><br /><br />Cliquez sur le nom d\'une maison pour la modifier.<br /><br /><table width="350">';
$count = 1;
while ($maisons = mysql_fetch_array($query)) {
if ($count == 1) { $page .= '<tr><td width="20" class="rose1">'.$maisons['id'].'</td><td class="rose1"><a href="admin.php?do=editmaisons:'.$maisons['id'].'">'.$maisons['name'].'</a></td></tr>'; $count = 2; }
else { $page .= '<tr><td width="2" class="rose2">'.$maisons['id'].'</td><td class="rose2"><a href="admin.php?do=editmaisons:'.$maisons['id'].'">'.$maisons['name'].'</a></td></tr>'; $count = 1; }
}
if (mysql_num_rows($query) == 0) { $page = 'Pas de maisons trouvés.'; }
$page .= '';

admindisplay($page, 'Editer les maisons');

}

function editmaisons($id) {
 
if (isset($_POST["submit"])) {

extract($_POST);
$errors = 0;
$errorlist = "";
if ($charname == "") { $errors++; $errorlist .= "Le nom est exigé.<br />"; }
if (preg_match("/[\^*+<>?#]/", $charname)==1) { $errors++; $errorlist .= "Le nom du site doit être écrit en caractères alphanumériques.<br />"; }
if ($longitude == "") { $errors++; $errorlist .= "La longitude est exigée.<br />"; }
if (!is_numeric($longitude)) { $errors++; $errorlist .= "La longitude doit être un nombre!.<br />"; }
if ($latitude == "") { $errors++; $errorlist .= "La latitude est exigée.<br />"; }
if (!is_numeric($latitude)) { $errors++; $errorlist .= "La latitude doit être un nombre!.<br />"; } if ($longitude == "") { $errors++; $errorlist .= "La longitude est exigé.<br />"; }
if ($auberge == "") { $errors++; $errorlist .= "Le prix de l'auberge est exigé.<br />"; }
if (!is_numeric($auberge)) { $errors++; $errorlist .= "Le prix de l'auberge doit être un nombre!.<br />"; } if ($longitude == "") { $errors++; $errorlist .= "La longitude est exigé.<br />"; }


$charname = addslashes($charname); 

if ($errors == 0)
{
if ( empty($effacement) ) { 
$query = doquery("UPDATE {{table}} SET name='".addslashes($name)."',longitude='$longitude',latitude='$latitude',innprice='$auberge' WHERE id='$id' LIMIT 1", "maison");
}
else {
$query = doquery("DELETE FROM {{table}} WHERE id='$id' LIMIT 1", "maison");
}
admindisplay('Maison mis à jour.','Editer les maisons');
}
else {
admindisplay('<b>Erreurs:</b><br /><br /><span class="alerte">'.$errorlist.'</span><br /><a href="admin.php?do=editmaisons:'.$id.'">Veuillez retourner et essayer encore</a>.', 'Editer les maisons');
}


} 

$query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "maison");
$maisons = mysql_fetch_array($query);

$page = '
<b><u><span class="mauve1">Editer maisons</span></u></b><br /><br />
<form action="admin.php?do=editmaisons:'.$id.'" method="post">
<table width="386" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td width="110"><span class="marron3">ID:</span></td><td>'.$id.'<br /><br /></td></tr>
<br /><br />
<tr valign="top"><td width="110"><span class="marron3">Charname:</span></td><td><input type="text" name="charname" size="30" maxlength="30" value="'.stripslashes($maisons['name']).'" /><br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Latitude:</span></td><td><input type="text" name="latitude" size="8" maxlength="3" value="'.stripslashes($maisons['latitude']).'" /><br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Longitude:</span></td><td><input type="text" name="longitude" size="8" maxlength="3" value="'.stripslashes($maisons['longitude']).'" /><br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Prix de l\'auberge:</span></td><td><input type="text" name="auberge" size="10" maxlength="4" value="'.stripslashes($maisons['innprice']).'" /> rubis<br /><br /></td></tr>
<tr valign="top"><td width="110"><span class="marron3">Effacer la maison:</span></td><td><input type="checkbox" name="effacement" value="1"><br /><br /></td></tr>
<tr valign="top"><td width="110"></td><td><input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" />
</td></tr>
</table>
</form>
'; 
$page = parsetemplate($page, $maisons);
admindisplay($page, "Editer les maisons");

}

function createquete ()
{
extract($_POST);
if($radio1=='1')
{
if($radio2=='1') { $prolongation=$oldquest; } else { $prolongation=0; }
mysql_query("INSERT INTO rpg_quete (name,description,level,type,monster,number,longi,lati,
town,experience,gils,prolongation) VALUES ('$nomquete','$textequete','$niveau','1','
$typemonster',
'$nbrmonster','','','$ville','$gain','$gils','$prolongation')") or die ("Erreur");
admindisplay("La Quete a été Ajoutée.","Quete Effective");
}
elseif($radio1=='2')
{
if($radio2=='1') { $prolongation=$oldquest; } else { $prolongation=0; }
mysql_query("INSERT INTO rpg_quete (name,description,level,type,monster,number,longi,lati,
town,experience,gils,prolongation) VALUES ('$nomquete','$textequete','$niveau','2','','',
'$longi','$lati',
'$ville','$gain','$gils','$prolongation')") or die ("Erreur");
admindisplay("La Quete a été Ajoutée.","Quete Effective");
}
else
{
admindisplay("Une erreur inattendue a empecher la création de la quete !","Erreur sur la Quete");
}
}

function quete () {

global $radio1;
$page = '
<form id="form1" name="form1" method="post" action="admin.php?do=createquete">
<label>Nom de la Quête
<input name="nomquete" type="text" id="nomquete" size="30" maxlength="50" />
</label>
<p>Entrez le texte du personnage <br />
<label>
<textarea name="textequete" cols="50" rows="10" id="textequete"></textarea>
</label>
</p>
<p>Entrez le niveau de la quete 
<label>
<input name="niveau" type="text" size="3" maxlength="3" />
</label>
</p>
<p>Entrez le gain en experience 
<label>
<input name="gain" type="text" size="3" maxlength="3" />
</label>
</p>
<p>Entrez le nombre de Monnaie gagnés 
<label>
<input name="Monnaie" type="text" size="3" maxlength="3" />
</label>
</p>
<p>Que doit faire la personne pour r&eacute;soudre la quete ?<br />
<label>
<input type="radio" name="radio1" value="1" />
Tuer des Monstres</label>
(Type de Monstres : 
<label>
<select name="typemonster" id="type monster">';
$query = mysql_query("SELECT * FROM rpg_monsters");
while( $req = mysql_fetch_array($query) )
{
$page .= '<option value="' . $req[1] . '">' . $req[1] . '</option>';
}
$page .='
</select>
</label>
et le nombre 
<label>
<input name="nbrmonster" type="text" id="nbrmonster" size="5" maxlength="5" />
</label>
)
<br />
<label>
<input type="radio" name="radio1" value="2" />
Trouver un Endroit Particulier </label>
(Longitude :
<label>
<input name="longi" type="text" id="longi" size="5" maxlength="5" />
</label> 
Lattitude :
<label>
<input name="lati" type="text" id="lati" size="5" maxlength="5" />
</label> 
) <br />
<!-- <label>
<input type="radio" name="radio1" value="3" />
Parler à quelqu\'un de spécifique</label>
-->
<br />
Choisissez la ville de d&eacute;part : 
<label>
<select name="ville" id="ville">';
$query = mysql_query("SELECT * FROM rpg_towns");
while( $req = mysql_fetch_array($query) )
{
$page .= '<option value="' . $req[1] . '">' . $req[1] . '</option>';
}


$page .= '
</select>
</label>
<br />Cette Quête est elle la prolongation d une autre quete ? <label>Oui<input type="radio" name="radio2" value="1" /></label><label>Non<input type="radio" name="radio2" value="2" /></label><br />
Si oui de quelle quête s agit t il ?
<label>
<select name="oldquest" id="oldquest">';

$query = mysql_query("SELECT * FROM rpg_quete");
while( $req = mysql_fetch_array($query) )
{
$page .= '<option value="' . $req[0] . '">' . $req[1] . '</option>';
}

$page .= '</select><br /><input type="submit" value="Envoyer" /> </p>
</form>';

admindisplay($page, "Créer les Quetes");
} 
?>