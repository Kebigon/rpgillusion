<?php // users.php :: Concerne la création et la gestion des comptes.

include('lib.php');
$link = opendb();

if (isset($_GET["do"])) {
    
    $do = $_GET["do"];
    if ($do == "register") { register(); }
    elseif ($do == "verify") { verify(); }
    elseif ($do == "lostpassword") { lostpassword(); }
    elseif ($do == "changepassword") { changepassword(); }
    
}

function register() { // Créer un nouveau compte.
    
    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
	$parainquery = doquery("SELECT * FROM {{table}} WHERE username='".$_POST['parain']."' LIMIT 1", "users");
    $parainrow = mysql_fetch_array($parainquery); 
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        
        $errors = 0; $errorlist = "";
        
        // Processus des ID.
        if ($username == "") { $errors++; $errorlist .= "Le champs 'ID' est éxigé.<br />"; }
        if (preg_match("/[^A-z0-9_\-]/", $username)==1) { $errors++; $errorlist .= "Votre ID doit être écrit en caractères alphanumérique.<br />"; } // Merci à "Carlos Pires" from de.net!
        $usernamequery = doquery("SELECT username FROM {{table}} WHERE username='$username' LIMIT 1","users");
        if (mysql_num_rows($usernamequery) > 0) { $errors++; $errorlist .= "L'ID est déja pris.<br />"; }

         // Processus des adresse email.
        if ($email1 == "" || $email2 == "") { $errors++; $errorlist .= "Le champs 'Email' est exigé .<br />"; }
        if ($email1 != $email2) { $errors++; $errorlist .= "Les 2 adresses Emails que vous avez inscrit ne sont pas indentiques.<br />"; }
        if (! is_email($email1)) { $errors++; $errorlist .= "L'adresse Email que vous avez inscrit est invalide.<br />"; }
        $emailquery = doquery("SELECT email FROM {{table}} WHERE email='$email1' LIMIT 1","users");
        if (mysql_num_rows($emailquery) > 0) { $errors++; $errorlist .= "L'adresse Email est déja pris.<br />"; }
        
        // Processus des PW.
        if (preg_match("/[^A-z0-9_\-]/", $password1)==1) { $errors++; $errorlist .= "Votre PW doit être écrit en caractères alphanumérique.<br />"; } // Merci à "Carlos Pires" de php.net!
        if ($password1 != $password2) { $errors++; $errorlist .= "Les 2 Pw que vous avez inscrit ne sont pas indentiques.<br />"; }
        $password = md5($password1);
        
        if ($errors == 0) {
            
            if ($controlrow["verifyemail"] == 1) {
                $verifycode = "";
                for ($i=0; $i<8; $i++) {
                    $verifycode .= chr(rand(65,90));
                }
            } else {
                $verifycode='1';
            }
			
			$newpar = $parainrow["bank"] + 50 ;
            $query = doquery("UPDATE {{table}} SET bank='$newpar' WHERE username='".$_POST['parain']."' ", "users") or die(mysql_error()); 
            $query = doquery("INSERT INTO {{table}} SET id='',regdate=NOW(),verify='$verifycode',username='$username',password='$password',email='$email1',charname='$charname',miniavatar='$avatar',avatar='$avatar',charclass='$charclass',difficulty='$difficulty',age='$age'", "users") or die(mysql_error());
			
                if ($controlrow["verifyemail"] == 1) {
                if (sendregmail($email1, $verifycode) == true) {
                    $page = "Votre compte a été crée avec succès.<br /><br />Vous devriez recevoir un email de vérification de compte sous peu. Vous aurez besoin du code de vérification contenu dans l'email. Sans ce code vous ne pourrez pas jouer. Lorsque vous aurez recu cet Email  allez à la page de <a href=\"users.php?do=verify\">Verification Page</a> et remplissez les champs requis.";
                } else {
                    $page = "Votre compte a été crée avec succès.<br /><br />Cependant, il y eu un problème en envoyant votre email avec le code de validation. Veuillez contacter l'administrateur du jeu pour résoudre ce problème.";
                }
            } else {
                $page = "Votre compte a été crée avec succès.<br /><br />Vous pouvez maintenant <a href=\"login.php?do=login\">vous loger</a> et commencer à jouer ".$controlrow["gamename"]."!";
            }
            
        } else {
            
            $page = "L'erreur(s) suivante s'est produite lorsque votre compte a été crée:<br /><span style=\"color:red;\">$errorlist</span><br />Veuillez retourner et recommencer.";
            
        }
        
    } else {
        
        $page = gettemplate("register");
        if ($controlrow["verifyemail"] == 1) { 
            $controlrow["verifytext"] = "<br /><span class=\"small\">Un code de validation sera envoyé à l'adresse email ci-dessus. Sans ce code de validation, vous ne pourrez pas jouer .  Veuillez être sûr d'écrire un adresse email correcte.</span>";
        } else {
            $controlrow["verifytext"] = "";
        }
        $page = parsetemplate($page, $controlrow);
        
    }
    
    $topnav = "<a href=\"login.php?do=login\"><img src=\"images/button_login.gif\" alt=\"Se loger\" border=\"0\" /></a><a href=\"users.php?do=register\"><img src=\"images/button_register.gif\" alt=\"S'enregistrer\" border=\"0\" /></a><a href=\"help.php\"><img src=\"images/button_help.gif\" alt=\"Aide\" border=\"0\" /></a>";
    display($page, "S'enregistrer", false, false, false);
    
}

