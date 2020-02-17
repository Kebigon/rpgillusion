<?php // index.php :: Index principal du jeu.
if (file_exists('install.php')) { die('Effacez le fichier <b>install.php</b>, si vous avez éffecué l\'installation'); }

error_reporting(E_ALL);
session_start();
  
include('kernel/functions.php');
include('kernel/display.php');
$link = opendb();

$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

if ($_SESSION == true) {
$userquery = doquery("SELECT * FROM {{table}} WHERE id='".addslashes($_SESSION['id'])."' LIMIT 1", "users");
$userrow = mysql_fetch_array($userquery);
}else{
$userrow = null;
}

if ($userrow == null) {
    if (isset($_GET["do"])) {
     if ($_GET["do"] == "verify") { header("Location: users.php?do=verify"); die(); }
	   if ($_GET["do"] == "flash") { flash(); die(); }
   }
  header("Location: login.php?do=login"); die(); 
}

// Jeu fermé
if ($controlrow["gameopen"] == 0) { display("Le jeu est actuellement fermé pour cause de maintenance"); die(); }
// Forcé la vérification de l'utilisateur.
if ($controlrow["verifyemail"] == 1 && $userrow["verify"] != 1) { header("Location: users.php?do=verify"); die(); }
// Compte bloqué.
if ($userrow["authlevel"] == 2) { die("Votre compte est bloqué!"); }

if(isset($_GET["do"])) {
  $do = explode(":",$_GET["do"]);
  switch ($do[0]) {
  case 'babblebox': babblebox(); break;
  case 'flash': flash(); break;
  case 'inn': include('towns.php'); inn(); break;  
  case 'buy': include('towns.php'); buy(); break;  
  case 'buy2': include('towns.php'); buy2($do[1]); break;
  case 'buy3': include('towns.php'); buy3($do[1]); break;
  case 'maps': include('towns.php'); maps(); break;  
  case 'maps2': include('towns.php'); maps2($do[1]); break;
  case 'maps3': include('towns.php'); maps3($do[1]); break;
  case 'gotown': include('towns.php'); travelto($do[1]); break;
  case 'move': include('explore.php'); move(); break;  
  case 'fight': include('fight.php'); fight(); break; 
  case 'victory': include('fight.php'); victory(); break;  
  case 'drop': include('fight.php'); drop(); break;  

  }  
} else { donothing(); }

function donothing() {
    
    global $userrow;

    if ($userrow["currentaction"] == "En ville") {
        $page = dotown();
        $title = "En ville";
    } elseif ($userrow["currentaction"] == "En exploration") {
        $page = doexplore();
        $title = "En exploration";
    } elseif ($userrow["currentaction"] == "En combat")  {
        $page = dofight();
        $title = "En combat";
    }
    
    display($page, $title);
    
}

