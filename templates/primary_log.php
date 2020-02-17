<?php

ob_start();
include 'blocs.php';
$blocs = ob_get_contents();
 ob_end_clean();
 ob_start();
 
$template = <<<THEVERYENDOFYOU
<head>
<title>{{title}}</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name='Description' content='RPG illusion est un rpg entierement gratuit en php. Téléchargez le pour votre site. Free php online www.rpgillusion.net'>
<meta name='Keywords' content='free, php, free hosting, rpg, free game, rpg online, online, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, i, ii, iii, iv, v, vi, vii, viii, ix, x, xi, xii, tactics, lengend, mmorg, mystic, free mmorpg, ff1, ff2, ff3, ff4, ff5, ff6, ff7, ff8, ff9, ff10, ff11, ff12, film, the, spirits, within, creatures, esprit, square, squaresoft, actualite, news, nouvelles, solution, soluce, walthrough, guides, faq, astuces, tips, cheats, codes, action, replay, game, shark, quetes, armes, chocobos, objets, discussion, forum, ezboard, avatars, chat, irc, script, livre, or, downloads, fonds, ecran, bureau, wallpapers, skins, winamp, icq, musique, midi, spc, nobuo, uematsu, en, francais, francaises, fr, triple, triad, online, en, ligne, runic, police, font, icones, ecrand, veille, sreensavers, images, videos, str, lecteur, fans, fanarts, fanfics, annuaire, portail, liens, taquin, histoire, historique, phenomene, japon, creation, genese, paroles, lyrics, goodies, pc, playstation, psx, psx2, sony, nintendo, super, famicom, jeux, video, games, top, topjv, classement, sites'>
<meta name="Author" content='Mick'>
<meta name='Identifier-URL' content='http://www.rpgillusion.net'>
<meta name='Reply-to' content='webmaster@rpgillusion.net'>
<meta name='revisit-after' content='1 days'>
<meta name='robots' content='index, follow'>
<meta name='Generator' content='Wordpad'>
<meta name='Copyright' content='RPGillusion'>
<LINK REL="shortcut icon" HREF="../images/ico.ico">

<style type="text/css">
body {
  background-image: url(images/background.jpg);
  color: black;
  font: 11px verdana;
}
#dek {
  width: 200px;
  background : #FFFFF9 ;
  border-bottom: solid 1px black;
  border-left: solid 1px black;
  border-top: solid 1px black;
  border-right: solid 1px black;
  z-index: 100;
  visibility: hidden; 
  position: absolute; 
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
td.login {
  vertical-align: top;
  font: 11px verdana;
  padding: 0px;
}
td.classement {
  vertical-align: top;
  font: 11px verdana;
  padding: 1px;
}
td.items2 {
  border-style: none;
  padding: 0px;
  vertical-align: bottom;
}
td.items {
  border-style: none;
  padding: 0px;
  vertical-align: top;
}
td.classement2 {
  border: 1px;
  font: 11px verdana;
  padding: 15px;
  vertical-align: top;
  text-align: left;
}
td.top {
  width: 889px;
  border-bottom: solid 1px black;
  border-style:dotted;
  border-left: solid 0px white;
  border-top: solid 0px white;
  border-right: solid 0px black; 
}
td.left {
  width: 180px;
  border-right: solid 1px black; 
  border-style:dotted;
  border-left: solid 0px white;
 border-top: solid 0px white;
 border-bottom: solid 0px white;
}
td.right {
  width: 0px;
   border-left: solid 0px black; 
   border-style:dotted;
  border-right: solid 0px white;
  border-top: solid 0px white;
  border-bottom: solid 0px white;
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
  padding: 1px;
  margin: 0px;
}
.bg_log { 
position: bottom;
}
.news {
  font: 11px verdana;
}

</style>
<script>
function opencharpopup(){
var popurl="index.php?do=showchar"
winpops=window.open(popurl,"","width=210,height=500,scrollbars")
}
function openmappopup(){
var popurl="index.php?do=showmap"
winpops=window.open(popurl,"","width=520,height=520,scrollbars")
}
</script>
</head>
<body><center>
<table cellspacing="0" width="75%"><tr>
<td class="top" colspan="3">
  <table width="75%"><tr><td><img src="images/logo.gif" alt="{{dkgamename}}" title="{{dkgamename}}" border="0"/></td><td style="text-align:right; vertical-align:middle;">{{topnav}}</td></tr></table>
</td>
</tr><tr>
<td class="left">{{leftnav_log}}</td>
<td class="middle">{{content}}</td>
<td class="right">{{rightnav}}</td>
</tr>
</table><br />
<table class="classement " width="90%"><tr>
<td width="25%" align="center" valign="middle">$blocs</table>
</center></body>
</html>
THEVERYENDOFYOU;
?>