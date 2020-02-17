<?php
$template ='
<div style="width:160px">  
<img src="images/jeu/votreperso.gif" width="155" height="36" alt="Votre perso"><br>
<p class="padding"></p>
<div style="background-image:url(images/avatars/jeu/{{avatar}}.gif)" class="avatar_menu">
<img src="images/jeu/puce2.gif" alt=""> <span class="rose5"><b>{{charname}}</b></span> <p class="padding"></p>
<img src="images/jeu/puce.jpg" alt=""> Niveau: <span class="rose4">{{level}}</span><br>
<img src="images/jeu/puce.jpg" alt=""> Exp: <span class="rose4">{{experience}}</span><br>
<img src="images/jeu/puce.jpg" alt=""> Dextérité: <span class="rose4">{{dexterity}}</span><br>
<img src="images/jeu/puce.jpg" alt=""> Rubis: <span class="rose4">{{gold}}</span><br>
<img src="images/jeu/puce.jpg" alt=""> <span class="mauve2"><b>HP: {{currenthp}}</b> /{{maxhp}}</span><br>
<img src="images/jeu/puce.jpg" alt=""> <span class="mauve1"><b>MP: {{currentmp}}</b> /{{maxmp}}</span><br>
<img src="images/jeu/puce.jpg" alt=""> <span class="rouge1"><b>TP: {{currenttp}}</b> /{{maxtp}}</span><br>
<img src="images/jeu/puce.jpg" alt=""> Votre sac: 
<select name="select" class="taille1">
<option>{{slot1name}}</option>
<option>{{slot2name}}</option>
<option>{{slot3name}}</option>
</select></div>
<br>

<img src="images/jeu/voscartes.gif" width="155" height="36" alt="Vos cartes"><br>
<p class="padding"></p>
{{townslist}}
<br>
<img src="images/jeu/lesommaire.gif" width="155" height="36" alt="Le sommmaire"><br>
<p class="padding"></p>
{{adminlink}}<div id="divid1" style="display:none;">{{adminmenu}}</div>
<img src="images/jeu/puce.jpg" alt="">&nbsp;<a href="?do=faq">Guide</a><br>
<img src="images/jeu/puce.jpg" alt="">&nbsp;<a href="login.php?do=logout">Déconnexion</a><br>  
<div id="divid2" style="display:none;"></div><div id="divid3" style="display:none;"></div>
</div>
';
?>