function dotown() { // En ville.
    
    global $userrow, $controlrow;
	
	$townquery = doquery("SELECT id, name FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
    $townrow = mysql_fetch_array($townquery);
    $townrow["currenttownid"] = $townrow["id"];
    $townrow["currenttown"] = $townrow["name"];
   
    if ($controlrow["showbabble"] == 1) {// T'chat.
	$townrow["babble_warning"]= null;

	if (isset($_POST['chat'])) {
    extract($_POST);

    if (trim($chat) == "") {$townrow["babble_warning"] = '<div class="alerte_session">Votre texte est vide!</div><br >'; }
    elseif (preg_match("/^[#$%&*<|>^_`{|}~]/", $chat)) {$townrow["babble_warning"] = '<div class="alerte_session">Caractères non autorisés!</div><br >'; }

    else{
    $insert = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),author='".$userrow['charname']."',babble='".addslashes($chat)."'","babble"); } }
	
	$townrow["babblebox"] =  "<script type='text/javascript'>
    function rafraichir() {
        var xmlhttp = getHTTPObject();
        xmlhttp.open('POST','?do=babblebox',true);
        xmlhttp.send(null);
		setTimeout('rafraichir()', 1000);
    }
    rafraichir();
    </script><div id='page2' class='rose2'></div>";
    $townrow["babble_bottom"] ='<form action="" method="post" onSubmit="submit.disabled=true">
    <div style="text-align:center;"><input type="text" name="chat" size="26" maxlength="95" ><br ><input type="submit" name="submit" value="Envoyer" > <input type="reset" name="reset" value="Effacer" ></div></form>';

    } else {$townrow["babble_warning"] = 'Babble blox désactivé'; $townrow["babblebox"] = $townrow["babble_bottom"] = null; }   
	
	if ($controlrow["showonline"] == 1) {
    $onlinequery = doquery("SELECT charname FROM {{table}} WHERE UNIX_TIMESTAMP(onlinetime) >= '".(time()-600)."' ORDER BY charname", "users");
	
	if ( mysql_num_rows($onlinequery) >= 2){// Membres en ligne.
	$townrow["whosonline"] = '<b>'.mysql_num_rows($onlinequery).'</b> joueurs en ligne: ';
	}else{
	$townrow["whosonline"] = '<b>'.mysql_num_rows($onlinequery).'</b> joueur en ligne: ';}
	
    while ($onlinerow = mysql_fetch_array($onlinequery)) { $townrow["whosonline"] .='<span class="rose5">'.$onlinerow["charname"].'</span>, '; }
        $townrow["whosonline"] = rtrim($townrow["whosonline"], ', ');
    } else { $townrow["whosonline"] = 'Modules des joueurs en ligne désactivé'; }
    
	$page = gettemplate("towns");
    $page = parsetemplate($page, $townrow);
    
    return $page;
    
}


function doexplore() { // Page d'exploration..

global $userrow;
     
$page = '<img src="images/jeu/actions/exploration.jpg" width="580" height="82" alt="En exploration"><br><br>
Vous êtes actuellement en exploration mais rien ne s\'est produit, continuez à vous déplacer avec les boutons de navigation.<br><br>Votre position est: <b>Latitude '.$userrow['latitude'].', Longitude '.$userrow['longitude'].'</b>.<br><br>Maintenant vous pouvez:<br><br>
<form action="?do=move" method="post"><div>
<input name="east_x" type="submit" class="no_bordure" value="» aller à l\'est"><br><br>
<input name="west_x" type="submit" class="no_bordure" value="» aller à l\'ouest"><br><br>
<input name="south_x" type="submit" class="no_bordure" value="» aller au sud"><br><br>
<input name="north_x" type="submit" class="no_bordure" value="» aller au nord">
</div>
</form>';

    return $page;
        
}


function dofight() { // Redirection combat.
    
    header("Location: ?do=fight");
    
}


function babblebox() { // T'chat.
    
    global $userrow;
    include('class/bbcode.php');
	$text = new texte();
	
    $bg = 1;
    $babblequery = doquery("SELECT * FROM {{table}} ORDER BY id DESC LIMIT 8", "babble");
    $babblebox["content"] ='';  
    while ($babblerow = mysql_fetch_array($babblequery)) {
    $message = strip_tags($babblerow['babble']);
  
    if ($bg == 1) { $content = '<div class="rose1" style="margin-left:2px; margin-top:4px; margin-bottom:4px"><span class="taille1"><span class="rose5"><b>'.$babblerow['author'].':</b></span> '.utf8_encode($text->ms_format($message)).'</span></div>'; $bg = 2; }
    else { $content = '<div name="texte" class="rose2" style="margin-left:2px; margin-top:4px; margin-bottom:4px"><span class="taille1" ><span class="rose5"><b>'.$babblerow['author'].':</b></span> '.utf8_encode($text->ms_format($message)).'</div>'; $bg = 1; } 
    $babblebox["content"] .= $content;
  }

    $page = gettemplate("babblebox");
    echo parsetemplate($page, $babblebox);
    die();

}


function flash() {

    global $userrow;

    $historyquery = doquery("SELECT content, time FROM {{table}} ORDER BY id DESC", "history");
    $historyrow = mysql_fetch_array($historyquery);

    if (($userrow) == null) {

    $history = '&infoMAJ= '.$historyrow['content'].' - '.date('(H:i)', $historyrow['time']);
    $misc = '&messagerie=<img src="images/login/horloge.gif" hspace="0" vspace="-16">    <p><span class="mauve2"><b>'.datefrance(date('Y-m-d')).'</b></span></p>';
    }else{
    $history = '&infoMAJ='.$historyrow['content'].' - '.date("(H:i)", $historyrow['time']);
    $misc = '&messagerie=<img src="images/jeu/messagerie.gif" hspace="0" vspace="-14">    <p><span class="mauve2"><b>Bientot votre messagerie!</b></span></p>';
}
 
echo utf8_encode($history);
echo utf8_encode($misc);

}
?>