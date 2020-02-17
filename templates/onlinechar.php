<?php
$template = <<<THEVERYENDOFYOU
Voici le profile du personnage nommé <b>{{charname}}</b>.<br /><br />
Quand vous avez fini, vous pouvez <a href="index.php">retourner à la ville</a>.<br /><br />
<table width="200">
<tr><td class="title"><img src="images/button_character.gif" alt="Personnage" title="Personnage" /></td></tr>
<tr><td>
<b>{{charname}}</b><br /><br />
<img src="././images/avatar/num-{{avatar}}.gif" width="71" height="66"><br /><br />
Difficulté: {{difficulty}}<br />
Classe: {{charclass}}<br /><br />

Niveau: {{level}}<br />
Experience: {{experience}}<br />
Gils: {{gold}}<br />
Points hit: {{currenthp}} / {{maxhp}}<br />
Points de magie: {{currentmp}} / {{maxmp}}<br />
Points de voyages: {{currenttp}} / {{maxtp}}<br /><br />

Force: {{strength}}<br />
Dextérité: {{dexterity}}<br />
Pouvoir d'attaque: {{attackpower}}<br />
Pouvoir de défense: {{defensepower}}<br />
</td></tr>
</table><br />

<table width="200">
<tr><td class="title"><img src="images/button_inventory.gif" alt="Inventaire" title="Inventaire" /></td></tr>
<tr><td>
<table width="100%">
<tr><td><img src="images/icon_weapon.gif" alt="Arme" title="Weapon" /></td><td width="100%">Armes: {{weaponname}}</td></tr>
<tr><td><img src="images/icon_armor.gif" alt="Armure" title="Armes" /></td><td width="100%">Armures: {{armorname}}</td></tr>
<tr><td><img src="images/icon_shield.gif" alt="Protection" title="Shield" /></td><td width="100%">Protection: {{shieldname}}</td></tr>
</table>
Fente 1: {{slot1name}}<br />
Fente 2: {{slot2name}}<br />
Fente 3: {{slot3name}}
</td></tr>
</table><br />
THEVERYENDOFYOU;
?>