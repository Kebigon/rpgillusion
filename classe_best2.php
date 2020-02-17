<?php 
// On ouvre pas la base de donnée, car elle sera ouverte dans dans la page login.php.

include("config.php");

 $query = doquery ("SELECT * FROM {{table}} ORDER by kuulsus DESC","clans");   

   $row = "0";
for ( $count = 1 ; $count <= 2 && $row != null ; $count ++ ) {
        $row = mysql_fetch_array($query);
        if ( $row != null ) {

	       echo "      <table width=\"119px\" height=\"142px\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 2px\" valign=\"middle\">";
	       echo "     <tr>
		               <td width=\"119px\" height=\"8px\" background=\"././images/classement/bg1_best.gif\"></td>
			      </tr>";	       
	        echo "    <tr>
		                <td width=\"119\" height=\"122px\" valign=\"top\" border=\"0\" background=\"././images/classement/bg2_best.gif\"><font  face=\"verdana\" size=\"1\" color=\"#000000\" align=\"left\" valign=\"bottom\"><img src=\"././images/classement/num-" . $count . "a.gif\" align=\"left\" valign=\"top\" class=\"classement2\" /><img src='" . $row["logo"] . "' BORDER=0 width='80px' height='80px'><br><br><b>Nom: </b></font><font  face=\"verdana\" size=\"1\" color=\"#000000\">" . $row["nimi"] . "</font><br><font  face=\"verdana\" size=\"1\" color=\"#000000\"align=\"left\" valign=\"bottom\"><b>Niv: </b></font><font  face=\"verdana\" size=\"1\" color=\"#000000\">" . $row["kuulsus"] . "</font></td>
		             </tr>";
               echo "     <tr valign=\"top\">
		               <td width=\"119px\" height=\"12px\" background=\"././images/classement/bg3_best.gif\" ></td>
			      </tr>";	
	       echo "</table>";

     }
}


?>
