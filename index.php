<?php // index.php :: Page principal.

header('P3P: CP="NON ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');

if (file_exists('install.php')) { die("Merci d'éffacer <b>install.php</b> pour pouvoir continuer."); }
include('lib.php');
include('cookies.php');
include('bbcode.php');
$link = opendb();
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

// Vérification si vous êtes logé ou pas.
$userrow = checkcookies();
if ($userrow == false) { 
    if (isset($_GET["do"])) {
        if ($_GET["do"] == "verify") { header("Location: users.php?do=verify"); die(); }
    }
    header("Location: login.php?do=login"); die(); 
}
// Jeu fermé ou en maintenance.
if ($controlrow["gameopen"] == 0 && $userrow["authlevel"] == 0) { display("<center></center><br><br>Le jeu est actuellement fermé pour cause de maintenance. Merci de revenir plus tard.","Jeu fermé"); die(); }
// Forcer la vérification de l'utilisateur.
if ($controlrow["verifyemail"] == 1 && $userrow["verify"] != 1) { header("Location: users.php?do=verify"); die(); }
// Bloquer/bannir un utilisateur.
if ($userrow["authlevel"] == 2) { die("votre compte a été bloqué. Veuillez réessayer plus tard."); }

if (isset($_GET["do"])) {
    $do = explode(":",$_GET["do"]);
    
    
 // Fonction villes.
    if ($do[0] == "inn") { include('towns.php'); inn(); }
	elseif ($do[0] == "enchanteur") {include('towns.php'); enchanteur(); }
    elseif ($do[0] == "pretre") {include('towns.php'); pretre(); }
	elseif ($do[0] == "cheatbanque") {include('towns.php'); cheatbanque(); } 
	elseif ($do[0] == "cheatniveau") {include('towns.php'); cheatniveau(); }
	elseif ($do[0] == "cheatptlevel") {include('towns.php'); cheatptlevel(); } 
	elseif ($do[0] == "cheatxp") {include('towns.php'); cheatxp(); }
	elseif ($do[0] == "post_comment") { include('comments_mod.php'); addpost($do[1]); }
    elseif ($do[0] == "comments") { include('comments_mod.php'); read($do[1]); }
	elseif ($do[0] == "bank") { include('towns.php'); bank(); }
    elseif ($do[0] == "service") { include('towns.php'); service(); }
    elseif ($do[0] == "sell") { include('towns.php'); sell(); }
    elseif ($do[0] == "gotown") { include('towns.php'); travelto($do[1]); }
	elseif ($do[0] == "towninf") { include('towninf.php'); towninf(); }
	elseif ($do[0] == "metier") { include('anpe.php'); metier();}
	elseif ($do[0] == "travail") { include('anpe.php'); travail();}
 
 // Fonction enchères 
    elseif ($do[0] == "encheres") { include('encheres.php'); encheres(); }
	elseif ($do[0] == "vente2") { include('encheres.php'); vente2($do[1]); }
	elseif ($do[0] == "vente3") { include('encheres.php'); vente3($do[1]); }
	elseif ($do[0] == "afficheencheres") { include('encheres.php'); afficheencheres(); }
	elseif ($do[0] == "encheres2") { include('encheres.php'); encheres2($do[1]); }
	elseif ($do[0] == "encheres3") { include('encheres.php'); encheres3($do[1]); }
 
 // Fontion joueurs.
    elseif ($do[0] == "delete") { include('delete.php'); delete();} 
    elseif ($do[0] == "deleteuser") { include('delete.php'); deleteuser();}
    elseif ($do[0] == "point") { include('towns.php'); point($do[1]); }
    elseif ($do[0] == "profil") { include('towns.php'); profil();}
	elseif ($do[0] == "classement") { include('classement.php'); classement($do[1]); }
	elseif ($do[0] == "av") { include('towns.php'); av(); }


 // Fontion quete.	
	elseif ($do[0] == "affaire") { include('quete.php'); liste(); }
	elseif ($do[0] == "journal") { include('quete.php'); journal(); }
    elseif ($do[0] == "accept") { include('quete.php'); accept(); }

 // Fontion magasin.
	elseif ($do[0] == "marche") { include('towns.php'); marche($do[1]); }
    elseif ($do[0] == "marche2") { include('towns.php'); marche2($do[1]); }
    elseif ($do[0] == "marche3") { include('towns.php'); marche3($do[1]); }
	elseif ($do[0] == "maps") { include('towns.php'); maps(); }
    elseif ($do[0] == "maps2") { include('towns.php'); maps2($do[1]); }
    elseif ($do[0] == "maps3") { include('towns.php'); maps3($do[1]); }
	elseif ($do[0] == "buy") { include('towns.php'); buy(); }
    elseif ($do[0] == "buy2") { include('towns.php'); buy2($do[1]); }
    elseif ($do[0] == "buy3") { include('towns.php'); buy3($do[1]); }
	elseif ($do[0] == "revente") { include('towns.php'); revente(); }
	elseif ($do[0] == "mag") { include('towns.php'); mag(); }
    elseif ($do[0] == "mag2") { include('towns.php'); mag2($do[1]); }
    elseif ($do[0] == "mag3") { include('towns.php'); mag3($do[1]); }
 
 // Fontion de la banque.
    elseif ($do[0] == "stockobjets") { include('bank.php'); stockobjets(); }
	elseif ($do[0] == "stockobjets31") { include('bank.php'); stockobjets31(); }
	elseif ($do[0] == "stockobjets32") { include('bank.php'); stockobjets32(); }
	elseif ($do[0] == "stockobjets33") { include('bank.php'); stockobjets33(); }
	elseif ($do[0] == "stockobjets21") { include('bank.php'); stockobjets21(); }
	elseif ($do[0] == "stockobjets22") { include('bank.php'); stockobjets22(); }
	elseif ($do[0] == "stockobjets23") { include('bank.php'); stockobjets23(); }
	elseif ($do[0] == "sendgold") { include('bank.php'); sendgold(); }
	elseif ($do[0] == "sendpotion") { include('bank.php'); sendpotion(); }
	elseif ($do[0] == "sendeat") { include('bank.php'); sendeat(); }
 
 // Fontion clans.
    elseif ($do[0] == "lahku") { include('clan.php'); lahku(); }
    elseif ($do[0] == "teekamp") { include('clan.php'); teekamp(); }
    elseif ($do[0] == "auaste") { include('clan.php'); auaste($do[1]); }
    elseif ($do[0] == "kick") { include('clan.php'); kick($do[1]); }
    elseif ($do[0] == "yes") { include('clan.php'); yes($do[1]); }
    elseif ($do[0] == "no") { include('clan.php'); no($do[1]); }
    elseif ($do[0] == "liitu") { include('clan.php'); liitu($do[1]); }
    elseif ($do[0] == "kamp") { include('clan.php'); kamp(); }
	elseif ($do[0] == "suppr") { include('clan.php'); suppr(); }
 
 // Fontion maison.
	elseif ($do[0] == "home") { include('towns.php'); home(); }
	elseif ($do[0] == "reposhome") { include('home.php'); reposhome(); }
	elseif ($do[0] == "bierrehome") { include('home.php'); bierrehome(); }
	elseif ($do[0] == "trainhome") { include('home.php'); trainhome(); }
	elseif ($do[0] == "msg") { include('home.php'); msg(); }
	elseif ($do[0] == "admin_maison") { include('home.php'); admin_maison(); }
    
 // Fontion exploration.
    elseif ($do[0] == "move") { include('explore.php'); move(); }
    elseif ($do[0] == "chat") { include('explore.php'); chat(); }
    elseif ($do[0] == "sacados") { sacados(); }
	elseif ($do[0] == "cherche") { include('explore.php'); cherche(); }
    elseif ($do[0] == "potionsoins") { include('explore.php'); potionsoins(); }
    elseif ($do[0] == "nourriture") { include('explore.php'); nourriture(); }
    elseif ($do[0] == "potiontp") { include('explore.php'); potiontp(); }
    elseif ($do[0] == "move2") {include('explore.php'); move2(); }

 // Fonction Entraînement
	elseif ($do[0] == "train") { include('train.php'); fight(); }	
	elseif ($do[0] == "trainvictory") { include('train.php'); trainvictory(); }
    elseif ($do[0] == "traindrop") { include('train.php'); drop(); }
    elseif ($do[0] == "traindead") { include('train.php'); dead(); }

 // Fonction combat.
    elseif ($do[0] == "fight") { include('fight.php'); fight(); }
    elseif ($do[0] == "victory") { include('fight.php'); victory(); }
    elseif ($do[0] == "drop") { include('fight.php'); drop(); }
    elseif ($do[0] == "dead") { include('fight.php'); dead(); }
    
 // Fonction magie.
    elseif ($do[0] == "verify") { header("Location: users.php?do=verify"); die(); }
    elseif ($do[0] == "spell") { include('heal.php'); healspells($do[1]); }
    elseif ($do[0] == "showchar") { showchar(); }
    elseif ($do[0] == "onlinechar") { onlinechar($do[1]); }
    elseif ($do[0] == "showmap") { showmap(); }
    elseif ($do[0] == "babblebox") { babblebox(); }
    elseif ($do[0] == "ninja") { ninja(); }
    
} else { donothing(); }


