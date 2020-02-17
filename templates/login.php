<?php
$template = '
<div id="bloc_principal" class="arriere_plan"><div id="taille2"><h1>Actualité</h1></div><br>{{news}}<br><div id="bloc_bas1">{{classementjoueurs}}<br><br></div><div id="bloc_bas2">{{classementmonstres}}<br><br></div></div>
<div id="bloc_droite">
<a href="?do=faq"><img src="images/login/leguide.gif" alt="Le guide" width="170" height="61" class="no_bordure"></a><br><br>
<a href="{{gameurl}}"><img src="images/login/leforum.jpg" alt="Le forum" width="170" height="61" class="no_bordure"></a><br><br>
<div class="taille3"><h1><b>Les objets populaires</b></h1></div><br>
<div class="rose2"><a href="javascript:classement(\'1\');">Armes</a> / <a href="javascript:classement(\'2\');">Armures</a> / <a href="javascript:classement(\'3\');">Boucliers</a><br><br><div id="divid1" style="display:none;">{{armes}}</div><div id="divid2" style="display:none;">{{armures}}</div><div id="divid3" style="display:none;">{{boucliers}}</div></div><br><br>
<div class="taille3"><h1><b>Les partenaires</b></h1></div><br>{{partners}}<br></div>'
;
?>