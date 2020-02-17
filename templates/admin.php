<?php

ob_start();
include '../blocs.php';
$blocs = ob_get_contents();
 ob_end_clean();
 ob_start();
 
$template = <<<THEVERYENDOFYOU
<head>
<title>{{title}}</title>
</script>
</head>
<head>
<title>RPG Illusion ++ =&gt; bienvenue ;)</title>
<h2 id="up"></h2>
  <link title="style" type="text/css" rel="stylesheet" href="../style.css">
</head>
<body topmargin="0" bottommargin="0" style="background-image: url(../images/site//fond.gif);">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="744">
  <tbody>
    <tr>
      <td><a href="index.php" title="RPG ILLUSION ++"><img src="../images/site//header.jpg" alt="RPG Illusion ++ => le portail 100% RPG Illusion" border="0"></a></td>
    </tr>
  </tbody>
</table>
<table valign="top" align="center" border="0" cellpadding="0" cellspacing="0" width="744">
  <tbody>
    <tr>
      <td background="../images/site//menu_fond.jpg" bgcolor="#cdbca3" valign="top" width="182">
      <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
           <td width="184"><img src="../images/site//main_nav.jpg" height="22" width="182"></td>
          </tr>
          <tr>
            <td valign="top" width="182">
            <table valign="top" align="center" width="150">
              <tbody>
                <tr>
                  <td>
				  
	<!-- Navigation! -->

                  <div id="menu">                  </div>

<b><u>Administration</u></b><br /><br />
<b>Les liens:</b><br />
<a href="admin.php">Page d'Admin</a><br />
<a href="../index.php">Index du jeu</a><br />
<a href="admin.php?do=stats">Statistiques du jeu</a><br /><br />

<b>Données principal:</b><br />
<a href="admin.php?do=main">Réglages principaux</a><br />
<a href="admin.php?do=news">Ajouter nouvelle</a><br />
<a href="admin.php?do=newsaccueil">Ajouter news</a><br />
<a href="admin.php?do=message">Envoyer un mail</a><br />
<a href="admin.php?do=users">Editer utilisateurs</a><br />
<a href="admin.php?do=blocs">Editer les blocs</a><br />
<a href="admin.php?do=forum">Editer le forum</a><br />
<a href="admin.php?do=babble">Vider le chatbox</a><br />
<a href="admin.php?do=comment">Vider les comments</a><br />
<a href="admin.php?do=historique">Vider l'historique</a><br />
<a href="admin.php?do=message2">Vider les messageries</a><br /><br />

<b>Données du jeu:</b><br />
<a href="admin.php?do=items">Editer objets</a><br />
<a href="admin.php?do=drops">Editer objets perdus</a><br />
<a href="admin.php?do=items2">Editer objets marché</a><br />
<a href="admin.php?do=monsters">Editer monstres</a><br />
<a href="admin.php?do=levels">Editer niv. du jeu</a><br />
<a href="admin.php?do=maisons">Editer maisons</a><br />
<a href="admin.php?do=addsort">Ajout de Sort</a><br />
<a href="admin.php?do=spells">Editer sorts</a><br />
<a href="admin.php?do=addville">Ajout de villes</a><br />
<a href="admin.php?do=towns">Editer villes</a><br />
<a href="admin.php?do=quete">Création de Quête</a><br />
<a href="admin.php?do=quetes">Edition de Quête</a><br />
<a href="admin.php?do=villenatal">Teleporter</a><br />
<a href="admin.php?do=interet">Déclencher les interets</a><br />
<a href="admin.php?do=metier">Déclencher les métiers</a><br /><br />
<b>Mises à jours:</b><br />
<a href="http://rpgillusion.franceserv.com/forum/?cat=3&id=18">Vérifier les maj</a><br />



$blocs
Dévelopé par Darkmore
<!--  Fin Navigation! -->
				 </td>
                  </tr>
              </tbody>
            </table>            </tr>
        </tbody>
      </table>      </td>
      <td background="../images/site//contenu_fond.jpg" valign="top">
      <table valign="top" align="center" bgcolor="#cdbca3" cellpadding="0" cellspacing="0">
        <tbody>
        </tbody>
      </table>
      <table valign="top" align="left" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td height="28"><img src="../images/site//news_and_content.jpg" alt=""></td>
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
      <td background="../images/site//menu_fond.jpg" bgcolor="#cdbca3" valign="top"><img src="../images/site//footer_menu.jpg"></td>
      <td background="../images/site//contenu_fond.jpg" valign="top"><img src="../images/site//footer_contenu.jpg"></td>
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