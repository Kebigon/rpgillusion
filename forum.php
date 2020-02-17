<?php // forum.php :: Forum interne du script.

include('lib.php');
include('cookies.php');
include('bbcode.php');
$link = opendb();
$userrow = checkcookies();
if ($userrow == false) { display("Le forum est réservé aux joueurs enregistrés.", "Forum"); die(); }
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

if ($controlrow["gameopen"] == 0) { display("<p class='Style5'>Le jeu est actuellement fermé pour cause de maintenance. Merci de revenir plus tard.","Jeu fermé"); die(); }

if (isset($_GET["do"])) {
$do = explode(":",$_GET["do"]);

if ($do[0] == "thread") { showthread($do[1], $do[2]); }
elseif ($do[0] == "forum") { forum(); }
elseif ($do[0] == "new") { newthread($do[1]); }
elseif ($do[0] == "reply") { reply($do[1]); }
elseif ($do[0] == "list") { donothing($do[1]); }

} else { donothing(0); }

function donothing($id) {

$query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='$id' ORDER BY newpostdate DESC LIMIT 200", "forum");
$page = "<center><img src='images/forum.jpg'></center><p><center><div class='bloc_droite2'><p class='Style5'>
&nbsp; &nbsp; <u> La ligne de conduite </u><br><br>Ce forum a été crée pour que tous les joueurs puissent discuter entre eux.
Il faut donc garder une conduite exempliare ici. Toutes insultes, tentative de hacking (essayez vous allez bien rigolez aprés),
et j'allait oubliez il est formellement interdit d'echanger vos adresses emails sur le site.
L'equipe de Rpg Illusion 1.2c espere que vous passerai du bon temps sur notre jeu.
</div><center><table width=\"100%\"><tr><br><br><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><th colspan=\"3\" style=\"background-color:#cdbca3;\"><center><p class='Style5'><a href=\"forum.php?do=new\">Nouveau sujet</a></center></th></tr><tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style2'>Sujets</th><th width=\"10%\" style=\"background-color:#cdbca3;\"><p class='Style2'>Réponses</th><th style=\"background-color:#cdbca3;\"><p class='Style2'>Derniers Post</th></tr>\n";
$count = 1;
if (mysql_num_rows($query) == 0) {
$page .= "<tr><td style=\"background-color:#cdbca3;\" colspan=\"3\"><p class='Style5'><b>Aucun sujet dans le forum.</b></td></tr>\n";
} else {
while ($row = mysql_fetch_array($query)) {
if ($count == 1) {
$page .= "<tr><td style=\"background-color:#cdbca3;\"><p class='Style5'><a href=\"forum.php?do=thread:".$row["id"].":0\">".$row["title"]."</a></td><td style=\"background-color:#ffffff;\"><p class='Style2'>".$row["replies"]."</td><td style=\"background-color:#ffffff;\"><p class='Style2'>".$row["newpostdate"]."</td></tr>\n";
$count = 2;
} else {
$page .= "<tr><td style=\"background-color:#cdbca3;\"><p class='Style5'><a href=\"forum.php?do=thread:".$row["id"].":0\">".$row["title"]."</a></td><td style=\"background-color:#ffffff;\"><p class='Style2'>".$row["replies"]."</td><td style=\"background-color:#ffffff;\"><p class='Style2'>".$row["newpostdate"]."</td></tr>\n";
$count = 1;
}
}
}
$page .= "</table></td></tr></table></center><p class='Style5'><a href='forum.php?do=forum'><<< Retourner a l'aceuil du forum</a>";

display($page, "Forum");

}

