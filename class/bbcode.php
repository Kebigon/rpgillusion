<?php // Pour l'affichage du bbcode général

class texte
{

  function ms_format($chaine)
   {
   
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);   
   
$chaine = stripcslashes($chaine);

    $chaine = str_replace(":oops:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/redface.gif' alt=''>", $chaine);
	$chaine = str_replace(":)", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/sourire2.gif' alt=''>", $chaine);
	$chaine = str_replace("8)", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/lunettes.gif' alt=''>", $chaine);
	$chaine = str_replace(":P", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/razz.gif' alt=''>", $chaine);
	$chaine = str_replace(":colere:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/colere.gif' alt=''>", $chaine);
	$chaine = str_replace(":bigcry:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/crying.gif' alt=''>", $chaine);
	$chaine = str_replace(":roll:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/rolleyes.gif' alt=''>", $chaine);
	$chaine = str_replace(":x", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/mad.gif' alt=''>", $chaine);
	$chaine = str_replace(":bigsmile:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/green.gif' alt=''>", $chaine);
	$chaine = str_replace(":splif:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/petard.gif' alt=''>", $chaine);
	$chaine = str_replace(":fire:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/flame.gif' alt=''>", $chaine);
	$chaine = str_replace(":confus:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/confus.gif' alt=''>", $chaine);
    $chaine = str_replace(":lol:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/lol.gif' alt=''>", $chaine);
	$chaine = str_replace(":o", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/etonne.gif' alt=''>", $chaine);
	$chaine = str_replace(":surpris:", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/yeuxrond.gif' alt=''>", $chaine);
	$chaine = str_replace(":(", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/triste.gif' alt=''>", $chaine);
	$chaine = str_replace(";)", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/clin.gif' alt=''>", $chaine);
	$chaine = str_replace(":D", "<img src='".$controlrow['gameurl']."images/jeu/blog/smileys/sourire.gif' alt=''>", $chaine);
    $chaine = preg_replace('/\[b\](.+?)\[\/b\]/', '<span style="font-weight: bold;">$1</span>', $chaine); 
    $chaine = preg_replace('/\[i\](.+?)\[\/i\]/', '<span style="font-style:italic;">$1</span>', $chaine); 
    $chaine = preg_replace('/\[u\](.+?)\[\/u\]/', '<span style="text-decoration: underline;">$1</span>', $chaine); 
    $chaine = preg_replace('/\[size=(.+?)\](.+?)\[\/size\]/', '<span style="font-size:$1px;">$2</span>', $chaine); 
    $chaine = preg_replace('/\[color=(.+?)\](.+?)\[\/color\]/', '<span style="color:$1;">$2</span>', $chaine); 
    $chaine = preg_replace('/\[img\](.+?)\[\/img\]/', '<img src="$1" alt=""/>', $chaine);
    $chaine = preg_replace('/\[url\](.+?)\[\/url\]/', '<a href="$1" target="_blank">$1</a>', $chaine);
 
 $chaine = nl2br($chaine); 



        return($chaine);
   }
    }

?>