<?php

function lahku() { //Vous pouvez exclure un membre du clan
global $userrow;
if(isset($_POST['yes'])) {
$page.= "<center>Vous avez �t� exclu du clan!<p><p><a href=\"index.php\">explorer le monde</a></center>";

$query = doquery("SELECT * FROM {{table}} WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
 while ($kambarow = mysql_fetch_array($query)) { 
$kuulsus = $kambarow["kuulsus"] - $userrow["level"]; }
$updatequery = doquery("UPDATE {{table}} SET kuulsus='$kuulsus' WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
$updateuserquery = doquery("UPDATE {{table}} SET kambaid='0', liikmestaatus='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); 

 }
 elseif(isset($_POST['no'])) {
$page.= <<<END
<meta http-equiv="refresh" content="2;URL=index.php">
END;
$page.="Vous allez �tre redirig� vers la page principale"; }

else { $page.= "<b><u>Voulez-vous quitter le clan?</u></b><br /><br />Etes-vous s�r?<p><p>";
$page.="<form action=index.php?do=lahku method=post><input type=submit value=oui name=yes><p><input type=submit value=non name=no></form>"; } 
display($page, "Quitter le clan"); }

function teekamp() { //Vous pouvez faire votre clan � partir du niveau 40, vous pouvez changer ce niveau
global $userrow;
if($userrow["level"] < 25) { display("Vous n'avez pas niveau requit!<br /> Il vous faut un lvl <b>25</b> pour cr�er votre clan.", "Error"); }
elseif (isset($_POST['teekamp'])) {
if($_POST['nimi'] == "") { display("Vous n'avez pas rentr� de nom pour le clan!!<br /><a href=\"index.php?do=kamp\">Pr�c�dent</a>", "Viga"); }
else { $page.="Votre clan a bien �t� cr��!<br /><br /><a href=\"index.php?do=kamp\">Aller au Quartier g�n�ral</a>";
$query = doquery("INSERT INTO {{table}} SET id='', nimi='".$_POST['nimi']."', logo='".$_POST['logo']."', omanik='".$userrow["id"]."'", "clans"); 
//mise � jour du membre ayant cr�� son clan. kambajuht --> chef du clan, si kambajuht est �gal � 1, c'est que vous �tes le chef du clan, et liikmestaatus --> statut des membres. Si votre statut de membre est �gal � 5 il sera affich� dans le clan � cot� de votre nom chef
$query2 = doquery("UPDATE {{table}} SET kambaid='".$userrow["id"]."', kambajuht='1', liikmestaatus='5' WHERE id='".$userrow["id"]."' LIMIT 1", "users"); } }
else {
$page .= "<center><form action=index.php?do=teekamp method=post><br />";
			$page .= "Nom du clan <input type=text name=nimi size=20 max=20><br />";
			$page .= "Logo du clan <input type=text name=logo size=20 max=20><br />";
			$page .= "<input type=submit value=Valider name=teekamp></form><br /><br /><br />";
			$page .= "Vous pouver aussi retourner <a href=\"index.php\"> explorer le monde</a></center>"; }
     display($page, $title); }

function auaste($id) { // Ici vous pouvez changer le rang des membres // chef, soldat, nouveau ect.
global $userrow;   
if(isset($_POST['muuda'])) { 
doquery("UPDATE {{table}} SET liikmestaatus='".$_POST['liikmestaatus']."' WHERE id='$id' LIMIT 1", "users"); 
$page.="Le rang du membre a �t� modifi�!!<br /><br />Retour au <a href=\"index.php?do=kamp\">QG</a>"; 
}
else {
$query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "users");
 while ($row = mysql_fetch_array($query)) { 
$mees = $row["charname"];
$page.= "<b><u>Modifier le rang des membres</b></u><br /><br />";
$page .= "<form action=index.php?do=auaste:$id method=post><br />";
			$page .= "rang de $mees : <input type=text name=liikmestaatus size=5><br />";
			$page .= "<input type=submit value=CHANGE name=muuda></form><br />"; } }
display($page, "Administration des rangs"); }


function kick($id) { //exclure un membre du clan
global $userrow;

$updatequery  = doquery("UPDATE {{table}} SET kambaid='0', liikmestaatus='0', liitumine='0' WHERE id='".$id."' LIMIT 1", "users");

$query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "users");
 while ($row = mysql_fetch_array($query)) { 


$kambaquery = doquery("SELECT*FROM {{table}} WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
 while ($kambarow = mysql_fetch_array($kambaquery)) { 
$k = $row["level"] * 2;
$uuskuulsus = $kambarow["kuulsus"] - $k;
$kuulsusupdate = doquery("UPDATE {{table}} SET kuulsus='$uuskuulsus' WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
} }
$page.= "Le membre a �t� exclu du clan!<br /><br />Retourner au <a href=\"index.php?do=kamp\">Quartier g�n�ral</a>"; 

display($page, "Exclure un membre"); }

function yes($id) { //Si vous acceptez un membre dans votre clan
global $userrow;

$liitujaquery = doquery("SELECT*FROM {{table}} WHERE id='$id' LIMIT 1", "liitujad"); //Vous gagnez de l'exp�rience pour votre clan quand le membre rejoin votre clan
 while ($liitujarow = mysql_fetch_array($liitujaquery)) { 

$kasutajaupdate = doquery("UPDATE {{table}} SET kambaid='".$userrow["id"]."' WHERE id='".$liitujarow["liitujaid"]."'", "users");//le membre accepte

$kambaquery = doquery("SELECT*FROM {{table}} WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
 while ($kambarow = mysql_fetch_array($kambaquery)) { 
$k = $liitujarow["kuulsus"] * 2;
$uuskuulsus1 = $kambarow["kuulsus"] + $k; //nouvelle exp�rience

$update = doquery("UPDATE {{table}} SET kuulsus='$uuskuulsus1' WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");

$page.= "Le membre a ete accepter dans votre clan.<br /><br />Par consequence votre clan a gagn� <b>$k</b> point d'experience<p><p>Vous pouvez retourner au <a href=\"index.php?do=kamp\">QG</a>"; 
$delete = doquery("DELETE FROM {{table}} WHERE id='$id'", "liitujad");
} } 
display($page, "Liige vastuv�etud"); }

function no($id) { //Si vous ne l'acceptez pas dans votre clan
$page.= "Demande refus�e!!<br /><br />";
$page.= "<a href=\"index.php?do=kamp\">Retourner au Quartier g�n�ral</a>";
doquery("DELETE FROM {{table}} WHERE id='$id'", "liitujad");
display($page, "Demande refus�e"); }

function liitu($id) {
global $userrow;
if($userrow["liitumine"] == 1) { $page.= "Vous avez d�ja fait votre demande!<p><a href=\"index.php\">Tagsi linna</a>"; }
else {
doquery("INSERT INTO {{table}} SET id='', kambaid='$id', kuulsus='".$userrow["level"]."', liitujaid='".$userrow["id"]."', liitujanimi='".$userrow["charname"]."'", "liitujad");
doquery("UPDATE {{table}} set liitumine='1' WHERE id='".$userrow["id"]."'","users");
$page.= "Demande envoy�e.<br />";
$page.= "<a href=\"index.php\">Tagasi linna</a>"; }
display($page, "Demande envoy�e"); }

function kamp() { //
global $userrow;

if($userrow["kambaid"] == 0) {
   $page .= "<center><b><u>Quartier g�n�ral</b></u></center><br />";
   $page.= "<center>Vous voulez cr�er un clan? <a href=\"index.php?do=teekamp\">Cliquez-ici</a><br /><br/><br /></center>";
    $page .= "<table width=\"80%\">";
    $query = doquery("SELECT * FROM {{table}} ORDER BY kuulsus DESC LIMIT 100", "clans");
    $rank = 1;
    while ($row = mysql_fetch_array($query)) { 
        $page .= "<tr><td width=\"10%\"><b>$rank</b></td><td width=\"50\">".$row["nimi"]."</a></td><td width=\"200%\">Exp�rience: <b>".$row["kuulsus"]."</b></td><td width=\"20%\"><a href=\"index.php?do=liitu:".$row["omanik"]."\">Rejoindre le clan</a></td></tr>\n";
        $rank++;
    }
    $page .= "</table>\n<br /><br />\n";
    $page .= "<center>Cliquez-<a href=\"index.php\"> ici </a>pour explorer le monde</center>";
	$title = "Int�grer le clan"; }


elseif($userrow["kambajuht"] == 0 & $userrow["kambaid"] > 0 ) { //membre du clan normal
	
	$kambaquery = doquery("SELECT logo FROM {{table}} WHERE omanik='".$userrow["kambaid"]."' LIMIT 1", "clans");
 while ($kambarow = mysql_fetch_array($kambaquery)) { 

	
			 $logo = $kambarow["logo"]; } 
		 $page .= "<center><img src=\"$logo\" width=\"393\" height=\"98\"/></center>"; //afficher le logo du clan
		 $page .= "<form action=index.php?do=kamp method=post>";
		 $page .= "<table><tr><td><input type=submit value='Infos clan' name=kamp></td><td><input type=submit value='Messages' name=teated></td><td><input type=submit value='Membres' name=liikmed></td><td><input type=submit value='Page principale' name=tagasi></td></tr><tr><center><a href=\"index.php\">Explorer le monde</a></center></td></tr><tr></tr><tr><a href=\"index.php?do=lahku\">Quitter le clan !!</a></td></tr></table>"; 
		 $page .= "<table><tr><td><input type=submit value='Ajouter un message' name=lisateade></td></tr><tr></tr></table>";    
			   }
elseif ($userrow["kambajuht"] == 1) { //chef du clan
			$kambaquery = doquery("SELECT logo FROM {{table}} WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
 while ($kambarow = mysql_fetch_array($kambaquery)) { 
			
			 $logo = $kambarow["logo"]; }
		 $page .= "<center><img src=\"$logo\" width=\"393\" hnoght=\"98\" /><br><br><a href=\"index.php\">Retourner en ville</a></center>";
		 $page .= "<form action=index.php?do=kamp method=post>";
		 $page .= "<table><tr><td><input type=submit value='Infos clan' name=kamp></td><td><input type=submit value='Messages' name=teated></td><td><input type=submit value='Membres' name=liikmed></td><td><input type=submit value='Administration' name=admin></td><td><input type=submit value='Page principale' name=tagasi></td></tr><tr></tr><tr></td></tr></table>";  
		 
		 } 
		


if(isset($_POST['kamp'])) {
$kambaquery = doquery("SELECT*FROM {{table}} WHERE omanik='".$userrow["kambaid"]."' LIMIT 1", "clans");
 while ($kambarow = mysql_fetch_array($kambaquery)) { 

				$omanikquery = doquery("SELECT*FROM {{table}} WHERE id='".$kambarow["omanik"]."' LIMIT 1", "users");
 while ($omanikrow = mysql_fetch_array($omanikquery)) { 

		

$page.= "<center><b><u>Infos clan</b></u></center><br /><br /><table>";
$page .="<tr><td>Nom du clan :</td><td>".$kambarow["nimi"]."</td></tr>";
$page .="<tr><td>Chef du clan :</td><td><a href=index.php?do=onlinechar:".$omanikrow["id"]."\">".$omanikrow["charname"]."</a></td></tr>";
$page .="<tr><td>Exp�rience du clan :</td><td>".$kambarow["kuulsus"]."</td></tr></table>";  }  } }




if(isset($_POST['teated'])) {
	
		$kampquery = doquery("SELECT * FROM {{table}} WHERE omanik='".$userrow["kambaid"]."' LIMIT 1", "clans");
	    
	 			 
    $newsquery = doquery("SELECT * FROM {{table}} WHERE kambaid='".$userrow["kambaid"]."' ORDER BY id DESC LIMIT 25", "kambauudised");
    $rank = 1;
    while ($newsrow = mysql_fetch_array($newsquery)) { 
        $page .= "<br/><br /><b>$rank.</b> ".$newsrow["sisu"]."<br />Message de: <a href=\"index.php?do=onlinechar:".$newsrow["lisajaid"]."\">".$newsrow["lisajanimi"]."</a><br/>";
        $rank++;
		
    } }
				
		
	elseif(isset($_POST['lisateade'])) {
		
				 $page .= "<form action=index.php?do=kamp method=post>";
		

		 $page .= "Message:<br /><textarea name=\"sisu\" rows=\"4\" cols=\"20\" max=50></textarea><br /><br /><input type=\"submit\" name=\"Valider\" value=\"Envoyer\" />"; } 
		 	
		 	 
		elseif(isset($_POST['Valider'])) {
		$updatequery = doquery("INSERT INTO {{table}} SET id='', kambaid='".$userrow["kambaid"]."', lisajaid='".$userrow["id"]."', lisajanimi='".$userrow["charname"]."', sisu='".$_POST['sisu']."'", "kambauudised");					
		
			$page.= "Message ajout�";
			} 
	
		
	
	
		elseif(isset($_POST['admin'])) {
	
			 $page .= "<form action=index.php?do=kamp method=post>";
		 $page .= "<table><tr><td><input type=submit value='Administration du clan' name=seaded></td><td><input type=submit value='Ajouter un message' name=lisateade></td><td><input type=submit value='Rangs' name=auastmed></td><td><input type=submit value='Exclure un membre' name=kick></td><td><input type=submit value='Demandes' name=avaldus></td></td></tr><tr></tr></table>"; 
		 }
		 
		 		 		 		 
		 
		 elseif(isset($_POST['avaldus'])) {
		$page .= "<table><tr><td><input type=submit value='Ajouter un message' name=lisateade></td><td><input type=submit value='Rangs'  name=auastmed></td><td><input type=submit value='Exclure un membre' name=kick></td></tr></table>";
		
		 $page .= "<table width=\"80%\">";
    $query = doquery("SELECT * FROM {{table}} WHERE kambaid='".$userrow["id"]."' ORDER BY id DESC LIMIT 100", "liitujad");
   
	$rank = 1;
    while ($row = mysql_fetch_array($query)) { 
  $kampquery = doquery("SELECT * FROM {{table}} WHERE id='".$row["liitujaid"]."'", "users");
   
	
    while ($kamprow = mysql_fetch_array($kampquery)) {
$page .= "<tr><td width=\"10%\"><b>$rank</b></td><td width=\"50\"><a href=\"index.php?do=onlinechar:".$row["liitujaid"]."\">Accepter ".$row["liitujanimi"]."?</a></td><td>".$kamprow["level"]."<td width=\"100%\"><a href=\"index.php?do=yes:".$row["id"]."\">[oui]</a></td><td width=\"100%\"><a href=\"index.php?do=no:".$row["id"]."\">[non]</a></td></tr>\n";
        $rank++;
    } }
	    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\">Vous n'avez aucune demande</td></tr>\n"; } // 

    $page .= "</table>\n<br /><br />\n"; }
	
	elseif(isset($_POST['seaded'])) {
	$page.= "<center><b><u>Administration</b></u></center><br /><br />";//modifier le nom du clan
	$page .= "<form action=index.php?do=kamp method=post><br />"; 
	$page .= "Nom du clan <input type=text name=kambanimi size=5><br />";
	$page .= "<input type=submit value='Modifier' name=nimi><br /><br />";
	$page.= "<center><b><u>Logo du clan</b></u></center><br /><br />"; //Logo du clan
    $page .= "URL du logo: <input type=text name=kambalogo size=20>(Insert http://!MAX size <b>400</b>X<b>100</b> pix)<br />";
	$page .= "<input type=submit value='Modifier' name=logo><br />";
	$page.= "<center><b><u>Supprimer votre clan</b></u></center><br /><br />"; //Logo du clan
    $page .= "Cliquez <a href='index.php?do=suppr'>ici</a> pour supprimer votre clan<br />"; 
	$page.= "<br /><br /><center>Retourner au <a href=\"index.php?do=kamp\">Quartier g�n�ral</a></center>";  }
	
elseif(isset($_POST['nimi'])) {
	$page .= "<center><br />Le nom du clan a �t� modifi�!<br /><br /><a href=\"index.php?do=kamp\">Retourner au Quartier g�n�ral</a></center>";
	doquery("UPDATE {{table}} SET nimi='".$_POST['kambanimi']."' WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
	 }
	 
	 elseif(isset($_POST['logo'])) {
	$page.= "<center><br /><br />Le logo du clan a �t� modifi�!<br /><br /><a href=\"index.php?do=kamp\">Retourner au Quartier g�n�ral</a></center>";
	doquery("UPDATE {{table}} SET logo='".$_POST['kambalogo']."' WHERE omanik='".$userrow["id"]."' LIMIT 1", "clans");
	 }
	
	
	elseif(isset($_POST['auastmed'])) {
			 $page .= "<form action=index.php?do=kamp method=post>";
		 $page .= "<table><tr><td><input type=submit value='Ajouter un message' name=lisateade></td><td><input type=submit value=Membres name=liikmed></td><td><input type=submit value='Rangs'  name=auastmed></td><td><input type=submit value=exclure name=kick></td></td><td><input type=submit value='Page principale'  name=tagasi></td></tr><tr></tr></table>"; 
				 
	$page .= "<table width=\"80%\">";
    $query = doquery("SELECT * FROM {{table}} WHERE kambaid='".$userrow["kambaid"]."' ORDER BY liikmestaatus DESC LIMIT 1000", "users");
  	$rank = 1;
    while ($row = mysql_fetch_array($query)) { 
 
 if($row["liikmestaatus"] == 0) { $staatus = "Nouveau"; }   elseif($row["liikmestaatus"] == 1) { $staatus = "Membre"; }   elseif($row["liikmestaatus"] == 2) { $staatus = "Soldat"; }   elseif($row["liikmestaatus"] == 3) { $staatus = "Commandant"; }   elseif($row["liikmestaatus"] == 4) { $staatus = "Bras droit"; }   elseif($row["liikmestaatus"] == 5) { $staatus = "Chef"; }
	  
 
$page .= "<tr><td width=\"10%\"><b>$rank</b></td><td width=\"50\"><a href=\"index.php?do=onlinechar:".$row["id"]."\">".$row["charname"]."</a></td><td width=\"200%\">Lvl: <b>".$row["level"]."</b></td><td>Rang: </td><td><b>$staatus</b></td><td width=\"100\"><a href=\"index.php?do=auaste:".$row["id"]."\">[Changer]</a></td></tr>\n";
        $rank++;
    }
    $page .= "</table>\n<br /><br />\n"; } 
	
				
	elseif(isset($_POST['liikmed'])) {
				
	
	 $page .= "<table width=\"80%\">";
    $liikmedquery = doquery("SELECT * FROM {{table}} WHERE kambaid='".$userrow["kambaid"]."' ORDER BY liikmestaatus DESC LIMIT 1000", "users");
    
	$rank = 1;
    while ($liikmerow = mysql_fetch_array($liikmedquery)) { 
	  if($liikmerow["liikmestaatus"] == 0) { $staatus = "Nouveau"; }   elseif($liikmerow["liikmestaatus"] == 1) { $staatus = "Membre"; }   elseif($liikmerow["liikmestaatus"] == 2) { $staatus = "Soldat"; }   elseif($liikmerow["liikmestaatus"] == 3) { $staatus = "Commandant"; }   elseif($liikmerow["liikmestaatus"] == 4) { $staatus = "Bras droit"; }   elseif($liikmerow["liikmestaatus"] == 5) { $staatus = "Chef"; }
        $page .= "<tr><td width=\"10%\"><b>$rank</b></td><td width=\"50\"><a href=\"index.php?do=onlinechar:".$liikmerow["id"]."\">".$liikmerow["charname"]."</a></td><td width=\"100%\"><b>".$liikmerow["level"]."</b></td><td>Rang: $staatus</td></tr>\n";
        $rank++;
    }
	
    $page .= "</table>\n<br /><br />\n";
			} 
	
			elseif(isset($_POST['kick'])) {
	
		 $page .= "<form action=index.php?do=kamp method=post>";
			
	 $page .= "<table width=\"80%\">";
    $liikmedquery = doquery("SELECT * FROM {{table}} WHERE kambaid='".$userrow["kambaid"]."' ORDER BY liikmestaatus DESC LIMIT 1000", "users");
    
	$rank = 1;
    while ($liikmedrow = mysql_fetch_array($liikmedquery)) { 
	  
	if($liikmedrow["kambajuht"] == 1) {  $kick = "";  }
	else { $kick ="<a href=\"index.php?do=kick:".$liikmedrow["id"]."\">[Exclure le membre]</a>"; }
        
		$page .= "<tr><td width=\"10%\"><b>$rank</b></td><td width=\"50\"><a href=\"index.php?do=onlinechar:".$liikmedrow["id"]."\">".$liikmedrow["charname"]."</a></td></td><td>$staatus</td><td>$kick</td></tr>\n";
        $rank++;
    }
	
    $page .= "</table>\n<br /><br />\n";
			} 
			
		display($page, "Exclure un membre");
 }
 
 function suppr() { //Pour supprimer votre clan
global $userrow;
$page .= "<form action=index.php?do=suppr method=post>";
$page .= "<center><b><u>Supprimer votre clan</b></u></center><br /><br />";
$page .= "Etes vous certains de vouloir supprimer votre clan?";
$page .= "<table><tr><td><input type=submit value='Oui' name=Oui></td><td><input type=submit value='Non' name=Non></td></tr></table>";

if(isset($_POST['Non'])) {
$page .= "Votre clan n'a donc pas �t� supprim�.";
$page .= "Vous pouvez retourner au <a href='index.php?do=kamp'>Quartier G�n�ral</a>.";
}
elseif(isset($_POST['Oui'])) {
$query = doquery("DELETE FROM {{table}} WHERE omanik='".$userrow["id"]."'", "clans");
$query = doquery("UPDATE {{table}} SET kambaid='0', liikmestaatus='0', liitumine='0' WHERE kambaid='".$userrow["id"]."'","users");
$page .= "<center><b><u>Votre clan a bien �t� supprim�.</b></u></center><br /><br />";
$page .= "Cliquez <a href='index.php'>ici</a> pour retourner en ville.";
}
display($page, "Supprimer votre clan"); 
} 
?>