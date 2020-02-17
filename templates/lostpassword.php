<?php
$template = <<<THEVERYENDOFYOU
<form action="users.php?do=lostpassword" method="post">
<table width="80%">
<tr><td colspan="2">Si vous avez perdu votre PW, écrivez votre adresse email ci-dessous. Un nouveau vous sera envoyé.</td></tr>
<tr><td width="20%">Adresse email:</td><td><input type="text" name="email" size="30" maxlength="100" /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>