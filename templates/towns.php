<?php
$template = <<<THEVERYENDOFYOU
<table width="100%">
<tr><td class="title"><img src="images/ville/town_{{id}}.gif" alt="Bienvenue � {{name}}" title="Bienvenue � {{name}}" /></td></tr>
<tr><td>
<table width="75%">
<tr><td width="50%">
<img src="images/ville/ville_{{id}}.jpg" height=220></td><td>
<b><img src="././images/ville/options_villes.gif" /></b><br />
<img src="././images/site/pic2.gif" /><a href="index.php?do=inn"> Se reposer � l'auberge</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=bank"> Passer � la Banque</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=buy"> Acheter amures/armes</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=service"> Services allopass</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=maps"> Acheter cartes</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=home"> Cr�er sa maison</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=train"> S'entra�ner</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=kamp"> QG de votre Clan</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=teekamp"> Cr�er un Clan</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=marche"> Allez au March�</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=revente"> Vendre votre minerais</a>  <br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=pretre"> Allez � l'�glise</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=enchanteur"> Allez chez la magicienne</a> <br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=metier"> ANPE</a> <br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=mag"> Achetez des sort</a><br>
<img src="././images/site/pic2.gif" /><a href="index.php?do=affaire"> Bureau des Affaires</a><br>
<img src="././images/site/pic2.gif" /> <a href="index.php?do=afficheencheres">Salle d'ench�re</a><br> 
</td></tr>
</table>
<tr><td><center>
{{news}}
<br />
<table width="95%">
<tr><td width="50%">
{{babblebox}}
</td><td>
{{whosonline}}
</td></tr>
</table>
</td></tr>
</table>
THEVERYENDOFYOU;
?>
