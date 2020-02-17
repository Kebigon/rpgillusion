<?php 
// On ouvre pas la base de donnée, car elle sera ouverte dans dans la page login.php.
include("config.php");

$link = opendb();
 
$query = doquery ("SELECT * FROM {{table}} ORDER by id DESC ","blocs"); 

$row = "0";
for ( $count = 1 ; $count <= 2 && $row != null ; $count ++ ) {
        $row = mysql_fetch_array($query);

// Début de la table copyright. On compte que 1 fois car on affiche qu'une table.

 if (($count % 2) === 1 && $count >= 1) {

	       echo "      <table>
	                        <tr>
				<td><img src=\"././images/barre_copyright.gif\"/>
				</tr>
				</table>
				<table>
	                        
	       	                        
				<tr>
		                <td valign=\"middle\" class=\"classement\"><img src=" . $row["bloc1"] . "></td>
				 <td valign=\"middle\" class=\"classement\">&nbsp;</td>
		                <td valign=\"middle\" class=\"classement\"><img src=" . $row["bloc2"] . "></td>
				<td valign=\"middle\" class=\"classement\">&nbsp;</td>
		                <td valign=\"middle\" class=\"classement\">" . $row["bloc3"] . "<font color=\"#ffffff\"><script type=\"text/javascript\" src=\"http://www.ovnet.net/live/?code=0/100/6038/6/1&ID=19713\"></script></font><br>" . $row["bloc4"] . "<br>" . $row["bloc5"] . "</td>
				</tr>
                                </table>";
  }
  }

?>


