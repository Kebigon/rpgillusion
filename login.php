<?php // login.php :: Page d'arrivé sur le jeu
session_start();
include('kernel/functions.php');
include('kernel/display_log.php');

switch($do) {
    case "logout":logout();break;
     default:login();
}

function login() {
    
include('config.php');
$link = opendb();
$menu['session'] = null;
  
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);
 
$onlinequery = doquery("SELECT charname FROM {{table}} WHERE UNIX_TIMESTAMP(onlinetime) >= '".(time()-600)."' ORDER BY charname", "users");

if (isset($_POST['submit_x'])) { //Session php.
  
$verifyquery = doquery("SELECT id, verify, username FROM {{table}} WHERE username='".addslashes($_POST['username'])."' AND password='".md5($_POST['password'])."' LIMIT 1", "users");
$verifyrow = mysql_fetch_array($verifyquery);
  
if ((empty($_POST['username'])) || (empty($_POST['password'])) ) {$menu['session'] = '<div class="alerte_session">Vous n\'avez pas correctement entré votre ID ou PW!</div><br>'; }
   elseif($verifyrow['verify'] == null) {$menu['session'] = '<div class="alerte_session">L\'utilisateur demandé est inconnu!</div><br>';  }
   elseif($verifyrow['verify'] != null && $verifyrow['verify'] != 1) {$menu['session'] = '<div class="alerte_session">Vous n\'avez pas validé votre compte, avec le code de validation contenu dans l\'e-mail que nous vous avons envoyé lors de votre inscription!</div><br>';  }
   elseif ($_POST['username'] == $verifyrow['username']) {
   session_start();
   $_SESSION['id'] = $verifyrow['id'];

   $onlinequery = doquery("UPDATE {{table}} SET onlinetime=NOW() WHERE id=$verifyrow[id] LIMIT 1", "users");	
	  
   header("Location: index.php");
  }  
 }

//Affichage nombre de connectés.
if (mysql_num_rows($onlinequery) <= 1) {
  $txt = 'connecté';
  } else{
  $txt = 'connectés';
}
	
$menu['statistics'] = '<img src="images/login/puce.jpg" alt="">&nbsp;<b><span class="rose3">Il y a '.mysql_num_rows($onlinequery).' '.$txt.'</span></b>';

//Affichage des 5 derniers inscrits.
$menu['statistics'] .= '<br><img src="images/login/puce.jpg" alt="">&nbsp;<b><span class="marron1">Les derniers inscrits:</span></b>';

$count = 0; 
$onlinequery = doquery("SELECT charname,onlinetime FROM {{table}} ORDER BY regdate DESC LIMIT 5","users");
while ($onlinerow = mysql_fetch_array($onlinequery)) { 
	
$tsonline = strtotime($onlinerow['onlinetime']); 
if ($tsonline >= time()-600 && $count<5){ 
  $count++; 
  $txt = 'En ligne'; 
}else{
  $txt = 'Hors ligne'; 
  }
$menu['statistics'] .= '<br>- ' .$onlinerow['charname']. ' <img src="images/login/' . $txt . '.gif" title="' . $txt . '" alt="' . $txt . '">'; 
  }
  
//Affichage du sondage. 
$vote_query = doquery ("SELECT * FROM {{table}} ORDER BY id DESC LIMIT 1", "poll");
$vote = mysql_fetch_array($vote_query);
$ip_query = doquery ("SELECT * FROM {{table}} WHERE numero='".$vote['id']."' AND ip='".$_SERVER['REMOTE_ADDR']."'","poll_ip");
$ip = mysql_num_rows($ip_query); 

if (!empty($vote['question'])){
  $question = '<img  width="16px" height="15px" alt="" src="images/login/question.gif" style="vertical-align: middle;"> <span class="marron2"><b>'.$vote['question'].'</b></span><br><br>';
  $bouton = '<div style="text-align: center" ><input type="image" src="images/login/bouton_voter.gif" class="no_bordure" title="Voter" name="sondage"></div>';
  }else{
  $question = '<span class="marron2"><b>Aucun sondage</b></span>';
  $bouton = '';
  }
  $menu['poll'] = $question;
  $nbQuestions = 4;
  
  if(!$ip){  
  for($i=1 ; $i<=$nbQuestions ; $i++) {
   $check = ($i==1) ? 'checked' : '';
      $champ='answer'.$i; 
        if(!empty($vote[$champ])) { 
        $menu['poll'] .= '<input type="radio" value="'.$i.'" name="submit" '.$check.'> '.$vote[$champ].'<br>'; 
     } 
  }

  $menu['poll'] .= '<br>'.$bouton; 

  if (isset($_POST['sondage_x'])) 
  {
  for($i=1 ; $i<=$nbQuestions ; $i++) {    
      if($i==$_POST['submit']) 
		{ 
         $resultat = $vote['resultat'.$i]+ 1;
		 $update = 'resultat'.$i.' = '.$resultat;	
	} 
  } 
  
$save_vote = doquery("UPDATE {{table}} SET $update WHERE id='".$vote['id']."'", "poll"); 
$insert_ip = doquery("INSERT INTO {{table}} SET numero='".$vote['id']."', ip='".$_SERVER['REMOTE_ADDR']."'", "poll_ip");

$menu['poll'] ='<span class="rose5"><b>Merci d\'avoir voté!</b></span>';
  }
  }else{
  $menu['poll'] = '<span class="mauve1"><b>Les résultats des votes:</b></span>';
  $menu['poll'] .= $question;
   for($i=1 ; $i<=$nbQuestions ; $i++) {
      $champ='answer'.$i;
        $nombre_vote='resultat'.$i; 	  
        if(!empty($vote[$champ])) {
          if($vote[$nombre_vote]>1){
            $pluriel = 'votes';	
			 }else{
			   $pluriel = 'vote';} 	
$menu['poll'] .= '<span class="rose3"><b>- '.$vote[$champ].'</b></span> <span class="taille1">('.$vote[$nombre_vote].' '.$pluriel.')</span><br>'; 
    }
  }
}

