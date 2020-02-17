<?php
$template = '
<img src="images/login/actions/inscription.jpg" width="580" height="82" alt="Inscription"><br><br>
<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td><input type="text" name="username" size="30" maxlength="30"><br>Votre ID ne doit pas faire plus de 30 caractères alphanumériques.<br><br></td></tr>
<tr valign="top"><td style="width:110px">PW:</td><td><input type="password" name="password1" size="30" maxlength="30"></td></tr>
<tr valign="top"><td style="width:110px">Retaper PW:</td><td><input type="password" name="password2" size="30" maxlength="30"><br>Votre PW ne doit pas faire plus de 30 caractères alphanumériques.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Adresse Email:</td><td><input type="text" name="email1" size="30" maxlength="50"></td></tr>
<tr valign="top"><td style="width:110px">Retapez Email:</td><td><input type="text" name="email2" size="30" maxlength="50">{{verifytext}}<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nom du perso:</td><td><input type="text" name="charname" size="30" maxlength="30"><br><br></td></tr>
<tr valign="top"><td style="width:110px">Avatar du perso:</td><td><select name="avatar" ><option value="1">numéro 1</option><option value="2">numéro 2</option><option value="3">numéro 3</option><option value="4">numéro 4</option><option value="5">numéro 5</option><option value="6">numéro 6</option><option value="7">numéro 7</option><option value="8">numéro 8</option><option value="9">numéro 9</option><option value="10">numéro 10</option></select><br>Pour voir tous les avatars <A HREF="#" onClick="window.open(\'avatars.php\',\'_blank\',\'toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=400, height=265\');return(false)">cliquez ici.</a><br><br></td><td></td></tr>
<tr valign="top"><td style="width:110px">Classe du perso:</td><td><select name="charclass"><option value="1">{{class1name}}</option><option value="2">{{class2name}}</option><option value="3">{{class3name}}</option></select><br><br></td></tr>
<tr valign="top"><td style="width:110px">Difficulté:</td><td><select name="difficulty"><option value="1">{{diff1name}}</option><option value="2">{{diff2name}}</option><option value="3">{{diff3name}}</option></select><br>Voir la rubrique <a href="login.php?do=guide">Guide</a> pour avoir plus d\'informations sur les personnages, les classes et les niveaux de difficulté.<br><br>
</td></tr>
<tr valign="top"><td style="width:1px"></td><td>
<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'login.php?do=login\'"></div></td></tr>
</table>
</form>';
?>