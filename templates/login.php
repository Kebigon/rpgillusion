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
include 'newsaccueil.php';
$news = ob_get_contents();
 ob_end_clean();
 ob_start();
 
  ob_start();
include 'items.php';
$items = ob_get_contents();
 ob_end_clean();
 ob_start();
 
$template = <<<THEVERYENDOFYOU

<table>
 <tr>
      <td><img src="images/intro_login.gif"/></td>
      </tr>
</table>

<div>
<div>

<table>
<td>
<table width="357px" height="38px" background="images/bg1_news.gif" alt="Les news" title="News"><tr><td>
</td></tr>
</table>
<table width="357px" height="1px" background="images/bg2_news.gif">
<tr>
<td width="344px" height="125px">$news</TD>
</tr>
</table> <table width="357px" height="10px" background="images/bg3_news.gif"><tr><td>
</td></tr>
</table><br> <table width="357px" height="200px" background="././images/items/bg1_items.gif">
 <tr>
 <td class="classement2" width="357px" height="200px"><br><br>$items</TD>
 </tr>
 </table>
 </td>
 <td></td>
 <td>
 <table width="276px" border="0" cellspacing="0" cellpadding="0">
 <tr>
<td  width="276px" height="38px" background="images/bg1_l.gif"></td>
</tr>
 
 <td  class="classement2" width="276px" height="1px" background="images/bg2_l.PNG">$classe_best</td></tr>
<tr>
<td  class="login" width="276px" height="1px" background="images/bg2_l.PNG">$classe</td>
</tr>
<tr>
<td  width="276px" height="13px" background="images/bg3_l.gif"></td>
</tr>
</table>
 </td>
 </table>

</table>

THEVERYENDOFYOU;


?>