// Affichage des news. 
$newsquery = doquery ("SELECT date, id, title, resume FROM {{table}} ORDER by id DESC LIMIT 6","news"); 
 
$count = 1;
$login['news'] ='';
 
while ($newsrow = mysql_fetch_array($newsquery))
  {
  $login['news'] .= '<img src="images/login/puce3.gif" alt="">&nbsp;<b><span class="rose4">'.date('d.m.Y', $newsrow['date']).'&nbsp;:&nbsp;</span></b><a href="?do=login&amp;news='.$newsrow['id'].'">'.$newsrow['title'].'</a><br>'.$newsrow['resume'].'<br><br>';
  }

if (isset($_GET["news"])){
  $newsquery = doquery("SELECT date, title, content FROM {{table}} WHERE id='$_GET[news]' LIMIT 1","news");
  $newsrow = mysql_fetch_array($newsquery);
  if(($newsrow['title'] != null))
  {
  include('class/bbcode.php');
  $texte = new texte();
  
  $login['news'] = '<b><span class="rose4">'.$newsrow['title'].'</span></b> le '.date('d.m.Y', $newsrow['date']).' [<a href="login.php?do=login">Retour</a>]<br><br>'.nl2br($texte->ms_format($newsrow['content'])).'';
  }else
  {
  $login['news'] = '<span class="alerte">La news est introuvable</span>';
  }
}

//Classement joueur.      
$userquery = doquery ("SELECT charname, charclass, level FROM {{table}} ORDER by level DESC LIMIT 6","users");
 
$count = 1;
$login['classementjoueurs'] ='';
  
if(!isset($_GET["news"])){
  $login['classementjoueurs'] .= '<div class="taille3"><h1><b>Top 6 joueurs</b></h1><br></div>';
  $login['classementjoueurs'] .= '<table border="0" width="190">';
  while ($userrow = mysql_fetch_array($userquery))
  {
  $login['classementjoueurs'] .= '<tr><td><img src="images/login/classement/num-'.$count.'.gif"  alt="'.$count.'"></td><td><img src="images/login/classement/class-'.$userrow['charclass'].'.gif" height="21px" alt=""></td><td><b><span class="rose5">'.$userrow['charname'].'</span></b></td><td style="text-align: right"><span class="taille1">Niv. <span class="rose3">'.$userrow['level'].'</span></span></td></tr>';
  $count++;
  } 
  $login['classementjoueurs'] .= '</table>';
  } 
  
//Classement monstres.      
$monsterquery = doquery ("SELECT name, level FROM {{table}} ORDER by level DESC LIMIT 10","monsters");
 
$count = 1;
$login['classementmonstres'] ='';
  
if(!isset($_GET["news"])){
  $login['classementmonstres'] .= '<div class="taille3"><h1><b>Top 10 monstres</b></h1><br></div>';
  $login['classementmonstres'] .= '<table border="0" width="178">';
  while ($monsterrow = mysql_fetch_array($monsterquery))
  {
  $login['classementmonstres'] .= '<tr><td><span class="mauve1"><b>'.$count.'</b></span></td><td><span class="rose5">'.$monsterrow['name'].'</span></td><td style="text-align: right"><span class="taille1">Niv. <span class="rose3">'.$monsterrow['level'].'</span></span></td></tr>';
  $count++;
  } 
  $login['classementmonstres'] .='</table>';
  }

