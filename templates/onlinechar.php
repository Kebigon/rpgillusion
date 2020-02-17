<?php
$template = <<<THEVERYENDOFYOU
Voici le profile du personnage nommé <b>{{charname}}</b>.<br /><br />
Quand vous avez fini, vous pouvez <a href="index.php">retourner à la ville</a>.<br /><br />
<table width="200">
<tr><td class="title"><img src="images/button_character.gif" alt="Personnage" title="Personnage" /></td></tr>
<tr><td>
<b>{{charname}}</b><br /><br />
<img src="././images/avatar/{{avatar}}" width="71" height="66"><br /><br />
<b>Id :</b> {{id}}<br>
<b>Classe :</b> {{charclass}}<br />
<b>Niveau :</b> {{level}}<br />
<b>Experience :</b> {{experience}}<br />
<b>Age :</b> {{age}}<br />
<b>Position:</b> :{{latitude}}/{{longitude}}<br />



</td></tr>
</table><br />
THEVERYENDOFYOU;
?>