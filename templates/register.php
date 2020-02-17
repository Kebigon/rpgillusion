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
<tr><td>Age du perso:</td><td><input type="text" name="age" size="30" maxlength="10" /></td></tr>
<tr><td>Avatar du perso:</td><td><select name="avatar" ><option value="num-1.gif">numéro 1</option><option value="num-2.gif">numéro 2</option><option value="num-3.gif">numéro 3</option><option value="num-4.gif">numéro 4</option><option value="num-5.gif">numéro 5</option><option value="num-6.gif">numéro 6</option><option value="num-7.gif">numéro 7</option><option value="num-8.gif">numéro 8</option><option value="num-9.gif">numéro 9</option><option value="num-10.gif">numéro 10</option>
<option value="num-11.gif">numéro 11</option><option value="num-12.gif">numéro 12</option><option value="num-13.gif">numéro 13</option><option value="num-14.gif">numéro 14</option><option value="num-15.gif">numéro 15</option><option value="num-16.gif">numéro 16</option><option value="num-17.gif">numéro 17</option><option value="num-18.gif">numéro 18</option><option value="num-19.gif">numéro 19</option><option value="num-20.gif">numéro 20</option>
<option value="num-21.gif">numéro 21</option><option value="num-22.gif">numéro 22</option><option value="num-23.gif">numéro 23</option><option value="num-24.gif">numéro 24</option><option value="num-25.gif">numéro 25</option><option value="num-26.gif">numéro 26</option><option value="num-27.gif">numéro 27</option><option value="num-28.gif">numéro 28</option><option value="num-29.gif">numéro 29</option>
<option value="num-30.gif">numéro 30</option></select></td><td></td></tr>
<tr><td colspan="2">Pour voir tous les avatars <A HREF="#" onClick="window.open('avatar.php','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=400, height=565');return(false)">cliquez ici.</A><br /></td></tr> 
<tr><td>Classe du perso:</td><td><select name="charclass"><option value="1">{{class1name}}</option><option value="2">{{class2name}}</option><option value="3">{{class3name}}</option></select></td></tr>
<tr><td>Difficulté:</td><td><select name="difficulty"><option value="1">{{diff1name}}</option><option value="2">{{diff2name}}</option><option value="3">{{diff3name}}</option></select></td></tr>
<tr><td>Parain:</td><td><input type="text" name="parain" size="30" maxlength="100" /><br /><br /><br /></td></tr> 
<tr><td colspan="2">Voir la rubrique <a href="guide.php?do=login">Guide</a> pour avoir plus d'informations sur les personnages, les classes et les niveaux de difficulté.<br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>