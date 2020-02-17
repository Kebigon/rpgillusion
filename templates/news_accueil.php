<?php
ob_start();
include 'classe_best.php';
$classe_best = ob_get_contents();
 ob_end_clean();
 ob_start();
 
ob_start();
include 'classe.php';
$classe = ob_get_contents();
 ob_end_clean();
 ob_start();
 
  ob_start();
include 'items.php';
$items = ob_get_contents();
 ob_end_clean();
 ob_start();
 
include('./bbcode.php');
 
if(isset($_GET['news']))
{
	// News System
	$rownews = doquery("SELECT * FROM {{table}} WHERE id='$_GET[news]' LIMIT 1","newsaccueil");
	$texte = new texte();
	$numnews = mysql_num_rows($rownews);
	$news = mysql_fetch_assoc($rownews);
	
	if($numnews != 1)
	{
		$contenu_news = 'Cette news n\'existe pas.';
	}
	else
	{
		//Affichage du contenu...
		$contenu_news = '&nbsp;<font size="1">Le <b>'.$news['postdate'].'</b> [<a href="index.php">Retour</a>]</font><br /><br />'.nl2br($texte->ms_format($news['content'])).' <br><br><u>Posté par </u>: <b><i>'.$news['auteur'].'</b></i>';
	}
}
else
{
	$contenu_news = 'La news sélectionnée n\'existe pas.';
}
$template = <<<THEVERYENDOFYOU





<table>
 <tr>
      <td><center></td>
      </tr>
</table>

<div>
<div>

<table>
<td>
<table width="357px" height="38px" alt="Les news" title="News"><tr><td>
</td></tr>
</table>
<table width="357px" height="1px">
<tr>
<td width="344px" height="125px">$contenu_news</TD>
</tr>
</table> <table width="357px" height="10px"><tr><td>
</td></tr>
</table>

</table>



THEVERYENDOFYOU;


?>