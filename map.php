<?

function map(){

global $userrow ; 

$hpstat = $userrow[currenthp] / $userrow[maxhp] * 100;
$mpstat = $userrow[currentmp] / $userrow[maxmp] * 100;
$tpstat = $userrow[currenttp] / $userrow[maxtp] * 100;

$latmax = $userrow['latitude'] + 4;
$longmax = $userrow['longitude'] + 8;
$latmin = $userrow['latitude'] - 5;
$longmin = $userrow['longitude'] - 8;

$latitude = $latmax;
echo "<bgsound src=\"musiques/map.mid\" autostart=\"true\" loop=\"5\">
<link rel=\"stylesheet\" href=\"styles/css_php.css\" type=\"text/css\">
<style>
body { 
 padding-right: 0px; 
 padding-left: 0px; 
 font: 11px verdana;
 PADDING-BOTTOM: 0px; MARGIN: 0px; 
 PADDING-TOP: 0px; 
 FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; 
 TOP: 0px; 
} 

table { 
 font: 11px verdana;
} 

.mauve { 
color: #990066; 
font: 11px verdana;
}

.blancmap { 
color: #D8D8D8; 
 font: 10px verdana;
}

.blancmap2 { 
color: #ffffff; 
  font: 10px verdana;
}</style>
";

echo " <table width=\"490\" height=\"9\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr> 
    <td height=\"9\" width=\"490\" background=\"images/carte/b1.gif\" colspan=\"3\" ></td></td>
  </tr>
  <tr> 
    <td height=\"300\" width=\"9\" background=\"images/carte/b3.gif\"></td>
    
  <td width=\"472\" height=\"300\" align=\"center\" background=\"images/carte/herbe.jpg\" >";
echo "<table width=\"472\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"300\" align=\"center\">\n";
echo "<tr>";
while ($latitude >= $latmin ) {
$longitude = $longmin;
while ($longitude <= $longmax) {
// infos personage 
$perso = doquery("SELECT charname, avatar FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "users");
$persorow = mysql_fetch_array($perso);

//infos map
$query2 = doquery("SELECT nom FROM {{table}} WHERE lati='$latitude' AND longi='$longitude' LIMIT 1", "sol");
$fetcht = mysql_fetch_array($query2);
$sol = $fetcht['nom'];

// infos Maisons
$query3 = doquery("SELECT name FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "maison");
$fetchh = mysql_fetch_array($query3);
$maison	= $fetchh['charname'];

// infos Villes
$query4 = doquery("SELECT name FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "towns");
$fetchx = mysql_fetch_array($query4);
$villes = $fetchx['name'];

if($villes !='') 
{echo "<td><img src=\"images/carte/ville.jpg\" width=\"29\" height=\"29\" border=\"0\" title=\"".$villes."\"></td>"; }
else {
if($persorow['avatar']!='') {
echo "<td style=\"background-image:url(images/avatar/carte/".$persorow['avatar'].".gif)\" width=\"29\" height=\"29\" title=\"".$persorow['charname']." (".$longitude." , ".$latitude.") est ici\"></td>";
} else {
if($maison !='') 
{echo "<td><img src=\"images/carte/maison.jpg\" width=\"29\" height=\"29\" border=\"0\" title=\"Maison de ".$maison."\"></td>"; }
else {
if($sol !='') {
echo "<td style=\"background-image:url(images/carte/".$sol.".gif)\" width=\"29\" height=\"29\"></td>"; }
else {
echo "<td></td>\n";
}
}
}
}
$longitude++;
}
echo "</td></tr>";
$latitude--;
}
echo "</table>";
echo "  </td>

 <td height=\"300\" width=\"9\" background=\"images/carte/b4.gif\"></td>
  </tr>
  <tr> 
    <td colspan=\"3\" height=\"9\" width=\"490\" background=\"images/carte/b2.gif\"></td>
  </tr>
</table>";


//Barre de hp,mp,tp.

echo" <div id=\"Layer1\" style=\"position:absolute; left:11px; top:13px; width:462px; height:294px; z-index:1\">
<table width=\"1\" height=\"1\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\">
  <tr> 
    <td width=\"6%\" height=\"2\"><span class=\"blancmap\"><b>HP</b></span></td>
    <td width=\"98\"><span class=\"blancmap2\"><div align=\"right\">".$userrow[currenthp]."/ ".$userrow[maxhp]."</div></span>
      <table width=\"100\"height=\"2\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr bgcolor=\"#000000\"> 
          <td>
		  <table width=\"".$hpstat."\"height=\"2\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr bgcolor=\"#DA4A12\"> 
          <td></td>
        </tr>
        </table>
		  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td width=\"6%\" height=\"2\"><span class=\"blancmap\"><b>TP</b></span></td>
    <td width=\"98\"><span class=\"blancmap2\"><div align=\"right\">".$userrow[currenttp]."/ ".$userrow[maxtp]."</div></span>
        <table width=\"100\"height=\"2\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr bgcolor=\"#000000\"> 
          <td>
		  <table width=\"".$tpstat."\"height=\"2\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr bgcolor=\"#CC00CC\"> 
          <td></td>
        </tr>
        </table>
		  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td width=\"6%\" height=\"2\"><span class=\"blancmap\"><b>MP</b></span></td>
    <td width=\"98\"><span class=\"blancmap2\"><div align=\"right\">".$userrow[currentmp]."/ ".$userrow[maxmp]."</div></span>
        <table width=\"100\"height=\"2\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr bgcolor=\"#000000\"> 
          <td>
		  <table width=\"".$mpstat."\"height=\"2\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr bgcolor=\"#810FF5\"> 
          <td></td>
        </tr>
        </table>
		  </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>";


// Affichage de la position.

echo "
<div id=\"Layer3\" style=\"position:absolute; right:8px; top:9px; width:156px; height:17px; z-index:1\">
<table width=\"156\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"17\" background=\"images/carte/haut1.gif\">
  <tr>
    <td align=\"center\">
<span class=\"mauve\"><b>Long:</b></span> ".$userrow[longitude]." - <span class=\"mauve\"><b>Lat:</b></span> ".$userrow[latitude]."
	</td>
  </tr>
</table>
</div>";

}

?>