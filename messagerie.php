<?
#################################################################################
## Mod Messagerie
## Dévellopé par Tsunami <http://zfusion.free.fr/illusion/>
## Le 20 Janvier 2005
## Inclut envoi et réception, statut(lu,non lu, archivé), gestion(suppression, modification..) des messages
#################################################################################

// Inclusion des fichiers neccessaires au script
include('lib.php');
include('cookies.php');

opendb();

// Informations du joueur
$userrow = checkcookies();

$doex = explode(':', $_GET['do']);

if($_GET['do'] == "Reception") 
{ 
	$messtitle = 'Boîte de réception'; 
}
elseif($doex[0] == "Envoi") 
{ 
	$messtitle = 'Envoyer un message'; 
}
elseif($_GET['do'] == "Archives") 
{
	$messtitle = 'Archives'; 
}
elseif($doex[0] == "Lect")
{
	$messtitle = 'Lire un message';
}
elseif($doex[0] == "Read") // lire un message archivé
{
	$messtitle = 'Lire un message';
}
elseif($doex[0] == "Suppr")
{
	$messtitle = 'Supprimer un message';
}
elseif($doex[0] == "Archiver")
{
	$messtitle = 'Archiver un message';
}
elseif($doex[0] == "Envoi")
{
	$messtitle = 'Boîte d\'envoi';
}
else 
{ 
	$messtitle = 'Boîte de réception'; 
}

// Affichage du titre de la messagerie
$page = '<table cellspacing="0" cellpadding="0" height="40" width="90%" align="center">
<img src="images/messagerie.jpg">
<tr>
<td background="images/bg_1.1.png" width="6">
</td>
<td width="98%" background="images/bg_1.2.png">
<center>
<b>'.$messtitle.'</b>
<br />
<a href="?do=Archives" alt="Archives">Archives</a> - <a href="?do=Benvoi">Boîte d\'envoi</a>/<a href="?do=Reception">réception</a> - <a href="?do=Envoi">Envoyer un message</a></center>
</td>
<td background="images/bg_1.3.png" width="6">
</td>
<tr>
</table>';

if(empty($_GET['do']))
{
	header("location: ?do=Reception");
}

