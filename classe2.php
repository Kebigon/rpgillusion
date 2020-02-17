<?php 
// On ouvre pas la base de donnée, car elle sera ouverte dans dans la page login.php.

include("config.php");

$query = doquery ("SELECT * FROM {{table}} ORDER by kuulsus DESC ","clans"); 

echo " <table width='272px' border='0' cellpadding='0' cellspacing='0'>";

//Initialisation pour une valeur de départ non null pour rentrer dans la boucle

$var = "0";
for ( $count = 1; $count <= 5 && $row != null ; $count ++ ) {
$var ++ ; 
$row = mysql_fetch_array($query);

//N'affiche pas la ligne si il n'y a plus d'enregistrements.
if ($var >= 1 && $row != null){
echo " <tr>";
echo " <td width='24px' align='center' class='classement'><img src='./images/classement/num-" . $count . ".gif'/></td>";
echo " <td width='100px' class='classement'><b><font color='f4d234'>" . $row['nimi'] . "</a></font></b></td>";
echo " <td width='91px' align='center' class='classement'><font face='verdana' size='1' color='#1cab59'>Niv.</font><font face='verdana' size='1' color='#FFFFFF'>" . $row['kuulsus'] . " </font></td>";
echo " </tr>";
echo " <tr>";
echo " <td ><img src='./images/classement/espace.gif' width='24px' height='3'></td>";
echo " <td colspan='3'><img src='./images/classement/tirets.gif' width='231px' height='3px'></td>";
echo " </tr>";
}
}
echo " </table>";
?>