// Affichage des objets classement armes
$itemsquery = doquery ("SELECT id, type, name, buycost, special , image, description FROM {{table}} WHERE type=1","items");  
$i=0;
while($itemsrow = mysql_fetch_row($itemsquery)){
  $i++; 
  $tabl[$i]=$itemsrow[0];
 }
  for ($count1=0 ;$count1<count($tabl);$count1++) {

  $itemsquery = doquery ("SELECT weaponname, count(weaponid) as occurences FROM {{table}} WHERE weaponid >= 0  GROUP BY weaponid ORDER by occurences DESC LIMIT 5 ","users");  
  $itemsquery = doquery ("SELECT u.weaponname, count(u.weaponid) as occurences, i.buycost, i.image, i.special  FROM {{table}} AS u, rpg_items AS i WHERE u.weaponid >= 0 AND i.id = u.weaponid GROUP BY u.weaponid ORDER by occurences DESC LIMIT 5","users");  
	  
  $itemsrow = 0;
  $login['armes'] ='';
  
while ($itemsrow = mysql_fetch_array($itemsquery)) 
{
  $login['armes'] .='<table border="0"><tr><td><img src="images/objets/'.$itemsrow['image'].'.jpg" title="'.$itemsrow['weaponname'].'" alt="'.$itemsrow['weaponname'].'"></td>
  <td><b>Nom: </b><span class="rose3">'.$itemsrow['weaponname'].'</span><br><b>Prix: </b><span class="rose3">'.$itemsrow['buycost'].' rubis</span><br><b>Equipé: </b><span class="rose3">'.$itemsrow['occurences'].' perso.</span><br></td></tr></table>';
  }	
}

// Affichage des objets classement  armures.
$itemsquery = doquery ("SELECT id, type, name, buycost, special , image, description FROM {{table}} WHERE type=2","items");  
$i=0;
while($itemsrow = mysql_fetch_row($itemsquery)){
  $i++; 
  $tabl[$i]=$itemsrow[0];
 }
 for ($count1=0 ;$count1<count($tabl);$count1++) {

  $itemsquery = doquery ("SELECT armorname, count(armorid) as occurences FROM {{table}} WHERE armorid >= 0  GROUP BY armorid ORDER by occurences DESC LIMIT 5 ","users");  
  $itemsquery = doquery ("SELECT u.armorname, count(u.armorid) as occurences, i.buycost, i.image, i.special  FROM {{table}} AS u, rpg_items AS i WHERE u.armorid >= 0 AND i.id = u.armorid GROUP BY u.armorid ORDER by occurences DESC LIMIT 5","users");  
	  
  $itemsrow = 0;
  $login['armures'] ='';
  
while ($itemsrow = mysql_fetch_array($itemsquery)) 
{
  $login['armures'] .='<table border="0"><tr><td><img src="images/objets/'.$itemsrow['image'].'.jpg" title="'.$itemsrow['armorname'].'" alt="'.$itemsrow['armorname'].'"></td>
  <td><b>Nom: </b><span class="rose3">'.$itemsrow['armorname'].'</span><br><b>Prix: </b><span class="rose3">'.$itemsrow['buycost'].' rubis</span><br><b>Equipé: </b><span class="rose3">'.$itemsrow['occurences'].' perso.</span><br></td></tr></table>';
  }	
}

// Affichage des objets classement  boucliers.
$itemsquery = doquery ("SELECT id, type, name, buycost, special , image, description FROM {{table}} WHERE type=3","items");  
$i=0;
while($itemsrow = mysql_fetch_row($itemsquery)){
  $i++; 
  $tabl[$i]=$itemsrow[0];
 }
 for ($count1=0 ;$count1<count($tabl);$count1++) {

  $itemsquery = doquery ("SELECT shieldname, count(shieldid) as occurences FROM {{table}} WHERE shieldid >= 0  GROUP BY shieldid ORDER by occurences DESC LIMIT 5 ","users");  
  $itemsquery = doquery ("SELECT u.shieldname, count(u.shieldid) as occurences, i.buycost, i.image, i.special  FROM {{table}} AS u, rpg_items AS i WHERE u.shieldid >= 0 AND i.id = u.shieldid GROUP BY u.shieldid ORDER by occurences DESC LIMIT 5","users");  
	  
  $itemsrow = 0;
  $login['boucliers'] ='';
  
while ($itemsrow = mysql_fetch_array($itemsquery)) 
{
  $login['boucliers'] .='<table border="0"><tr><td><img src="images/objets/'.$itemsrow['image'].'.jpg" title="'.$itemsrow['shieldname'].'" alt="'.$itemsrow['shieldname'].'"></td>
  <td><b>Nom: </b><span class="rose3">'.$itemsrow['shieldname'].'</span><br><b>Prix: </b><span class="rose3">'.$itemsrow['buycost'].' rubis</span><br><b>Equipé: </b><span class="rose3">'.$itemsrow['occurences'].' perso.</span><br></td></tr></table>';
  }	
}

//Affichage des partenaires.      
$partnerquery = doquery ("SELECT name, url FROM {{table}} ORDER by id DESC LIMIT 6","partners"); 
$count = 1;
$login['partners'] ='';
 
while ($partnerrow = mysql_fetch_array($partnerquery))
  {
  $login['partners'] .= '<img src="images/login/puce3.gif" alt="">&nbsp;'.$partnerrow['name'].' <span class="taille1">[<a href="#" onclick="window.open(\''.$partnerrow['url'].'\')">visiter</a>]</span><br>';
  } 	  

$template_menu = gettemplate("leftnavlog");
$template_login = gettemplate("login");

display(parsetemplate($template_login, $login), 'Bienvenue', parsetemplate($template_menu, $menu), false, false);
	
}

function logout() {
    
    session_destroy();
    header("Location: login.php?do=login");
    die();
    
}
?>