function verify() {
    
    if (isset($_POST["submit"])) {
        extract($_POST);
        $userquery = doquery("SELECT username,email,verify FROM {{table}} WHERE username='$username' LIMIT 1","users");
        if (mysql_num_rows($userquery) != 1) { die("Il y a aucun compte existant avec cet ID."); }
        $userrow = mysql_fetch_array($userquery);
        if ($userrow["verify"] == 1) { die("Votre compte a déja été validé."); }
        if ($userrow["email"] != $email) { die("Adresse email incorrecte."); }
        if ($userrow["verify"] != $verify) { die("Code de validation invalide."); }
        $updatequery = doquery("UPDATE {{table}} SET verify='1' WHERE username='$username' LIMIT 1","users");
        display("Votre compte a été validé avec succès.<br /><br />Vous pouvez maintenant <a href=\"login.php?do=login\">vous loger</a> et commencer à jouer.<br /><br />Merci de participer à RPG illusion!","Vérification de l'Email",false,false,false);
    }
    $page = gettemplate("verify");
    $topnav = "<a href=\"login.php?do=login\"><img src=\"images/button_login.gif\" alt=\"Se loger\" border=\"0\" /></a><a href=\"users.php?do=register\"><img src=\"images/button_register.gif\" alt=\"S'enregistrer\" border=\"0\" /></a><a href=\"help.php\"><img src=\"images/button_help.gif\" alt=\"Aide\" border=\"0\" /></a>";
    display($page, "Vérification de l'Email", false, false, false);
    
}

function lostpassword() {
    
    if (isset($_POST["submit"])) {
        extract($_POST);
        $userquery = doquery("SELECT email FROM {{table}} WHERE email='$email' LIMIT 1","users");
        if (mysql_num_rows($userquery) != 1) { die("Aucun compte avec cette adresse email."); }
        $newpass = "";
        for ($i=0; $i<8; $i++) {
            $newpass .= chr(rand(65,90));
        }
        $md5newpass = md5($newpass);
        $updatequery = doquery("UPDATE {{table}} SET password='$md5newpass' WHERE email='$email' LIMIT 1","users");
        if (sendpassemail($email,$newpass) == true) {
            display("Votre nouveau PW a été envoyé à l'adresse email que vous nous avez fournie.<br /><br />Après avoir recu votre nouveau PW, vous pouvez <a href=\"login.php?do=login\">vous loger</a> et commencer à jouer.<br /><br />Nous vous remercions.","PW perdu",false,false,false);
        } else {
            display("Il y a eu un problème lors de l'envoi de votre nouveau PW.<br /><br />Veuillez contacter l'administrateur du jeu pour résoudre ce problème.<br /><br />Veuilez nous excuser de ce disfonctionnement.","PW perdu",false,false,false);
        }
        die();
    }
    $page = gettemplate("lostpassword");
    $topnav = "<a href=\"login.php?do=login\"><img src=\"images/button_login.gif\" alt=\"Se loger\" border=\"0\" /></a><a href=\"users.php?do=register\"><img src=\"images/button_register.gif\" alt=\"S'enregistrer\" border=\"0\" /></a><a href=\"help.php\"><img src=\"images/button_help.gif\" alt=\"Aide\" border=\"0\" /></a>";
    display($page, "PW perdu", false, false, false);
    
}