if($_GET['do'] == 'Reception' || empty($_GET['do']))
{

	// Lister les messages dont le destinataire est l'utilisateur
	$msglist = doquery("SELECT * FROM {{table}} WHERE destinataire='$userrow[id]' AND statut!='Archivé' ORDER BY date DESC","msg");

	$page .= '<table width="90%" align="center"><tr><td width="30%"><b>Titre</b></td><td width="20%"><b>Envoyeur</td><td width="30%"><center><b>Date</td><td width="20%"><center><b>Actions</td></tr>';
	while($msg = mysql_fetch_assoc($msglist))
	{
		$env = doquery("SELECT username FROM {{table}} WHERE id='$msg[envoyeur]'","users");
		$env = mysql_fetch_assoc($env);
	
	if($msg['statut'] == "Non lu")
	{
		$attributecolor = 'style="color:red;"';
	}
	
		$date = date("j/m/Y à G:i",$msg['date']);
	
		$page .= '<tr><td><a '.$attributecolor.' href="?do=Lect:'.$msg['id'].'">'.$msg['titre'].'</a></td><td>'.$env['username'].'</td><td>'.$date.'</td><td><center><a href="?do=Suppr:'.$msg['id'].'"><img border="0" src="images/msg_delete.gif" alt="S" /> <a href="?do=Archiver:'.$msg['id'].'"><img border="0" src="images/msg_archiv.gif" alt="- A" /></td></tr>';
	}
	$page .= '</table>';
	
	$page .= '<br /><br /><a href="?do=Suppr:All"><img style="float:left;" border="0" src="images/msg_delete.gif" alt="Supprimer tout">Supprimer tout les messages</a>';
}
elseif($doex[0] == 'Lect') 
{
	$msg1 = doquery("SELECT * FROM {{table}} WHERE id='$doex[1]' AND destinataire='$userrow[id]'","msg");
	$msg = mysql_fetch_assoc($msg1);
	
	if($msg['statut'] == "Non lu")
	{
	$update = doquery("UPDATE {{table}} SET statut='Lu' WHERE id='$msg[id]' AND destinataire='$userrow[id]'","msg");
	}
	$date = date("j/m/Y à G:i",$msg['date']);
	
	$env = doquery("SELECT username FROM {{table}} WHERE id='$msg[envoyeur]'","users");
	$env = mysql_fetch_assoc($env);
	
	$page .= '<table width="80%" align="center"><tr><td><b>'.$msg['titre'].'</b></td><td width="40%">- '.$date.'<br /> - '.$env['username'].'</td></tr>
	<tr>
	<td colspan="2" style="border:1px black dotted;padding:10px;" height="200">
	'.nl2br(stripslashes($msg['message'])).'
	</td>
	</tr>
	</table>';
	$page .= '<br /><br /><center>[<a href="?do=Envoi:'.$msg['id'].'">Répondre à ce message</a> - <a href="?do=Suppr:'.$msg['id'].'">Supprimer</a> - <a href="?do=Archiver:'.$msg['id'].'">Archiver</a>]';
	
}
elseif($doex[0] == 'Read') 
{
	$msg1 = doquery("SELECT * FROM {{table}} WHERE id='$doex[1]' AND envoyeur='$userrow[id]'","msg");
	$msg = mysql_fetch_assoc($msg1);
	
	
	$date = date("j/m/Y à G:i",$msg['date']);
	
	$env = doquery("SELECT username FROM {{table}} WHERE id='$msg[destinataire]'","users");
	$env = mysql_fetch_assoc($env);
	
	$page .= '<table width="80%" align="center"><tr><td><b>'.$msg['titre'].'</b></td><td width="40%">- '.$date.'<br /> - A '.$env['username'].'</td></tr>
	<tr>
	<td colspan="2" style="border:1px black dotted;padding:10px;" height="200">
	'.nl2br(stripslashes($msg['message'])).'
	</td>
	</tr>
	</table>';
	$page .= '<br /><br /><center>[<a href="?do=Envoi:'.$msg['id'].'">Répondre à ce message</a> - <a href="?do=Suppr:'.$msg['id'].'">Supprimer</a>]';
	
}
elseif($doex[0] == "Envoi")
{
	
	if(empty($_POST['message']) || empty($_POST['pseudo']) || empty($_POST['titre']))
	{
		if(isset($doex[1]))
		{
			$infen = doquery("SELECT envoyeur,titre FROM {{table}} WHERE id='$doex[1]'","msg");
			$infen = mysql_fetch_assoc($infen);
		
			$env = doquery("SELECT username FROM {{table}} WHERE id='$infen[envoyeur]'","users");
			$env = mysql_fetch_assoc($env);
		
			(substr_count($infen['titre'],'Re:' ) == 0) ? $pre = 'Re: ' : $pre = '';
		}
				
		$page .= '<form method="post"><table align="center" width="80%">
	<tr>
	<td width="100">
	&nbsp;&nbsp;Pseudo: 
	</td>
	<td>
	<input type="text" value="'.$env['username'].'" name="pseudo" size="60">
	</td>
	</tr>
	<tr>
	<td width="100">
	&nbsp;&nbsp;Titre: 
	</td>
	<td>
	<input type="text" name="titre" value="'.$pre.$infen['titre'].'" size="60">
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<textarea name="message" cols="50" rows="10"></textarea>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<center><input type="submit" value="Poster" /></center>
	</td>
	</tr>
	</table></form>';
	}
	else
	{
			$ide = doquery("SELECT id FROM {{table}} WHERE username='$_POST[pseudo]'","users");
			
			$error = 0;
			
			if(mysql_num_rows($ide) == 0)
			{
				$page .= '<center>Le joueur indiqué n\'existe pas.';
				$error++;
			}
			
			$ide = mysql_fetch_assoc($ide);
			$ides = $ide['id'];
			
			$message = addslashes($_POST['message']);
			$time = time();
			
			if($error == 0)
			{
				doquery("INSERT INTO {{table}} ( `id` , `titre` , `message` , `date` , `envoyeur` , `destinataire` , `statut` ) VALUES('', '$_POST[titre]', '$message', '$time', '$userrow[id]', '$ides', 'Non lu')","msg");
				$page .= '<center><br />Votre message pour '.$_POST['pseudo'].' a bien été envoyé à la poste.<br /><br /><a href="messagerie.php">Boite de réception</a>';
			}
			
		
	}
}
elseif($doex[0] == "Suppr")
{
	if($doex[1] == "All")
	{
		doquery("DELETE FROM {{table}} WHERE destinataire='$userrow[id]' AND statut!='Archivé'","msg");
		$page .= '<center><br />Tous les messages présents dans votre boîte de réception ont étés supprimés.<br /><br /><a href="?do=Reception">Boîte de réception</a>';
	}
	else
	{
		doquery("DELETE FROM {{table}} WHERE destinataire='$userrow[id]' AND id='$doex[1]'","msg");
		$page .= '<center><br />Ce message présent dans votre boîte de réception a été supprimé.<br /><br /><a href="?do=Reception">Boîte de réception</a>';
	}
}
elseif($doex[0] == "Archiver")
{
	$nbar = doquery("SELECT id FROM {{table}} WHERE statut='Archivé'","msg");
	$nbar = mysql_num_rows($nbar);
	
	if($nbar >= 25) // 25 :: nombre max d'éléments archivés
	{
		$page .= '<center>Désolé, mais vous avez atteind le nombre maximum de lettres archivées.<br /><br /><a href="?do=Reception">Boîte de réception</a>';
	}
	elseif($doex[1] == "All")
	{
		doquery("UPDATE {{table}} SET statut='Archivé' WHERE statut!='Archivé' AND destinataire='$userrow[id]'","msg");
		$page .= '<center><br />Tous les messages présents dans votre boîte de réception ont étés archivés.<br /><br /><a href="?do=Reception">Boîte de réception</a>';
	}
	else
	{
		doquery("UPDATE {{table}} SET statut='Archivé' WHERE statut!='Archivé' AND destinataire='$userrow[id]' AND id='$doex[1]'","msg");
		$page .= '<center><br />Ce message présent dans votre boîte de réception a été archivé.<br /><br /><a href="?do=Reception">Boîte de réception</a>';
	}
}
elseif($doex[0] == "Archives")
{

	// Lister les messages dont le destinataire est l'utilisateur
	$msglist = doquery("SELECT * FROM {{table}} WHERE destinataire='$userrow[id]' AND statut='Archivé' ORDER BY date DESC","msg");

	$page .= '<table width="90%" align="center"><tr><td width="30%"><b>Titre</b></td><td width="20%"><b>Envoyeur</td><td width="30%"><center><b>Date</td><td width="20%"><center><b>Actions</td></tr>';
	while($msg = mysql_fetch_assoc($msglist))
	{
		$env = doquery("SELECT username FROM {{table}} WHERE id='$msg[envoyeur]'","users");
		$env = mysql_fetch_assoc($env);
	
		$date = date("j/m/Y à G:i",$msg['date']);
	
		$page .= '<tr><td><a href="?do=Read:'.$msg['id'].'">'.$msg['titre'].'</a></td><td>'.$env['username'].'</td><td>'.$date.'</td><td><center><a href="?do=Suppr:'.$msg['id'].'"><img border="0" src="images/msg_delete.gif" alt="S" /></td></tr>';
	}
	$page .= '</table>';
	
}
elseif($doex[0] == "Benvoi")	// Boite d'envoi - messages envoyés
{
	// Lister les messages dont l'nvoyeur est le membre
	$msglist = doquery("SELECT * FROM {{table}} WHERE envoyeur='$userrow[id]' AND statut='Non lu' ORDER BY date DESC","msg");

	$page .= '<table width="90%" align="center"><tr><td width="30%"><b>Titre</b></td><td width="20%"><b>Envoyeur</td><td width="30%"><center><b>Date</td><td width="20%"><center><b>Actions</td></tr>';
	while($msg = mysql_fetch_assoc($msglist))
	{
		$env = doquery("SELECT username FROM {{table}} WHERE id='$msg[destinataire]'","users");
		$env = mysql_fetch_assoc($env);
	
		$date = date("j/m/Y à G:i",$msg['date']);
	
		$page .= '<tr><td><a href="?do=Lect:'.$msg['id'].'">'.$msg['titre'].'</a></td><td>'.$env['destinataire'].'</td><td>'.$date.'</td><td><center><a href="?do=Suppr:'.$msg['id'].'"><img border="0" src="images/msg_delete.gif" alt="S" /> <a href="?do=Archiver:'.$msg['id'].'"><img border="0" src="images/msg_archiv.gif" alt="- A" /></td></tr>';
	}
	$page .= '</table>';
	
	$page .= '<br /><br /><a href="?do=Suppr:All"><img style="float:left;" border="0" src="images/msg_delete.gif" alt="Supprimer tout">Supprimer tout les messages</a>';
}
display($page,"Messagerie");