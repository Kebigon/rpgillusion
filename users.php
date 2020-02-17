<?php // users.php :: Page d'inscription ou concernant le Password.

include('kernel/functions.php');
include('kernel/display_log.php');
$link = opendb();

$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

$menuquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "menu_users");
$menurow = mysql_fetch_array($menuquery);

$advertising['advertising'] = $menurow['content'];
$template_menu = gettemplate("advertising");
$advertising = parsetemplate($template_menu, $advertising);

if(isset($_GET['do'])){
switch ($_GET['do']) {
  case 'register': register(); break;
   case 'verify': verify(); break;
    case 'lostpassword': lostpassword(); break;
     case 'changepassword': changepassword(); break;
  }  
}

function register() { // Créer un nouveau compte.
	
    global $controlrow, $advertising;
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        
        $errors = 0; $errorlist = "";
        
        // Processus des ID.
        if (trim($username) == "") { $errors++; $errorlist .= "- Vous n'avez entré aucun ID.<br>"; }
        if (preg_match("/[\^*+<>?#]/", $username)==1) { $errors++; $errorlist .= "- Votre ID doit être écrit en caractères alphanumérique.<br>"; } 
        $usernamequery = doquery("SELECT username FROM {{table}} WHERE username='".addslashes($username)."' LIMIT 1","users");
        if (mysql_num_rows($usernamequery) > 0) { $errors++; $errorlist .= "- L'ID est déja pris.<br>"; }

        // Processus des adresse email.
        if (trim($email1) == "" || $email2 == "") { $errors++; $errorlist .= "- Vous n'avez entré aucun E-mail.<br>"; }
        if ($email1 != $email2) { $errors++; $errorlist .= "- Les 2 adresses E-mail que vous avez inscrit ne sont pas indentiques.<br>"; }
        if (! is_email($email1)) { $errors++; $errorlist .= "- L'adresse E-mail que vous avez inscrit est invalide.<br>"; }
        $emailquery = doquery("SELECT email FROM {{table}} WHERE email='".addslashes($email1)."' LIMIT 1","users");
        if (mysql_num_rows($emailquery) > 0) { $errors++; $errorlist .= "- L'adresse E-mail est déja pris.<br>"; }
        
        // Processus des PW. 
        if (preg_match("/[\^*+<>?#]/", $password1)==1) { $errors++; $errorlist .= "- Votre PW doit être écrit en caractères alphanumérique.<br>"; }
        if ($password1 != $password2) { $errors++; $errorlist .= "- Les 2 PW que vous avez inscrit ne sont pas indentiques.<br>"; }
        $password = md5($password1);
		
		// Processus des charname 
        if (trim($charname) == "") { $errors++; $errorlist .= "- Vous n'avez entré aucun Pseudo<br>"; }
        if (preg_match("/[\^*+<>?#]/", $charname)==1) { $errors++; $errorlist .= "- Votre Pseudo doit être écrit en caractères alphanumérique.<br>"; }
        $charnamequery = doquery("SELECT charname FROM {{table}} WHERE charname='".addslashes($charname)."' LIMIT 1","users");
        if (mysql_num_rows($charnamequery) > 0) { $errors++; $errorlist .= "- Le Pseudo est déja pris.<br>"; }
        
        if ($errors == 0) {
            
            if ($controlrow["verifyemail"] == 1) {
                $verifycode = "";
                for ($i=0; $i<8; $i++) {
                    $verifycode .= chr(rand(65,90));
                }
            } else {
                $verifycode='1';
            }
            
            $query = doquery("INSERT INTO {{table}} SET id='',regdate=NOW(),verify='".addslashes($verifycode)."',username='".addslashes($username)."',password='".addslashes($password)."',email='".addslashes($email1)."',charname='".addslashes($charname)."',avatar='".addslashes($avatar)."',charclass='".addslashes($charclass)."',difficulty='".addslashes($difficulty)."'", "users") or die(mysql_error());
            
            if ($controlrow["verifyemail"] == 1) {
                if (sendregmail($email1, $verifycode) == true) {
                    $page = 'Votre compte a été crée avec succès.<br><br>Vous devriez recevoir un e-mail de vérification de compte sous peu. Vous aurez besoin du code de vérification contenu dans l\'e-mail. Sans ce code vous ne pourrez pas jouer. <br><br>Lorsque vous aurez recu cet e-mail  allez à la page de <a href="?do=verify">vérification</a> et remplissez les champs requis.';
                } else {
                    $page = 'Votre compte a été crée avec succès.<br><br>Toutefois, un problème est survenu lors de l\'envois de l\'e-mail, contactez l\'administrateur du jeu à l\'adresse suivante pour avoir plus de précisions : <b>'.$controlrow["adminemail"].'</b> .';
                }
            } else {
                $page = 'Votre compte a été crée avec succès.<br><br>Vous pouvez maintenant <a href="login.php?do=login">vous loger</a> et commencer à jouer '.$controlrow["gamename"].'!';
            }
            
        } else {
            
         $page = 'Votre compte n\'a pas pu être crée car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="?do=register">» retourner et réessayer</a>';            
        }
        
    } else {
        
        $page = gettemplate("register");
        if ($controlrow["verifyemail"] == 1) { 
            $controlrow["verifytext"] = '<br><span class="notice">Un code de validation sera envoyé à l\'adresse email ci-dessus. Sans ce code de validation, vous ne pourrez pas jouer .  Veuillez être sûr d\'écrire un adresse email correcte.</span>';
        } else {
            $controlrow["verifytext"] = "";
        }
    }
