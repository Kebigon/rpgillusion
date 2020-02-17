<?php 
// On ouvre pas la base de donnée, car elle sera ouverte dans dans la page login.php.
include("config.php");

$link = opendb();

$query = doquery ("SELECT * FROM {{table}} ORDER by buycost DESC ","items");   

echo" <div id=\"dek\"></div>
<script language=\"javascript\" type=\"text/javascript\" src=\"infobulle.js\"></script> ";

echo" <script language=\"javascript\">

function menuLink(linkLoc){

	if (linkLoc != \"\"){

	window.location=linkLoc;

    }
}
</script>";
 
// Début de l'affichage du tableau.   
 
$row = "0";
for ( $count = 1 ; $count <= 11 && $row != null ; $count ++ ) {
        $row = mysql_fetch_array($query);

	
 if (($count % 11) === 1 && $count >= 1) {

	       echo "      <table width=\"58px\" height=\"58px\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"bottom\" background=\"././images/items/bg_items.gif\">
	       	                        
				<tr>
		                <td class=\"items2\" width=\"58px\" height=\"58px\" valign=\"bottom\"><center><img src=\"././images/items/space_items.gif\"  valign=\"bottom\"/></center></td>
		          
	                        <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
		                <td class=\"items2\" width=\"1px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\"  valign=\"bottom\"/></center></td>
		          
		                </table>";
  }
     
 if (($count % 11) === 2 && $count >= 1) {

	     	   
	       echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"bottom\" background=\"././images/items/bg_items.gif\">
	                      
			      <tr>
		              <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
			      <td class=\"items2\" width=\"1px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\"  valign=\"bottom\"/></center></td>
		          
		             </table>";
  }
        
 if (($count % 11) === 3 && $count >= 1) {

	     
	       echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"bottom\" background=\"././images/items/bg_items.gif\">
	       
	                       <tr>
		                
		              <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
			        <td class=\"items2\" width=\"58px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\"  valign=\"bottom\"/></center></td>
		            
			    </table>";
  }
 
 if (($count % 11) === 4 && $count >= 1) {

	     
	       echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"bottom\" background=\"././images/items/bg_items.gif\">
	       
	                       <tr>
		                
		               <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
	                     <td class=\"items2\" width=\"58px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\"  valign=\"bottom\"/></center></td>
		          
	                      </table>";
  }
  
 if (($count % 11) === 5 && $count >= 1) {

	      
	       echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"bottom\" background=\"././images/items/bg_items.gif\">
	       
	                       <tr>
		                
                              <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
                              <td class=\"items2\" width=\"58px\" height=\"58px\"><center><img src=\"././images/items/space_items.gif\"  valign=\"bottom\"/></center></td>
		          
	                     </table>";
  }
   
  if (($count % 11) === 5 && $count >= 1) {

	       echo "      <table width=\"284px\" height=\"1px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  style=\"clear: both;\" align=\"bottom\">
	       
	                        <tr>
		                
				<td class=\"items\" width=\"284px\" height=\"1px\"><center><img src=\"././images/items/middle_items.gif\" align=\"center\" align=\"top\"/></center></td>
		                 
			        </tr>
	
	                      </table>";

     
    }
    
  if (($count % 11) === 6 && $count >= 1) {

	      
	       echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"top\" background=\"././images/items/bg_items.gif\">
	       
	                       <tr>
			       
		               <td class=\"items\" width=\"2px\" height=\"58px\"><center><img src=\"././images/items/space_items.gif\"  valign=\"top\"/></center></td>
		             
                                    <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
                              <td class=\"items\" width=\"1px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\" align=\"center\" align=\"top\"/></center></td>
		           
                             </table>";
}
         
if (($count % 11) === 7 && $count >= 1) {

	  echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"top\" background=\"././images/items/bg_items.gif\">
	       
	                  <tr>
		             
                          <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
                         <td class=\"items\" width=\"1px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\" align=\"center\" align=\"top\"/></center></td>
		           
                         </table>";
}
  
 if (($count % 11) === 8 && $count >= 1) {

	     echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"top\" background=\"././images/items/bg_items.gif\">
	       
	                     <tr>
		             
                              <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
                            <td class=\"items\" width=\"1px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\" align=\"center\" align=\"top\"/></center></td>
		           
                            </table>";
}
         
 if (($count % 11) === 9 && $count >= 1) {

	     echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"top\" background=\"././images/items/bg_items.gif\">
	       
	                    <tr>
		             
                             <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
                            <td class=\"items\" width=\"1px\" height=\"58px\"><center><img src=\"././images/items/top_items.gif\" align=\"center\" align=\"top\"/></center></td>
		           
                           </table>";
}
         
 if (($count % 11) === 10 && $count >= 1) {

	      echo "      <table width=\"58px\" height=\"58px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  align=\"left\" style=\"margin-right: 0px\" valign=\"top\" background=\"././images/items/bg_items.gif\">
	       
	                      <tr>
		             
                               <td class=\"items2\" width=\"59px\" height=\"58px\"><center><a onMouseOver=\"popup('<font color=#CC0099><u><b>" . $count . "/ " .addslashes(htmlspecialchars($row["name"])) ."</b></u></font><br><img src=././images/space_bulle.gif><br><b>Prix:</b> " . $row["buycost"] . " rubis<br><b>Arme de type:</b> " . $row["type"] . "<br><b>Description:</b> " .addslashes(htmlspecialchars($row["description"])) ." ','#FFFFF9')\" onMouseOut=kill() ;><img src=\"././images/items/" . $row["image"] . ".gif\" valign=\"bottom\"/></a></center></td>
		      
                              <td class=\"items\" width=\"2px\" height=\"58px\"><center><img src=\"././images/items/space_items.gif\"    valign=\"top\"/></center></td>
	           
		             </table>";
}

}

?>


