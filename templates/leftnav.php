<?php
$template = <<<THEVERYENDOFYOU
<table width="180px" height="57px" background="././images/bg1.gif">
<tr><td class=""></td></tr></table>
<table width="180px" height="216px" background="././images/bg2.gif"><tr><td>
Actuellement: {{currentaction}}<br />
Latitude: {{latitude}}<br />
Longitude: {{longitude}}<br />
<img src="././images/pic.gif"/><a href="javascript:openmappopup()">&nbsp;Voir carte</a><br /><br />
<form action="index.php?do=move" method="post">
<center>
<input name="north" type="image" src="././images/pic_nord.gif"/><br />
<input name="west" type="image" src="././images/pic_ouest.gif"/><input name="east" type="image" src="././images/pic_est.gif"/><br />
<input name="south" type="image" src="././images/pic_sud.gif" />
</center>
</form>
</td></tr>
</table>

<table width="180px" height="54px" background="././images/bg3.gif" alt="Villes" title="Villes"> 
<tr><td class="title"></td></tr></table> 
<table width="180px" height="1px" background="././images/bgg.gif"><tr><td> 
{{currenttown}} 
Se téléporter à:<br /> 
{{townslist}} 
</td></tr> 
</table> 
<table width="180px" height="29px" background="././images/bg4.gif"> 
<tr><td></td></tr></table>

<table width="180px" height="60px" background="././images/bg5.gif" alt="Villes" title="Villes">
<tr><td class="title"></td></tr></table>
<table width="180px" height="186px" background="././images/bg6.gif" alt="Villes" title="Villes"><tr><td>
<img src="././images/pic.gif"/>&nbsp;{{forumslink}}
{{adminlink}}
<img src="././images/pic.gif"/><a href="users.php?do=changepassword">&nbsp;Changer de password</a><br /> 
<img src="././images/pic.gif"/><a href="help.php?do=login" >&nbsp;Nous aider</a><br>
<img src="././images/pic.gif"/><a href="guide.php?do=login">&nbsp;Guide</a><br>
<img src="././images/pic.gif"/><a href="login.php?do=logout">&nbsp;Quitter</a><br />
<br><br>
<center><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type=hidden name=cmd value=_xclick>
<input type=hidden name=business value=ffstory1@hotmail.com>
<input type=hidden name=item_name value=RPG illusion donation>
<input type=hidden name=no_note value=1>
<input type=hidden name=currency_code value=EUR>
<input type=hidden name=tax value=0>
<input type=hidden name=bn value=PP-DonationsBF>
<input type=image src="https://www.paypal.com/fr_FR/i/btn/x-click-but21.gif" border=0 name=submit alt=Effectuez vos paiements via PayPal : une solution rapide, gratuite et sécurisée !>
</form></center>

</td></tr>
</table><br />
THEVERYENDOFYOU;
?>