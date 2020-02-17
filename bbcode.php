<?php

// Pour l'affichage du bbcode général

class texte
{

  function ms_format($chaine)
   {
$chaine = stripcslashes($chaine);

    $chaine = str_replace(":1:", "<img src='images/smileys/1.jpg'>", $chaine);
	$chaine = str_replace(":2:", "<img src='images/smileys/2.jpg'>", $chaine);
	$chaine = str_replace(":3:", "<img src='images/smileys/3.jpg'>", $chaine);
	$chaine = str_replace(":4:", "<img src='images/smileys/4.jpg'>", $chaine);
	$chaine = str_replace(":5:", "<img src='images/smileys/5.jpg'>", $chaine);
	$chaine = str_replace(":6:", "<img src='images/smileys/6.jpg'>", $chaine);
	$chaine = str_replace(":7:", "<img src='images/smileys/7.jpg'>", $chaine);
	$chaine = str_replace(":8:", "<img src='images/smileys/8.jpg'>", $chaine);
    $chaine = preg_replace('/\[b\](.+?)\[\/b\]/', '<b>$1</b>', $chaine); 
    $chaine = preg_replace('/\[i\](.+?)\[\/i\]/', '<i>$1</i>', $chaine); 
    $chaine = preg_replace('/\[u\](.+?)\[\/u\]/', '<u>$1</u>', $chaine); 
    $chaine = preg_replace('/\[size=(.+?)\](.+?)\[\/size\]/', '<font size=$1>$2</font>', $chaine); 
    $chaine = preg_replace('/\[color=(.+?)\](.+?)\[\/color\]/', '<font color=$1>$2</font>', $chaine); 
    $chaine = preg_replace('/\[img\](.+?)\[\/img\]/', '<img src="$1" />', $chaine);
    $chaine = preg_replace('/\[url\](.+?)\[\/url\]/', '<a href="$1" target="_blank">$1</a>', $chaine);
 
 $chaine = nl2br($chaine); 



        return($chaine);
   }
    }

?>