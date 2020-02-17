<?php
ob_start();
include 'vote.php';
$vote = ob_get_contents();
 ob_end_clean();
 ob_start();

// Lister les derniers inscrits
$di = doquery("SELECT username FROM {{table}} WHERE verify='1' ORDER BY id DESC LIMIT 5","users");
$dinum = mysql_num_rows($di);

while($arr = mysql_fetch_assoc($di))
{
$dins .= $arr['username'];
$num++;
if($num == ($dinum - 1))
{
$dins .= ' et ';
}
elseif($num == $dinum)
{
$dins .= '.';
}
else
{
$dins .= ', ';
}
}

// Nombre de joueurs inscrits
$di2 = doquery("SELECT id FROM {{table}} WHERE verify='1' ORDER BY id DESC LIMIT 1","users");
$dinum2 = mysql_num_rows($di2);

while($arr = mysql_fetch_assoc($di2))
{
$dins2 .= $arr['id'];
$num++;
if($num == ($dinum - 1))
{
$dins2 .= '';
}
elseif($num == $dinum)
{
$dins2 .= '';
}
else
{
$dins2 .= '';
}
}

// Nombre de joueurs connécté
$onlinequery = doquery("SELECT * FROM {{table}} WHERE UNIX_TIMESTAMP(onlinetime) >= '".(time()-600)."' ORDER BY charname", "users");
$online = mysql_num_rows($onlinequery);

if($online == 1) $mbr_s = "Membre connecté";
if($online > 1) $mbr_s = "Membres connectés";
if($online < 1) $mbr_s = "Pas de connectés";

while($onn = mysql_fetch_assoc($onlinequery))
{
$ons .=$onn['charname'];
$nu++;
if($nu == ($online - 1))
{
$ons .= '&nbsp;<img src="images/site/ligne.gif"><br/>
';
}
elseif($nu == $online)
{
$ons .= '&nbsp;<img src="images/site/ligne.gif"><br/>';
}
else
{
$ons .= '&nbsp;<img src="images/site/ligne.gif"><br/>&nbsp;
';
}
}

$template = <<<THEVERYENDOFYOU

<br>

<table width="150px" height="62px"><tr><td>
<center><form action="login.php?do=login" method="post">
<table  align="left" >
  <tr>
     <td>ID:&nbsp;&nbsp;<input type="text" size="20" name="username" style="font-family:Verdana; font-size:7pt"/></td>
  </tr>
  <tr>
      <td>PW:&nbsp; <input type="password" size="20" name="password" style="font-family:Verdana; font-size:7pt"/></td>
 </tr>
</table>
<center>
 <tr><td><center><input type="image" name="submit" src="././images/leftnav_log/log_valid.gif" alt="Ok" border="0"/></center>
</td> </tr>     

</form>
</center></td></tr>
<table width="150px" height="61px" valign="top">
     <tr>
       <td>
<img src="././images/site/pic.gif"/>&nbsp; <a href="users.php?do=register">Créer un personnage</a>
<br><img src="././images/site/pic.gif"/>&nbsp; <a href="users.php?do=lostpassword">Password oublié ?</a>
<br><img src="././images/site/pic.gif"/>&nbsp; <a href="users.php?do=changepassword">Changer de password</a><br>
<br> <img src="././images/site/pic.gif"/><b>Il y a :</b> $dins2 <b>joueurs.</b><br>
<img src="././images/site/pic.gif"/><b>Derniers inscrits :</b> <br> $dins
<br><img src="././images/site/pic.gif"/><b>$mbr_s:</b>
<br>$ons 
$vote

</td> 
	 </tr>


  <tr>
       <td>
	   </tr>
</table>



THEVERYENDOFYOU;
?>