function donothing() {
    
    global $userrow;

    if ($userrow["currentaction"] == "En ville") {
        $page = dotown();
        $title = "En ville";
    } elseif ($userrow["currentaction"] == "En exploration") {
        $page = doexplore();
        $title = "En exploration";
    } elseif ($userrow["currentaction"] == "En maison") {
        $page = dohome();
        $title = "En maison";
    } elseif ($userrow["currentaction"] == "En combat")  {
        $page = dofight();
        $title = "En combat";
    }
    
    display($page, $title);
    
}

function dotown() { // Les 2 modules du bas de l'index.
    
    global $userrow, $controlrow, $numqueries;
    
    $townquery = doquery("SELECT * FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
    if (mysql_num_rows($townquery) == 0) { display("Il y a une erreur avec votre compte d'utilisateur, ou avec les données de la ville.  Veuillez réessayer encore.","Erreur"); }
    $townrow = mysql_fetch_array($townquery);

  
    // Dernières nouvelles - affichage de la dernière news dans toutes les villes .
if ($controlrow["shownews"] == 1) { 
        $newsquery = doquery("SELECT * FROM {{table}} ORDER BY id DESC LIMIT 1", "news");
		$texte = new texte();
        $newsrow = mysql_fetch_array($newsquery);
        $townrow["news"] = "<table width=\"500px\"><tr><td class=\"title\"> &nbsp;<img src=\"././images/titre_news.gif\" alt=\"Dernière news\" /></td></tr><tr><td>\n";
        $townrow["news"] .= "<span class=\"light\">[".prettydate($newsrow["postdate"])."]</span><br />".$texte->ms_format($newsrow["content"]);
        $townrow["news"] .= "<br><br>Posté par: <b><i>".$newsrow["author"]."</b></u></td></tr></table>\n";
		$numquery = doquery("SELECT * FROM {{table}} WHERE topic=".$newsrow['id']."", "comments");
		$comments = mysql_num_rows($numquery);
		$townrow["news"] .= "<br /><a href=index.php?do=comments:".$newsrow['id'].">Commentaires</a> ($comments)";
    } else { $townrow["news"] = ""; }
    
    // Qui est en ligne? - affichage des membres qui sont actullement en ligne.
	if ($controlrow["showonline"] == 1) {
	$onlinequery = doquery("SELECT * FROM {{table}} WHERE UNIX_TIMESTAMP(onlinetime) >= '".(time()-600)."' ORDER BY charname", "users");
	$townrow["whosonline"] = "<table width=\"210px\"><tr><td class=\"title\"><img src=\"././images/ville/enligne.gif\" /></td></tr><tr><td>\n";
	$townrow["whosonline"] .= "Il y a <b>" . mysql_num_rows($onlinequery) . "</b> joueur(s) en ligne: ";
	while ($onlinerow = mysql_fetch_array($onlinequery))
	{ 
	if($onlinerow[authlevel] == "1"){ $color = "#CC0000"; }
	elseif($onlinerow[authlevel] == "0") { $color = "#000000"; }
	elseif($onlinerow[authlevel] == "3") { $color = "#009966"; }
	$townrow["whosonline"] .= "<a href=\"index.php?do=onlinechar:".$onlinerow["id"]."\"><font color='".$color."'>".$onlinerow["charname"]."</a></font>" . ", ";
	}
	$townrow["whosonline"] = rtrim($townrow["whosonline"], ", ");
	$townrow["whosonline"] .= "</td></tr></table>\n";
	} else { $townrow["whosonline"] = ""; }
    
    if ($controlrow["showbabble"] == 1) {
        $townrow["babblebox"] = "<table width=\"210px\"><tr><td class=\"title\"><img src=\"././images/ville/chat.gif\" /></td></tr><tr><td>\n";
        $townrow["babblebox"] .= "<iframe src=\"index.php?do=babblebox\" name=\"sbox\" width=\"210px\" height=\"360\" frameborder=\"0\" id=\"bbox\">Votre navigateur ne supporte pas les frames! La boite de dialogue n'est pas disponible pour vous. Nous vous conseillons d'utiliser ce <a href=\"http://www.mozilla.org\" target=\"_new\">Navigateur gratuit</a>.</iframe>";
        $townrow["babblebox"] .= "</td></tr></table>\n";
    } else { $townrow["babblebox"] = ""; }
    
    $page = gettemplate("towns");
    $page = parsetemplate($page, $townrow);
    
    return $page;
    }
	
// Fonction pour afficher le menu des ville + chat box	
function dohome() { 
    
    global $userrow, $controlrow, $numqueries;
    
    $homequery = doquery("SELECT * FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "maison");
    if (mysql_num_rows($homequery) == 0) { display("Il y a une erreur avec votre compte d'utilisateur, ou avec les données de la maison.   Veuillez réessayer encore.","Erreur"); }
    $homerow = mysql_fetch_array($homequery);

  
 // Dernières nouvelles - affichage de la dernière news dans toutes les villes .
    if ($controlrow["shownews"] == 1) { 
        $newsquery = doquery("SELECT * FROM {{table}} ORDER BY id DESC LIMIT 1", "news");
        $newsrow = mysql_fetch_array($newsquery);
        $homerow["news"] = "<center><table width=\"500px\"><tr><td class=\"title\"> &nbsp;<img src=\"././images/titre_news.gif\" alt=\"Dernière news\" /></td></tr><tr><td>\n";
        $homerow["news"] .= "<span class=\"light\">[".prettydate($newsrow["postdate"])."]</span><br />".nl2br($newsrow["content"]);
        $homerow["news"] .= "</td></tr></table>\n";
		$numquery = doquery("SELECT * FROM {{table}} WHERE topic=".$newsrow['id']."", "comments");
		$comments = mysql_num_rows($numquery);
		$homerow["news"] .= "<br /><a href=index.php?do=comments:".$newsrow['id'].">Commentaires</a> ($comments)";
    } else { $homerow["news"] = ""; }
    
    // Qui est en ligne? - affichage des membres qui sont actullement en ligne.
    if ($controlrow["showonline"] == 1) {
        $onlinequery = doquery("SELECT * FROM {{table}} WHERE UNIX_TIMESTAMP(onlinetime) >= '".(time()-600)."' ORDER BY charname", "users");
        $homerow["whosonline"] = "<table width=\"210px\"><tr><td class=\"title\"><img src=\"././images/ville/enligne.gif\" /></td></tr><tr><td>\n";
        $homerow["whosonline"] .= "Il y a <b>" . mysql_num_rows($onlinequery) . "</b> joueur(s) en ligne: ";
        while ($onlinerow = mysql_fetch_array($onlinequery)) { $homerow["whosonline"] .= "<a href=\"index.php?do=onlinechar:".$onlinerow["id"]."\">".$onlinerow["charname"]."</a>" . ", "; }
        $homerow["whosonline"] = rtrim($homerow["whosonline"], ", ");
        $homerow["whosonline"] .= "</td></tr></table>\n";
    } else { $homerow["whosonline"] = ""; }
    
    if ($controlrow["showbabble"] == 1) {
        $homerow["babblebox"] = "<table width=\"210px\"><tr><td class=\"title\"><img src=\"././images/ville/chat.gif\" /></td></tr><tr><td>\n";
        $homerow["babblebox"] .= "<iframe src=\"index.php?do=babblebox\" name=\"sbox\" width=\"210px\" height=\"360\" frameborder=\"0\" id=\"bbox\">Votre navigateur ne supporte pas les frames! La boite de dialogue n'est pas disponible pour vous. Nous vous conseillons d'utiliser ce <a href=\"http://www.mozilla.org\" target=\"_new\">Navigateur gratuit</a>.</iframe>";
        $homerow["babblebox"] .= "</td></tr></table>\n";
    } else { $homerow["babblebox"] = ""; }
    
    $page = gettemplate("home");
    $page = parsetemplate($page, $homerow);
    
    return $page;

   }	

  function chat() {///Affichage du chat
        $townrow["babblebox"] = "<table width=\"210px\"><tr><td class=\"title\"><img src=\"././images/ville/chat.gif\" /></td></tr><tr><td>\n";
        $townrow["babblebox"] .= "<iframe src=\"index.php?do=babblebox\" name=\"sbox\" width=\"210px\" height=\"360\" frameborder=\"0\" id=\"bbox\">Votre navigateur ne supporte pas les frames! La boite de dialogue n'est pas disponible pour vous. Nous vous conseillons d'utiliser ce <a href=\"http://www.mozilla.org\" target=\"_new\">Navigateur gratuit</a>.</iframe>";
        $townrow["babblebox"] .= "</td></tr></table>\n";
}

function doexplore() { // Affichage lors de l'exploration.
    
    // Affichage normal de l'exploration sans aucuns évenements particulier.
	
$page = <<<END
<table width="120px">
<tr><td class="title"><img src="images/title_exploring.gif" alt="En exploration" /></td></tr>
<tr><td>
<tr><td><center><a href="index.php?do=cherche">Chercher des ressources</a> - <a href="index.php?do=potionsoins">Prendre une Potion de soins</a> - <a href="index.php?do=nourriture">Manger</a> - <a href="index.php?do=potiontp">Recuperer les TP</a></center></tr></td>
</td></tr>
</table>
<center><iframe src="./map.php" name="carte" width="490" height="550" align="middle" scrolling="No" frameborder="0" allowtransparency="true"></iframe><center>
<br>
<iframe src="index.php?do=babblebox" width=\"400px\" height=\"800\" frameborder=\"0\"></iframe>

END;
    return $page;
        
}

function dofight() { // Redirection pour le combat.
    
    header("Location: index.php?do=fight");
    
}

function showchar() {
    
    global $userrow, $controlrow;
    
    // Récompense rubis/bonus en fonction de plusieurs paramètres.
    $userrow["experience"] = number_format($userrow["experience"]);
    $userrow["gold"] = number_format($userrow["gold"]);
    if ($userrow["expbonus"] > 0) { 
        $userrow["plusexp"] = "<span class=\"light\">(+".$userrow["expbonus"]."%)</span>"; 
    } elseif ($userrow["expbonus"] < 0) {
        $userrow["plusexp"] = "<span class=\"light\">(".$userrow["expbonus"]."%)</span>";
    } else { $userrow["plusexp"] = ""; }
    if ($userrow["goldbonus"] > 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(+".$userrow["goldbonus"]."%)</span>"; 
    } elseif ($userrow["goldbonus"] < 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(".$userrow["goldbonus"]."%)</span>";
    } else { $userrow["plusgold"] = ""; }
    
    $levelquery = doquery("SELECT ". $userrow["charclass"]."_exp FROM {{table}} WHERE id='".($userrow["level"]+1)."' LIMIT 1", "levels");
    $levelrow = mysql_fetch_array($levelquery);
    if ($userrow["level"] < 99) { $userrow["nextlevel"] = number_format($levelrow[$userrow["charclass"]."_exp"]); } else { $userrow["nextlevel"] = "<span class=\"light\">Aucun</span>"; }

    if ($userrow["charclass"] == 1) { $userrow["charclass"] = $controlrow["class1name"]; }
    elseif ($userrow["charclass"] == 2) { $userrow["charclass"] = $controlrow["class2name"]; }
    elseif ($userrow["charclass"] == 3) { $userrow["charclass"] = $controlrow["class3name"]; }
    
    if ($userrow["difficulty"] == 1) { $userrow["difficulty"] = $controlrow["diff1name"]; }
    elseif ($userrow["difficulty"] == 2) { $userrow["difficulty"] = $controlrow["diff2name"]; }
    elseif ($userrow["difficulty"] == 3) { $userrow["difficulty"] = $controlrow["diff3name"]; }
    
    $spellquery = doquery("SELECT id,name FROM {{table}}","spells");
    $userspells = explode(",",$userrow["spells"]);
    $userrow["magiclist"] = "";
    while ($spellrow = mysql_fetch_array($spellquery)) {
        $spell = false;
        foreach($userspells as $a => $b) {
            if ($b == $spellrow["id"]) { $spell = true; }
        }
        if ($spell == true) {
            $userrow["magiclist"] .= $spellrow["name"]."<br />";
        }
    }
    if ($userrow["magiclist"] == "") { $userrow["magiclist"] = "Aucun"; }
    
    // Tags pour la validation XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//FR\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
    
    $charsheet = gettemplate("showchar");
    $page = $xml . gettemplate("minimal");
    $array = array("content"=>parsetemplate($charsheet, $userrow), "title"=>"Infos du personnage");
    echo parsetemplate($page, $array);
    die();
    
}

function onlinechar($id) {
    
    global $controlrow;
    $userquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "users");
    if (mysql_num_rows($userquery) == 1) { $userrow = mysql_fetch_array($userquery); } else { display("Votre ID n'est pas reconnu.", "Erreur"); }
    
    // Récompense rubis/bonus en fonction de plusieurs paramètres.
    $userrow["experience"] = number_format($userrow["experience"]);
    $userrow["gold"] = number_format($userrow["gold"]);
    if ($userrow["expbonus"] > 0) { 
        $userrow["plusexp"] = "<span class=\"light\">(+".$userrow["expbonus"]."%)</span>"; 
    } elseif ($userrow["expbonus"] < 0) {
        $userrow["plusexp"] = "<span class=\"light\">(".$userrow["expbonus"]."%)</span>";
    } else { $userrow["plusexp"] = ""; }
    if ($userrow["goldbonus"] > 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(+".$userrow["goldbonus"]."%)</span>"; 
    } elseif ($userrow["goldbonus"] < 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(".$userrow["goldbonus"]."%)</span>";
    } else { $userrow["plusgold"] = ""; }
    
    $levelquery = doquery("SELECT ". $userrow["charclass"]."_exp FROM {{table}} WHERE id='".($userrow["level"]+1)."' LIMIT 1", "levels");
    $levelrow = mysql_fetch_array($levelquery);
    $userrow["nextlevel"] = number_format($levelrow[$userrow["charclass"]."_exp"]);

    if ($userrow["charclass"] == 1) { $userrow["charclass"] = $controlrow["class1name"]; }
    elseif ($userrow["charclass"] == 2) { $userrow["charclass"] = $controlrow["class2name"]; }
    elseif ($userrow["charclass"] == 3) { $userrow["charclass"] = $controlrow["class3name"]; }
    
    if ($userrow["difficulty"] == 1) { $userrow["difficulty"] = $controlrow["diff1name"]; }
    elseif ($userrow["difficulty"] == 2) { $userrow["difficulty"] = $controlrow["diff2name"]; }
    elseif ($userrow["difficulty"] == 3) { $userrow["difficulty"] = $controlrow["diff3name"]; }
    
    $charsheet = gettemplate("onlinechar");
    $page = parsetemplate($charsheet, $userrow);
    display($page, "Informations du personnage");
    
}

function showmap() {
    
    global $userrow; 
    
    // Make page tags for XHTML validation.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    
    $page = $xml . gettemplate("minimal");
    $time = time();
    $array = array("content"=>"<div id=\"map\"><img src=\"index.php?do=makemap&time=$time\" alt=\"Map\" border=\"0\" /></div></center>", "title"=>"Map");
    echo parsetemplate($page, $array);
    die();
    
}

if ($do[0] == "makemap") { makemap(); }
function makemap() {
	global $userrow, $controlrow;
	$latitude = $userrow["latitude"];
	$longitude = $userrow["longitude"];
	$map = imageCreate(500,500);
	$magenta = ImageColorAllocate($map, 255, 0, 255);
	$red = imageColorAllocate($map, 211, 0, 0);
	ImageColorTransparent($map, $magenta);
	imageFilledEllipse($map, ($longitude + 250), (-$latitude + 250), 10, 10, $red);
	header("Content-type: image/png");
	imagePNG($map);
	imageDestroy($map);
}

function babblebox() {
    
    global $userrow;
    
    if (isset($_POST["submit_x"])) {
        $safecontent = my_htmlspecialchars($_POST["babble"]);
        if ($safecontent == "" || $safecontent == " ") { // Post de la boite de dialogues.
        } else { $insert = doquery("INSERT INTO {{table}} SET id='',posttime=NOW(),author='".$userrow["charname"]."',babble='$safecontent'", "babble"); }
        header("Location: index.php?do=babblebox");
        die();
    }
    $texte = new texte();
    $babblebox = array("content"=>"");
    $bg = 1;
    $babblequery = doquery("SELECT * FROM {{table}} ORDER BY id DESC LIMIT 20", "babble");
    while ($babblerow = mysql_fetch_array($babblequery)) {
        if ($bg == 1) { $new = "<center><div style=\"width:185px; background-color:#eeeeee;\">[<b>".$babblerow["author"]."</b>] ".$texte->ms_format($babblerow["babble"])."</div></center>\n"; $bg = 2; }
        else { $new = "<center><div style=\"width:185px; background-color:#ffffff;\">[<b>".$babblerow["author"]."</b>] ".$texte->ms_format(stripslashes($babblerow["babble"]))."</div></center>\n"; $bg = 1; } 
        $babblebox["content"] = $new . $babblebox["content"];
    }
    $babblebox["content"] .= "<center><form action=\"index.php?do=babblebox\" method=\"post\"><input type=\"text\" name=\"babble\" size=\"27\" maxlength=\"110\" /><input type=\"image\" style=\"background-color:#E0E0E0\" name=\"submit\" src=\"././images/bouton_envoyer.gif\" value=\"Envoyer\" /><input  type=\"image\" style=\"background-color:#E0E0E0\" name=\"reset\" src=\"././images/bouton_effacer.gif\" value=\"Effacer\" /></form></center>";
    
    // Tags pour la validation XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//FR\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";
    $page = $xml . gettemplate("babblebox");
    echo parsetemplate($page, $babblebox);
    die();

}

function ninja() {
    header("Location: ././images/intro.gif");
}

function sacados() {
global $userrow, $page, $title;
$page ='<center><img src="images/sac.gif"></center>
<center>Voici le contenu de votre sac à dos pour<br> utiliser ces objet alez en exploration et regarder au dessus de la carte :</center><br><br><br>
<center></center>
<center><table>
<tr><td width="180px"><b>Objets:</b></td></tr> 
<tr><td><img src="images/pic.gif" alt="Nouriture" title="Nouriture" />Nouriture :</td><td >x'.$userrow["itemsac6qt"].'</a></td> 
<tr><td><img src="images/pic.gif" alt="Potion Soin" title="Potion Soin" />Potion de Soin :</td><td >x'.$userrow["itemsac1qt"].'</a></td>
<tr><td><img src="images/pic.gif" alt="Potion Mana" title="Potion Mana" />Restauration de Mana :</td><td >x'.$userrow["itemsac2qt"].'</a></td>
<tr><td><img src="images/pic.gif" alt="Antidote" title="Antidode" />Antidote :</td><td >x'.$userrow["itemsac4qt"].'</a></td></tr> 
<tr><td><img src="images/pic.gif" alt="Potion de Vigueur" title="Potion de Vigueur" />Potion de Tp :</td><td >x'.$userrow["itemsac5qt"].'</a></td></tr> 
<tr><td><img src="images/pic.gif" alt="item6" title="objet6" />Pioche</td><td >'.$userrow["itemsac3qt"].'</td></tr>
</table>
<br><br><br>
<table>
<tr><td width="180px"><b>Ressources:</b></td></tr> 
<tr><td><img src="images/pic.gif" alt="cuivre" title="cuivre" />Cuivre :</td><td >'.$userrow["cuivre"].'</td></tr> 
<tr><td><img src="images/pic.gif" alt="fer" title="cuivre" />Fer :</td><td >'.$userrow["fer"].'</td></tr> 
<tr><td><img src="images/pic.gif" alt="argent" title="argent" />Argent :</td><td >'.$userrow["argent"].'</td></tr> 
<tr><td><img src="images/pic.gif" alt="fer" title="platine" />Platine :</td><td >'.$userrow["platine"].'</td></tr>
</table>';
$title = 'Votre sac à dos';
display($page, $title);
    }
?>
