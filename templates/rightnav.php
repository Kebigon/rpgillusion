<?php
$template = <<<THEVERYENDOFYOU
<table width="205px" height="60px" background="././images/bg7.gif">
<tr><td class=""></td></tr></table>
<table width="205px" height="287px" background="././images/bg8.gif"><tr><td>
<b>{{charname}}</b><br />
Niveau: {{level}}<br />
Exp: {{experience}}<br />
Gils: {{gold}}<br />
HP: {{currenthp}}<br />
MP: {{currentmp}}<br />
TP: {{currenttp}}<br />
{{statbars}}<br />
<img src="././images/pic.gif"/><a href="javascript:opencharpopup()">&nbsp;Stats détaillés</a>
</td></tr>
</table><br />

<table width="205px" height="56px" background="././images/bg9.gif">
<tr><td></td></tr></table>
<table width="205px"   height="100%" background="././images/bg9-b.gif"><tr><td>
<tr><td><img src="images/icon_weapon.gif" alt="Arme" title="Weapon" /></td><td width="205px">Arme: {{weaponname}}</td></tr>
<tr><td><img src="images/icon_armor.gif" alt="Armure" title="Armor" /></td><td width="205px">Armure: {{armorname}}</td></tr>
<tr><td><img src="images/icon_shield.gif" alt="Protection" title="Shield" /></td><td width="205px">Protection: {{shieldname}}</td></tr></table>
<table width="205px" height="73px" background="././images/bg9-c.gif"><tr><td>
Fente 1: {{slot1name}}<br>
Fente 2: {{slot2name}}<br>
Fente 3: {{slot3name}}
</tr></td>
</table>

<table width="205px" height="54px" background="././images/bg11.gif">
<tr><td class="title"></td></tr></table>
<table width="205px" height="74px" background="././images/bg12.gif"><tr><td>
{{magiclist}}
</td></tr>
</table><br />
THEVERYENDOFYOU;
?>