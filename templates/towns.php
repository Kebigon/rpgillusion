<?php
$template = <<<THEVERYENDOFYOU
<table width="100%">
<tr><td class="title"><img src="images/town_{{id}}.gif" alt="Bienvenue à {{name}}" title="Bienvenue à {{name}}" /></td></tr>
<tr><td>
<b> <img src="././images/options_villes.gif" /></b><br />
<ul>
 <img src="././images/pic2.gif" /><a href="index.php?do=inn"> Se reposer à l'auberge</a><br>
 <img src="././images/pic2.gif" /><a href="index.php?do=bank"> Passer à la Banque</a><br>
 <img src="././images/pic2.gif" /><a href="index.php?do=buy"> Acheter amures/armes</a><br>
 <img src="././images/pic2.gif" /><a href="index.php?do=service"> Services allopass</a><br>
 <img src="././images/pic2.gif" /><a href="index.php?do=maps"> Acheter cartes</a></a></br>
 <img src="././images/pic2.gif" /><a href="index.php?do=home"> Créer sa maison</a></a></br>
 <img src="././images/pic2.gif" /><a href="index.php?do=train"> S'entraîner</a></a><br>
</ul>
</td></tr>
<tr><td><center>
{{news}}
<br />
<table width="95%">
<tr><td width="50%">
{{whosonline}}
</td><td>
{{babblebox}}
</td></tr>
</table>
</td></tr>
</table>
THEVERYENDOFYOU;
?>
