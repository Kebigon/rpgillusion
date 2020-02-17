<?php
$template = '
<img src="images/login/actions/changer_pw.jpg" width="580" height="82" alt="Changer de Password"><br><br>
Pour changer votre password (PW), il vous suffit de remplir correctement le formulaire ci-dessous. La modification sera opérationnel instantanement.<br><br><br>
<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td><input type="text" name="username" size="30" maxlength="30"><br>Votre ID ne doit pas faire plus de 30 caractères alphanumériques.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Ancien PW:</td><td><input type="password" name="oldpass" size="30" maxlength="30"><br>Tapez ci-dessus votre ancien PW.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Nouveau PW:</td><td><input type="password" name="newpass1" size="30" maxlength="30"></td></tr>
<tr valign="top"><td style="width:110px">Retapez le PW:</td><td><input type="password" name="newpass2" size="30" maxlength="30"><br>Votre PW ne doit pas faire plus de 30 caractères alphanumériques.<br><br>
</td></tr>
<tr valign="top"><td style="width:1px"></td><td>
<div style="text-align: center"><input type="submit" name="submit" value="Changer"> <input type="button" value="Retour" OnClick="javascript:location=\'login.php?do=login\'"></div></td></tr>
</table>
</form>
';
?>