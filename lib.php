<?php // lib.php :: Les fontions essentielles au script.

$starttime = getmicrotime();
$numqueries = 0;
$version = "1.2a";
$build = "";

function opendb() { // Ouverture de la bdd.

    include('config.php');
    extract($dbsettings);
    $link = mysql_connect($server, $user, $pass) or die(mysql_error());
    mysql_select_db($name) or die(mysql_error());
    return $link;

}

function doquery($query, $table) { // Selection des tables.
    
    include('config.php');
    global $numqueries;
    $sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"] . "_" . $table, $query)) or die(mysql_error());
    $numqueries++;
    return $sqlquery;

}

function gettemplate($templatename) { // SQL query pour les templates.

    $filename = "templates/" . $templatename . ".php";
    include("$filename");
    return $template;
    
}

function parsetemplate($template, $array) { // Replacement des templates avec proper content.
    
    foreach($array as $a => $b) {
        $template = str_replace("{{{$a}}}", $b, $template);
    }
    return $template;
    
}

function getmicrotime() { // Fontion pour les opérations temporelles.

    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 

}

function prettydate($uglydate) { //  Format de la date (YYYY-MM-DD).

    return date("F j, Y", mktime(0,0,0,substr($uglydate, 5, 2),substr($uglydate, 8, 2),substr($uglydate, 0, 4)));

}

function prettyforumdate($uglydate) {  //  Format de la date (YYYY-MM-DD).

    return date("F j, Y", mktime(0,0,0,substr($uglydate, 5, 2),substr($uglydate, 8, 2),substr($uglydate, 0, 4)));

}

function is_email($email) { // Merci à "mail@philipp-louis.de" de php.net!

    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));

}

function my_htmlspecialchars($text) { // Merci à "etymxris at yahoo dot com" de php.net!
    
  $ALLOWABLE_TAGS = array("b", "i", "u", "p", "blockquote", "ol", "ul", "li");
  static $PATTERNS = array();
  static $REPLACEMENTS = array();
  if (count($PATTERNS) == 0) {
   foreach ($ALLOWABLE_TAGS as $tag) {
     $PATTERNS[] = "/&lt;$tag&gt;/i";
     $PATTERNS[] = "/&lt;\/$tag&gt;/i";
     $REPLACEMENTS[] = "<$tag>";
     $REPLACEMENTS[] = "</$tag>";
   }
  }

  $result = str_replace(array(">", "<", "\"", "'"),
                       array("&gt;", "&lt;", "&quot;", "&#039;"),
                       $text);

  $result = preg_replace($PATTERNS, $REPLACEMENTS, $result);

  return $result;
  
}

function mododisplay($content, $title) { // Page en fonction du navagateur.
    
    global $numqueries, $userrow, $controlrow, $starttime, $version, $build;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
    
    $template = gettemplate("modo");
    
    // Tags pour la validation XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//FR\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";

    $finalarray = array(
        "title"=>$title,
        "content"=>$content,
        "totaltime"=>round(getmicrotime() - $starttime, 4),
        "numqueries"=>$numqueries,
        "version"=>$version,
        "build"=>$build);
    $page = parsetemplate($template, $finalarray);
    $page = $xml . $page;

    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo $page;
    die();
    
}

function admindisplay($content, $title) { // Page en fonction du navagateur.
    
    global $numqueries, $userrow, $controlrow, $starttime, $version, $build;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
    
    $template = gettemplate("admin");
    
    // Tags pour la validation XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//FR\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";

    $finalarray = array(
        "title"=>$title,
        "content"=>$content,
        "totaltime"=>round(getmicrotime() - $starttime, 4),
        "numqueries"=>$numqueries,
        "version"=>$version,
        "build"=>$build);
    $page = parsetemplate($template, $finalarray);
    $page = $xml . $page;

    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo $page;
    die();
    
}

