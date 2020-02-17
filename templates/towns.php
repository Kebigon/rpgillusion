<?php
$template = '
<img src="images/jeu/villes/{{currenttownid}}.jpg" width="580" height="82" alt="{{currenttown}}"><br><br>
<div id="bloc_principal" class="arriere_plan"><div id="taille2"><h1>Menu de ville</h1></div><br>
<img src="images/jeu/puce3.gif" alt=""> <a href="?do=inn">Se reposer à l\'auberge de {{currenttown}}</a><br>
<span class="taille1">Reposez vous à l\'auberge et augmenter vos de points de vie (HP, TP et MP).</span><br><br>
<img src="images/jeu/puce3.gif" alt=""> <a href="?do=buy">Aller au magasin d\'objet</a><br>
<span class="taille1">Au magasin vous pouvez acheter des équipements tel que des armes, armures et boucliers.</span><br><br>
<img src="images/jeu/puce3.gif" alt=""> <a href="?do=maps">Aller au magasin de cartes</a><br>
<span class="taille1">Achetez des cartes, cela vous facilite vos déplacements, grâce à la téléportation.</span><br><br>
<br><div id="bloc_bas1"><div class="taille3"><h1><b>Les joueurs en ligne</b></h1><br>{{whosonline}}</div><br><br></div><div id="bloc_bas2"><div class="taille3"><h1><b>Les quêtes</b></h1><br>Prohainement...</div><br><br></div></div>
<div id="bloc_droite">
<form action="?do=move" method="post">
<div><input name="south" type="image" class="no_bordure" title="Sortir de la ville" src="images/jeu/sortirville.gif"><br><br></div>
</form>
<a href="#"><img src="images/login/leforum.jpg" alt="Le forum" width="170" height="61" class="no_bordure"></a><br><br>
<div class="taille3"><h1><b>Le T\'chat</b></h1></div><br>
{{babble_warning}}{{babblebox}}{{babble_bottom}}
<br><br>
<div class="taille3"><h1><b>Module vide</b></h1></div><br>module vide<br></div>
';
?>