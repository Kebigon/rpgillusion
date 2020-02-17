<?php
$template = <<<THEVERYENDOFYOU
<form action="users.php?do=verify" method="post">
<table width="80%">
<tr><td colspan="2">Merci de votre inscription. Maintenant veuillez inscrire votre id, adresse email, et le code de validation présent dans l'email que nous vous avons envoyé.</td></tr>
<tr><td width="20%">ID:</td><td><input type="text" name="username" size="30" maxlength="30" /></td></tr>
<tr><td>Adresse Email:</td><td><input type="text" name="email" size="30" maxlength="100" /></td></tr>
<tr><td>Code de Validation:</td><td><input type="text" name="verify" size="10" maxlength="8" /><br /><br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>