display(parsetemplate($page, $controlrow), 'Créer un compte', $advertising);

}


function verify() { // Validation d'un compte.

    global $controlrow, $advertising;

    if (isset($_POST["submit"])) {
        
		extract($_POST);
        $errors = 0;
        $errorlist = "";
        
		$userquery = doquery("SELECT username,email,verify FROM {{table}} WHERE username='$username' LIMIT 1","users");
        if (mysql_num_rows($userquery) != 1) { $errors++; $errorlist .= "- Aucun compte existant avec cet ID.<br>"; }
        $userrow = mysql_fetch_array($userquery);
        if ($userrow["verify"] == 1)  { $errors++; $errorlist .= "- Votre compte a déja été validé.<br>"; }
        if ($userrow["email"] != $email)  { $errors++; $errorlist .= "- L'adresse e-mail est incorrecte.<br>"; }
        if ($userrow["verify"] != $verify) { $errors++; $errorlist .= "- Le code de validation est incorrect.<br>"; }
        if ($errors == 0) {
	   $updatequery = doquery("UPDATE {{table}} SET verify='1' WHERE username='$username' LIMIT 1","users");
       $page = '<b>Bravo votre compte vient d\'être validé!</b><br><br>Vous pouvez désormais vous loger via le menu de gauche de l\'accueil et commencer à jouer à '.$controlrow['gamename'].'.<br><br>Maintenant vous pouvez:<br><br><a href="login.php?do=login">» retourner à l\'accueil</a>';
        }else { 
       $page = 'Votre compte n\'a pas pu être validé, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="users.php?do=verify">» retourner et réessayer</a>';  
        } 
	}else{
     $page = gettemplate("verify");
	}

display(parsetemplate($page, $controlrow), 'Vérification de votre compte',$advertising);
    
}


function lostpassword() { // Password perdu.
    
	global $controlrow, $advertising;

    if (isset($_POST["submit"])) {
        extract($_POST);
        $userquery = doquery("SELECT email FROM {{table}} WHERE email='$email' LIMIT 1","users");
        if (mysql_num_rows($userquery) != 1) { $errors++; $errorlist .= "- Aucun compte avec cette adresse email.<br>"; }
		if (trim($email) == "") { $errors++; $errorlist .= "- Vous n'avez entré aucune adresse e-mail.<br>"; }
		if ($errors == 0) {
        $newpass = "";
        for ($i=0; $i<8; $i++) {
            $newpass .= chr(rand(65,90));
        }
        $md5newpass = md5($newpass);
        $updatequery = doquery("UPDATE {{table}} SET password='$md5newpass' WHERE email='$email' LIMIT 1","users");
        if (sendpassemail($email,$newpass) == true) {
          $page='Votre nouveau PW a été envoyé à l\'adresse e-mail ('.$email.') que vous nous avez indiqué.<br><br>Après avoir recu votre nouveau PW, vous pourrez vous loger et commencer à jouer.<br><br>Maintenant vous pouvez:<br><br><a href="login.php?do=login">» retourner à l\'accueil</a>';
        } }else {
          $page='Votre nouveau PW n\'a pas pu être crée, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="users.php?do=lostpassword">» retourner et réessayer</a>';
		}
    }else{
	$page = gettemplate("lostpassword");
	}

display(parsetemplate($page, $controlrow), 'Password perdu?', $advertising);
    
}


