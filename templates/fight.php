<?php
$template = <<<THEVERYENDOFYOU
<table width="100%">
<tr><td class="title"><img src="images/title_fighting.gif" alt="combat" /></td></tr>
<tr><td align="left">
Vous combattez un <b>{{monstername}}</b>
</td></tr>
<tr><td align="left" style="vertical-align: top;">
<img src="images/monstre/{{image}}.jpg" width="71" height="59" style="vertical-align: top; float: left;">
{{levelmonstre}}<br>
{{monsterhp}}<br>Immunisé contre {{immunecontre}}
</td></tr>
<tr><td>
{{yourturn}}
{{monsterturn}}
{{command}}
</td></tr>
</table>
THEVERYENDOFYOU;
?>