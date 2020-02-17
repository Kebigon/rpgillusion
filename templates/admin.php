<?php
$template = <<<THEVERYENDOFYOU
<head>
<title>{{title}}</title>
<style type="text/css">
body {
  color: black;
  font: 11px verdana;
}
table {
  border-style: none;
  padding: 0px;
  font: 11px verdana;
}
td {
  border-style: none;
  padding: 3px;
  vertical-align: top;
}
a {
    color: #663300;
    text-decoration: none;
    font-weight: bold;
}
a:hover {
    color: #330000;
}
.small {
  font: 10px verdana;
}
.highlight {
  color: red;
}
.light {
  color: #999999;
}
.title {
  border: solid 1px black;
  background-color: #eeeeee;
  font-weight: bold;
  padding: 5px;
  margin: 3px;
}
.copyright {
  border: solid 1px black;
  background-color: #eeeeee;
  font: 10px verdana;
}
</style>
</head>
<body><center>
<table width="90%"><tr>
<td width="150" style="border-right: solid 1px black;">
<b><u>Administration</u></b><br /><br />
<b>Les liens:</b><br />
<a href="admin.php">Page d'Admin</a><br />
<a href="./index.php">Index du jeu</a><br /><br />
<b>Données principal:</b><br />
<a href="admin.php?do=main">Réglages principaux</a><br />
<a href="admin.php?do=news">Ajouter nouvelle</a><br />
<a href="admin.php?do=users">Editer utilisateurs</a><br />
<a href="admin.php?do=sondage">Editer sondage</a><br />
<a href="admin.php?do=blocs">Editer les blocs</a><br />
<a href="admin.php?do=babble">Vider le chatbox</a><br />
<a href="admin.php?do=message">Editer un mail</a><br />
<a href="admin.php?do=newsaccueil">Editer les news</a><br /><br />
<b>Données du jeu:</b><br />
<a href="admin.php?do=items">Editer objets</a><br />
<a href="admin.php?do=drops">Editer objets perdus</a><br />
<a href="admin.php?do=towns">Editer villes</a><br />
<a href="admin.php?do=monsters">Editer monstres</a><br />
<a href="admin.php?do=levels">Editer niv. du jeu</a><br />
<a href="admin.php?do=carte">Editer la map</a><br />
<a href="admin.php?do=spells">Editer sorts</a><br /><br>
<b>Mises à jours:</b><br />
<a href="http://www.rpgillusion.net/forum/?cat=3&id=18">Vérifier les maj</a><br />
</td><td>
{{content}}
</td></tr></table>
<br />
<table class="copyright" width="90%"><tr>
<td width="25%" align="center"></td>
</center></body>
</html>
THEVERYENDOFYOU;
?>