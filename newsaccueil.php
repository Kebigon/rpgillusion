<?php 
// On ouvre pas la base de donnée, car elle sera ouverte dans dans la page login.php.

include("config.php");

 $query = doquery ("SELECT * FROM {{table}} ORDER by id DESC","newsaccueil");   

    echo "      <table width=\"344px\"  height=\"154px \" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
    //Initialisation pour une valeur de départ non null pour rentrer dans la boucle
    $row = "0";

    for ( $count = 1 ; $count <= 5 && $row != null ; $count ++ ) {
        $row = mysql_fetch_array($query);

       //N'affiche pas la ligne si il n'y a plus d'enregistrements.
        if ( $row != null ) {
                
		echo "     <tr>";
		echo "    <td height=\"1px \"align=\"center\" class=\"login\" ><img src=\"././images/icon_news.gif\"  border=\"0\"></td>";
	        echo "    <td width=\"333px\" height=\"1px align=\"left\" ><font color=\"fe7314\">" . prettydatenews($row["postdate"]). "&nbsp;</font><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["titre"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br>" .addslashes(htmlspecialchars($row["content"])) ." ','#FFFFF9')\" onMouseOut=\"kill();\">

<a href='viewnews.php?news=".$row["id"]."'>" . $row["titre"] . "</a></td>";
                echo "    </tr>";
                echo "    <tr>";
                echo "    <td height=\"1px><img src=\"././images/classement/espace.gif\" width=\"24px\" height=\"3\"></td>";
	        echo "    <td height=\"1px><img src=\"././images/tirets_login.gif\" width=\"310px\" height=\"3\"></td>";
	        echo "    </tr>";
     }
}
                echo "     </table>";
?>

