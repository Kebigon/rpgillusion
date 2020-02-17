<?php // modo.php :: modoration du script.

include('../lib.php');
include('../cookies.php');
include('../bbcode.php');
$link = opendb();
$userrow = checkcookies();
if ($userrow == false) { die("Merci de vous loger dans le <a href=\"../login.php?do=login\">jeu</a> avant d'utiliser le panneau de commande."); }
if ($userrow["authlevel"] != 3) { die("Vous devez avoir des privilèges d'modoistrateur pour employer le panneau de commande."); }
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

if (isset($_GET["do"])) {
    $do = explode(":",$_GET["do"]);

    if ($do[0] == "main") { main(); }
    elseif ($do[0] == "users") { users(); }
    elseif ($do[0] == "edituser") { edituser($do[1]); }
    elseif ($do[0] == "news") { addnews(); }
	elseif ($do[0] == "message") { message(); }
	elseif ($do[0] == "babble") { babble(); }
	elseif ($do[0] == "newsaccueil") { newsaccueil(); }


} else { donothing() ; }

function donothing() {
    
    $page = "Bienvenue sur la page de modération de RPG illusion. Ici vous pouvez modifier ou éditer librement plusieurs paramètres. <br><br> En cas de problème, veuillez contactez l'auteur de script à cette adresse : webmaster@rpgillusion.com<br><br><br><center><img src=\"../images/im_admin.gif\"/><br><br>Pour que RPG illusion perdure et que nous puissions financer de meilleurs services, nous vous invitons à faire un don du montant de votre choix. <font color=cc0000><b>Ceci est très important, car sans ces donations, le RPG pourrait <u>perdre sa licence open source et devenir payant</u> pour financer le développement du jeu.</b></font></span><br><br>
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
	
	mododisplay($page, "Administration");
    
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

        if ($errors == 0) {
            $query = doquery("UPDATE {{table}} SET gamename='$gamename',gamesize='$gamesize',forumtype='$forumtype',forumaddress='$forumaddress',compression='$compression',class1name='$class1name',class2name='$class2name',class3name='$class3name',diff1name='$diff1name',diff2name='$diff2name',diff3name='$diff3name',diff2mod='$diff2mod',diff3mod='$diff3mod',gameopen='$gameopen',verifyemail='$verifyemail',gameurl='$gameurl',modoemail='$modoemail',shownews='$shownews',showonline='$showonline',showbabble='$showbabble' WHERE id='1' LIMIT 1", "control");
            mododisplay("Réglages mis à jour.","Main Settings");
        } else {
            mododisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Menu des réglages");
        }
    }

    global $controlrow;

$page = "";
$controlrow["control"] = "";


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

	$page = template("control");
    $page = parsetemplate($page, $controlrow);
    mododisplay($page, "Réglages principaux");

}


    mododisplay($page, "Reglage des zones");




function users() {
    
    $query = doquery("SELECT id,username FROM {{table}} ORDER BY id", "users");
    $page = "<b><u>Editer les utilisateurs</u></b><br />Cliquez sur le nom d'un utilisateur pour éditer son compte.<br /><br /><table width=\"50%\">\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\"><a href=\"modo.php?do=edituser:".$row["id"]."\">".$row["username"]."</a></td></tr>\n"; $count = 2; }
        else { $page .= "<tr><td width=\"8%\" style=\"background-color: #ffffff;\">".$row["id"]."</td><td style=\"background-color: #ffffff;\"><a href=\"modo.php?do=edituser:".$row["id"]."\">".$row["username"]."</a></td></tr>\n"; $count = 1; }
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">Pas de sorts trouvés.</td></tr>\n"; }
    $page .= "</table>";
    mododisplay($page, "Editer utilisateurs");

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
            mododisplay("Utilisateur mis à jour.","Editer utilisateurs");
        } else {
            mododisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les utilsateurs");
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
<form action="modo.php?do=edituser:$id" method="post">
<table width="90%">
<tr><td width="20%">Joueur numéro:</td><td>{{id}}</td></tr>
<tr><td width="20%">ID:</td><td>{{username}}</td></tr>
<tr><td width="20%">Avatar classe:</td><td><img src="../images/avatar/num-{{avatar}}.gif" width="71" height="66"></td></tr>
<tr><td width="20%">Email:</td><td><input type="text" name="email" size="30" maxlength="100" value="{{email}}" /></td></tr>
<tr><td width="20%">Verifié:</td><td><input type="text" name="verify" size="30" maxlength="8" value="{{verify}}" /></td></tr>
<tr><td width="20%">Nom du personnage:</td><td><input type="text" name="charname" size="30" maxlength="30" value="{{charname}}" /></td></tr>
<tr><td width="20%">Date d'inscription:</td><td>{{regdate}}</td></tr>
<tr><td width="20%">Dernière fois en ligne:</td><td>{{onlinetime}}</td></tr>
<tr><td width="20%">Niv. d'accès:</td><td><select name="authlevel"><option value="0" {{auth0select}}>Simple joueur</option><option value="3" {{auth3select}}>Moderateur</option><option value="2" {{auth2select}}>Bloqué</option></select><br /><span class="small">Sélectionnez "bloqué" pour empêcher un utilisateur d'accèder au jeu.</span></td></tr>

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
    mododisplay($page, "Editer utilisateurs");
    
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
			mododisplay("La nouvelle vient d'êtres ajouté.","Ajouter une nouvelle");
        } else {
            mododisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Ajouter une nouvelle");
        }

    }

