<?php
$template = '
   <div style="width:162px">
   <form action="login.php?do=login" method="post"><div>
   <img src="images/login/seconnecter.gif" width="155" height="36" alt="Se connecter"><br>
   <p class="padding"></p>{{session}}
   ID:&nbsp; 
   <input type="text" size="15" name="username">
   <input type="image" name="submit" src="images/login/ok.gif" title="Ok" class="no_bordure" style="width:22px; height:15px"><br>PW: 
   <input type="password" size="15" name="password">
   </div></form>
   <img src="images/login/puce2.gif" alt="">&nbsp;<a href="users.php?do=register"><span class="marron1">Créer un personnage</span></a><br>
   <img src="images/login/puce2.gif" alt="">&nbsp;<a href="users.php?do=lostpassword"><span class="marron1">Password oublié ?</span></a><br>
   <img src="images/login/puce2.gif" alt="">&nbsp;<a href="users.php?do=changepassword"><span class="marron1">Changer de password</span><br>
   </a><br>
   <img src="images/login/lesstats.gif" width="155" height="36" alt="Les statistiques"><br>
   <p class="padding"></p>
   {{statistics}}
   <br>
   <form method="post" action=""><div>
   <img src="images/login/lesondage.gif" width="155" height="36" alt="Le sondage"><br>
   <p class="padding"></p>
   {{poll}}<br>
   </div></form>
   </div>
'
;
?>
