<?php 
// Fonction de suppression du compte 
// Codée par Ted_2.3 
// Pour toute aide, allez sur http://rpgillusion.online.fr/forum/ ou écrivez àthekillerofcovenants@hotmail.fr 

function delete() 
{ 
global $userrow; 
$page .= "<center><b><u>Supprimer votre clan</b></u></center><br /><br />"; 
$page .= "<form method='post' action='index.php?do=deleteuser'>"; 
$page .= "Vous êtes sur le point de supprimer votre compte.<br />Etes-vous sûr de vouloir supprimer votre compte de jeu ?"; 
$page .= "<table><tr><td><input type='submit' value='Oui' name='Oui'></td><td><input type='submit' value='Non' name='Non'></td></tr></table>"; 
display($page, "Supprimer votre compte de jeu"); 
} 

function deleteuser() 
{ 
global $userrow; 

if ($userrow["id"] == false) 
{ 
$page .= "Tentative de hack détectée. Votre IP a été enregistrée."; 
display($page, "Tentative de hack détectée"); 

} 
else 
{ 
if (isset($_POST['Non'])) 
{ 
$page .= "Votre compte n'a pas été supprimé.<br />Vous pouvez maintenant retourner <a href='index.php'>en ville</a>."; 
display($page, "Compte non-supprimé"); 

} 
elseif (isset($_POST['Oui'])) 
$query = doquery("DELETE FROM {{table}} WHERE id='".$userrow["id"]."'", "users"); 
if ($query == true) 
{ 
?> 
Votre compte a correctement été supprimé. Vous pouvez <a href="login.php?do=login">retourner à l'accueil du jeu</a>.<br /> 
Merci d'avoir joué à DreamWar Online ! 
<?php 
} 
elseif ($query == false) 
{ 
$page .= "Une erreur s'est produite lors de la suppression de votre compte. Veuillez recommencer."; 
} 
} 
} 
?>