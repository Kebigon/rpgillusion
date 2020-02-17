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
include 'classe2.php';
$classe2 = ob_get_contents();
 ob_end_clean();
 ob_start();

 ob_start();
include 'newsaccueil.php';
$news = ob_get_contents();
 ob_end_clean();
 ob_start();
 
$template = <<<THEVERYENDOFYOU

<table width="70%">
<tr><td width="50%"><table width="300px" height="10px" background="././images/cellpic3.jpg"><tr><td><b>Classement joueurs</b>&nbsp; &nbsp; &nbsp; <a href="login.php?do=login2"><font color=\"OOOOOO\"> Classement guildes</a>&nbsp; &nbsp; &nbsp;</a><br></table><br><table width="70%">
<tr><td width="60%">
$classe_best</td><td>$classe </td></tr>
</table></td><td></table><br><table width="300px" height="10px" background="././images/cellpic3.jpg"><tr><td><a href="login.php?do=login"><font color=\"OOOOOO\">Les dernieres news</a></font>&nbsp; &nbsp; &nbsp; <b> L'histoire ...</b><br></table>
<br><br>
<table width="95%"><tr><td width="50%">
<b><u>Bienvenue sur rpg illusion 1.2c.</u></b><br><br> L'histoire commence bien avant notre ère, 8 villages se lancent dans une grande guerre, pour devenir le pays le plus puissant. Devenez citoyen de Midworld, de Roma, de Bris, de Kalle, de Narcissa, de Hambry, de Gilead et de Endworld.<br><br> Dans ce jeu, vous pouvez soit explorer le monde enorme de rpg illsuion 1.2c ou soit effectuer des quetes pour gagner des gils pour vous et pour votre village, ou sinon plus radicalement attaquer les villages voisins et leurs voler des gils. Il est aussi possible de faire l'aventure acompagner d'un animal.<br>Si ce n'est pas encore fait <a href="users.php?do=register">inscrivez-vous</a>.
</table>

THEVERYENDOFYOU;


?>