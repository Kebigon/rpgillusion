<?php 
// Fonction de suppression du compte 
// Cod�e par Ted_2.3 
// Pour toute aide, allez sur http://rpgillusion.online.fr/forum/ ou �crivez �thekillerofcovenants@hotmail.fr 

function delete() 
{ 
global $userrow; 
$page .= "<center><b><u>Supprimer votre clan</b></u></center><br /><br />"; 
$page .= "<form method='post' action='index.php?do=deleteuser'>"; 
$page .= "Vous �tes sur le point de supprimer votre compte.<br />Etes-vous s�r de vouloir supprimer votre compte de jeu ?"; 
$page .= "<table><tr><td><input type='submit' value='Oui' name='Oui'></td><td><input type='submit' value='Non' name='Non'></td></tr></table>"; 
display($page, "Supprimer votre compte de jeu"); 
} 

function deleteuser() 
{ 
global $userrow; 

if ($userrow["id"] == false) 
{ 
$page .= "Tentative de hack d�tect�e. Votre IP a �t� enregistr�e."; 
display($page, "Tentative de hack d�tect�e"); 

} 
else 
{ 
if (isset($_POST['Non'])) 
{ 
$page .= "Votre compte n'a pas �t� supprim�.<br />Vous pouvez maintenant retourner <a href='index.php'>en ville</a>."; 
display($page, "Compte non-supprim�"); 

} 
elseif (isset($_POST['Oui'])) 
$query = doquery("DELETE FROM {{table}} WHERE id='".$userrow["id"]."'", "users"); 
if ($query == true) 
{ 
?> 
Votre compte a correctement �t� supprim�. Vous pouvez <a href="login.php?do=login">retourner � l'accueil du jeu</a>.<br /> 
Merci d'avoir jou� � DreamWar Online ! 
<?php 
} 
elseif ($query == false) 
{ 
$page .= "Une erreur s'est produite lors de la suppression de votre compte. Veuillez recommencer."; 
} 
} 
} 
?>