function display($content, $title, $topnav=true, $leftnav=true, $rightnav=true, $badstart=false) { // Page en fonction du navagateur.
    
    global $numqueries, $userrow, $controlrow, $version, $build;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
    if ($badstart == false) { global $starttime; } else { $starttime = $badstart; }
    
    // Tags pour la validation XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//FR\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\n";

    $template = gettemplate("primary");
    
    if ($rightnav == true) { $rightnav = gettemplate("rightnav"); } else { $rightnav = ""; }
    if ($leftnav == true) { $leftnav = gettemplate("leftnav"); } else { $leftnav = ""; }
    if ($topnav == true) {
        $topnav = "";
    } else {
        $topnav = "";
    }
    
    if (isset($userrow)) {
        
        // Obtenir userrow en fonction de la mise à jour.
        $userquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["id"]."' LIMIT 1", "users");
        unset($userrow);
        $userrow = mysql_fetch_array($userquery);
        
        // Affichage de la ville en cours.
        if ($userrow["currentaction"] == "En ville") {
            $townquery = doquery("SELECT * FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "towns");
            $townrow = mysql_fetch_array($townquery);
            $userrow["currenttown"] = "Bienvenue à <b>".$townrow["name"]."</b>.<br /><br />";
        } else {
            $userrow["currenttown"] = "";
        }
        
        if ($controlrow["forumtype"] == 0) { $userrow["forumslink"] = ""; }
        elseif ($controlrow["forumtype"] == 1) { $userrow["forumslink"] = "<a href=\"forum.php?do=forum\">Forum</a><br />"; }
        elseif ($controlrow["forumtype"] == 2) { $userrow["forumslink"] = "<a href=\"".$controlrow["forumaddress"]."\">Forum</a><br />"; }
        
        // Formats lettres de déplacement.
        if ($userrow["latitude"] < 0) { $userrow["latitude"] = $userrow["latitude"] * -1 . "S"; } else { $userrow["latitude"] .= "N"; }
        if ($userrow["longitude"] < 0) { $userrow["longitude"] = $userrow["longitude"] * -1 . "W"; } else { $userrow["longitude"] .= "E"; }
        $userrow["experience"] = number_format($userrow["experience"]);
        $userrow["gold"] = number_format($userrow["gold"]);
        if ($userrow["authlevel"] == 1) { $userrow["adminlink"] = "<img src=\"images/site/pic.gif\"/>&nbsp;<a href=\"admin/admin.php\">Admin</a><br />"; } else { $userrow["adminlink"] = ""; }
        if ($userrow["authlevel"] == 3) { $userrow["modolink"] = "<img src=\"images/site/pic.gif\"/>&nbsp;<a href=\"admin/modo.php\">Modo</a><br />"; } else { $userrow["modolink"] = ""; }
        
        // Barres HP/MP/TP.
        $stathp = ceil($userrow["currenthp"] / $userrow["maxhp"] * 100);
        if ($userrow["maxmp"] != 0) { $statmp = ceil($userrow["currentmp"] / $userrow["maxmp"] * 100); } else { $statmp = 0; }
        $stattp = ceil($userrow["currenttp"] / $userrow["maxtp"] * 100);
        $stattable = "<table width=\"100\"><tr><td width=\"33%\">\n";
        $stattable .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td style=\"padding:0px; width:15px; height:100px; border:solid 1px black; vertical-align:bottom;\">\n";
        if ($stathp >= 66) { $stattable .= "<div style=\"padding:0px; height:".$stathp."px; border-top:solid 1px black; background-image:url(images/bars_green.gif);\"><img src=\"images/bars_green.gif\" alt=\"\" /></div>"; }
        if ($stathp < 66 && $stathp >= 33) { $stattable .= "<div style=\"padding:0px; height:".$stathp."px; border-top:solid 1px black; background-image:url(images/bars_yellow.gif);\"><img src=\"images/bars_yellow.gif\" alt=\"\" /></div>"; }
        if ($stathp < 33) { $stattable .= "<div style=\"padding:0px; height:".$stathp."px; border-top:solid 1px black; background-image:url(images/bars_red.gif);\"><img src=\"images/bars_red.gif\" alt=\"\" /></div>"; }
        $stattable .= "</td></tr></table></td><td width=\"33%\">\n";
        $stattable .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td style=\"padding:0px; width:15px; height:100px; border:solid 1px black; vertical-align:bottom;\">\n";
        if ($statmp >= 66) { $stattable .= "<div style=\"padding:0px; height:".$statmp."px; border-top:solid 1px black; background-image:url(images/bars_green.gif);\"><img src=\"images/bars_green.gif\" alt=\"\" /></div>"; }
        if ($statmp < 66 && $statmp >= 33) { $stattable .= "<div style=\"padding:0px; height:".$statmp."px; border-top:solid 1px black; background-image:url(images/bars_yellow.gif);\"><img src=\"images/bars_yellow.gif\" alt=\"\" /></div>"; }
        if ($statmp < 33) { $stattable .= "<div style=\"padding:0px; height:".$statmp."px; border-top:solid 1px black; background-image:url(images/bars_red.gif);\"><img src=\"images/bars_red.gif\" alt=\"\" /></div>"; }
        $stattable .= "</td></tr></table></td><td width=\"33%\">\n";
        $stattable .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td style=\"padding:0px; width:15px; height:100px; border:solid 1px black; vertical-align:bottom;\">\n";
        if ($stattp >= 66) { $stattable .= "<div style=\"padding:0px; height:".$stattp."px; border-top:solid 1px black; background-image:url(images/bars_green.gif);\"><img src=\"images/bars_green.gif\" alt=\"\" /></div>"; }
        if ($stattp < 66 && $stattp >= 33) { $stattable .= "<div style=\"padding:0px; height:".$stattp."px; border-top:solid 1px black; background-image:url(images/bars_yellow.gif);\"><img src=\"images/bars_yellow.gif\" alt=\"\" /></div>"; }
        if ($stattp < 33) { $stattable .= "<div style=\"padding:0px; height:".$stattp."px; border-top:solid 1px black; background-image:url(images/bars_red.gif);\"><img src=\"images/bars_red.gif\" alt=\"\" /></div>"; }
        $stattable .= "</td></tr></table></td>\n";
        $stattable .= "</tr><tr><td>HP</td><td>MP</td><td>TP</td></tr></table>\n";
        $userrow["statbars"] = $stattable;
        
        // Création des barres en fonction des nombres.
        if ($userrow["currenthp"] <= ($userrow["maxhp"]/5)) { $userrow["currenthp"] = "<blink><span class=\"highlight\"><b>*".$userrow["currenthp"]."*</b></span></blink>"; }
        if ($userrow["currentmp"] <= ($userrow["maxmp"]/5)) { $userrow["currentmp"] = "<blink><span class=\"highlight\"><b>*".$userrow["currentmp"]."*</b></span></blink>"; }

        $spellquery = doquery("SELECT id,name,type FROM {{table}}","spells");
        $userspells = explode(",",$userrow["spells"]);
        $userrow["magiclist"] = "";
        while ($spellrow = mysql_fetch_array($spellquery)) {
            $spell = false;
            foreach($userspells as $a => $b) {
                if ($b == $spellrow["id"] && $spellrow["type"] == 1) { $spell = true; }
            }
            if ($spell == true) {
                $userrow["magiclist"] .= "<a href=\"index.php?do=spell:".$spellrow["id"]."\">".$spellrow["name"]."</a><br />";
            }
        }
        if ($userrow["magiclist"] == "") { $userrow["magiclist"] = "Aucun"; }
        
        // Liste des villes disponible au téléportement.
        $townslist = explode(",",$userrow["towns"]);
        $townquery2 = doquery("SELECT * FROM {{table}} ORDER BY id", "towns");
        $userrow["townslist"] = "";
        while ($townrow2 = mysql_fetch_array($townquery2)) {
            $town = false;
            foreach($townslist as $a => $b) {
                if ($b == $townrow2["id"]) { $town = true; }
            }
            if ($town == true) { 
                $userrow["townslist"] .= "<img src=\"images/site/pic.gif\"/>&nbsp;<a href=\"index.php?do=gotown:".$townrow2["id"]."\">".$townrow2["name"]."</a><br />\n"; 
            }
        }
		
		$nb0 = doquery("SELECT * FROM {{table}} WHERE destinataire='".$userrow[id]."' AND statut='Non lu'", "msg");
        $nb = mysql_num_rows($nb0);
        $userrow["nb"] .= "$nb"; 

        
    } else {
        $userrow = array();
    }
	
	$newmsg = doquery("SELECT id FROM {{table}} WHERE destinataire='$userrow[id]' AND statut='Non lu'","msg");
		$nummsg = mysql_num_rows($newmsg);
		
		if($nummsg > 0)
		{
			$msglink = '<a href="messagerie.php" style="color:red;"> Messagerie</a><br /><br />';
		}
		else
		{
			$msglink = '<a href="messagerie.php"> Messagerie</a><br /><br />
';
		}


    $finalarray = array(
        "dkgamename"=>$controlrow["gamename"],
        "title"=>$title,
        "content"=>$content,
        "rightnav"=>parsetemplate($rightnav,$userrow),
        "leftnav"=>parsetemplate($leftnav,$userrow),
        "topnav"=>$topnav,
        "totaltime"=>round(getmicrotime() - $starttime, 4),
        "numqueries"=>$numqueries,
        "version"=>$version,
		"msglink"=>$msglink,
        "build"=>$build);
    $page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
    
    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo $page;
    die();
    
}

?>