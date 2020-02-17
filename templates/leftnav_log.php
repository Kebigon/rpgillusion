<?php
ob_start();
include 'vote.php';
$vote = ob_get_contents();
 ob_end_clean();
 ob_start();

$template = <<<THEVERYENDOFYOU

<table width="230px" height="52px" background="././images/leftnav_log/bg1_log.gif"><tr><td>
<center><form action="login.php?do=login" method="post">
<table  align="left" >
  <tr>
     <td>ID:&nbsp;&nbsp;<input type="text" size="20" name="username" style="font-family:Verdana; font-size:7pt"/></td>
  </tr>
  <tr>
      <td>PW:&nbsp; <input type="password" size="20" name="password" style="font-family:Verdana; font-size:7pt"/></td>
  </tr>
</table>
<table  align="left" valign="middle" width="20">
    <tr>
      <td ><input type="image" name="submit" src="././images/leftnav_log/log_valid.gif" alt="Ok" border="0"/>
      </td></tr>
</table >
</form>
</center></td></tr>
</table><table background="././images/leftnav_log/bg2_log.gif" width="230px" height="1px" valign="top">
     <tr>
       <td>
<img src="././images/pic.gif"/>&nbsp; <a href="users.php?do=register">Créer un personnage</a>
<br><img src="././images/pic.gif"/>&nbsp; <a href="users.php?do=lostpassword">Password oublié ?</a>
<br><img src="././images/pic.gif"/>&nbsp; <a href="users.php?do=changepassword">Changer de password</a><br>
<img src="././images/pic.gif"/>&nbsp; <a href="http://www.rpgillusion.net">Il y a&nbsp;<script type="text/javascript" src="http://www.ovnet.net/live/?code=0/100/6038/6/1&ID=19713"></script> online sur le réseau</a></td>
     </tr>
</table>
<table background="././images/leftnav_log/bg3_log.gif" width="230px" height="23px" valign="top">
<tr><td>
</td></tr>
</table>

<table width="230px" height="74px" background="././images/leftnav_log/pub_guide.gif" alt="Guide de jeu" title="Guide de jeu">
<tr><td><a href="././guide.php?do=login"><img src="././images/leftnav_log/click-guide.gif" border="0"/></a></td></tr></table>

<table width="230px" height="59px" background="././images//leftnav_log/bg1_sondage.gif" alt="Sondage" title="Sondage"><tr><td>
</td></tr>
</table>
<table width="230px" height="1px" background="././images//leftnav_log/bg2_sondage.gif">
<tr><td width="230px" >$vote</td></tr></table>

<table width="230px" height="19px" background="././images//leftnav_log/bg3_sondage.gif"><tr><td>
<tr><td></td></tr></table>

THEVERYENDOFYOU;
?>