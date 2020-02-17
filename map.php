<meta http-equiv="refresh" content="240">
<body style="background-color:transparent">
<bgsound src="./musiques/map.mid" autostart="true" loop="50000000000000000000000000000000000000000000000000">
<table   width="478" height="454" style="background-image:url(images/sol/fond_carte.jpg)" border="0" >
  <tr>
    <td align="center" valign="middle">
<?php

	
include('lib.php');
include('config.php');
include('cookies.php');
$link = opendb();
$userrow = checkcookies();

global $userrow;

if (isset($_COOKIE["dkgame"])) {
	
// Format du cookies:
// {ID} {USERNAME} {PASSWORDHASH} {REMEMBERME}
$theuser = explode(" ",$_COOKIE["dkgame"]);
$username= $theuser[1];
$id = $theuser[0];
}
$query2 = doquery("SELECT latitude,longitude FROM rpg_towns WHERE id='$id' LIMIT 1", "towns");
$query = doquery("SELECT latitude,longitude FROM rpg_users WHERE id='$id' LIMIT 1", "users");
$query2 = doquery("SELECT lati,longi FROM rpg_sol WHERE id='$id' LIMIT 1", "sol");
$query2 = doquery("SELECT latitude,longitude,name FROM rpg_maison WHERE id='$id' LIMIT 1", "maison");

$deplaquery = doquery("SELECT id FROM rpg_users WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "users");
$tabl = mysql_fetch_array($query);


$latmax = $tabl['latitude'] + 5;
$longmax = $tabl['longitude'] + 6;
$latmin = $tabl['latitude'] - 5;
$longmin = $tabl['longitude'] - 6;

$hp = 100 / $userrow['maxhp'];
$hp2 = $hp * $userrow['currenthp'];
$tp = 100 / $userrow['maxtp'];
$tp2 = $tp * $userrow['currenttp'];
$mp = 100 / $userrow['maxmp'];
$mp2 = $mp * $userrow['currentmp'];

$latitude = $latmax;
echo "<body><center><table>\n";
while ($latitude >= $latmin ) {
echo "<tr>\n\n";
$longitude = $longmin;
while ($longitude <= $longmax) {
$sql = "SELECT username, id, avatar FROM rpg_users WHERE latitude='$latitude' AND longitude='$longitude'";
$query = mysql_query($sql);
$fetch = mysql_fetch_array($query);
$username = $fetch['username'];
$avatar = $fetch['avatar'];
$id = $fetch['id'];

$sql = "SELECT nimi FROM rpg_clans WHERE omanik='$id'";
$query = mysql_query($sql);
$fetch = mysql_fetch_array($query);
$nimi = $fetch['nimi'];

$sqll = "SELECT nom FROM rpg_sol WHERE lati='$latitude' AND longi='$longitude'";
$query = mysql_query($sqll);
$fetch = mysql_fetch_array($query);
$sol = $fetch['nom'];

$sqll = "SELECT name FROM rpg_maison WHERE latitude='$latitude' AND longitude='$longitude'";
$query = mysql_query($sqll);
$fetch = mysql_fetch_array($query);
$maison	= $fetch['name'];

$sqll = "SELECT name FROM rpg_towns WHERE latitude='$latitude' AND longitude='$longitude'";
$query = mysql_query($sqll);
$fetch = mysql_fetch_array($query);
$villes = $fetch['name'];
if($villes !='') 
{echo "<td style=\"background-image:url(images/sol/maison1.jpg)\" width=\"40\" height=\"40\"><img src=\"./images/sol/maison1.jpg\" width=\"35\" height=\"40\" border=\"0\" title=\"".$villes."\"></td>"; }
else {
if($avatar!='') {
echo "<td><img src=\"./images/avatar/".$avatar."\" width=\"35\" height=\"35\" border=\"0\" title=\"Id :".$id."/Pseudo:".$username."/Clan: ".$nimi."/Position:(".$longitude." , ".$latitude.")\"></td>";
} else {
if($maison !='') 
{echo "<td style=\"background-image:url(images/sol/maison.jpg)\" width=\"40\" height=\"40\"><img src=\"./images/sol/maison.jpg\" width=\"35\" height=\"40\" border=\"0\" title=\"Maison de ".$maison."\"></td>"; }
else {
if($sol !='') {
echo "<td style=\"background-image:url(./images/sol/".$sol.".jpg)\" width=\"35\" height=\"35\"></td>"; }
else {
echo "<td style=\"background-image:url(./images/avatar/.gif)\" width=\"35\" height=\"35\"></td>\n";
}
}
}
}
$longitude++;
}
echo "</tr>";
$latitude--;
}
echo '</table></center></body>';

echo '<div id="Layer1" style="position:absolute; left:36; top:30; width:99; height:71; z-index:1">
<table width="1" height="1" border="0" cellspacing="2" cellpadding="0">
<tr> 
<td width="6%" height="2"><span class="blancmap"><b><font size="2">HP</font></b></span></td>
<td width="98"><span class="blancmap2"><div align="right"><font size="2">'.$userrow['currenthp'].'/ '.$userrow['maxhp'].'</font></div></span>
<table width="100"height="2" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#000000"> 
<td>
<table width="'.$hp2.'" height="2" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#DA4A12"> 
<td></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<tr> 
<td width="6%" height="2"><span class="blancmap"><b><font size="2">TP</font></b></span></td>
<td width="98"><span class="blancmap2"><div align="right"><font size="2">'.$userrow['currenttp'].'/ '.$userrow['maxtp'].'</font></div></span>
<table width="100" height="2" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#000000"> 
<td>
<table width="'.$tp2.'" height="2" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#CC00CC"> 
<td></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<tr> 
<td width="6%" height="2"><span class="blancmap"><b><font size="2">MP</font></b></span></td>
<td width="98"><span class="blancmap2"><div align="right"><font size="2">'.$userrow['currentmp'].'/ '.$userrow['maxmp'].'</font></div></span>
<table width="100" height="2" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#000000"> 
<td>
<table width="'.$mp2.'" height="2" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#810FF5"> 
<td></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>';
?>
</td>
  </tr>
</table>

