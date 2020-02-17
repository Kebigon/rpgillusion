<?php
$template = <<<THEVERYENDOFYOU
<form action="users.php?do=changepassword" method="post">
<table width="100%">
<tr><td colspan="2">Veuillez remplir les champs ci-dessous pour changer votre PW. Tous les champs sont exigés. Les nouveaux PW ne doivent pas faire plus de 10 caractères alphanumériques.</td></tr>
<tr><td width="20%">id:</td><td><input type="text" name="username" size="30" maxlength="30" /></td></tr>
<tr><td>Ancien PW:</td><td><input type="password" name="oldpass" size="20" /></td></tr>
<tr><td>Nouveau PW:</td><td><input type="password" name="newpass1" size="20" maxlength="10" /></td></tr>
<tr><td>Retapez le PW:</td><td><input type="password" name="newpass2" size="20" maxlength="10" /><br /><br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Valider" /> <input type="submit" name="submit" value="Annuler" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>