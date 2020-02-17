<?php 
// On ouvre pas la base de donnée, car elle sera ouverte dans dans la page login.php.

include("config.php");

 $query = doquery ("SELECT * FROM {{table}} ORDER by level DESC ","users");   

    echo "      <table width=\"272px\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";

    //Initialisation pour une valeur de départ non null pour rentrer dans la boucle

    $var = "0";
    for  ( $count =  1; $count <= 8 && $row != null ; $count ++ ) {
    $var ++ ;    
    $row = mysql_fetch_array($query);

       //N'affiche pas la ligne si il n'y a plus d'enregistrements.
    if ($var >= 3 &&  $row != null){
                echo "     <tr>";
	        echo "    <td width=\"24px\"  align=\"center\" class=\"classement\"><img src=\"././images/classement/num-" . $count . ".gif\"/></td>";
	        echo "    <td width=\"40px\" align=\"center\" class=\"classement\"><img src=\"././images/classement/class-" . $row["charclass"] . ".gif\"/></td>";
                echo "    <td width=\"100px\" class=\"classement\"><b><font color=\"6b3a07\"><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["charname"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Actuellement: </b>" . $row["currentaction"] . "<br><b>Gils:</b> " . $row["gold"] . "<br><b>En banque: </b>" . $row["bank"] . "<br><b>Mp:</b> " . $row["maxmp"] . "<br><b>Tp:</b> " . $row["maxtp"] . "<br><b>Arme:</b> " .addslashes(htmlspecialchars($row["weaponname"])) ."<br><b>Armure:</b> " .addslashes(htmlspecialchars($row["armorname"])) ."<br><b>Bouclier: </b>" .addslashes(htmlspecialchars($row["shieldname"])) ."<br><b>Dextérité:</b> " . $row["dexterity"] . "<br><b> Pourvoir d\'attaque: </b>" . $row["attackpower"] . "<br><b>Pouvoir de defense:</b> " . $row["defensepower"] . " ','#FFFFF9')\" onMouseOut=kill() ;>" . $row["charname"] . "</a></font></b></td>";
                echo "    <td width=\"91px\" align=\"center\" class=\"classement\"><font  face=\"verdana\" size=\"1\" color=\"#990066\">Niv.</font>" . $row["level"] . " (" . $row["currenthp"] . ".hp)</td>";
                echo "    </tr>";
                echo "    <tr>";
                echo "    <td ><img src=\"././images/classement/espace.gif\" width=\"24px\" height=\"3\"></td>";
	        echo "    <td colspan=\"3\"><img src=\"././images/classement/tirets.gif\" width=\"231px\" height=\"3px\"></td>";
	        echo "    </tr>";
     }
}
                echo "     </table>";
?>

