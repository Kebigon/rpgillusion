<?php
ob_start();
include 'classe_best2.php';
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
<tr><td width="50%"><table width="300px" height="10px" background="././images/cellpic3.jpg"><tr><td><b><a href="login.php?do=login"><font color=\"OOOOOO\">Classement joueurs</b>&nbsp; &nbsp; &nbsp; <font color=\"OOOOOO\">Classement guildes &nbsp; &nbsp; &nbsp;</a><br></table><br><table width="100%">
<tr><td width="40%">
$classe_best</td><td>$classe2 </td></tr>
</table></td><td></table><br><table width="300px" height="10px" background="././images/cellpic3.jpg"><tr><td><b>Les dernieres news</b>&nbsp; &nbsp; &nbsp; <a href="login.php?do=login4"><font color=\"OOOOOO\"> L'histoire ...</a><br></table>
<table width="95%"><tr><td width="50%">
$news
</table>

THEVERYENDOFYOU;


?>