function changepassword() {
    
    if (isset($_POST["submit"])) {
        extract($_POST);
        $userquery = doquery("SELECT * FROM {{table}} WHERE username='$username' LIMIT 1","users");
        if (mysql_num_rows($userquery) != 1) { die("Il y a aucun compte existant avec cet ID."); }
        $userrow = mysql_fetch_array($userquery);
        if ($userrow["password"] != md5($oldpass)) { die("Le vieux PW que vous avez fournie est incorrect."); }
        if (preg_match("/[^A-z0-9_\-]/", $newpass1)==1) { die("Le nouveau PW doit être écrit en caractères alphanumérique."); } // Thanks to "Carlos Pires" from php.net!
        if ($newpass1 != $newpass2) { die("Les 2 PW que vous avez inscrit ne sont pas indentiques."); }
        $realnewpass = md5($newpass1);
        $updatequery = doquery("UPDATE {{table}} SET password='$realnewpass' WHERE username='$username' LIMIT 1","users");
        if (isset($_COOKIE["dkgame"])) { setcookie("dkgame", "", time()-100000, "/", "", 0); }
        display("Votre PW a été changé avec succès.<br /><br />Lorsque vous vous êtes logé , une erreur de cookie s'est produite.<br /><br />Veuillez <a href=\"login.php?do=login\">vous reloger</a> pour commencer à jouer.","Changer le PW",false,false,false);
        die();
    }
    $page = gettemplate("changepassword");
    $topnav = "<a href=\"login.php?do=login\"><img src=\"images/button_login.gif\" alt=\"Se loger\" border=\"0\" /></a><a href=\"users.php?do=register\"><img src=\"images/button_register.gif\" alt=\"S'enregistrer\" border=\"0\" /></a><a href=\"help.php\"><img src=\"images/button_help.gif\" alt=\"Aide\" border=\"0\" /></a>";
    display($page, "Change de PW", false, false, false); 
    
}

function sendpassemail($emailaddress, $password) {
    
    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
    extract($controlrow);
    
$email = <<<END
Vous ou une personne employant votre adresse email a perdu son PW sur RPG illusion. 

Nous vous avons envoyé un nouveau PW. Ainsi vous pourrez continuer à jouer sur $gamename.

Votre nouveau PW est: $password

cliquez sur lien suivant pour vous loger: $gameurl

Merci de votre participation.

END;

    $status = mymail($emailaddress, "PW perdu - RPG illusion", $email);
    return $status;
    
}

function sendregmail($emailaddress, $vercode) {
    
    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
    extract($controlrow);
    $verurl = $gameurl . "?do=verify";
    
$email = <<<END
Vous ou une personne employant votre adresse email a récement crée un compte sur RPG illusion. 

Un code de validation est join à cet Email. Sans celui-ci, vous ne pourrez pas activer votre compte sur RPG illusion

Votre code de validation: $vercode

Cliquez sur le liens suivant pour activer votre compte: $verurl

Si vous n/étiez pas la personne qui a signé sur RPG illusion, négligez ce méssage.  Vous ne recevrez aucun autre Email de notre part.
END;

    $status = mymail($emailaddress, "Email de validation - RPG illusion", $email);
    return $status;
    
}

function mymail($to, $title, $body, $from = '') { // Merci de ne pas modifier cette fonction pour en faire du spam!.

    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
    extract($controlrow);


  $from = trim($from);

  if (!$from) {
   $from = '<'.$controlrow["adminemail"].'>';
  }

  $rp    = $controlrow["adminemail"];
  $org    = '$gameurl';
  $mailer = 'PHP';

  $head  = '';
  $head  .= "Content-Type: text/plain \r\n";
  $head  .= "Date: ". date('r'). " \r\n";
  $head  .= "Return-Path: $rp \r\n";
  $head  .= "From: $from \r\n";
  $head  .= "Sender: $from \r\n";
  $head  .= "Reply-To: $from \r\n";
  $head  .= "Organization: $org \r\n";
  $head  .= "X-Sender: $from \r\n";
  $head  .= "X-Priority: 3 \r\n";
  $head  .= "X-Mailer: .$mailer \r\n";

  $body  = str_replace("\r\n", "\n", $body);
  $body  = str_replace("\n", "\r\n", $body);

  return mail($to, $title, $body, $head);

}


?>