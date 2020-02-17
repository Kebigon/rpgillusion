<?php
function classement()
{
$ordre = $_GET['ordre'];
if ($ordre == "level") { $ordre_classement = 'level DESC'; }
elseif ($ordre == "experience") { $ordre_classement = 'experience DESC'; }
elseif ($ordre == "hp") { $ordre_classement = 'currenthp DESC'; }
elseif ($ordre == "mp") { $ordre_classement = 'currentmp DESC'; }
elseif ($ordre == "tp") { $ordre_classement = 'currenttp DESC'; }
elseif ($ordre == "level2") { $ordre_classement = 'level'; }
elseif ($ordre == "experience2") { $ordre_classement = 'experience'; }
elseif ($ordre == "hp2") { $ordre_classement = 'currenthp'; }
elseif ($ordre == "mp2") { $ordre_classement = 'currentmp'; }
elseif ($ordre == "tp2") { $ordre_classement = 'currenttp'; }
else { $ordre_classement = 'level DESC'; }

$classement_sql = mysql_query("SELECT id,charname,level,currentaction,currenthp,maxhp,currentmp,maxmp,currenttp,maxtp,experience FROM rpg_users WHERE verify='1' ORDER BY $ordre_classement");
while ($donnees = mysql_fetch_array($classement_sql) )
{
$classement_id = $donnees['id'];
$classement_utilisateur = $donnees['charname'];
$classement_niveau = $donnees['level'];
$classement_lieux = $donnees['currentaction'];
$classement_hp = $donnees['currenthp'];
$classement_hp_max = $donnees['maxhp'];
$classement_mp = $donnees['currentmp'];
$classement_mp_max = $donnees['maxmp'];
$classement_tp = $donnees['currenttp'];
$classement_tp_max = $donnees['maxtp'];
$classement_experience = $donnees['experience'];
$page_exe .= <<<END
<tr>
<td style="border-width:1; border-color:black;" bgcolor="#ECD5B2">

<p align="center"><a href="index.php?do=onlinechar:$classement_id">$classement_utilisateur</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#ECD5B2">

<p align="center">$classement_niveau</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#ECD5B2">

<p align="center">$classement_experience</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#ECD5B2">

<p align="center">$classement_lieux</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#ECD5B2">

<p align="center">$classement_hp / $classement_hp_max</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#ECD5B2">

<p align="center">$classement_mp / $classement_mp_max</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#ECD5B2">

<p align="center">$classement_tp / $classement_tp_max</p>
</td>
</tr>
END;
}

$page = <<<END
<table align="center" cellspacing="0" style="border-collapse:collapse;" border="1">
<tr>
<td style="border-width:1; border-color:black;" bgcolor="#DABE92">

<p align="center">Personnage</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#DABE92">

<p align="center"><a href="index.php?do=classement&amp;ordre=level">Niveau</a></p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#DABE92">

<p align="center"><a href="index.php?do=classement&amp;ordre=experience">Expérience</a></p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#DABE92">

<p align="center">Lieu Actuel</p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#DABE92">

<p align="center"><a href="index.php?do=classement&amp;ordre=hp">Points de vie</a></p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#DABE92">

<p align="center"><a href="index.php?do=classement&amp;ordre=mp">Points de Magie</a></p>
</td>
<td style="border-width:1; border-color:black;" bgcolor="#DABE92">

<p align="center"><a href="index.php?do=classement&amp;ordre=tp">Points de Téléportation</a></p>
</td>
</tr>
$page_exe
</table>
END;
display($page, "Classement");
}
?>