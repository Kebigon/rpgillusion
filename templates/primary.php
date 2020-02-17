<?php

ob_start();
include './blocs.php';
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
<LINK REL="shortcut icon" HREF="../images/site/ico.ico">


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
<head>

<h2 id="up"></h2>
  <link title="style" type="text/css" rel="stylesheet" href="style.css">
</head>
<body topmargin="0" bottommargin="0" style="background-image: url(images/site/fond.gif);">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="744">
  <tbody>
    <tr>
      <td><a href="index.php" title="Rpg Illusion 1.2c"><img src="images/site/header.jpg" alt="Rpg Illusion 1.2c" border="0"></a></td>
    </tr>
  </tbody>
</table>
<table valign="top" align="center" border="0" cellpadding="0" cellspacing="0" width="744">
  <tbody>
    <tr>
      <td background="images/site/menu_fond.jpg" bgcolor="#cdbca3" valign="top" width="182">
      <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
           <td width="184"><img src="images/site/main_nav.jpg" height="22" width="182"></td>
          </tr>
          <tr>
            <td valign="top" width="182">
            <table valign="top" align="center" width="150">
              <tbody>
                <tr>
                  <td>
				  
	<!-- Navigation! -->

                  <div id="menu">                  </div>

{{leftnav}}


$blocs
Dévelopé par Darkmore
<!--  Fin Navigation! -->
				 </td>
                  </tr>
              </tbody>
            </table>            </tr>
        </tbody>
      </table>      </td>
      <td background="images/site/contenu_fond.jpg" valign="top">
      <table valign="top" align="center" bgcolor="#cdbca3" cellpadding="0" cellspacing="0">
        <tbody>
        </tbody>
      </table>
      <table valign="top" align="left" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td height="28"><img src="images/site/news_and_content.jpg" alt=""></td>
          </tr>
          <tr>
            <td align="center" valign="top">
            <table valign="top" style="border-style: none solid solid; border-color: rgb(167, 153, 133); border-width: 0px 1px 1px; margin-left: 18px;" bgcolor="#e2d9c7" cellpadding="0" cellspacing="0" width="512">
              <tbody>
                <tr>
                  <td valign="top"><br>
				  {{content}}
<!-- Fin Parti texte! -->         </td>
               </tr>
              </tbody>
            </table>            </td>
          </tr>
        </tbody>
      </table>      </td>
    </tr>
    <tr>
      <td background="images/site/menu_fond.jpg" bgcolor="#cdbca3" valign="top"><img src="images/site/footer_menu.jpg"></td>
      <td background="images/site/contenu_fond.jpg" valign="top"><img src="images/site/footer_contenu.jpg"></td>
    </tr>
  </tbody>
  </table>  
</td>
</table>
</body>



</body>
</html>
THEVERYENDOFYOU;

?>