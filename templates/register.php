<?php
$template = <<<THEVERYENDOFYOU
<form enctype="multipart/form-data" action="users.php?do=register" method="post">
<table width="80%">
<tr><td width="20%">ID:</td><td><input type="text" name="username" size="30" maxlength="30" /><br />Votre ID ne doit pas faire plus de 30 caractères alphanumériques.<br /><br /><br /></td></tr>
<tr><td>PW:</td><td><input type="password" name="password1" size="30" maxlength="10" /></td></tr>
<tr><td>Retaper PW:</td><td><input type="password" name="password2" size="30" maxlength="10" /><br />Votre PW ne doit pas faire plus de 30 caractères alphanumériques.<br /><br /><br /></td></tr>
<tr><td>Adresse Email:</td><td><input type="text" name="email1" size="30" maxlength="100" /></td></tr>
<tr><td>Retapez Email:</td><td><input type="text" name="email2" size="30" maxlength="100" />{{verifytext}}<br /><br /><br /></td></tr>
<tr><td>Nom du perso:</td><td><input type="text" name="charname" size="30" maxlength="30" /></td></tr>
<tr><td>Avatar du perso:</td><td><select name="avatar" ><option value="1">numéro 1</option><option value="2">numéro 2</option><option value="3">numéro 3</option><option value="4">numéro 4</option><option value="5">numéro 5</option><option value="6">numéro 6</option><option value="7">numéro 7</option><option value="8">numéro 8</option><option value="9">numéro 9</option><option value="10">numéro 10</option></select></td><td></td></tr>
<tr><td colspan="2">Pour voir tous les avatars <A HREF="#" onClick="window.open('avatar.php','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=400, height=265');return(false)">cliquez ici.</A><br /></td></tr> 
<tr><td>Classe du perso:</td><td><select name="charclass"><option value="1">{{class1name}}</option><option value="2">{{class2name}}</option><option value="3">{{class3name}}</option></select></td></tr>
<tr><td>Difficulté:</td><td><select name="difficulty"><option value="1">{{diff1name}}</option><option value="2">{{diff2name}}</option><option value="3">{{diff3name}}</option></select></td></tr>
<tr><td colspan="2">Voir la rubrique <a href="guide.php?do=login">Guide</a> pour avoir plus d'informations sur les personnages, les classes et les niveaux de difficulté.<br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>