function forum() {

$forum1query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='1' LIMIT 200", "forum");
$forum1 = "" . mysql_num_rows($forum1query) . "";
$forum2query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='2' LIMIT 200", "forum");
$forum2 = "" . mysql_num_rows($forum2query) . "";
$forum3query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='3' LIMIT 200", "forum");
$forum3 = "" . mysql_num_rows($forum3query) . "";
$forum4query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='4' LIMIT 200", "forum");
$forum4 = "" . mysql_num_rows($forum4query) . "";
$forum5query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='5' LIMIT 200", "forum");
$forum5 = "" . mysql_num_rows($forum5query) . "";
$forum6query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='6' LIMIT 200", "forum");
$forum6 = "" . mysql_num_rows($forum6query) . "";
$forum7query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='7' LIMIT 200", "forum");
$forum7 = "" . mysql_num_rows($forum7query) . "";
$forum8query = doquery("SELECT * FROM {{table}} WHERE parent='0' AND type='8' LIMIT 200", "forum");
$forum8 = "" . mysql_num_rows($forum8query) . "";
$mess1query = doquery("SELECT * FROM {{table}} WHERE type='1' LIMIT 200", "forum");
$mess1 = "" . mysql_num_rows($mess1query) . "";
$mess2query = doquery("SELECT * FROM {{table}} WHERE type='2' LIMIT 200", "forum");
$mess2 = "" . mysql_num_rows($mess2query) . "";
$mess3query = doquery("SELECT * FROM {{table}} WHERE type='3' LIMIT 200", "forum");
$mess3 = "" . mysql_num_rows($mess3query) . "";
$mess4query = doquery("SELECT * FROM {{table}} WHERE type='4' LIMIT 200", "forum");
$mess4 = "" . mysql_num_rows($mess4query) . "";
$mess5query = doquery("SELECT * FROM {{table}} WHERE type='5' LIMIT 200", "forum");
$mess5 = "" . mysql_num_rows($mess5query) . "";
$mess6query = doquery("SELECT * FROM {{table}} WHERE type='6' LIMIT 200", "forum");
$mess6 = "" . mysql_num_rows($mess6query) . "";
$mess7query = doquery("SELECT * FROM {{table}} WHERE type='7' LIMIT 200", "forum");
$mess7 = "" . mysql_num_rows($mess7query) . "";
$mess8query = doquery("SELECT * FROM {{table}} WHERE type='8' LIMIT 200", "forum");
$mess8 = "" . mysql_num_rows($mess8query) . "";

$page = "<center><img src='images/forum.jpg'></center><p><center><div class='bloc_droite2'><p class='Style5'>
&nbsp; &nbsp; <u> La ligne de conduite </u><br><br>Ce forum a été crée pour que tous les joueurs puissent discuter entre eux.
Il faut donc garder une conduite exempliare ici. Toutes insultes, tentative de hacking (essayez vous allez bien rigolez aprés),
et j'allait oubliez il est formellement interdit d'echanger vos adresses emails sur le site.
L'equipe de Rpg Illusion 1.2c espere que vous passerai du bon temps sur notre jeu.
</div><center><table width=\"100%\"><tr><br><br><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><th colspan=\"3\" style=\"background-color:#cdbca3;\"><center><p class='Style5'>Bienvenue sur le forum de Rpg Illusion 1.2c</center></th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; Sujet :</th><th width=\"20%\" style=\"background-color:#cdbca3;\"><p class='Style5'>Topic :</th><th style=\"background-color:#cdbca3;\"><p class='Style5'>Moderateur :</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:1'>News</a><br>Parler ici des differantes nouvelles de Rpg Illusion 1.2c.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum1 sujet(s)<br>$mess1 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:2'>Forum General</a><br>Parler de tous ce qui concerne le site.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum2 sujet(s)<br>$mess2 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:3'>Sondage</a><br>Donner votre avis sur Rpg Illusion 1.2c et ses choix.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum3 sujet(s)<br>$mess3 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:4'>Recrutement ou creation de clan</a><br>Ceci est le forum des clans.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum4 sujet(s)<br>$mess4 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:5'>Le bar de Rpg Illusion 1.2c</a><br>Parler de tous et de tous.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum5 sujet(s)<br>$mess5 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:6'>Aidez-nous !!!</a><br>Un bug ? Dite le nous pour qu'on puisse le corriger.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum6 sujet(s)<br>$mess6 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:7'>La prison</a><br>Attention, si vous etes attraper en train de tricher ou autres, tous le monde va le savoir.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum7 sujet(s)<br>$mess7 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
<tr><th width=\"50%\" style=\"background-color:#cdbca3;\"><p class='Style5'>&nbsp; <a href='forum.php?do=list:8'>RPG-Illusion</a><br>Créer votre propre rpg en php.</th><th width=\"10%\" style=\"background-color:#FFFFFF;\"><p class='Style5'>$forum8 sujet(s)<br>$mess8 message(s)</th><th style=\"background-color:#FFFFFF;\"><p class='Style5'>Admin</th></tr>
\n";

$page .= "</table></td></tr></table></center><p class='Style5'><a href='index.php'><<< Retourner au jeu</a>";

display($page, "Forum");

}