function changepassword() { // Changer password.

	global $controlrow, $advertising;
    
    if (isset($_POST["submit"])) {
        extract($_POST);
        $errors = 0;
        $errorlist = "";
		
	    $userquery = doquery("SELECT * FROM {{table}} WHERE username='".addslashes($username)."' LIMIT 1","users");
        if (mysql_num_rows($userquery) != 1)  { $errors++; $errorlist .= "- Il y a aucun compte existant avec cet ID.<br>"; }
        $userrow = mysql_fetch_array($userquery);
        if ($userrow['password'] != md5($oldpass))  { $errors++; $errorlist .= "- L'ancien PW que vous avez fournie est incorrect.<br>"; }
		if ((trim($newpass1)== "") && (trim($newpass2)== "")) { $errors++; $errorlist .= "- Vous n'avez entré aucun nouveau PW.<br>"; }
		if (preg_match("/[^A-z0-9_\-]/", $newpass1)==1)  { $errors++; $errorlist .= "- Le nouveau PW doit être écrit en caractères alphanumérique.<br>"; }
        if ($newpass1 != $newpass2)  { $errors++; $errorlist .= "- Les 2 PW que vous avez inscrit ne sont pas indentiques.<br>"; }
        $realnewpass = md5($newpass1);
        if ($errors == 0) {
        $updatequery = doquery("UPDATE {{table}} SET password='".addslashes($realnewpass)."' WHERE username='".addslashes($username)."' LIMIT 1","users");
        $page='Votre PW a été changé avec succès.<br><br>Maintenant vous pouvez:<br><br><a href="login.php?do=login">» retourner à l\'accueil</a>';
    }else { 
      $page = 'Votre PW n\'a pas pu être changé, car les erreur(s) suivante(s) se sont produite(s):<br><br><span class="alerte">'.$errorlist.'</span><br><br>Maintenant vous pouvez:<br><br><a href="users.php?do=changepassword">» retourner et réessayer</a>';  
    } 
	}else{
    $page = gettemplate("changepassword");
	}
	
display(parsetemplate($page, $controlrow), 'Changer de password',$advertising);
    
}


function sendpassemail($emailaddress, $password) { // Envois nouveau password.
    
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);
    
$email = "Bonjours,\n\nvous avez récement demandé un nouveau Password (PW) sur ".stripslashes($controlrow['gamename']).".\nComme convenu le voici: $password\n\nVous pouvez dès maintenant vous loger avec à cette adresse : $controlrow[gameurl].\n\nA bientot sur ".stripslashes($controlrow['gamename'])."!";

$status = mymail($emailaddress, stripslashes($controlrow['gamename']).' : votre password', $email);
return $status;
    
}


function sendregmail($emailaddress, $verifycode) { // Envois e-mail de validation.
    
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);
    
$email ="Bonjours,\n\nvous vous êtes récement inscrit sur ".stripslashes($controlrow['gamename']).".\nPour valider votre compte rendez vous ici: $controlrow[gameurl]users.php?do=verify et entrez le code de validation suivant: $verifycode\n\nA bientot sur ".stripslashes($controlrow['gamename'])."!";

$status = mymail($emailaddress, ''.stripslashes($controlrow['gamename']).' : votre inscription', $email);
return $status;
    
}


function mymail($to, $title, $body) { // Fonction d'envoie.

$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

$head  = $controlrow['adminemail']; 
$head .= 'MIME-version: 1.0\n'; 
$head .= 'Content-type: text/plain; charset= iso-8859-1\n';

return mail($to, $title, $body, $head);
  
}


?>