<?php
$townquery3 = doquery("SELECT monnaie FROM {{table}} WHERE  id='1'  LIMIT 1", "control"); 
$townrow3 = mysql_fetch_array($townquery3); 
$monnaie = $townrow3["monnaie"];
$template = <<<THEVERYENDOFYOU

<table width="30px" height="32px" background="images/site/dr.gif"><tr><td>
<br>
<table width="95%">
<tr><td width="90%"><img src="images/avatar/{{avatar}}"><br>
<a href="javascript:opencharpopup()"><b> {{charname}}</b></a><br />
Niveau: {{level}}<br />
<a href="javascript:openmappopup()"><b>Po:</b></a> {{latitude}}/{{longitude}}<br />
Exp: {{experience}}<br />
$monnaie: {{gold}}<br />
Age: {{age}}<br />
HP: {{currenthp}}<br />
MP: {{currentmp}}<br />
TP: {{currenttp}}</br />
</td><td>
</table>

<br><img src="images/site/main_nav5.jpg">
<form action="index.php?do=move" method="post">
<center><input name="north" type="image" src="././images/pic_nord.gif"/><br />
<input name="west" type="image" src="././images/pic_ouest.gif"/><input name="east" type="image" src="././images/pic_est.gif"/><br />
<input name="south" type="image" src="././images/pic_sud.gif" /></center>
</form>


<img src="images/site/main_nav3.jpg"><br>
{{townslist}} 


<br><img src="images/site/main_nav4.jpg"><br>
{{adminlink}}{{modolink}}  
<img src="././images/site/pic.gif">&nbsp;{{forumslink}}
<img src="././images/site/pic.gif"/>({{nb}}){{msglink}}
<img src="././images/site/pic.gif"><a href=index.php?do=sacados>&nbsp;Sac a Dos</a><br>
<img src="././images/site/pic.gif"><a href="index.php?do=kamp">&nbsp;QG de votre Clan</a><br>
<img src="././images/site/pic.gif"><a href="index.php?do=journal">&nbsp;JournalQuetes</a><br>
<img src="././images/site/pic.gif"><a href="index.php?do=point">&nbsp;PointPerso</a><br>
<img src="././images/site/pic.gif"><a href="index.php?do=profil">&nbsp;Profil</a><br>
<img src="././images/site/pic.gif"><a href="index.php?do=classement">&nbsp;Classement</a><br> 
<img src="././images/site/pic.gif"/><a href="help.php?do=login" >&nbsp;Nous aider</a><br>
<img src="././images/site/pic.gif"/><a href="guide.php?do=login">&nbsp;Guide</a><br>
<img src="././images/site/pic.gif"><a href="login.php?do=logout">&nbsp;Quitter</a><br />
</table><br>

THEVERYENDOFYOU;
?>