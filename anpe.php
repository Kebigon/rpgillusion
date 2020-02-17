<?php

function metier() { // Staying at the inn resets all expendable stats to their max values.

$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
$townrow3 = mysql_fetch_array($townquery3);

global $userrow, $numqueries;



/////- Metier n°1 -/////

if (isset($_POST["1"])) {
if ($userrow["gold"] > 500 ) {


$newtpmetier = $userrow["ptmetier"] - 1 ;
$newgold = $userrow["gold"] - 500 ;
$query = doquery("UPDATE {{table}} SET metier='forgeron',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "ANPE";
$page = "vous etes bien embaucher <a href=\"index.php?do=metier\">Retour</a></br>";
display($page, $title);
} else {display("Vous n'avez pas assez d'argent pour vous former", "Metier"); die(); }
}
/////- FIN Metier n°1 -/////

/////- Metier n°2 -/////

if (isset($_POST["2"])) {
if ($userrow["gold"] > 1000 ) {


$newtpmetier = $userrow["ptmetier"] - 1 ;
$newgold = $userrow["gold"] - 1000 ;
$query = doquery("UPDATE {{table}} SET metier='bucheron',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 2", "users");
$title = "ANPE";
$page = "Vous etes bien embaucher <a href=\"index.php?do=metier\">Retour</a></br>";
display($page, $title);
} else {display("Vous n'avez pas assez d'argent pour vous former", "Metier"); die(); }
}
/////- FIN Metier n°2 -/////

/////- Metier n°3 -/////

if (isset($_POST["3"])) {
if ($userrow["gold"] > 1500 ) {


$newtpmetier = $userrow["ptmetier"] - 1 ;
$newgold = $userrow["gold"] - 1500 ;
$query = doquery("UPDATE {{table}} SET metier='taneur',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 2", "users");
$title = "ANPE";
$page = "Vous etes bien embaucher <a href=\"index.php?do=metier\">Retour</a></br>";
display($page, $title);
} else {display("Vous n'avez pas assez d'argent pour vous former", "Metier"); die(); }
}
/////- FIN Metier n°3 -/////

/////- Metier n°4 -/////

if (isset($_POST["4"])) {
if ($userrow["gold"] > 2000 ) {


$newtpmetier = $userrow["ptmetier"] - 1 ;
$newgold = $userrow["gold"] - 2000 ;
$query = doquery("UPDATE {{table}} SET metier='aubergiste',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 2", "users");
$title = "ANPE";
$page = "Vous etes bien embaucher <a href=\"index.php?do=metier\">Retour</a></br>";
display($page, $title);
} else {display("Vous n'avez pas assez d'argent pour vous former", "Metier"); die(); }
}
/////- FIN Metier n°4 -/////

/////- Metier n°5 -/////

if (isset($_POST["5"])) {
if ($userrow["gold"] > 2500 ) {


$newtpmetier = $userrow["ptmetier"] - 1 ;
$newgold = $userrow["gold"] - 2500 ;
$query = doquery("UPDATE {{table}} SET metier='apothicaires',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 2", "users");
$title = "ANPE";
$page = "Vous etes bien embaucher <a href=\"index.php?do=metier\">Retour</a></br>";
display($page, $title);
} else {display("Vous n'avez pas assez d'argent pour vous former", "Metier"); die(); }
}
/////- FIN Metier n°5 -/////

/////- Metier n°6 -/////

if (isset($_POST["5"])) {
if ($userrow["gold"] > 3000 ) {


$newtpmetier = $userrow["ptmetier"] - 1 ;
$newgold = $userrow["gold"] - 3000 ;
$query = doquery("UPDATE {{table}} SET metier='ichikaku',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 2", "users");
$title = "ANPE";
$page = "Vous etes bien embaucher <a href=\"index.php?do=metier\">Retour</a></br>";
display($page, $title);
} else {display("Vous n'avez pas assez d'argent pour vous former", "Metier"); die(); }
}
/////- FIN Metier n°6 -/////



else {

$title = "ANPE";
$metier = $userrow["metier"] ;
$monnaie = $townrow3["monnaie"];
$page = "

<p align=\"center\">Vous etes un(e) $metier </p>
<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<!--DWLayoutTable-->
<tr>
<td width=\"450\" height=\"68\" valign=\"top\"><div align=\"center\"><a href=\"index.php?do=travail\">Aller au boulot </a></div></td>
<td width=\"450\" height=\"68\" valign=\"top\"><div align=\"center\"><a href=\"index.php\">Retour en ville</a>
</tr>
</table>

<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<!--DWLayoutTable-->
<tr>
<td width=\"300\" height=\"250\" valign=\"top\"><div align=\"center\">
<p><img src=\"././images/travail/forge.jpg\"></p>
</div></td>
<td width=\"150\" valign=\"top\"><p align=\"center\"><u>Forgeron</u></p>
<p align=\"center\">500 $monnaie de Formation</p>
<p align=\"center\">50 $monnaie / Jour</p>
<form name=\"form1\" method=\"post\" action=\"index.php?do=metier\">
<div align=\"center\">
<input name=\"1\" type=\"submit\" id=\"1\" value=\"Se Former\">
</div>
</form> <p align=\"center\">&nbsp;</p></td>
</tr>
</table>
</br>

<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<!--DWLayoutTable-->
<tr>
<td width=\"300\" height=\"250\" valign=\"top\"><div align=\"center\">
<p><img src=\"././images/travail/buche.jpg\"></p>
</div></td>
<td width=\"150\" valign=\"top\"><p align=\"center\"><u>Bucheron</u></p>
<p align=\"center\">1000 $monnaie de Formation</p>
<p align=\"center\">100 $monnaie / Jour</p>
<form name=\"form1\" method=\"post\" action=\"index.php?do=metier\">
<div align=\"center\">
<input name=\"2\" type=\"submit\" id=\"2\" value=\"Se Former\">
</div>
</form> <p align=\"center\">&nbsp;</p></td>
</tr>
</table>
</br>

<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<!--DWLayoutTable-->
<tr>
<td width=\"300\" height=\"250\" valign=\"top\"><div align=\"center\">
<p><img src=\"././images/travail/tane.jpg\"></p>
</div></td>
<td width=\"150\" valign=\"top\"><p align=\"center\"><u>Taneur</u></p>
<p align=\"center\">1500 $monnaie de Formation</p>
<p align=\"center\">150 $monnaie / Jour</p>
<form name=\"form1\" method=\"post\" action=\"index.php?do=metier\">
<div align=\"center\">
<input name=\"3\" type=\"submit\" id=\"3\" value=\"Se Former\">
</div>
</form> <p align=\"center\">&nbsp;</p></td>
</tr>
</table>
</br>

<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<!--DWLayoutTable-->
<tr>
<td width=\"300\" height=\"250\" valign=\"top\"><div align=\"center\">
<p><img src=\"././images/travail/auberge.jpg\"></p>
</div></td>
<td width=\"150\" valign=\"top\"><p align=\"center\"><u>Aubergiste</u></p>
<p align=\"center\">2000 $monnaie de Formation</p>
<p align=\"center\">200 $monnaie / Jour</p>
<form name=\"form1\" method=\"post\" action=\"index.php?do=metier\">
<div align=\"center\">
<input name=\"4\" type=\"submit\" id=\"4\" value=\"Se Former\">
</div>
</form> <p align=\"center\">&nbsp;</p></td>
</tr>
</table>
</br>

<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<!--DWLayoutTable-->
<tr>
<td width=\"300\" height=\"250\" valign=\"top\"><div align=\"center\">
<p><img src=\"././images/travail/apothicaires.jpg\"></p>
</div></td>
<td width=\"150\" valign=\"top\"><p align=\"center\"><u>Apothicaires</u></p>
<p align=\"center\">2500 $monnaie de Formation</p>
<p align=\"center\">250 $monnaie / Jour</p>
<form name=\"form1\" method=\"post\" action=\"index.php?do=metier\">
<div align=\"center\">
<input name=\"5\" type=\"submit\" id=\"5\" value=\"Se Former\">
</div>
</form> <p align=\"center\">&nbsp;</p></td>
</tr>
</table>
</br>

<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<!--DWLayoutTable-->
<tr>
<td width=\"300\" height=\"250\" valign=\"top\"><div align=\"center\">
<p><img src=\"././images/travail/ichikaku.gif\"></p>
</div></td>
<td width=\"150\" valign=\"top\"><p align=\"center\"><u>Ichikaku</u></p>
<p align=\"center\">3000 $monnaie de Formation</p>
<p align=\"center\">300 $monnaie / Jour</p>
<form name=\"form1\" method=\"post\" action=\"index.php?do=metier\">
<div align=\"center\">
<input name=\"6\" type=\"submit\" id=\"6\" value=\"Se Former\">
</div>
</form> <p align=\"center\">&nbsp;</p></td>
</tr>
</table>
</br>
<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">

<tr>

</table>

";

}
display($page, $title);
} 





function travail() { // Staying at the inn resets all expendable stats to their max values.

$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
$townrow3 = mysql_fetch_array($townquery3);
$monnaie = $townrow3["monnaie"];

global $userrow, $numqueries;

if ($userrow["ptmetier"] < 1) { display("Vous avez deja travaillés ! <a href=\"index.php\">retourner à la ville</a>", "Forge"); die(); }



/////- Metier n°1 -///// 


if ($userrow["metier"] == "forgeron") {


$newgold = $userrow["gold"] + 50 ;
$newptmetier = $userrow["ptmetier"] - 1 ;
$query = doquery("UPDATE {{table}} SET gold='$newgold',ptmetier='$newptmetier' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Au boulot";
$page = "Vous avez bien travaillés aujourd'hui ! vous remportez 50 $monnaie ! <a href=\"index.php\">retourner à la ville</a>";
display($page, $title);
}
/////- Metier n°1 -/////

/////- Metier n°2-///// 


if ($userrow["metier"] == "bucheron") {


$newgold = $userrow["gold"] + 100 ;
$newptmetier = $userrow["ptmetier"] - 1 ;
$query = doquery("UPDATE {{table}} SET gold='$newgold',ptmetier='$newptmetier' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Au boulot";
$page = "Vous avez bien travaillés aujourd'hui ! vous remportez 100 $monnaie ! <a href=\"index.php\">retourner à la ville</a>";
display($page, $title);
}
/////- Metier n°2 -/////

/////- Metier n°3-///// 


if ($userrow["metier"] == "taneur") {


$newgold = $userrow["gold"] + 150 ;
$newptmetier = $userrow["ptmetier"] - 1 ;
$query = doquery("UPDATE {{table}} SET gold='$newgold',ptmetier='$newptmetier' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Au boulot";
$page = "Vous avez bien travaillés aujourd'hui ! vous remportez 150 $monnaie ! <a href=\"index.php\">retourner à la ville</a>";
display($page, $title);
}
/////- Metier n°3 -/////

/////- Metier n°4-///// 


if ($userrow["metier"] == "aubergiste") {


$newgold = $userrow["gold"] + 200 ;
$newptmetier = $userrow["ptmetier"] - 1 ;
$query = doquery("UPDATE {{table}} SET gold='$newgold',ptmetier='$newptmetier' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Au boulot";
$page = "Vous avez bien travaillés aujourd'hui ! vous remportez 200 $monnaie ! <a href=\"index.php\">retourner à la ville</a>";
display($page, $title);
}
/////- Metier n°4 -/////

/////- Metier n°5-///// 


if ($userrow["metier"] == "apothicaires") {


$newgold = $userrow["gold"] + 250 ;
$newptmetier = $userrow["ptmetier"] - 1 ;
$query = doquery("UPDATE {{table}} SET gold='$newgold',ptmetier='$newptmetier' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Au boulot";
$page = "Vous avez bien travaillés aujourd'hui ! vous remportez 250 $monnaie ! <a href=\"index.php\">retourner à la ville</a>";
display($page, $title);
}
/////- Metier n°5-/////

/////- Metier n°6-///// 


if ($userrow["metier"] == "ichikaku") {


$newgold = $userrow["gold"] + 300 ;
$newptmetier = $userrow["ptmetier"] - 1 ;
$query = doquery("UPDATE {{table}} SET gold='$newgold',ptmetier='$newptmetier' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
$title = "Au boulot";
$page = "Vous avez bien travaillés aujourd'hui ! vous remportez 300 $monnaie ! <a href=\"index.php\">retourner à la ville</a>";
display($page, $title);
}
/////- Metier n°6-/////

}
?>