function showthread($id, $start) {

$query = doquery("SELECT * FROM {{table}} WHERE id='$id' OR parent='$id' ORDER BY id LIMIT $start,200", "forum");
$query2 = doquery("SELECT title,type,avatar,id,signature FROM {{table}} WHERE id='$id' LIMIT 1", "forum");
$row2 = mysql_fetch_array($query2);
$query3 = doquery("SELECT level,avatar,charclass FROM {{table}} WHERE id='3' ORDER BY id LIMIT 1", "users");
$info = mysql_fetch_array($query3);
$texte = new texte();
$auteur = $row["authorid"];
$type = $row2["type"];
$page = "<center><img src='images/forum.jpg'></center><p><table width=\"100%\"><tr><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><td colspan=\"2\" style=\"background-color:#cdbca3;\"><p class='Style5'><b><a href=\"forum.php?do=forum\">Forum</a> :: ".$row2["title"]."</b></td></tr>\n";
$count = 1;
while ($row = mysql_fetch_array($query)) {
if ($count == 1) {
$page .= "<tr><td width=\"25%\" style=\"background-color:#cdbca3; vertical-align:top;\"><p class='Style5'><span class=\"small\"><a href=\"index.php?do=onlinechar:".$row["id2"]."\"><b>".$row["author"]."</b></a><br /><img src='images/avatar/".$row["avatar"]."'><br />".prettyforumdate($row["postdate"])."</td><td style=\"background-color:#ffffff; vertical-align:top;\"><p class='Style5'>".$texte->ms_format(htmlentities($row["content"]))."<p>--------------------------------------------<br>".$texte->ms_format($row["signature"])."</td></tr>\n";
$count = 2;
} else {
$page .= "<tr><td width=\"25%\" style=\"background-color:#cdbca3; vertical-align:top;\"><p class='Style5'><span class=\"small\"><a href=\"index.php?do=onlinechar:".$row["id2"]."\"><b>".$row["author"]."</b></a><br /><img src='images/avatar/".$row["avatar"]."'><br />".prettyforumdate($row["postdate"])."</td><td style=\"background-color:#ffffff; vertical-align:top;\"><p class='Style5'>".$texte->ms_format(htmlentities($row["content"]))."<p>--------------------------------------------<br>".$texte->ms_format($row["signature"])."</td></tr>\n";
$count = 1;
}
}
$page .= "</table></td></tr></table><br />";
$page .= "[b]Gras[/b] / [i]Italique[/i] / [u]Souligné[/u] / [img]Image[\img] / [url]Lien[/url] <br>
	          <img src='images/smileys/1.jpg'> :1: /
			  <img src='images/smileys/2.jpg'> :2: /
			  <img src='images/smileys/3.jpg'> :3: /
			  <img src='images/smileys/4.jpg'> :4: /
			  <img src='images/smileys/5.jpg'> :5: /
			  <img src='images/smileys/6.jpg'> :6: /
			  <img src='images/smileys/7.jpg'> :7: /
              <img src='images/smileys/8.jpg'> :8: /
<table width=\"100%\"><tr><td><p class='Style5'><b>Répondre à ce sujet:</b><br /><form action=\"forum.php?do=reply\" method=\"post\"><input type=\"hidden\" name=\"parent\" value=\"$id\" /><input type=\"hidden\" name=\"point\" value=\"$type\" /><input type=\"hidden\" name=\"title\" value=\"Re: ".$row2["title"]."\" /><textarea name=\"content\" rows=\"7\" cols=\"40\"></textarea><br /><input type=\"submit\" name=\"submit\" value=\"Valider\" /><a href='index.php'> Retourner au jeu</a></form></td></tr></table>";

display($page, "Forum");

}

function reply($id) {

$query2 = doquery("SELECT avatar,id,signature FROM {{table}} WHERE id='$id' LIMIT 1", "users");
$userrow = mysql_fetch_array($query2);

global $userrow;
extract($_POST);
$query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),newpostdate=NOW(),author='".$userrow["charname"]."',signature='".$userrow["signature"]."',avatar='".$userrow["avatar"]."',id2='".$userrow["id"]."',parent='$parent',replies='0',title='$title',content='$content',type='$point'", "forum");
$query2 = doquery("UPDATE {{table}} SET newpostdate=NOW(),replies=replies+1 WHERE id='$parent' LIMIT 1", "forum");
header("Location: forum.php?do=thread:$parent:0");
die();

}

function newthread() {

$query2 = doquery("SELECT avatar,id,signature FROM {{table}} WHERE id='$id' LIMIT 1", "users");
$userrow = mysql_fetch_array($query2);

global $userrow;

if (isset($_POST["submit"])) {
extract($_POST);
$query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),newpostdate=NOW(),author='".$userrow["charname"]."',signature='".$userrow["signature"]."',avatar='".$userrow["avatar"]."',id2='".$userrow["id"]."',parent='0',replies='0',title='$title',content='$content',type='$type'", "forum");
header("Location: forum.php?do=forum");
die();
}

$page = "<center><img src='images/forum.jpg'></center>Gras : [b][/b] / Italique : [i][/i] / Souligné : [u][/u] / Image : [img][\img] / Lien : [url][/url]
	          <img src='images/smileys/1.jpg'> :1: /
			  <img src='images/smileys/2.jpg'> :2: /
			  <img src='images/smileys/3.jpg'> :3: /
			  <img src='images/smileys/4.jpg'> :4: /
			  <img src='images/smileys/5.jpg'> :5: /
			  <img src='images/smileys/6.jpg'> :6: /
			  <img src='images/smileys/7.jpg'> :7: /
              <img src='images/smileys/8.jpg'> :8: /
<table width=\"100%\"><tr><td><p class='Style5'><b>Nouveau sujet:</b><br /><br/ >
<form action=\"forum.php?do=new\" method=\"post\">
Forum : <select name='type'><option value='1'> News</option><option value='2'> Forum general</option><option value='3'> Sondage</option>
<option value='4'> Forum clan</option><option value='5'> Le bar</option><option value='6'> Aidez-nous !!!</option>
<option value='7'> La prison</option><option value='8'> RPG Illusion</option></select><br /><br />
Titre:<br /><input type=\"text\" name=\"title\" size=\"50\" maxlength=\"50\" /><br /><br />
Message:<br /><textarea name=\"content\" rows=\"7\" cols=\"40\"></textarea><br /><br />
<input type=\"submit\" name=\"submit\" value=\"Valider\" />
<input type=\"reset\" name=\"reset\" value=\"Annuler\" /></form></td></tr></table>";
display($page, "Forum");

}

?>