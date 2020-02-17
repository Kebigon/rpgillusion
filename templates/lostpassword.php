<?php
$template ='
<img src="images/login/actions/pw_oublie.jpg" width="580" height="82" alt="Password oublié"><br><br>
Si vous avez perdu votre Password (PW), il vous sufffit de nous indiquer votre adresse e-mail utilisé lors de votre inscription. Nous vous enverrons imédiatement un nouveau PW par e-mail.<br><br><br>
<form enctype="multipart/form-data" action="" method="post">
<table width="580" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><td style="width:110px">Adresse email:</td><td><input type="text" name="email" size="30" maxlength="50"><br><br></td></tr>
<tr valign="top"><td style="width:1px"></td><td>
<div style="text-align: center"><input type="submit" name="submit" value="Valider"> <input type="button" value="Retour" OnClick="javascript:location=\'login.php?do=login\'"></div></td></tr>
</table>
</form>
';
?>