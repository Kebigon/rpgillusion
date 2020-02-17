<?php
$template = <<<THEVERYENDOFYOU
<table width="100%">
<tr><td class="title"><img src="images/button_character.gif" alt="Personnage" title="Personnage" /></td></tr>
<tr><td>
<b>{{charname}}</b><br /><br />
<img src="././images/avatar/{{avatar}}" width="71" height="66"><br /><br />

Difficulté: {{difficulty}}<br />
Classe: {{charclass}}<br /><br />

Niveau: {{level}}<br />
Experience: {{experience}} {{plusexp}}<br />
Prochain niveau: {{nextlevel}}<br />
Gils: {{gold}} {{plusgold}}<br />
Points hit: {{currenthp}} / {{maxhp}}<br />
Points de magies: {{currentmp}} / {{maxmp}}<br />
Points de voyages: {{currenttp}} / {{maxtp}}<br /><br />

Force: {{strength}}<br />
Dextérité: {{dexterity}}<br />
Pouvoir d'attaque: {{attackpower}}<br />
Pouvoir de défense: {{defensepower}}<br />
</td></tr>
</table><br />

<table width="100%">
<tr><td class="title"><img src="images/button_inventory.gif" alt="Inventaire" title="Inventaire" /></td></tr>
<tr><td>
<table width="100%">
<tr><td><img src="images/icon_weapon.gif" alt="Arme" title="Weapon" /></td><td width="100%">Arme: {{weaponname}}</td></tr>
<tr><td><img src="images/icon_armor.gif" alt="Armure" title="Armor" /></td><td width="100%">Armure: {{armorname}}</td></tr>
<tr><td><img src="images/icon_shield.gif" alt="Protection" title="Shield" /></td><td width="100%">Protection: {{shieldname}}</td></tr>
</table>
Fente 1: {{slot1name}}<br />
Fente 2: {{slot2name}}<br />
Fente 3: {{slot3name}}
</td></tr>
</table><br />

<table width="100%">
<tr><td class="title"><img src="images/button_spells.gif" alt="Sorts" title="Spells" /></td></tr>
<tr><td>
{{magiclist}}
</td></tr>
</table><br />
THEVERYENDOFYOU;
?>