<?php
$template = <<<THEVERYENDOFYOU
<form enctype="multipart/form-data" action="users.php?do=register" method="post">
<table width="80%">
<tr><td width="20%">ID:</td><td><input type="text" name="username" size="30" maxlength="30" /><br />Votre ID ne doit pas faire plus de 30 caract�res alphanum�riques.<br /><br /><br /></td></tr>
<tr><td>PW:</td><td><input type="password" name="password1" size="30" maxlength="10" /></td></tr>
<tr><td>Retaper PW:</td><td><input type="password" name="password2" size="30" maxlength="10" /><br />Votre PW ne doit pas faire plus de 30 caract�res alphanum�riques.<br /><br /><br /></td></tr>
<tr><td>Adresse Email:</td><td><input type="text" name="email1" size="30" maxlength="100" /></td></tr>
<tr><td>Retapez Email:</td><td><input type="text" name="email2" size="30" maxlength="100" />{{verifytext}}<br /><br /><br /></td></tr>
<tr><td>Nom du perso:</td><td><input type="text" name="charname" size="30" maxlength="30" /></td></tr>
<tr><td>Age du perso:</td><td><input type="text" name="age" size="30" maxlength="10" /></td></tr>
<tr><td>Avatar du perso:</td><td><select name="avatar" ><option value="num-1.gif">num�ro 1</option><option value="num-2.gif">num�ro 2</option><option value="num-3.gif">num�ro 3</option><option value="num-4.gif">num�ro 4</option><option value="num-5.gif">num�ro 5</option><option value="num-6.gif">num�ro 6</option><option value="num-7.gif">num�ro 7</option><option value="num-8.gif">num�ro 8</option><option value="num-9.gif">num�ro 9</option><option value="num-10.gif">num�ro 10</option>
<option value="num-11.gif">num�ro 11</option><option value="num-12.gif">num�ro 12</option><option value="num-13.gif">num�ro 13</option><option value="num-14.gif">num�ro 14</option><option value="num-15.gif">num�ro 15</option><option value="num-16.gif">num�ro 16</option><option value="num-17.gif">num�ro 17</option><option value="num-18.gif">num�ro 18</option><option value="num-19.gif">num�ro 19</option><option value="num-20.gif">num�ro 20</option>
<option value="num-21.gif">num�ro 21</option><option value="num-22.gif">num�ro 22</option><option value="num-23.gif">num�ro 23</option><option value="num-24.gif">num�ro 24</option><option value="num-25.gif">num�ro 25</option><option value="num-26.gif">num�ro 26</option><option value="num-27.gif">num�ro 27</option><option value="num-28.gif">num�ro 28</option><option value="num-29.gif">num�ro 29</option>
<option value="num-30.gif">num�ro 30</option></select></td><td></td></tr>
<tr><td colspan="2">Pour voir tous les avatars <A HREF="#" onClick="window.open('avatar.php','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=400, height=565');return(false)">cliquez ici.</A><br /></td></tr> 
<tr><td>Classe du perso:</td><td><select name="charclass"><option value="1">{{class1name}}</option><option value="2">{{class2name}}</option><option value="3">{{class3name}}</option></select></td></tr>
<tr><td>Difficult�:</td><td><select name="difficulty"><option value="1">{{diff1name}}</option><option value="2">{{diff2name}}</option><option value="3">{{diff3name}}</option></select></td></tr>
<tr><td>Parain:</td><td><input type="text" name="parain" size="30" maxlength="100" /><br /><br /><br /></td></tr> 
<tr><td colspan="2">Voir la rubrique <a href="guide.php?do=login">Guide</a> pour avoir plus d'informations sur les personnages, les classes et les niveaux de difficult�.<br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Valider" /> <input type="reset" name="reset" value="Annuler" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>