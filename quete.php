<?php

function liste () { //Listage des Quetes disponibles
global $userrow ;
if($userrow["quete"] > '0')
{
$page .= "Vous avez déjà une quête en cours. Finissez là avant d'en choisir une autre !<br>Regardez dans votre journal de quête.";
display($page, "Quête en cours"); 
}
else
{
$page .= 'Bonjour !<br>';
$page .= 'Vous venez pour nous aider je supppose ? Alors consultez le tableau ci dessous, celui ci vous donnera tous les renseignements necessaires pour les quêtes de votre niveau.<br>';
$page .= '<table border="1"><tr><td>Quete</td><td>Description</td><td>Experience Gagn&eacute;e </td><td>Gils Gagn&eacute;s </td><td>Accepter</td></tr>';
//recuperation nom ville
$query=mysql_query("SELECT name from rpg_towns WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."'");
while($row=mysql_fetch_array($query)) { $ville=$row[0] ; }
//recuperation quete
$query=mysql_query("SELECT * from rpg_quete WHERE level>='".$userrow["level"]."' AND town='$ville'");
while ($row=mysql_fetch_array($query))
{ 
$fait=0;
if(ereg($row[0],$userrow["listquest"])) {$page .= ''; $fait=1;} //Déjà faite on l'affiche pas
elseif($row[12]<>'0' AND ereg($row[12],$userrow["listquest"])) //Quete prolongee et quete avant deja faite
{ 
$page .= '<tr><form action="index.php?do=accept" method="POST"><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[10].'</td><td>'.$row[11].'</td><td><input type="hidden" name="quest" value="'.$row[0].'"><input type="submit" value="Oui"></form></td></tr>';
}
//if($row[12]=='0' AND $fait=='0' ) //pas de quete prolongee et pas faite 
elseif($row[12]=='0')
{
$page .= '<tr><form action="index.php?do=accept" method="POST"><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[10].'</td><td>'.$row[11].'</td><td><input type="hidden" name="quest" value="'.$row[0].'"><input type="submit" value="Oui"></form></td></tr>'; 
}
}
$page .= '</table>';
display($page, "Quêtes Réalisable"); 
}
}

function journal() { //Affichage du journal de la Quete en Cours
global $userrow ;
$requete=mysql_query("SELECT quete FROM rpg_users WHERE id='" .$userrow["id"] ."'");
while($row=mysql_fetch_array($requete)) { $queteid=$row[0];}
$requete=mysql_query("SELECT * FROM rpg_quete WHERE id='". $queteid ."'");
$page .= '<div align="center"><strong>Journal de Quete</strong></div><br>';
$page .= '<table border="1"><tr><td>Quete</td><td>Description</td><td>Experience Gagn&eacute;e </td><td>Gils Gagn&eacute;s </td></tr>';
while ($row=mysql_fetch_array($requete))
{
$page .="<tr><td>$row[1]</td><td>$row[2]</td><td>$row[10]</td><td>$row[11]</td></tr>";
}
$page .= '</table>';
display($page, "Quête En Cours"); 
}

function accept() { //Acceptation de Quete
global $userrow;
extract($_POST); 
mysql_query("UPDATE rpg_users SET quete='$quest' WHERE id='". $userrow["id"] ."'");
$page = 'Merci de nous aider ! <br> Je vous souhaite bonne chance !<br>(consulter le journal des quêtes)';
display($page, "Quête Acceptée"); 

}

?>