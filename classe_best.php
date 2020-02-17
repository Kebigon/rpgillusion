<?php 
// On ouvre pas la base de donnée, car elle sera ouverte dans dans la page login.php.

include("config.php");

 $query = doquery ("SELECT * FROM {{table}} ORDER by level DESC","users");   

   $row = "0";
for ( $count = 1 ; $count <= 2 && $row != null ; $count ++ ) {
        $row = mysql_fetch_array($query);
        if ( $row != null ) {

	       echo "      <table width=\"119px\" height=\"142px\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 2px\" valign=\"middle\">";
	       echo "     <tr>
		               <td width=\"119px\" height=\"8px\" background=\"././images/classement/bg1_best.gif\"></td>
			      </tr>";	       
	        echo "    <tr>
		                <td width=\"119\" height=\"122px\" valign=\"top\" border=\"0\" background=\"././images/classement/bg2_best.gif\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["charname"])) ."</b></u></font><br><img src=././images/space_bulle.gif width=150><br><b>Actuellement: </b>" . $row["currentaction"] . "<br><b>Gils:</b> " . $row["gold"] . "<br><b>En banque: </b>" . $row["bank"] . "<br><b>Mp:</b> " . $row["maxmp"] . "<br><b>Tp:</b> " . $row["maxtp"] . "<br><b>Arme:</b> " .addslashes(htmlspecialchars($row["weaponname"])) ."<br><b>Armure:</b> " .addslashes(htmlspecialchars($row["armorname"])) ."<br><b>Bouclier: </b>" .addslashes(htmlspecialchars($row["shieldname"])) ."<br><b>Dextérité:</b> " . $row["dexterity"] . "<br><b> Pourvoir d\'attaque: </b>" . $row["attackpower"] . "<br><b>Pouvoir de defense:</b> " . $row["defensepower"] . " ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/classement/num-" . $count . ".gif\" align=\"left\" valign=\"top\" class=\"classement2\" /><img src=\"././images/avatar/num-" . $row["avatar"] . ".gif\" align=\"center\" align=\"top\"/></a></center><font  face=\"verdana\" size=\"1\" color=\"#990066\" align=\"left\" valign=\"bottom\"><b>Nom: </b></font><font  face=\"verdana\" size=\"1\" color=\"#000000\">" . $row["charname"] . "</font><br><font  face=\"verdana\" size=\"1\" color=\"#990066\"align=\"left\" valign=\"bottom\"><b>Niv: </b></font><font  face=\"verdana\" size=\"1\" color=\"#000000\">" . $row["level"] . "</font><br><font  face=\"verdana\" size=\"1\" color=\"#990066\"align=\"left\" valign=\"bottom\"><b>Hp: </b></font><font  face=\"verdana\" size=\"1\" color=\"#000000\">" . $row["currenthp"] . " </font></td>
		             </tr>";
               echo "     <tr valign=\"top\">
		               <td width=\"119px\" height=\"12px\" background=\"././images/classement/bg3_best.gif\" ></td>
			      </tr>";	
	       echo "     </table>";

     }
}


?>
