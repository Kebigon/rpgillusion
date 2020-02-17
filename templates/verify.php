<?php
$template ='
<img src="images/login/actions/verification.jpg" width="580" height="82" alt="Vérification du compte"><br><br>
Pour vérifier et valider votre compte, vous devez entrer ci-dessous votre adresse e-mail ainsi que le code de vérification que nous vous avons envoyé lors de votre inscription.<br><br><br>
<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">ID:</td><td><input type="text" name="username" size="30" maxlength="30"></td></tr>
<tr valign="top"><td style="width:110px">Adresse E-mail:</td><td><input type="text" name="email" size="30" maxlength="50"><br>Entrez ci-dessus l\'adresse e-mail utilisé lors de l\'inscription.<br><br></td></tr>
<tr valign="top"><td style="width:110px">Code:</td><td><input type="text" name="verify" size="10" maxlength="8"><br>Entrez ci-dessus le code de validation contenu dans votre e-mail.<br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>
<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'login.php?do=login\'"></div></td></tr>
</table>
</form>
';
?>