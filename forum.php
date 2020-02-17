<?php // forum.php :: Forum interne du script.

include('lib.php');
include('cookies.php');
$link = opendb();
$userrow = checkcookies();
if ($userrow == false) { display("Le forum est r�serv� aux joueurs enregistr�s.", "Forum"); die(); }
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

if ($controlrow["gameopen"] == 0) { display("Le jeu est actuellement ferm� pour cause de maintenance. Merci de revenir plus tard.","Jeu ferm�"); die(); }

if (isset($_GET["do"])) {
	$do = explode(":",$_GET["do"]);
	
	if ($do[0] == "thread") { showthread($do[1], $do[2]); }
	elseif ($do[0] == "new") { newthread(); }
	elseif ($do[0] == "reply") { reply(); }
	elseif ($do[0] == "list") { donothing($do[1]); }
	
} else { donothing(0); }

function donothing($start=0) {

    $query = doquery("SELECT * FROM {{table}} WHERE parent='0' ORDER BY newpostdate DESC LIMIT 20", "forum");
    $page = "<table width=\"490\"><tr><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><th colspan=\"3\" style=\"background-color:#EFC8A5;\"><center><a href=\"forum.php?do=new\">Nouveau sujet</a></center></th></tr><tr><th width=\"50%\" style=\"background-color:#EFC8A5;\">Sujets</th><th width=\"10%\" style=\"background-color:#EFC8A5;\">R�ponses</th><th style=\"background-color:#EFC8A5;\">Derniers Post</th></tr>\n";
    $count = 1;
    if (mysql_num_rows($query) == 0) { 
        $page .= "<tr><td style=\"background-color:#ffffff;\" colspan=\"3\"><b>Aucun sujet dans le forum.</b></td></tr>\n";
    } else { 
        while ($row = mysql_fetch_array($query)) {
        	if ($count == 1) {
            	$page .= "<tr><td style=\"background-color:#ffffff;\"><a href=\"forum.php?do=thread:".$row["id"].":0\">".$row["title"]."</a></td><td style=\"background-color:#ffffff;\">".$row["replies"]."</td><td style=\"background-color:#ffffff;\">".$row["newpostdate"]."</td></tr>\n";
            	$count = 2;
            } else {
                $page .= "<tr><td style=\"background-color:#EFC8A5;\"><a href=\"forum.php?do=thread:".$row["id"].":0\">".$row["title"]."</a></td><td style=\"background-color:#EFC8A5;\">".$row["replies"]."</td><td style=\"background-color:#EFC8A5;\">".$row["newpostdate"]."</td></tr>\n";
                $count = 1;
            }
        }
    }
    $page .= "</table></td></tr></table>";
    
    display($page, "Forum");
    
}

function showthread($id, $start) {

    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' OR parent='$id' ORDER BY id LIMIT $start,15", "forum");
    $query2 = doquery("SELECT title FROM {{table}} WHERE id='$id' LIMIT 1", "forum");
    $row2 = mysql_fetch_array($query2);
    $page = "<table width=\"100%\"><tr><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><td colspan=\"2\" style=\"background-color:#EFC8A5;\"><b><a href=\"forum.php\">Forum</a> :: ".$row2["title"]."</b></td></tr>\n";
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) {
            $page .= "<tr><td width=\"25%\" style=\"background-color:#ffffff; vertical-align:top;\"><span class=\"small\"><b>".$row["author"]."</b><br /><br />".prettyforumdate($row["postdate"])."</td><td style=\"background-color:#ffffff; vertical-align:top;\">".nl2br($row["content"])."</td></tr>\n";
            $count = 2;
        } else {
            $page .= "<tr><td width=\"25%\" style=\"background-color:#EFC8A5; vertical-align:top;\"><span class=\"small\"><b>".$row["author"]."</b><br /><br />".prettyforumdate($row["postdate"])."</td><td style=\"background-color:#EFC8A5; vertical-align:top;\">".nl2br($row["content"])."</td></tr>\n";
            $count = 1;
        }
    }
    $page .= "</table></td></tr></table><br />";
    $page .= "<table width=\"490\"><tr><td><b>R�pondre � ce sujet:</b><br /><form action=\"forum.php?do=reply\" method=\"post\"><input type=\"hidden\" name=\"parent\" value=\"$id\" /><input type=\"hidden\" name=\"title\" value=\"Re: ".$row2["title"]."\" /><textarea name=\"content\" rows=\"7\" cols=\"40\"></textarea><br /><input type=\"submit\" name=\"submit\" value=\"Valider\" /> <input type=\"reset\" name=\"reset\" value=\"Annuler\" /></form></td></tr></table>";
    
    display($page, "Forum");
    
}

function reply() {

    global $userrow;
	extract($_POST);
	
	$content = addslashes($content);
	$title = addslashes($title);
	$parent = addslashes($parent);
	$query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),newpostdate=NOW(),author='".$userrow["charname"]."',parent='$parent',replies='0',title='$title',content='$content'", "forum");
	$query2 = doquery("UPDATE {{table}} SET newpostdate=NOW(),replies=replies+1 WHERE id='$parent' LIMIT 1", "forum");
	header("Location: forum.php?do=thread:$parent:0");
	die();
	
}

function newthread() {

    global $userrow;
    
    if (isset($_POST["submit"])) {
        extract($_POST);
			$content = addslashes($content);
	$title = addslashes($title);
	$parent = addslashes($parent);
        $query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),newpostdate=NOW(),author='".$userrow["charname"]."',parent='0',replies='0',title='$title',content='$content'", "forum");
        header("Location: forum.php");
        die();
    }
    
    $page = "<table width=\"490\"><tr><td><b>Nouveau sujet:</b><br /><br/ ><form action=\"forum.php?do=new\" method=\"post\">Titre:<br /><input type=\"text\" name=\"title\" size=\"50\" maxlength=\"50\" /><br /><br />Message:<br /><textarea name=\"content\" rows=\"7\" cols=\"40\"></textarea><br /><br /><input type=\"submit\" name=\"submit\" value=\"Valider\" /> <input type=\"reset\" name=\"reset\" value=\"Annuler\" /></form></td></tr></table>";
    display($page, "Forum");
    
}
	
?>