$page = <<<END
<b><u>Ajouter une nouvelle</u></b><br /><br />
<form action="modo.php?do=news" method="post">
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

    mododisplay($page, "Ajouter une nouvelle");

}




function message()
{
$page .= "<table align=\"center\" width=\"380\" cellspacing=\"0\" cellpadding=\"0\"><tr><td background=\"../images/bloc_graphic1/bloc_01.gif\"></td>";
$page .= "<td background=\"../images/bloc_graphic1/bloc_02.gif\" height=\"17px\"></td>";
$page .= "<td background=\"../images/bloc_graphic1/bloc_03.gif\"></td></tr>";
$page .= "<tr><td background=\"../images/bloc_graphic1/bloc_04.gif\" width=\"17px\"></td>";
$page .= "<td align=\"center\" background=\"../images/bloc_graphic1/bloc_05.gif\"  height=\"60px\">";
							
//On regarde si le formulaire a été validé
    if (!isset ($_POST['envoi'])){
    $page .= '<center>Vous pouvez envoyer ici un email aux membres.<br>Il vous suffit de remplir le formulaire ci dessous et d&acute;envoyer!!<br><br>
    <form action="'.$_SERVER['PHP_SELF'].'?do=message" method=POST>
    L&acute;email qui apparaitra en expediteur:<br><input type=text name=email_expediteur size=20><br>Sujet du mail:<br><input type=text name=sujet_mail size=20><br><br>
    Votre message <br><textarea rows=20 name=message_envoi cols=55></textarea><br><br><input type=submit name=envoi value="Envoyer le message"><br><br></form><a href=\'modo.php\'>Retour</a>';
    }
    else{
    //On regarde si tous les champs ont été remplis
   if (empty ($_POST['email_expediteur']) || empty ($_POST['sujet_mail']) || empty ($_POST['message_envoi'])){
   $page .= '<strong>Erreur</strong>';
   }
   else{
   //On sélectionne tous les emails et on envoie le message
   $selection="select * from maf_users where id";
   $sql=mysql_query($selection);
       while ($a_row=mysql_fetch_assoc($sql)){
        //La récupération étant terminée, on envoie le message à chaque membre!
       $to .= $a_row[email];
       $sujet .= $_POST[sujet_mail];
       //--- la structure du mail ----//
       $from  .= "From:$_POST[email_expediteur]\n";
       $from .= "MIME-version: 1.0\n";
       $from .= "Content-type: text/html; charset= iso-8859-1\n";
 //--- Corps du message ---//
       $message_def=$_POST[message_envoi];
       //--- on envoie l'email ---//
       mail($to,$sujet,$message_def,$from);
       }
   $page .= '<strong>Erreur</strong>';
   }
    }
						$page .= "</td><td background=\"../images/bloc_graphic1/bloc_06.gif\" width=\"17px\"></td></tr>";
						$page .= "<tr><td background=\"../images/bloc_graphic1/bloc_07.gif\"></td>";
						$page .= "<td background=\"../images/bloc_graphic1/bloc_08.gif\"  height=\"17px\"></td>";
						$page .= "<td background=\"../images/bloc_graphic1/bloc_09.gif\"></td></tr></table>";	
						
	mododisplay($page, "Message");
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
            mododisplay("La new a été Ajoutée.","Editer la new 1");
        } else {
            mododisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer la new");
        }

    }


$page = '
<b><u>Editer les news</u></b><br /><br />
<form method="post" action="modo.php?do=newsaccueil">
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

    mododisplay($page, "Editer les news");

}

function babble() 
{    
if (isset($_POST["submit"])) 
{ 
mysql_query("TRUNCATE TABLE `rpg_babble`"); 
} 
$page = ' 
<b><u> Vider Le Chat box </u></b><br /><br /> 
<form method="post" action="modo.php?do=babble"> 
<input type="submit" name="submit" value="Valider" /> 
<br><br><b><font color="red">! Attention !</font></b> Vider le babble entrenera la perte de tout les messages figurant dedans, il sera impossible de les récupérer ! 
</form> 
'; 
  if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        
        if ($errors == 0) { 
           
            mododisplay("La chatbox à été vidée","vider le chatbox");
        } else {
            mododisplay("<b>Erreurs:</b><br /><div style=\"color:red;\">$errorlist</div><br />Veuillez retourner et essayer encore.", "Editer les blocs");
        }        
        
    } 
  mododisplay($page, "vider le chatbox"); 
} 
?>