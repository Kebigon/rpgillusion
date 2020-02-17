<?php // install.php :: création/complétation des tables.

include('config.php');
include('lib.php');
$link = opendb();
$start = getmicrotime();

if (isset($_GET["page"])) {
    $page = $_GET["page"];
    if ($page == 2) { second(); }
    elseif ($page == 3) { third(); }
    elseif ($page == 4) { fourth(); }
    elseif ($page == 5) { fifth(); }
    else { first(); }
} else { first(); }

// Merci à Predrag Supurovic from php.net pour cette function!
function dobatch ($p_query) {
  $query_split = preg_split ("/[;]+/", $p_query);
  foreach ($query_split as $command_line) {
   $command_line = trim($command_line);
   if ($command_line != '') {
     $query_result = mysql_query($command_line);
     if ($query_result == 0) {
       break;
     };
   };
  };
  return $query_result;
}

function first() { // Première page - infos et avertissements sur l'installation.
    
$page = <<<END
<html>
<head>
<title>Installation de RPG illusion</title>
</head>
<body>
<font  face="verdana" size="3"><b>Installation de RPG illusion: page 1</b></font><br /><br />
<font  face="verdana" size="2"><b>NOTE:</b> Veuillez vous assurer que les infos dans config.php, ont été complétées correctement avant de continuer.  L'installation échouera si ces infos ne sont pas correctes.  En outre, la base de données de MySQL doit exister déjà.  Ce script d'installation prendra soin d'installer la structure et le contenu du jeu, mais la base de données elle-même doit déjà exister sur votre serveur de MySQL avant d'éxécuter l'installation.<br /><br />
L'installation de RPG illusion est un processus en deux étapes simple:  installez les tables de la base de données, puis créez l'utilisateur d'administration.  Après ces deux étape le jeu sera totalement installé.<br /><br />
Vous avez le choix entre 2 types d'installation:
<ul>
<li /><b>L'installation complète</b> crée toutes les tables de la base données, et elle les complètent par défault - après l'installation complète, le jeu est prêt à fonctionner.
<li /><b>L'installation partielle</b> crée seulement  les tables de la base données. Elle ne les complètent pas - employez cette installation si vous pensez modifier le script plus tard.
</ul>
Cliquez le bouton d'installation qui vous convient.<br /><br />
<form action="install.php?page=2" method="post">
<input type="submit" name="complete" style="font-family:Verdana; font-size:10pt" value="Installation complète" /><br /> - OU - <br /><input type="submit" name="partial" style="font-family:Verdana; font-size:10pt" value="Installation partielle" /></font>
</form>
</body>
</html>
END;
echo $page;
die();
  
}

	function second() { // Deuxième page - Installation des tables mysql.
    
    global $dbsettings;
    echo "<html><head><title>Installation de RPG illusion</title></head><body><b>Installation de RPG illusion: page 2</b><br /><br />";
    $prefix = $dbsettings["prefix"];
    $babble = $prefix . "_babble";
    $blocs = $prefix . "_blocs";
    $control = $prefix . "_control";
	$comments = $prefix . "_comments";
    $drops = $prefix . "_drops";
    $forum = $prefix . "_forum";
    $items = $prefix . "_items";
    $levels = $prefix . "_levels";
    $monsters = $prefix . "_monsters";
    $news = $prefix . "_news";
    $newsaccueil = $prefix . "_newsaccueil";
    $resultats = $prefix . "_resultats";
    $sondage = $prefix . "_sondage";
    $sondage_ip = $prefix . "_sondage_ip";
    $spells = $prefix . "_spells";
    $towns = $prefix . "_towns";
	$maison = $prefix . "_maison";
	$sol = $prefix . "_sol";
    $users = $prefix . "_users";
    $map = $prefix . "_map";
    if (isset($_POST["complete"])) { $full = true; } else { $full = false; }

 $query = <<<END
CREATE TABLE `$babble` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `posttime` time NOT NULL default '00:00:00',
  `author` varchar(30) NOT NULL default '',
  `babble` varchar(120) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Babble Box a été crée.<br />"; } else { echo "Erreur de création de la table Babble Box table."; }
unset($query);   

$query = 
"CREATE TABLE `$blocs`(
`id` int(6) NOT NULL auto_increment, 
`bloc1` VARCHAR(200) NOT NULL default '',
`bloc2` VARCHAR(200) NOT NULL default '', 
`bloc3` VARCHAR(200) NOT NULL default '',
`bloc4` VARCHAR(200) NOT NULL default '',
`bloc5` VARCHAR(200) NOT NULL default '',
 PRIMARY KEY(id)
)";  
 if (dobatch($query) == 1) { echo "La table blocs a été crée.<br />"; } else { echo "Erreur de création de la table blocs"; }
unset($query);

$query = <<<END
INSERT INTO `$blocs` VALUES (1, 'images/vide.jpg','images/libertnova.jpg','Copyright (c) Rpgillusion.net - Kat Network - All rights reserved - 2004-2006.', 'Toutes les images présentent sur ce site, appartiennent à leurs propriétaires respectif', '');
END;
if (dobatch($query) == 1) { echo "La table blocs a été complétée.<br />"; } else { echo "Erreur lorsque la table blocs a été complétée."; }
unset($query);

$query = <<<END
CREATE TABLE `$control` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `gamename` varchar(50) NOT NULL default '',
  `gamesize` smallint(5) unsigned NOT NULL default '0',
  `gameopen` tinyint(3) unsigned NOT NULL default '0',
  `gameurl` varchar(200) NOT NULL default '',
  `adminemail` varchar(100) NOT NULL default '',
  `forumtype` tinyint(3) unsigned NOT NULL default '0',
  `forumaddress` varchar(200) NOT NULL default '',
  `class1name` varchar(50) NOT NULL default '',
  `class2name` varchar(50) NOT NULL default '',
  `class3name` varchar(50) NOT NULL default '',
  `diff1name` varchar(50) NOT NULL default '',
  `diff1mod` float unsigned NOT NULL default '0',
  `diff2name` varchar(50) NOT NULL default '',
  `diff2mod` float unsigned NOT NULL default '0',
  `diff3name` varchar(50) NOT NULL default '',
  `diff3mod` float unsigned NOT NULL default '0',
  `compression` tinyint(3) unsigned NOT NULL default '0',
  `verifyemail` tinyint(3) unsigned NOT NULL default '0',
  `shownews` tinyint(3) unsigned NOT NULL default '0',
  `showbabble` tinyint(3) unsigned NOT NULL default '0',
  `showonline` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

END;
if (dobatch($query) == 1) { echo "La table Control a été crée.<br />"; } else { echo "Erreur de création de la table Control."; }
unset($query);

$query = <<<END
INSERT INTO `$control` VALUES (1, 'RPG illusion v1.2b', 250, 1, '', '', 1, '', 'Mage', 'Guerrier', 'Paladin', 'Facile', '1', 'Moyen', '1.2', 'Dur', '1.5', 1, 1, 1, 1, 1);
END;
if (dobatch($query) == 1) { echo "La table Control a été complétée.<br />"; } else { echo "Erreur lorsque la table Control a été complétée."; }
unset($query);

$query = <<<END
CREATE TABLE `$comments` (
  `id` bigint(255) NOT NULL auto_increment,
  `topic` bigint(255) NOT NULL default '0',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `poster` bigint(255) NOT NULL default '0',
  `post` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table comments a été crée.<br />"; } else { echo "Erreur de création de la table comments."; }
unset($query);

$query = <<<END
CREATE TABLE `$drops` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `mlevel` smallint(5) unsigned NOT NULL default '0',
  `type` smallint(5) unsigned NOT NULL default '0',
  `attribute1` varchar(30) NOT NULL default '',
  `attribute2` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Drops a été crée.<br />"; } else { echo "Erreur de création de la table Drops."; }
unset($query);

if ($full == true) {
$query = <<<END
INSERT INTO `$drops` VALUES (1, 'Life Pebble', 1, 1, 'maxhp,10', 'Aucun');
INSERT INTO `$drops` VALUES (2, 'Life Stone', 10, 1, 'maxhp,25', 'Aucun');
INSERT INTO `$drops` VALUES (3, 'Life Rock', 25, 1, 'maxhp,50', 'Aucun');
INSERT INTO `$drops` VALUES (4, 'Magic Pebble', 1, 1, 'maxmp,10', 'Aucun');
INSERT INTO `$drops` VALUES (5, 'Magic Stone', 10, 1, 'maxmp,25', 'Aucun');
INSERT INTO `$drops` VALUES (6, 'Magic Rock', 25, 1, 'maxmp,50', 'Aucun');
INSERT INTO `$drops` VALUES (7, 'Dragon\'s Scale', 10, 1, 'defensepower,25', 'Aucun');
INSERT INTO `$drops` VALUES (8, 'Dragon\'s Plate', 30, 1, 'defensepower,50', 'Aucun');
INSERT INTO `$drops` VALUES (9, 'Dragon\'s Claw', 10, 1, 'attackpower,25', 'Aucun');
INSERT INTO `$drops` VALUES (10, 'Dragon\'s Tooth', 30, 1, 'attackpower,50', 'Aucun');
INSERT INTO `$drops` VALUES (11, 'Dragon\'s Tear', 35, 1, 'strength,50', 'Aucun');
INSERT INTO `$drops` VALUES (12, 'Dragon\'s Wing', 35, 1, 'dexterity,50', 'Aucun');
INSERT INTO `$drops` VALUES (13, 'Demon\'s Sin', 35, 1, 'maxhp,-50', 'strength,50');
INSERT INTO `$drops` VALUES (14, 'Demon\'s Fall', 35, 1, 'maxmp,-50', 'strength,50');
INSERT INTO `$drops` VALUES (15, 'Demon\'s Lie', 45, 1, 'maxhp,-100', 'strength,100');
INSERT INTO `$drops` VALUES (16, 'Demon\'s Hate', 45, 1, 'maxmp,-100', 'strength,100');
INSERT INTO `$drops` VALUES (17, 'Angel\'s Joy', 25, 1, 'maxhp,25', 'strength,25');
INSERT INTO `$drops` VALUES (18, 'Angel\'s Rise', 30, 1, 'maxhp,50', 'strength,50');
INSERT INTO `$drops` VALUES (19, 'Angel\'s Truth', 35, 1, 'maxhp,75', 'strength,75');
INSERT INTO `$drops` VALUES (20, 'Angel\'s Love', 40, 1, 'maxhp,100', 'strength,100');
INSERT INTO `$drops` VALUES (21, 'Seraph\'s Joy', 25, 1, 'maxmp,25', 'dexterity,25');
INSERT INTO `$drops` VALUES (22, 'Seraph\'s Rise', 30, 1, 'maxmp,50', 'dexterity,50');
INSERT INTO `$drops` VALUES (23, 'Seraph\'s Truth', 35, 1, 'maxmp,75', 'dexterity,75');
INSERT INTO `$drops` VALUES (24, 'Seraph\'s Love', 40, 1, 'maxmp,100', 'dexterity,100');
INSERT INTO `$drops` VALUES (25, 'Ruby', 50, 1, 'maxhp,150', 'Aucun');
INSERT INTO `$drops` VALUES (26, 'Pearl', 50, 1, 'maxmp,150', 'Aucun');
INSERT INTO `$drops` VALUES (27, 'Emerald', 50, 1, 'strength,150', 'Aucun');
INSERT INTO `$drops` VALUES (28, 'Topaz', 50, 1, 'dexterity,150', 'Aucun');
INSERT INTO `$drops` VALUES (29, 'Obsidian', 50, 1, 'attackpower,150', 'Aucun');
INSERT INTO `$drops` VALUES (30, 'Diamond', 50, 1, 'defensepower,150', 'Aucun');
INSERT INTO `$drops` VALUES (31, 'Memory Drop', 5, 1, 'expbonus,10', 'Aucun');
INSERT INTO `$drops` VALUES (32, 'Fortune Drop', 5, 1, 'goldbonus,10', 'Aucun');
END;
if (dobatch($query) == 1) { echo "La table Drops a été complétée.<br />"; } else { echo "Erreur lorsque la table Drops table a été complétée."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$forum` (
  `id` int(11) NOT NULL auto_increment,
  `postdate` datetime NOT NULL default '00-00-0000 00:00:00',
  `newpostdate` datetime NOT NULL default '00-00-0000 00:00:00',
  `author` varchar(30) NOT NULL default '',
  `parent` int(11) NOT NULL default '0',
  `replies` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Forum a été crée.<br />"; } else { echo "Erreur de création de la table Forum."; }
unset($query);


$query = <<<END
CREATE TABLE `$items` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `buycost` smallint(5) unsigned NOT NULL default '0',
  `attribute` smallint(5) unsigned NOT NULL default '0',
  `special` varchar(50) NOT NULL default '',
  `image` tinyint(3) unsigned NOT NULL default '0',
  `description` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Items a été crée.<br />"; } else { echo "Erreur de création de la table Items."; }
unset($query);

if ($full == true) {
$query = <<<END
INSERT INTO `$items` VALUES (1, 1, 'Branche', 10, 2, 'Aucun',1, 'Aucune description');
INSERT INTO `$items` VALUES (2, 1, 'Bilboquet', 30, 4, 'Aucun',2, 'Aucune description');
INSERT INTO `$items` VALUES (3, 1, 'Epée sacrée', 35, 5, 'Aucun',3, 'Aucune description');
INSERT INTO `$items` VALUES (4, 1, 'Épée Soleil', 200, 9, 'Aucun',4, 'Aucune description');
INSERT INTO `$items` VALUES (5, 1, 'Épée Volca', 650, 13, 'maxhp,-8',5, 'Aucune description');
INSERT INTO `$items` VALUES (6, 1, 'Hache', 200, 16, 'Aucun',8, 'Aucune description');
INSERT INTO `$items` VALUES (7, 1, 'Bombes rechargeable', 300, 25, 'Aucun',7, 'Aucune description');
INSERT INTO `$items` VALUES (8, 3, 'Pull anti flames', 50, 4, 'Aucun',8, 'Aucune description');
INSERT INTO `$items` VALUES (9, 3, 'Manteau de proction', 120, 5, 'Aucun',9, 'Aucune description');
INSERT INTO `$items` VALUES (10, 2, 'Carapace', 1200, 20, 'maxhp,60',10, 'Aucune description');
INSERT INTO `$items` VALUES (11, 2, 'Casque millitaire', 190, 6, 'Aucun',11, 'Aucune description');
INSERT INTO `$items` VALUES (12, 2, 'Super casque', 3000, 56, 'expbonus,100',12, 'Aucune description');
INSERT INTO `$items` VALUES (13, 2, 'Casque taureau', 4500, 90, 'goldbonus,120',13, 'Aucune description');
INSERT INTO `$items` VALUES (14, 1, 'Baguette magique', 6000, 200, 'expbonus,230',14, 'Aucune description');
INSERT INTO `$items` VALUES (15, 3, 'Pantalon millitaire', 420, 12, 'Aucun',15, 'Aucune description');
INSERT INTO `$items` VALUES (16, 3, 'Pantalon de Génoa', 850, 15, 'Aucun',16, 'Aucune description');
INSERT INTO `$items` VALUES (17, 2, 'Cobra de Gobi', 6000, 220, 'goldbonus,210',17, 'Aucune description');
INSERT INTO `$items` VALUES (18, 1, 'Pierre', 120, 5, 'Aucun',18, 'Aucune description');
INSERT INTO `$items` VALUES (19, 1, 'Arc', 360, 10, 'Aucun',19, 'Aucune description');
INSERT INTO `$items` VALUES (20, 1, 'Super arc', 960, 16, 'maxtp,18',20, 'Aucune description');
INSERT INTO `$items` VALUES (21, 3, 'Lunette anti-éclairs', 300, 11, 'Aucun',21, 'Aucune description');
INSERT INTO `$items` VALUES (22, 3, 'Gans', 310, 11, 'Aucun',22, 'Aucune description');
INSERT INTO `$items` VALUES (23, 3, 'Super gans', 752, 14, 'Aucun',23, 'Aucune description');
INSERT INTO `$items` VALUES (24, 1, 'Masse ronde', 800, 17, 'maxhp,-20',24, 'Aucune description');
INSERT INTO `$items` VALUES (25, 1, 'Dent de requin', 60, 4, 'expbonus,-2',25, 'Aucune description');
INSERT INTO `$items` VALUES (26, 1, 'Couteau sacré', 180, 8, 'expbonus,2',26, 'Aucune description');
INSERT INTO `$items` VALUES (27, 1, 'Marteau', 500, 200, 'dexterity,-10',27, 'Aucune description');
INSERT INTO `$items` VALUES (28, 2, 'Botte de Stella', 2500, 86, 'maxtp,200',28, 'Aucune description');
INSERT INTO `$items` VALUES (29, 3, 'Chaussure de randonnée', 100, 4, 'maxtp,2',29, 'Aucune description');
INSERT INTO `$items` VALUES (30, 3, 'Bonnet', 90, 2, 'Aucun',30, 'Aucune description');
INSERT INTO `$items` VALUES (31, 1, 'Pioche', 750, 8, 'Aucun',31, 'Aucune description');
INSERT INTO `$items` VALUES (32, 1, 'Poison foudroyant', 1000, 60, 'Aucun',32, 'Aucune description');
INSERT INTO `$items` VALUES (33, 3, 'Potion blanche', 95, 100, 'maxhp,50',33, 'Aucune description');
INSERT INTO `$items` VALUES (34, 3, 'Potion bleu', 120, 100, 'maxhp,50',34, 'Aucune description');
INSERT INTO `$items` VALUES (35, 3, 'Potion rouge', 155, 100, 'maxhp,50',35, 'Aucune description');
END;
if (dobatch($query) == 1) { echo "La table Items a été complétée.<br />"; } else { echo "Erreur lorsque la table Items a été complétée."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$levels` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `1_exp` mediumint(8) unsigned NOT NULL default '0',
  `1_hp` smallint(5) unsigned NOT NULL default '0',
  `1_mp` smallint(5) unsigned NOT NULL default '0',
  `1_tp` smallint(5) unsigned NOT NULL default '0',
  `1_strength` smallint(5) unsigned NOT NULL default '0',
  `1_dexterity` smallint(5) unsigned NOT NULL default '0',
  `1_spells` tinyint(3) unsigned NOT NULL default '0',
  `2_exp` mediumint(8) unsigned NOT NULL default '0',
  `2_hp` smallint(5) unsigned NOT NULL default '0',
  `2_mp` smallint(5) unsigned NOT NULL default '0',
  `2_tp` smallint(5) unsigned NOT NULL default '0',
  `2_strength` smallint(5) unsigned NOT NULL default '0',
  `2_dexterity` smallint(5) unsigned NOT NULL default '0',
  `2_spells` tinyint(3) unsigned NOT NULL default '0',
  `3_exp` mediumint(8) unsigned NOT NULL default '0',
  `3_hp` smallint(5) unsigned NOT NULL default '0',
  `3_mp` smallint(5) unsigned NOT NULL default '0',
  `3_tp` smallint(5) unsigned NOT NULL default '0',
  `3_strength` smallint(5) unsigned NOT NULL default '0',
  `3_dexterity` smallint(5) unsigned NOT NULL default '0',
  `3_spells` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Levels a été crée.<br />"; } else { echo "Erreur de création de la table Levels."; }
unset($query);

if ($full == true) {
$query = <<<END
INSERT INTO `$levels` VALUES (1, 0, 15, 0, 5, 5, 5, 0, 0, 15, 0, 5, 5, 5, 0, 0, 15, 0, 5, 5, 5, 0);
INSERT INTO `$levels` VALUES (2, 15, 2, 5, 1, 0, 1, 1, 18, 2, 4, 1, 2, 1, 1, 20, 2, 5, 1, 0, 2, 1);
INSERT INTO `$levels` VALUES (3, 45, 3, 4, 2, 1, 2, 0, 54, 2, 3, 2, 3, 2, 0, 60, 2, 3, 2, 1, 3, 0);
INSERT INTO `$levels` VALUES (4, 105, 3, 3, 2, 1, 2, 6, 126, 2, 3, 2, 3, 2, 0, 140, 2, 4, 2, 1, 3, 0);
INSERT INTO `$levels` VALUES (5, 195, 2, 5, 2, 0, 1, 0, 234, 2, 4, 2, 2, 1, 6, 260, 2, 4, 2, 0, 2, 6);
INSERT INTO `$levels` VALUES (6, 330, 4, 5, 2, 2, 3, 0, 396, 3, 4, 2, 4, 3, 0, 440, 3, 5, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (7, 532, 3, 4, 2, 1, 2, 11, 639, 2, 3, 2, 3, 2, 0, 710, 2, 3, 2, 1, 3, 0);
INSERT INTO `$levels` VALUES (8, 835, 2, 4, 2, 0, 1, 0, 1003, 2, 3, 2, 2, 1, 11, 1115, 2, 4, 2, 0, 2, 11);
INSERT INTO `$levels` VALUES (9, 1290, 5, 3, 2, 3, 4, 2, 1549, 4, 2, 2, 5, 4, 0, 1722, 4, 2, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (10, 1973, 10, 3, 2, 4, 3, 0, 2369, 10, 2, 2, 6, 3, 0, 2633, 10, 3, 2, 4, 4, 0);
INSERT INTO `$levels` VALUES (11, 2997, 5, 2, 2, 3, 4, 0, 3598, 4, 1, 2, 5, 4, 2, 3999, 4, 1, 2, 3, 5, 2);
INSERT INTO `$levels` VALUES (12, 4533, 4, 2, 2, 2, 3, 7, 5441, 4, 1, 2, 4, 3, 0, 6047, 4, 2, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (13, 6453, 4, 3, 2, 2, 3, 0, 7745, 4, 2, 2, 4, 3, 0, 8607, 4, 2, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (14, 8853, 5, 4, 2, 3, 4, 17, 10625, 4, 3, 2, 5, 4, 7, 11807, 4, 4, 2, 3, 5, 7);
INSERT INTO `$levels` VALUES (15, 11853, 5, 5, 2, 3, 4, 0, 14225, 4, 4, 2, 5, 4, 0, 15808, 4, 4, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (16, 15603, 5, 3, 2, 3, 4, 0, 18725, 5, 2, 2, 5, 4, 0, 20807, 5, 3, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (17, 20290, 4, 2, 2, 2, 3, 12, 24350, 4, 1, 2, 4, 3, 0, 27057, 4, 1, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (18, 25563, 4, 2, 2, 2, 3, 0, 30678, 3, 1, 2, 4, 3, 14, 34869, 3, 2, 2, 2, 4, 17);
INSERT INTO `$levels` VALUES (19, 31495, 4, 5, 2, 2, 3, 0, 37797, 3, 4, 2, 4, 3, 0, 43657, 3, 4, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (20, 38169, 10, 6, 2, 3, 3, 0, 45805, 10, 5, 2, 5, 3, 0, 53543, 10, 6, 2, 3, 4, 0);
INSERT INTO `$levels` VALUES (21, 45676, 4, 4, 2, 2, 3, 0, 54814, 4, 3, 2, 4, 3, 0, 64664, 4, 3, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (22, 54121, 5, 5, 2, 3, 4, 0, 64949, 4, 4, 2, 5, 4, 12, 77175, 4, 5, 2, 3, 5, 12);
INSERT INTO `$levels` VALUES (23, 63622, 5, 3, 2, 3, 4, 0, 76350, 4, 2, 2, 5, 4, 0, 91250, 4, 2, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (24, 74310, 5, 5, 2, 3, 4, 0, 89176, 4, 4, 2, 5, 4, 0, 107083, 4, 5, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (25, 86334, 4, 4, 2, 2, 3, 3, 103605, 3, 3, 2, 4, 3, 17, 124895, 3, 3, 2, 2, 4, 14);
INSERT INTO `$levels` VALUES (26, 99861, 6, 3, 2, 4, 5, 0, 119837, 5, 2, 2, 6, 5, 0, 144933, 5, 3, 2, 4, 6, 0);
INSERT INTO `$levels` VALUES (27, 115078, 6, 2, 2, 4, 5, 0, 138098, 5, 1, 2, 6, 5, 0, 167475, 5, 1, 2, 4, 6, 0);
INSERT INTO `$levels` VALUES (28, 132197, 4, 2, 2, 2, 3, 0, 158641, 4, 1, 2, 4, 3, 0, 192835, 4, 2, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (29, 151456, 6, 3, 2, 4, 5, 0, 181751, 5, 2, 2, 6, 5, 3, 221365, 5, 2, 2, 4, 6, 3);
INSERT INTO `$levels` VALUES (30, 173121, 10, 4, 3, 4, 4, 0, 207749, 10, 3, 3, 6, 4, 0, 253461, 10, 4, 3, 4, 5, 0);
INSERT INTO `$levels` VALUES (31, 197494, 5, 5, 3, 3, 4, 8, 236996, 4, 3, 3, 5, 4, 0, 289568, 4, 3, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (32, 224913, 6, 4, 3, 4, 5, 0, 269898, 5, 3, 3, 6, 5, 0, 330188, 5, 4, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (33, 255758, 5, 4, 3, 3, 4, 0, 306912, 5, 3, 3, 5, 4, 0, 375885, 5, 3, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (34, 290458, 6, 4, 3, 4, 5, 0, 348552, 5, 3, 3, 6, 5, 8, 427294, 5, 4, 3, 4, 6, 8);
INSERT INTO `$levels` VALUES (35, 329495, 5, 3, 3, 3, 4, 0, 395397, 4, 2, 3, 5, 4, 0, 485126, 4, 2, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (36, 373412, 4, 3, 3, 2, 3, 18, 448097, 5, 2, 3, 4, 3, 0, 550188, 5, 3, 3, 2, 4, 0);
INSERT INTO `$levels` VALUES (37, 422818, 5, 4, 3, 3, 4, 0, 507384, 5, 3, 3, 5, 4, 0, 623383, 5, 3, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (38, 478399, 6, 5, 3, 4, 5, 0, 574081, 5, 4, 3, 6, 5, 15, 705726, 5, 5, 3, 4, 6, 18);
INSERT INTO `$levels` VALUES (39, 540927, 6, 4, 3, 4, 5, 0, 649115, 5, 3, 3, 6, 5, 0, 798362, 5, 3, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (40, 611271, 15, 3, 3, 5, 5, 13, 733528, 15, 2, 3, 7, 5, 0, 902577, 15, 3, 3, 5, 6, 0);
INSERT INTO `$levels` VALUES (41, 690408, 7, 3, 3, 5, 2, 0, 828492, 6, 2, 3, 7, 2, 0, 1019818, 6, 2, 3, 5, 3, 0);
INSERT INTO `$levels` VALUES (42, 779437, 7, 4, 3, 5, 6, 0, 935326, 6, 3, 3, 7, 6, 0, 1151714, 6, 4, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (43, 879592, 8, 5, 3, 6, 7, 0, 1055514, 7, 4, 3, 8, 7, 0, 1300096, 7, 4, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (44, 992268, 6, 3, 3, 4, 5, 0, 1190725, 5, 2, 3, 6, 5, 0, 1448478, 5, 3, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (45, 1119028, 5, 8, 3, 3, 4, 4, 1325936, 5, 8, 3, 5, 4, 18, 1596860, 5, 8, 3, 3, 5, 4);
INSERT INTO `$levels` VALUES (46, 1245788, 6, 5, 3, 4, 5, 0, 1461147, 5, 4, 3, 6, 5, 0, 1745242, 5, 5, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (47, 1372548, 7, 4, 3, 5, 6, 0, 1596358, 6, 3, 3, 7, 6, 0, 1893624, 6, 3, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (48, 1499308, 6, 4, 3, 4, 5, 0, 1731569, 5, 3, 3, 6, 5, 0, 2042006, 5, 4, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (49, 1626068, 5, 3, 3, 3, 4, 0, 1866780, 4, 2, 3, 5, 4, 0, 2190388, 4, 2, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (50, 1752828, 15, 3, 3, 5, 5, 0, 2001991, 15, 2, 3, 7, 5, 0, 2338770, 15, 3, 3, 5, 6, 0);
INSERT INTO `$levels` VALUES (51, 1879588, 6, 2, 3, 4, 5, 9, 2137202, 5, 1, 3, 6, 5, 13, 2487152, 5, 1, 3, 4, 6, 13);
INSERT INTO `$levels` VALUES (52, 2006348, 7, 2, 3, 5, 6, 0, 2272413, 6, 1, 3, 7, 6, 0, 2635534, 6, 2, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (53, 2133108, 8, 2, 3, 6, 7, 0, 2407624, 7, 1, 3, 8, 7, 0, 2783916, 7, 1, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (54, 2259868, 8, 4, 3, 6, 7, 0, 2542835, 7, 3, 3, 8, 7, 0, 2932298, 7, 4, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (55, 2386628, 7, 4, 3, 5, 6, 0, 2678046, 6, 3, 3, 7, 6, 0, 3080680, 6, 3, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (56, 2513388, 7, 4, 3, 5, 6, 0, 2813257, 6, 3, 3, 7, 6, 0, 3229062, 6, 4, 3, 5, 7, 9);
INSERT INTO `$levels` VALUES (57, 2640148, 6, 5, 3, 4, 5, 0, 2948468, 6, 4, 3, 6, 5, 0, 3377444, 6, 4, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (58, 2766908, 5, 5, 3, 3, 4, 0, 3083679, 5, 4, 3, 5, 4, 19, 3525826, 5, 5, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (59, 2893668, 8, 3, 3, 6, 7, 0, 3218890, 7, 2, 3, 8, 7, 0, 3674208, 7, 2, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (60, 3020428, 15, 4, 4, 6, 6, 19, 3354101, 15, 3, 4, 8, 6, 0, 3822590, 15, 4, 4, 6, 7, 15);
INSERT INTO `$levels` VALUES (61, 3147188, 8, 5, 4, 6, 7, 0, 3489312, 7, 4, 4, 8, 7, 0, 3970972, 7, 4, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (62, 3273948, 8, 4, 4, 6, 7, 0, 3624523, 7, 3, 4, 8, 7, 0, 4119354, 7, 4, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (63, 3400708, 9, 5, 4, 7, 8, 0, 3759734, 8, 4, 4, 9, 8, 0, 4267736, 8, 4, 4, 7, 9, 0);
INSERT INTO `$levels` VALUES (64, 3527468, 5, 5, 4, 3, 4, 0, 3894945, 5, 4, 4, 5, 4, 0, 4416118, 5, 5, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (65, 3654228, 6, 4, 4, 4, 5, 0, 4030156, 6, 3, 4, 6, 5, 0, 4564500, 6, 3, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (66, 3780988, 8, 4, 4, 6, 7, 0, 4165367, 8, 3, 4, 8, 7, 0, 4712882, 8, 4, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (67, 3907748, 7, 3, 4, 5, 6, 0, 4300578, 7, 2, 4, 7, 6, 0, 4861264, 7, 2, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (68, 4034508, 9, 3, 4, 7, 8, 0, 4435789, 8, 2, 4, 9, 8, 0, 5009646, 8, 3, 4, 7, 9, 0);
INSERT INTO `$levels` VALUES (69, 4161268, 5, 4, 4, 3, 4, 0, 4571000, 5, 3, 4, 5, 4, 0, 5158028, 5, 3, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (70, 4288028, 20, 4, 4, 6, 6, 5, 4706211, 20, 3, 4, 8, 6, 16, 5306410, 20, 4, 4, 6, 7, 0);
INSERT INTO `$levels` VALUES (71, 4414788, 5, 5, 4, 3, 4, 0, 4841422, 5, 4, 4, 5, 4, 0, 5454792, 5, 4, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (72, 4541548, 6, 2, 4, 4, 5, 0, 4976633, 5, 1, 4, 6, 5, 0, 5603174, 5, 2, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (73, 4668308, 8, 4, 4, 6, 7, 0, 5111844, 8, 3, 4, 8, 7, 0, 5751556, 8, 3, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (74, 4795068, 7, 5, 4, 5, 6, 0, 5247055, 6, 4, 4, 7, 6, 0, 5899938, 6, 5, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (75, 4921828, 5, 3, 4, 3, 4, 0, 5382266, 5, 2, 4, 5, 4, 0, 6048320, 5, 2, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (76, 5048588, 6, 3, 4, 4, 5, 0, 5517477, 6, 2, 4, 6, 5, 0, 6196702, 6, 3, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (77, 5175348, 6, 4, 4, 4, 5, 0, 5652688, 7, 3, 4, 6, 5, 0, 6345084, 7, 3, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (78, 5302108, 7, 4, 4, 5, 6, 0, 5787899, 7, 3, 4, 7, 6, 0, 6493466, 7, 4, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (79, 5428868, 8, 4, 4, 6, 7, 10, 5923110, 7, 3, 4, 8, 7, 0, 6641848, 7, 3, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (80, 5555628, 20, 5, 4, 6, 7, 0, 6058321, 20, 4, 4, 8, 7, 0, 6790230, 20, 5, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (81, 5682388, 7, 3, 4, 5, 6, 0, 6193532, 7, 2, 4, 7, 6, 0, 6938612, 7, 2, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (82, 5809148, 6, 4, 4, 4, 5, 0, 6328743, 5, 3, 4, 6, 5, 0, 7086994, 5, 4, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (83, 5935908, 6, 2, 4, 4, 5, 0, 6463954, 6, 1, 4, 6, 5, 0, 7235376, 6, 1, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (84, 6062668, 5, 4, 4, 3, 4, 0, 6599165, 5, 3, 4, 5, 4, 0, 7383758, 5, 4, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (85, 6189428, 7, 4, 4, 5, 6, 0, 6734376, 6, 3, 4, 7, 6, 0, 7532140, 6, 3, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (86, 6316188, 8, 5, 4, 6, 7, 0, 6869587, 8, 4, 4, 8, 7, 0, 7680522, 8, 5, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (87, 6442948, 8, 4, 4, 6, 7, 0, 7004798, 7, 3, 4, 8, 7, 0, 7828904, 7, 3, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (88, 6569708, 9, 5, 4, 7, 8, 0, 7140009, 8, 4, 4, 9, 8, 0, 7977286, 8, 5, 4, 7, 9, 0);
INSERT INTO `$levels` VALUES (89, 6696468, 5, 2, 4, 3, 4, 0, 7275220, 5, 1, 4, 5, 4, 0, 8125668, 5, 1, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (90, 6823228, 20, 2, 5, 7, 8, 0, 7410431, 20, 1, 5, 9, 8, 0, 8274050, 20, 2, 5, 7, 9, 0);
INSERT INTO `$levels` VALUES (91, 6949988, 5, 3, 5, 3, 4, 0, 7545642, 5, 2, 5, 5, 4, 0, 8422432, 5, 2, 5, 3, 5, 0);
INSERT INTO `$levels` VALUES (92, 7076748, 6, 3, 5, 4, 5, 0, 7680853, 4, 2, 5, 6, 5, 0, 8570814, 4, 3, 5, 4, 6, 0);
INSERT INTO `$levels` VALUES (93, 7203508, 8, 4, 5, 6, 7, 0, 7816064, 6, 2, 5, 8, 7, 0, 8719196, 6, 2, 5, 6, 8, 0);
INSERT INTO `$levels` VALUES (94, 7330268, 4, 4, 5, 3, 3, 0, 7951275, 4, 3, 5, 5, 3, 0, 8867578, 4, 4, 5, 3, 4, 0);
INSERT INTO `$levels` VALUES (95, 7457028, 3, 3, 5, 5, 2, 0, 8086486, 4, 2, 5, 7, 2, 0, 9015960, 4, 2, 5, 5, 3, 0);
INSERT INTO `$levels` VALUES (96, 7583788, 5, 3, 5, 4, 3, 0, 8221697, 5, 2, 5, 7, 3, 0, 9164342, 5, 3, 5, 4, 4, 0);
INSERT INTO `$levels` VALUES (97, 7710548, 5, 4, 5, 4, 5, 0, 8356908, 5, 3, 5, 7, 5, 0, 9312724, 5, 3, 5, 4, 6, 0);
INSERT INTO `$levels` VALUES (98, 7837308, 4, 5, 5, 4, 3, 0, 8492119, 4, 3, 5, 7, 3, 0, 9461106, 4, 4, 5, 4, 4, 0);
INSERT INTO `$levels` VALUES (99, 7964068, 50, 5, 5, 6, 5, 0, 8627330, 50, 3, 5, 9, 5, 0, 9609488, 50, 4, 5, 6, 6, 0);
INSERT INTO `$levels` VALUES (100, 16777215, 0, 0, 0, 0, 0, 0, 16777215, 0, 0, 0, 0, 0, 0, 16777215, 0, 0, 0, 0, 0, 0);
END;
if (dobatch($query) == 1) { echo "La table Levels a été complétée.<br />"; } else { echo "Erreur lorsque la table Levels a été complétée."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$monsters` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `maxhp` smallint(5) unsigned NOT NULL default '0',
  `maxdam` smallint(5) unsigned NOT NULL default '0',
  `armor` smallint(5) unsigned NOT NULL default '0',
  `level` smallint(5) unsigned NOT NULL default '0',
  `maxexp` smallint(5) unsigned NOT NULL default '0',
  `maxgold` smallint(5) unsigned NOT NULL default '0',
  `immune` tinyint(3) unsigned NOT NULL default '0',
  `image` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Monsters a été crée.<br />"; } else { echo "Erreur de création de la table Monsters."; }
unset($query);

if ($full == true) {
$query = <<<END
INSERT INTO `$monsters` VALUES (1, 'Blue Slime', 4, 3, 1, 1, 1, 1, 0, 1);
INSERT INTO `$monsters` VALUES (2, 'Red Slime', 6, 5, 1, 1, 2, 1, 0, 2);
INSERT INTO `$monsters` VALUES (3, 'Critter', 6, 5, 2, 1, 4, 2, 0, 3);
INSERT INTO `$monsters` VALUES (4, 'Creature', 10, 8, 2, 2, 4, 2, 0, 4);
INSERT INTO `$monsters` VALUES (5, 'Shadow', 10, 9, 3, 2, 6, 2, 1, 5);
INSERT INTO `$monsters` VALUES (6, 'Drake', 11, 10, 3, 2, 8, 3, 0, 6);
INSERT INTO `$monsters` VALUES (7, 'Shade', 12, 10, 3, 3, 10, 3, 1, 7);
INSERT INTO `$monsters` VALUES (8, 'Drakelor', 14, 12, 4, 3, 10, 3, 0, 8);
INSERT INTO `$monsters` VALUES (9, 'Silver Slime', 15, 100, 200, 30, 15, 1000, 2, 9);
INSERT INTO `$monsters` VALUES (10, 'Scamp', 16, 13, 5, 4, 15, 5, 0, 10);
INSERT INTO `$monsters` VALUES (11, 'Raven', 16, 13, 5, 4, 18, 6, 0, 11);
INSERT INTO `$monsters` VALUES (12, 'Scorpion', 18, 14, 6, 5, 20, 7, 0, 12);
INSERT INTO `$monsters` VALUES (13, 'Illusion', 20, 15, 6, 5, 20, 7, 1, 13);
INSERT INTO `$monsters` VALUES (14, 'Nightshade', 22, 16, 6, 6, 24, 8, 0, 14);
INSERT INTO `$monsters` VALUES (15, 'Drakemal', 22, 18, 7, 6, 24, 8, 0, 15);
INSERT INTO `$monsters` VALUES (16, 'Shadow Raven', 24, 18, 7, 6, 26, 9, 1, 16);
INSERT INTO `$monsters` VALUES (17, 'Ghost', 24, 20, 8, 6, 28, 9, 0, 17);
INSERT INTO `$monsters` VALUES (18, 'Frost Raven', 26, 20, 8, 7, 30, 10, 0, 18);
INSERT INTO `$monsters` VALUES (19, 'Rogue Scorpion', 28, 22, 9, 7, 32, 11, 0, 19);
INSERT INTO `$monsters` VALUES (20, 'Ghoul', 29, 24, 9, 7, 34, 11, 0, 20);
INSERT INTO `$monsters` VALUES (21, 'Magician', 30, 24, 10, 8, 36, 12, 0, 21);
INSERT INTO `$monsters` VALUES (22, 'Rogue', 30, 25, 12, 8, 40, 13, 0, 22);
INSERT INTO `$monsters` VALUES (23, 'Drakefin', 32, 26, 12, 8, 40, 13, 0, 23);
INSERT INTO `$monsters` VALUES (24, 'Shimmer', 32, 26, 14, 8, 45, 15, 1, 24);
INSERT INTO `$monsters` VALUES (25, 'Fire Raven', 34, 28, 14, 9, 45, 15, 0, 25);
INSERT INTO `$monsters` VALUES (26, 'Dybbuk', 34, 28, 14, 9, 50, 17, 0, 26);
INSERT INTO `$monsters` VALUES (27, 'Knave', 36, 30, 15, 9, 52, 17, 0, 27);
INSERT INTO `$monsters` VALUES (28, 'Goblin', 36, 30, 15, 10, 54, 18, 0, 28);
INSERT INTO `$monsters` VALUES (29, 'Skeleton', 38, 30, 18, 10, 58, 19, 0, 29);
INSERT INTO `$monsters` VALUES (30, 'Dark Slime', 38, 32, 18, 10, 62, 21, 0, 30);
INSERT INTO `$monsters` VALUES (31, 'Silver Scorpion', 30, 160, 350, 40, 63, 2000, 2, 31);
INSERT INTO `$monsters` VALUES (32, 'Mirage', 40, 32, 20, 11, 64, 21, 1, 32);
INSERT INTO `$monsters` VALUES (33, 'Sorceror', 41, 33, 22, 11, 68, 23, 0, 33);
INSERT INTO `$monsters` VALUES (34, 'Imp', 42, 34, 22, 12, 70, 23, 0, 34);
INSERT INTO `$monsters` VALUES (35, 'Nymph', 43, 35, 22, 12, 70, 23, 0, 35);
INSERT INTO `$monsters` VALUES (36, 'Scoundrel', 43, 35, 22, 12, 75, 25, 0, 36);
INSERT INTO `$monsters` VALUES (37, 'Megaskeleton', 44, 36, 24, 13, 78, 26, 0, 37);
INSERT INTO `$monsters` VALUES (38, 'Grey Wolf', 44, 36, 24, 13, 82, 27, 0, 38);
INSERT INTO `$monsters` VALUES (39, 'Phantom', 46, 38, 24, 14, 85, 28, 1, 39);
INSERT INTO `$monsters` VALUES (40, 'Specter', 46, 38, 24, 14, 90, 30, 0, 40);
INSERT INTO `$monsters` VALUES (41, 'Dark Scorpion', 48, 40, 26, 15, 95, 32, 1, 41);
INSERT INTO `$monsters` VALUES (42, 'Warlock', 48, 40, 26, 15, 100, 33, 1, 42);
INSERT INTO `$monsters` VALUES (43, 'Orc', 49, 42, 28, 15, 104, 35, 0, 43);
INSERT INTO `$monsters` VALUES (44, 'Sylph', 49, 42, 28, 15, 106, 35, 0, 44);
INSERT INTO `$monsters` VALUES (45, 'Wraith', 50, 45, 30, 16, 108, 36, 0, 45);
INSERT INTO `$monsters` VALUES (46, 'Hellion', 50, 45, 30, 16, 110, 37, 0, 46);
INSERT INTO `$monsters` VALUES (47, 'Bandit', 52, 45, 30, 16, 114, 38, 0, 47);
INSERT INTO `$monsters` VALUES (48, 'Ultraskeleton', 52, 46, 32, 16, 116, 39, 0, 48);
INSERT INTO `$monsters` VALUES (49, 'Dark Wolf', 54, 47, 36, 17, 120, 40, 1, 49);
INSERT INTO `$monsters` VALUES (50, 'Troll', 56, 48, 36, 17, 120, 40, 0, 50);
INSERT INTO `$monsters` VALUES (51, 'Werewolf', 56, 48, 38, 17, 124, 41, 0, 51);
INSERT INTO `$monsters` VALUES (52, 'Hellcat', 58, 50, 38, 18, 128, 43, 0, 52);
INSERT INTO `$monsters` VALUES (53, 'Spirit', 58, 50, 38, 18, 132, 44, 0, 53);
INSERT INTO `$monsters` VALUES (54, 'Nisse', 60, 52, 40, 19, 132, 44, 0, 54);
INSERT INTO `$monsters` VALUES (55, 'Dawk', 60, 54, 40, 19, 136, 45, 0, 55);
INSERT INTO `$monsters` VALUES (56, 'Figment', 64, 55, 42, 19, 140, 47, 1, 56);
INSERT INTO `$monsters` VALUES (57, 'Hellhound', 66, 56, 44, 20, 140, 47, 0, 57);
INSERT INTO `$monsters` VALUES (58, 'Wizard', 66, 56, 44, 20, 144, 48, 0, 58);
INSERT INTO `$monsters` VALUES (59, 'Uruk', 68, 58, 44, 20, 146, 49, 0, 59);
INSERT INTO `$monsters` VALUES (60, 'Siren', 68, 400, 800, 50, 10000, 50, 2, 60);
INSERT INTO `$monsters` VALUES (61, 'Megawraith', 70, 60, 46, 21, 155, 52, 0, 61);
INSERT INTO `$monsters` VALUES (62, 'Dawkin', 70, 60, 46, 21, 155, 52, 0, 62);
INSERT INTO `$monsters` VALUES (63, 'Grey Bear', 70, 62, 48, 21, 160, 53, 0, 63);
INSERT INTO `$monsters` VALUES (64, 'Haunt', 72, 62, 48, 22, 160, 53, 0, 64);
INSERT INTO `$monsters` VALUES (65, 'Hellbeast', 74, 64, 50, 22, 165, 55, 0, 65);
INSERT INTO `$monsters` VALUES (66, 'Fear', 76, 66, 52, 23, 165, 55, 0, 66);
INSERT INTO `$monsters` VALUES (67, 'Beast', 76, 66, 52, 23, 170, 57, 0, 67);
INSERT INTO `$monsters` VALUES (68, 'Ogre', 78, 68, 54, 23, 170, 57, 0, 68);
INSERT INTO `$monsters` VALUES (69, 'Dark Bear', 80, 70, 56, 24, 175, 58, 1, 69);
INSERT INTO `$monsters` VALUES (70, 'Fire', 80, 72, 56, 24, 175, 58, 0, 70);
INSERT INTO `$monsters` VALUES (71, 'Polgergeist', 84, 74, 58, 25, 180, 60, 0, 71);
INSERT INTO `$monsters` VALUES (72, 'Fright', 86, 76, 58, 25, 180, 60, 0, 72);
INSERT INTO `$monsters` VALUES (73, 'Lycan', 88, 78, 60, 25, 185, 62, 0, 73);
INSERT INTO `$monsters` VALUES (74, 'Terra Elemental', 88, 80, 62, 25, 185, 62, 1, 74);
INSERT INTO `$monsters` VALUES (75, 'Necromancer', 90, 80, 62, 26, 190, 63, 0, 75);
INSERT INTO `$monsters` VALUES (76, 'Ultrawraith', 90, 82, 64, 26, 190, 63, 0, 76);
INSERT INTO `$monsters` VALUES (77, 'Dawkor', 92, 82, 64, 26, 195, 65, 0, 77);
INSERT INTO `$monsters` VALUES (78, 'Werebear', 92, 84, 65, 26, 195, 65, 0, 78);
INSERT INTO `$monsters` VALUES (79, 'Brute', 94, 84, 65, 27, 200, 67, 0, 79);
INSERT INTO `$monsters` VALUES (80, 'Large Beast', 96, 88, 66, 27, 200, 67, 0, 80);
INSERT INTO `$monsters` VALUES (81, 'Horror', 96, 88, 68, 27, 210, 70, 0, 81);
INSERT INTO `$monsters` VALUES (82, 'Flame', 100, 90, 70, 28, 210, 70, 0, 82);
INSERT INTO `$monsters` VALUES (83, 'Lycanthor', 100, 90, 70, 28, 210, 70, 0, 83);
INSERT INTO `$monsters` VALUES (84, 'Wyrm', 100, 92, 72, 28, 220, 73, 0, 84);
INSERT INTO `$monsters` VALUES (85, 'Aero Elemental', 104, 94, 74, 29, 220, 73, 1, 85);
INSERT INTO `$monsters` VALUES (86, 'Dawkare', 106, 96, 76, 29, 220, 73, 0, 86);
INSERT INTO `$monsters` VALUES (87, 'Large Brute', 108, 98, 78, 29, 230, 77, 0, 87);
INSERT INTO `$monsters` VALUES (88, 'Frost Wyrm', 110, 100, 80, 30, 230, 77, 0, 88);
INSERT INTO `$monsters` VALUES (89, 'Knight', 110, 102, 80, 30, 240, 80, 0, 89);
INSERT INTO `$monsters` VALUES (90, 'Lycanthra', 112, 104, 82, 30, 240, 80, 0, 90);
INSERT INTO `$monsters` VALUES (91, 'Terror', 115, 108, 84, 31, 250, 83, 0, 91);
INSERT INTO `$monsters` VALUES (92, 'Blaze', 118, 108, 84, 31, 250, 83, 0, 92);
INSERT INTO `$monsters` VALUES (93, 'Aqua Elemental', 120, 110, 90, 31, 260, 87, 1, 93);
INSERT INTO `$monsters` VALUES (94, 'Fire Wyrm', 120, 110, 90, 32, 260, 87, 0, 94);
INSERT INTO `$monsters` VALUES (95, 'Lesser Wyvern', 122, 110, 92, 32, 270, 90, 0, 95);
INSERT INTO `$monsters` VALUES (96, 'Doomer', 124, 112, 92, 32, 270, 90, 0, 96);
INSERT INTO `$monsters` VALUES (97, 'Armor Knight', 130, 115, 95, 33, 280, 93, 0, 97);
INSERT INTO `$monsters` VALUES (98, 'Wyvern', 134, 120, 95, 33, 290, 97, 0, 98);
INSERT INTO `$monsters` VALUES (99, 'Nightmare', 138, 125, 100, 33, 300, 100, 0, 99);
INSERT INTO `$monsters` VALUES (100, 'Fira Elemental', 140, 125, 100, 34, 310, 103, 1, 100);
INSERT INTO `$monsters` VALUES (101, 'Megadoomer', 140, 128, 105, 34, 320, 107, 0, 101);
INSERT INTO `$monsters` VALUES (102, 'Greater Wyvern', 145, 130, 105, 34, 335, 112, 0, 102);
INSERT INTO `$monsters` VALUES (103, 'Advocate', 148, 132, 108, 35, 350, 117, 0, 103);
INSERT INTO `$monsters` VALUES (104, 'Strong Knight', 150, 135, 110, 35, 365, 122, 0, 104);
INSERT INTO `$monsters` VALUES (105, 'Liche', 150, 135, 110, 35, 380, 127, 0, 105);
INSERT INTO `$monsters` VALUES (106, 'Ultradoomer', 155, 140, 115, 36, 395, 132, 0, 106);
INSERT INTO `$monsters` VALUES (107, 'Fanatic', 160, 140, 115, 36, 410, 137, 0, 107);
INSERT INTO `$monsters` VALUES (108, 'Green Dragon', 160, 140, 115, 36, 425, 142, 0, 108);
INSERT INTO `$monsters` VALUES (109, 'Fiend', 160, 145, 120, 37, 445, 148, 0, 109);
INSERT INTO `$monsters` VALUES (110, 'Greatest Wyvern', 162, 150, 120, 37, 465, 155, 0, 110);
INSERT INTO `$monsters` VALUES (111, 'Lesser Devil', 164, 150, 120, 37, 485, 162, 0, 111);
INSERT INTO `$monsters` VALUES (112, 'Liche Master', 168, 155, 125, 38, 505, 168, 0, 112);
INSERT INTO `$monsters` VALUES (113, 'Zealot', 168, 155, 125, 38, 530, 177, 0, 113);
INSERT INTO `$monsters` VALUES (114, 'Serafiend', 170, 155, 125, 38, 555, 185, 0, 114);
INSERT INTO `$monsters` VALUES (115, 'Pale Knight', 175, 160, 130, 39, 580, 193, 0, 115);
INSERT INTO `$monsters` VALUES (116, 'Blue Dragon', 180, 160, 130, 39, 605, 202, 0, 116);
INSERT INTO `$monsters` VALUES (117, 'Obsessive', 180, 160, 135, 40, 630, 210, 0, 117);
INSERT INTO `$monsters` VALUES (118, 'Devil', 184, 164, 135, 40, 666, 222, 0, 118);
INSERT INTO `$monsters` VALUES (119, 'Liche Prince', 190, 168, 138, 40, 660, 220, 0, 119);
INSERT INTO `$monsters` VALUES (120, 'Cherufiend', 195, 170, 140, 41, 690, 230, 0, 120);
INSERT INTO `$monsters` VALUES (121, 'Red Dragon', 200, 180, 145, 41, 720, 240, 0, 121);
INSERT INTO `$monsters` VALUES (122, 'Greater Devil', 200, 180, 145, 41, 750, 250, 0, 122);
INSERT INTO `$monsters` VALUES (123, 'Renegade', 205, 185, 150, 42, 780, 260, 0, 123);
INSERT INTO `$monsters` VALUES (124, 'Archfiend', 210, 190, 150, 42, 810, 270, 0, 124);
INSERT INTO `$monsters` VALUES (125, 'Liche Lord', 210, 190, 155, 42, 850, 283, 0, 125);
INSERT INTO `$monsters` VALUES (126, 'Greatest Devil', 215, 195, 160, 43, 890, 297, 0, 126);
INSERT INTO `$monsters` VALUES (127, 'Dark Knight', 220, 200, 160, 43, 930, 310, 0, 127);
INSERT INTO `$monsters` VALUES (128, 'Giant', 220, 200, 165, 43, 970, 323, 0, 128);
INSERT INTO `$monsters` VALUES (129, 'Shadow Dragon', 225, 200, 170, 44, 1010, 337, 0, 129);
INSERT INTO `$monsters` VALUES (130, 'Liche King', 225, 205, 170, 44, 1050, 350, 0, 130);
INSERT INTO `$monsters` VALUES (131, 'Incubus', 230, 205, 175, 44, 1100, 367, 1, 131);
INSERT INTO `$monsters` VALUES (132, 'Traitor', 230, 205, 175, 45, 1150, 383, 0, 132);
INSERT INTO `$monsters` VALUES (133, 'Demon', 240, 210, 180, 45, 1200, 400, 0, 133);
INSERT INTO `$monsters` VALUES (134, 'Dark Dragon', 245, 215, 180, 45, 1250, 417, 1, 134);
INSERT INTO `$monsters` VALUES (135, 'Insurgent', 250, 220, 190, 46, 1300, 433, 0, 135);
INSERT INTO `$monsters` VALUES (136, 'Leviathan', 255, 225, 190, 46, 1350, 450, 0, 136);
INSERT INTO `$monsters` VALUES (137, 'Grey Daemon', 260, 230, 190, 46, 1400, 467, 0, 137);
INSERT INTO `$monsters` VALUES (138, 'Succubus', 265, 240, 200, 47, 1460, 487, 1, 138);
INSERT INTO `$monsters` VALUES (139, 'Demon Prince', 270, 240, 200, 47, 1520, 507, 0, 139);
INSERT INTO `$monsters` VALUES (140, 'Black Dragon', 275, 250, 205, 47, 1580, 527, 1, 140);
INSERT INTO `$monsters` VALUES (141, 'Nihilist', 280, 250, 205, 47, 1640, 547, 0, 141);
INSERT INTO `$monsters` VALUES (142, 'Behemoth', 285, 260, 210, 48, 1700, 567, 0, 142);
INSERT INTO `$monsters` VALUES (143, 'Demagogue', 290, 260, 210, 48, 1760, 587, 0, 143);
INSERT INTO `$monsters` VALUES (144, 'Demon Lord', 300, 270, 220, 48, 1820, 607, 0, 144);
INSERT INTO `$monsters` VALUES (145, 'Red Daemon', 310, 280, 230, 48, 1880, 627, 0, 145);
INSERT INTO `$monsters` VALUES (146, 'Colossus', 320, 300, 240, 49, 1940, 647, 0, 146);
INSERT INTO `$monsters` VALUES (147, 'Demon King', 330, 300, 250, 49, 2000, 667, 0, 147);
INSERT INTO `$monsters` VALUES (148, 'Dark Daemon', 340, 320, 260, 49, 2200, 733, 1, 148);
INSERT INTO `$monsters` VALUES (149, 'Titan', 360, 340, 270, 50, 2400, 800, 0, 149);
INSERT INTO `$monsters` VALUES (150, 'Black Daemon', 400, 400, 280, 50, 3000, 1000, 1, 150);
INSERT INTO `$monsters` VALUES (151, 'Lucifuge', 600, 600, 400, 50, 10000, 10000, 2, 151);
END;
if (dobatch($query) == 1) { echo "La table Monsters a été complétée.<br />"; } else { echo "Erreur lorsque la table Monsters a été complétée."; }
unset($query);
}


$query = <<<END
CREATE TABLE `$news` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `postdate` datetime NOT NULL default '00-00-0000 00:00:00',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table News a été crée.<br />"; } else { echo "Erreur de création de la table News."; }
unset($query);

$query = <<<END
INSERT INTO `$news` VALUES (1, '2005-01-01 12:00:00', 'Ceci est la dernière nouvelle . Veuillez employer le menu d\'administration pour additionner une autre et faire disparaitre celle-ci.');
END;
if (dobatch($query) == 1) { echo "La table News a été complétée.<br />"; } else { echo "Erreur lorsque la table News a été complétée."; }
unset($query);

$query = <<<END
CREATE TABLE `$newsaccueil`(
`id` int(6) NOT NULL auto_increment, 
`postdate` datetime NOT NULL default '00-00-0000 00:00:00',
`titre` text NOT NULL,
`content` text NOT NULL, 
 PRIMARY KEY(id)
);  
END;
 if (dobatch($query) == 1) { echo "La table newsaccueil a été crée.<br />"; } else { echo "Erreur de création de la table newsaccueil"; }
unset($query); 

$query = <<<END
INSERT INTO `$newsaccueil` VALUES (1, '2005-11-11 12:00:00', 'Bienvenue sur RPG illusion !','Bienvenue sur RPG illusion v1.2 . Vous pouvez également la télécharger pour votre site à cette adresse : http//www.rpgillusion.net');
END;
if (dobatch($query) == 1) { echo "La table Newsaccueil a été complétée.<br />"; } else { echo "Erreur lorsque la table Newsaccueil a été complétée."; }
unset($query);  

$query = <<<END
CREATE TABLE `$resultats`(
`numero` int(6) NOT NULL default '0',
`reponse` varchar(200) NOT NULL default ''
);
END;
 
 if (dobatch($query) == 1) { echo "La table resultats a été crée.<br />"; } else { echo "Erreur de création de la table resultats"; }
unset($query);  
 
$query = <<<END
CREATE TABLE `$sondage`(
`id` int(6) NOT NULL auto_increment, 
`question` VARCHAR(200) NOT NULL default '',
`reponse1` VARCHAR(200) NOT NULL default '', 
`reponse2` VARCHAR(200) NOT NULL default '',
`reponse3` VARCHAR(200) NOT NULL default '',
`reponse4` VARCHAR(200) NOT NULL default '',
 PRIMARY KEY(id)
); 
END;
 
 if (dobatch($query) == 1) { echo "La table sondage a été crée.<br />"; } else { echo "Erreur de création de la table sondage"; }
unset($query); 

$query = <<<END
INSERT INTO `$sondage` VALUES (1, 'Comment vous trouvez le jeu?', 'Génial','Moyen','Bof','Nul');
END;
if (dobatch($query) == 1) { echo "La table Sondage a été complétée.<br />"; } else { echo "Erreur lorsque la table Sondage a été complétée."; }
unset($query);    


$query = <<<END
CREATE TABLE `$sondage_ip`(
`numero` VARCHAR(10) NOT NULL default '',
`ip` VARCHAR(100) NOT NULL default ''
); 
END;

 if (dobatch($query) == 1) { echo "La table sondage_ip a été crée.<br />"; } else { echo "Erreur de création de la table sondage_ip"; }
unset($query);   

$query = <<<END
CREATE TABLE `$spells` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `mp` smallint(5) unsigned NOT NULL default '0',
  `attribute` smallint(5) unsigned NOT NULL default '0',
  `type` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Spells a été crée.<br />"; } else { echo "Erreur de création de la table Spells."; }
unset($query);

if ($full == true) {
$query = <<<END
INSERT INTO `$spells` VALUES (1, 'Heal', 5, 10, 1);
INSERT INTO `$spells` VALUES (2, 'Revive', 10, 25, 1);
INSERT INTO `$spells` VALUES (3, 'Life', 25, 50, 1);
INSERT INTO `$spells` VALUES (4, 'Breath', 50, 100, 1);
INSERT INTO `$spells` VALUES (5, 'Gaia', 75, 150, 1);
INSERT INTO `$spells` VALUES (6, 'Hurt', 5, 15, 2);
INSERT INTO `$spells` VALUES (7, 'Pain', 12, 35, 2);
INSERT INTO `$spells` VALUES (8, 'Maim', 25, 70, 2);
INSERT INTO `$spells` VALUES (9, 'Rend', 40, 100, 2);
INSERT INTO `$spells` VALUES (10, 'Chaos', 50, 130, 2);
INSERT INTO `$spells` VALUES (11, 'Sleep', 10, 5, 3);
INSERT INTO `$spells` VALUES (12, 'Dream', 30, 9, 3);
INSERT INTO `$spells` VALUES (13, 'Nightmare', 60, 13, 3);
INSERT INTO `$spells` VALUES (14, 'Craze', 10, 10, 4);
INSERT INTO `$spells` VALUES (15, 'Rage', 20, 25, 4);
INSERT INTO `$spells` VALUES (16, 'Fury', 30, 50, 4);
INSERT INTO `$spells` VALUES (17, 'Ward', 10, 10, 5);
INSERT INTO `$spells` VALUES (18, 'Fend', 20, 25, 5);
INSERT INTO `$spells` VALUES (19, 'Barrier', 30, 50, 5);
END;
if (dobatch($query) == 1) { echo "La table Spells a été complétée.<br />"; } else { echo "Erreur lorsque la table Spells a été complétée."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$towns` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `codebanque` text NOT NULL default '',
  `codeniveau` text NOT NULL default '',
  `interets` smallint(200) NOT NULL default '0',
  `chiffrebanque` smallint(200) NOT NULL default '0',
  `chiffreniveau` smallint(200) NOT NULL default '0',
  `latitude` smallint(6) NOT NULL default '0',
  `longitude` smallint(6) NOT NULL default '0',
  `innprice` tinyint(4) NOT NULL default '0',
  `mapprice` smallint(6) NOT NULL default '0',
  `homeprice` smallint(6) NOT NULL default '0',
  `travelpoints` smallint(5) unsigned NOT NULL default '0',
  `itemslist` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Towns a été crée.<br />"; } else { echo "Erreur de création de la table Towns."; }
unset($query);

if ($full == true) {
$query = <<<END
INSERT INTO `$towns` VALUES (1, 'Midworld','Service non disponible','Service non disponible',0.03, 5000, 5, 0, 0, 5, 0, 1000, 0, '1,2,3,17,18,19,28,29');
INSERT INTO `$towns` VALUES (2, 'Roma','Service non disponible','Service non disponible',0.03,5000,5, 30, 30, 10, 25, 800, 5, '2,3,4,18,19,29');
INSERT INTO `$towns` VALUES (3, 'Bris','Service non disponible','Service non disponible',0.03,5000,5, 70, -70, 25, 50, 700, 15, '2,3,4,5,18,19,20,29.30');
INSERT INTO `$towns` VALUES (4, 'Kalle','Service non disponible','Service non disponible',0.03,5000,5, -100, 100, 40, 100, 900, 30, '5,6,8,10,12,21,22,23,29,30');
INSERT INTO `$towns` VALUES (5, 'Narcissa','Service non disponible','Service non disponible',0.03,5000,5, -130, -130, 60, 500, 600, 50, '4,7,9,11,13,21,22,23,29,30,31');
INSERT INTO `$towns` VALUES (6, 'Hambry','Service non disponible','Service non disponible',0.03,5000,5, 170, 170, 90, 1000, 500, 80, '10,11,12,13,14,23,24,30,31');
INSERT INTO `$towns` VALUES (7, 'Gilead','Service non disponible','Service non disponible',0.03,5000,5, 200, -200, 100, 3000, 500, 110, '12,13,14,15,24,25,26,32');
INSERT INTO `$towns` VALUES (8, 'Endworld','Service non disponible','Service non disponible',0.03,5000,5, -250, -250, 125, 9000, 300, 160, '16,27,33');

END;
if (dobatch($query) == 1) { echo "La table Towns a été complétée.<br />"; } else { echo "Erreur lorsque la table Towns a été complétée."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$maison` (
  `id` int(6) NOT NULL auto_increment,
  `name` VARCHAR(200) NOT NULL default '',
  `latitude` smallint(6) NOT NULL default '0',
  `longitude` smallint(6) NOT NULL default '0',
  `buvette` tinyint(3) NOT NULL default '1',
  `innprice` tinyint(4) NOT NULL default '0',
  `training` tinyint(4) NOT NULL default '0',
  `msg` VARCHAR(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Maison a été crée.<br />"; } else { echo "Erreur de création de la table Maison."; }
unset($query);

$query = <<<END
CREATE TABLE `$sol` (
  `id` int(6) NOT NULL auto_increment,
  `lati` int(5) NOT NULL default '0',
  `longi` int(5) NOT NULL default '0',
  `passable` tinyint(1) NOT NULL default '1',
  `peage` tinyint(1) NOT NULL default '0',
  `type` varchar(25) NOT NULL default '',
  `prix` tinyint(4) NOT NULL default '0',
  `nom` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=697 ;
END;
if (dobatch($query) == 1) { echo "La table Sol a été crée.<br />"; } else { echo "Erreur de création de la table Sol."; }
unset($query);
      
if ($full == true) {
$query = <<<END
INSERT INTO `$sol` VALUES (81, 6, 5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (68, 2, -2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (67, -2, -2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (66, -2, 2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (65, 2, 2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (273, 8, 0, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (63, -1, -4, 1, 0, '', 0, 'peage1');
INSERT INTO `$sol` VALUES (61, -2, -3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (60, -1, -3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (59, 1, -3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (58, 2, -3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (57, 2, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (56, 1, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (55, -1, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (54, -2, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (53, 3, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (52, 3, 2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (51, 3, 1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (50, 3, -1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (49, 3, -2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (48, 3, -3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (47, -3, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (46, -3, 2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (45, -3, 1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (44, -3, -1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (43, -3, -3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (42, -3, -2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (80, 7, 5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (77, 10, 5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (79, 8, 5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (78, 9, 5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (82, 5, 5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (83, 4, 4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (84, 10, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (85, 9, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (86, 9, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (87, 8, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (88, 7, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (89, 6, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (90, 5, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (91, 10, 7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (92, 9, 7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (93, 8, 7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (94, 7, 7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (95, 6, 7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (96, 5, 7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (97, 5, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (98, 5, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (99, 5, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (100, 6, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (101, 6, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (102, 6, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (103, 7, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (104, 7, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (105, 7, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (106, 8, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (107, 8, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (108, 8, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (109, 9, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (110, 9, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (111, 9, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (112, 10, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (113, 10, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (114, 10, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (115, 10, 11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (116, 9, 11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (117, 8, 11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (118, 9, 12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (119, 10, 12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (120, 2, 19, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (121, 2, 18, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (122, 2, 17, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (123, 2, 16, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (124, 2, 15, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (125, 3, 15, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (126, 4, 17, 1, 0, '', 0, 'maison1');
INSERT INTO `$sol` VALUES (127, 4, 15, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (128, 5, 15, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (129, 6, 15, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (130, 6, 16, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (131, 6, 17, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (132, 3, 19, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (133, 4, 19, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (134, 5, 19, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (135, 6, 19, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (136, 6, 18, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (137, 11, 11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (138, 11, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (139, 12, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (140, 12, 11, 1, 0, '', 0, 'maison1');
INSERT INTO `$sol` VALUES (141, 14, 14, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (142, 12, 17, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (143, 12, 14, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (144, 17, 17, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (145, 18, 12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (146, 14, 20, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (147, 15, 17, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (148, 20, 17, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (149, 12, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (150, 12, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (151, 11, 7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (152, 11, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (153, 11, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (154, 13, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (155, 16, 4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (156, 18, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (157, 14, 1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (158, 20, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (159, 16, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (160, 14, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (161, 12, 6, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (162, 11, 2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (163, 13, 4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (164, 18, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (165, 20, 4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (166, 19, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (167, 20, 0, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (168, 8, 1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (169, 4, 2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (170, 5, 2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (171, 4, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (172, 5, 4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (173, 2, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (174, 20, 1, 1, 0, '', 0, 'maison1');
INSERT INTO `$sol` VALUES (175, 0, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (176, 3, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (177, 7, 3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (178, 0, 17, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (179, 8, 18, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (180, 1, 13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (181, 9, 15, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (274, 9, 0, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (183, 4, 13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (184, 10, 20, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (185, 1, 20, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (186, 7, 21, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (187, 9, 23, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (188, 6, 26, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (189, 5, 26, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (190, 7, 28, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (191, 4, 26, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (192, 6, 25, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (193, 5, 25, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (194, 4, 25, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (195, 6, 24, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (196, 5, 24, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (197, 4, 24, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (198, 5, 23, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (199, 4, 23, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (200, 4, 22, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (201, 3, 22, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (202, 2, 23, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (203, 1, 24, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (204, 1, 25, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (205, 2, 25, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (206, 3, 23, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (207, 3, 24, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (208, 2, 24, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (209, 3, 25, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (210, 1, 26, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (211, 2, 26, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (212, 3, 26, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (213, 2, 22, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (214, 1, 22, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (215, 1, 23, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (216, 5, 22, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (217, 6, 22, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (218, 6, 23, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (219, 1, 27, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (220, 2, 27, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (221, 3, 27, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (222, 4, 27, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (223, 5, 27, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (224, 6, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (225, 7, 25, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (226, 9, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (227, 0, 30, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (228, 3, 29, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (229, 0, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (230, 0, 22, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (231, 3, 21, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (232, 5, 28, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (233, 5, 29, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (234, 4, 28, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (235, 4, 29, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (236, 5, 30, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (237, 2, 28, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (238, 2, 29, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (239, 4, 30, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (240, 3, 30, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (241, 2, 30, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (242, 1, 28, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (243, 1, 29, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (244, 1, 30, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (245, 6, 31, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (246, 6, 32, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (247, 5, 32, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (248, 5, 31, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (249, 4, 32, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (250, 3, 32, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (251, 4, 31, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (252, 3, 31, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (253, 6, 33, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (254, 6, 34, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (255, 5, 34, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (256, 7, 33, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (257, 7, 34, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (258, 7, 35, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (259, 6, 35, 1, 0, '', 0, 'mer');
INSERT INTO `$sol` VALUES (260, 12, 5, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (265, 10, 0, 1, 0, '', 0, 'pierre');
INSERT INTO `$sol` VALUES (696, 3, 0, 1, 0, '', 0, 'peage1');
INSERT INTO `$sol` VALUES (271, 7, 1, 1, 0, '', 0, 'rocher2');
INSERT INTO `$sol` VALUES (289, 30, 10, 1, 0, '', 0, 'arbres');
INSERT INTO `$sol` VALUES (279, 10, 1, 1, 0, '', 0, 'pierre');
INSERT INTO `$sol` VALUES (277, 9, 1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (287, 2, 4, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (288, 6, 2, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (290, 30, 11, 1, 0, '', 0, 'arbres');
INSERT INTO `$sol` VALUES (291, 30, 12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (292, 29, 11, 1, 0, '', 0, 'rocher');
INSERT INTO `$sol` VALUES (293, 29, 10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (294, 28, 12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (295, 30, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (296, 29, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (297, 26, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (298, 27, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (299, 28, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (300, 26, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (301, 26, 28, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (302, 27, 11, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (303, 26, 29, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (304, 25, 29, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (305, 27, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (306, 29, 24, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (307, 24, 22, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (308, 27, 23, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (309, 25, 24, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (310, 27, 12, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (311, 26, 21, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (312, 29, 22, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (313, 22, 24, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (314, 28, 13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (315, 24, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (316, 21, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (317, 24, 25, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (318, 27, 25, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (319, 25, 23, 1, 0, '', 0, 'rocher');
INSERT INTO `$sol` VALUES (320, 22, 30, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (321, 25, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (322, 28, 15, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (323, 28, 27, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (324, 29, 27, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (325, 30, 27, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (326, 30, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (327, 30, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (328, 29, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (329, 28, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (330, 27, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (331, 29, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (332, 28, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (333, 27, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (334, 26, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (335, 27, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (336, 28, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (338, 29, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (339, 31, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (340, 32, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (341, 33, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (342, 34, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (343, 35, 26, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (344, 35, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (345, 34, 27, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (346, 35, 29, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (347, 35, 28, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (348, 35, 31, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (349, 35, 32, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (350, 35, 33, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (351, 34, 33, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (352, 31, 27, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (353, 30, 14, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (354, 32, 27, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (355, 33, 27, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (356, 34, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (357, 33, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (358, 32, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (359, 31, 28, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (360, 35, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (361, 34, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (362, 34, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (363, 33, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (364, 33, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (365, 32, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (366, 31, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (367, 30, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (368, 31, 29, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (369, 27, 13, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (370, 32, 30, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (372, 27, 14, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (373, 34, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (374, 33, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (375, 32, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (376, 31, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (377, 29, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (378, 25, 31, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (379, 26, 31, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (380, 26, 32, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (381, 26, 12, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (382, 28, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (383, 27, 31, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (384, 27, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (385, 28, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (386, 29, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (387, 30, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (388, 31, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (389, 32, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (390, 33, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (391, 34, 32, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (396, 32, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (393, 35, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (394, 34, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (395, 33, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (397, 31, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (398, 30, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (399, 29, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (400, 28, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (401, 27, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (402, 26, 34, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (403, 26, 33, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (404, 27, 33, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (405, 28, 33, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (406, 29, 33, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (407, 30, 33, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (408, 31, 33, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (409, 32, 33, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (410, 33, 33, 1, 0, '', 0, 'pave');
INSERT INTO `$sol` VALUES (411, 26, 11, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (412, 28, 11, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (413, 33, 25, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (414, 32, 25, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (415, 28, 25, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (416, 29, 25, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (417, 30, 25, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (418, 31, 25, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (419, 33, 35, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (420, 28, 35, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (421, 29, 35, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (422, 30, 35, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (423, 31, 35, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (424, 32, 35, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (425, 26, 35, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (426, 34, 35, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (427, 25, 26, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (428, 25, 28, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (429, 26, 13, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (430, 26, 14, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (431, 28, 14, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (432, 28, 16, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (433, 27, 15, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (450, 5, -4, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (546, -3, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (436, 35, 25, 1, 0, '', 0, 'tron1');
INSERT INTO `$sol` VALUES (437, 26, 16, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (438, 25, 12, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (439, 25, 13, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (440, 25, 14, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (441, 25, 15, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (442, 25, 11, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (443, 25, 16, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (444, 24, 12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (445, 24, 13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (446, 24, 11, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (447, 24, 14, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (448, 24, 15, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (451, -4, -5, 1, 0, '', 0, 'rocher');
INSERT INTO `$sol` VALUES (452, 2, -5, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (453, 5, -2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (454, -5, -3, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (455, -2, -7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (456, -6, -7, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (457, -4, -9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (458, -2, -10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (459, -2, -11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (460, -3, -10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (461, -3, -11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (462, -3, -12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (463, -2, -12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (464, -2, -13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (465, -3, -13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (466, -4, -13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (467, -5, -13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (468, -5, -12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (469, -4, -12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (470, -4, -11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (471, -5, -11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (472, -4, -10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (473, -5, -10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (474, -6, -13, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (475, -6, -12, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (476, -6, -11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (477, -6, -10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (478, -2, -9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (479, -3, -9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (480, -5, -9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (481, -6, -9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (568, -15, -10, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (484, 0, -9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (485, -4, -15, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (486, 0, -14, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (487, -9, -12, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (488, -10, -8, 1, 0, '', 0, 'dino');
INSERT INTO `$sol` VALUES (489, -13, -11, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (490, -8, -15, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (491, -9, -14, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (492, -2, -15, 1, 0, '', 0, 'rocher2');
INSERT INTO `$sol` VALUES (493, -13, -14, 1, 0, '', 0, 'butte');
INSERT INTO `$sol` VALUES (494, -14, -14, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (495, -13, -8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (496, -11, -10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (497, -8, -10, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (498, -12, -4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (499, -9, -8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (500, 127, -50, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (501, 127, -50, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (502, 127, -50, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (503, 127, -55, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (504, 127, -50, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (505, 4, 5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (569, 13, 6, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (508, 127, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (509, 127, -53, 1, 0, '', 0, 'lave');
INSERT INTO `$sol` VALUES (510, 127, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (511, 127, -54, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (512, 127, -51, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (513, 169, -51, 1, 0, '', 0, 'terre');
INSERT INTO `$sol` VALUES (514, 183, -50, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (515, 183, -51, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (516, 183, -52, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (517, 183, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (518, 182, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (519, 181, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (520, 182, -55, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (521, 181, -55, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (522, 180, -55, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (523, 179, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (524, 179, -54, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (525, 179, -55, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (526, 178, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (527, 177, -53, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (528, 177, -52, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (529, 177, -51, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (530, 177, -50, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (531, 183, -49, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (532, 183, -48, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (533, 183, -47, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (534, 182, -47, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (535, 181, -47, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (536, 180, -47, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (537, 177, -47, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (538, 179, -47, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (539, 178, -47, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (540, 177, -48, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (541, 177, -49, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (542, 185, -51, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (543, 175, -54, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (544, 181, -45, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (545, 185, -54, 1, 0, '', 0, 'dino');
INSERT INTO `$sol` VALUES (547, 7, -2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (548, 8, -4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (549, 10, -2, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (550, 6, 0, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (551, -5, 1, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (552, 10, -5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (553, 6, -5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (554, -1, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (555, 0, -5, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (556, 1, 8, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (557, -4, 6, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (558, -5, 9, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (559, 0, -2, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (571, -39, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (561, -4, -4, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (562, 6, -2, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (563, -2, 5, 1, 0, '', 0, 'feuille_morte');
INSERT INTO `$sol` VALUES (564, -1, 8, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (565, -3, 10, 1, 0, '', 0, 'rocher');
INSERT INTO `$sol` VALUES (566, -5, 4, 0, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (567, -5, 7, 1, 0, '', 0, 'arbres');
INSERT INTO `$sol` VALUES (572, -37, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (573, -38, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (574, -36, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (575, -40, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (576, -40, 44, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (577, -40, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (578, -36, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (579, -35, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (580, -34, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (581, -35, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (582, -35, 42, 1, 0, '', 0, 'maison1');
INSERT INTO `$sol` VALUES (583, -36, 42, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (584, -36, 41, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (585, -36, 40, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (586, -35, 40, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (587, -34, 40, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (588, -38, 42, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (589, -38, 41, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (590, -40, 42, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (591, -40, 41, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (592, -38, 40, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (593, -40, 40, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (594, -38, 39, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (595, -37, 38, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (596, -40, 39, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (597, -33, 39, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (598, -39, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (599, -40, 38, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (600, -38, 36, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (601, -36, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (602, -36, 36, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (603, -36, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (604, -37, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (605, -39, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (606, -40, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (607, -40, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (608, -40, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (609, -38, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (610, -39, 32, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (612, -39, 33, 1, 0, '', 0, 'chien');
INSERT INTO `$sol` VALUES (613, -34, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (614, -34, 36, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (615, -33, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (616, -34, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (617, -32, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (618, -36, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (619, -34, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (620, -34, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (621, -36, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (622, -33, 32, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (623, -35, 31, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (624, -36, 32, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (627, -34, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (628, -33, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (629, -32, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (630, -31, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (631, -30, 31, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (632, -29, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (633, -29, 32, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (634, -32, 32, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (635, -31, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (636, -31, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (638, -32, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (639, -29, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (640, -30, 36, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (641, -29, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (642, -31, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (643, -32, 39, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (644, -31, 39, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (645, -30, 39, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (646, -29, 38, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (647, -28, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (648, -27, 36, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (649, -27, 32, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (650, -28, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (651, -27, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (652, -26, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (653, -25, 30, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (654, -25, 31, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (655, -25, 32, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (656, -25, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (657, -27, 33, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (658, -25, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (659, -27, 34, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (660, -27, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (661, -25, 37, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (662, -25, 35, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (663, -25, 36, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (664, -26, 38, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (665, -27, 39, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (666, -28, 40, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (667, -29, 41, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (668, -34, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (669, -34, 42, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (670, -33, 42, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (671, -32, 41, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (672, -31, 41, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (673, -31, 42, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (674, -30, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (676, -25, 40, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (677, -26, 41, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (678, -29, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (679, -27, 42, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (680, -26, 43, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (681, -25, 44, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (682, -26, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (684, -32, 36, 1, 0, '', 0, 'peage1');
INSERT INTO `$sol` VALUES (685, -32, 44, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (686, -31, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (687, -33, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (688, -30, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (689, -29, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (690, -26, 44, 1, 0, '', 0, 'fleur');
INSERT INTO `$sol` VALUES (691, -27, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (692, -28, 45, 1, 0, '', 0, 'arbre');
INSERT INTO `$sol` VALUES (693, -27, 44, 1, 0, '', 0, 'fleur1');
INSERT INTO `$sol` VALUES (694, -27, 43, 1, 0, '', 0, 'pierre');
INSERT INTO `$sol` VALUES (695, 0, -1, 1, 0, '', 0, 'arbre');
END;
if (dobatch($query) == 1) { echo "La table Towns a été complétée.<br />"; } else { echo "Erreur lorsque la table Towns a été complétée."; }
unset($query);
}
	  
$query = <<<END
CREATE TABLE `$users` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `verify` varchar(8) NOT NULL default '0',
  `charname` varchar(30) NOT NULL default '',
  `regdate` datetime NOT NULL default '00-00-0000 00:00:00',
  `onlinetime` datetime NOT NULL default '00-00-0000 00:00:00',
  `authlevel` tinyint(3) unsigned NOT NULL default '0',
  `latitude` smallint(6) NOT NULL default '0',
  `longitude` smallint(6) NOT NULL default '0',
  `difficulty` tinyint(3) unsigned NOT NULL default '0',
  `avatar` tinyint(4) unsigned NOT NULL default '0',
  `bank` smallint(255) unsigned NOT NULL default '0', 
  `miniavatar` tinyint(4) unsigned NOT NULL default '0',
  `charclass` tinyint(4) unsigned NOT NULL default '0',
  `currentaction` varchar(30) NOT NULL default 'En ville',
  `currentfight` tinyint(4) unsigned NOT NULL default '0',
  `currentmonster` smallint(6) unsigned NOT NULL default '0',
  `currentmonsterhp` smallint(6) unsigned NOT NULL default '0',
  `currentmonstersleep` tinyint(3) unsigned NOT NULL default '0',
  `currentmonsterimmune` tinyint(4) NOT NULL default '0',
  `currentuberdamage` tinyint(3) unsigned NOT NULL default '0',
  `currentuberdefense` tinyint(3) unsigned NOT NULL default '0',
  `currenthp` smallint(6) unsigned NOT NULL default '15',
  `currentmp` smallint(6) unsigned NOT NULL default '0',
  `currenttp` smallint(6) unsigned NOT NULL default '10',
  `maxhp` smallint(6) unsigned NOT NULL default '15',
  `maxmp` smallint(6) unsigned NOT NULL default '0',
  `maxtp` smallint(6) unsigned NOT NULL default '10',
  `level` smallint(5) unsigned NOT NULL default '1',
  `gold` mediumint(8) unsigned NOT NULL default '100',
  `experience` mediumint(8) unsigned NOT NULL default '0',
  `goldbonus` smallint(5) NOT NULL default '0',
  `expbonus` smallint(5) NOT NULL default '0',
  `strength` smallint(5) unsigned NOT NULL default '5',
  `dexterity` smallint(5) unsigned NOT NULL default '5',
  `attackpower` smallint(5) unsigned NOT NULL default '5',
  `defensepower` smallint(5) unsigned NOT NULL default '5',
  `weaponid` smallint(5) unsigned NOT NULL default '0',
  `armorid` smallint(5) unsigned NOT NULL default '0',
  `shieldid` smallint(5) unsigned NOT NULL default '0',
  `slot1id` smallint(5) unsigned NOT NULL default '0',
  `slot2id` smallint(5) unsigned NOT NULL default '0',
  `slot3id` smallint(5) unsigned NOT NULL default '0',
  `weaponname` varchar(30) NOT NULL default 'Aucun',
  `armorname` varchar(30) NOT NULL default 'Aucun',
  `shieldname` varchar(30) NOT NULL default 'Aucun',
  `slot1name` varchar(30) NOT NULL default 'Aucun',
  `slot2name` varchar(30) NOT NULL default 'Aucun',
  `slot3name` varchar(30) NOT NULL default 'Aucun',
  `dropcode` mediumint(8) unsigned NOT NULL default '0',
  `spells` varchar(50) NOT NULL default '0',
  `towns` varchar(50) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Users a été crée.<br />"; } else { echo "Erreur de création de la table Users."; }
unset($query);
    
$query = <<<END
CREATE TABLE `$map` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `longitude` smallint(6) NOT NULL default '0',
  `latitude` smallint(6) NOT NULL default '0',
  `decor` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { echo "La table Map a été crée.<br />"; } else { echo "Erreur de création de la table Map."; }
unset($query);

    global $start;
    $time = round((getmicrotime() - $start), 4);
    echo "<br />Tables Mysql crées en  $time secondes.<br /><br /><a href=\"install.php?page=3\">Cliquez ici pour poursuivre l'installation.</a></body></html>";
    die();
    
}

function third() { // Troisième page: Récupération des infos du futur admin.

$page = <<<END
<html>
<head>
<title>Installation de RPG illusion</title>
</head>
<body>
<font  face="verdana" size="3"><b>installation de RPG illusion: page 3</b></font><br /><br />
<font  face="verdana" size="2">Maintenant vous devez créer un compte d\'administrateur ainsi vous pourrez employer le menu d\'administration du jeu.  Complétez les champs ci-dessous pour créer votre compte.  Vous pourrez modifier vos infos par la suite dans le menu d'administration.<br /><br />
<form action="install.php?page=4" method="post">
<table width="50%">
<tr><td width="20%" style="vertical-align:top; font-family:Verdana; font-size:10pt;">ID:</td><td><input type="text" name="username" style="font-family:Verdana; font-size:10pt" size="30" maxlength="30" /><br><br></td></tr>
<tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">PW:</td><td><input type="password" name="password1" style="font-family:Verdana; font-size:10pt" size="30" maxlength="30" /></td></tr>
<tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">Retapez PW:</td><td><input type="password" name="password2" style="font-family:Verdana; font-size:10pt" size="30" maxlength="30" /><br><br></td></tr>
<tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">Votre Email:</td><td><input type="text" name="email1" style="font-family:Verdana; font-size:10pt" size="30" maxlength="100" /></td></tr>
<tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">Retapez Email:</td><td><input type="text" name="email2" style="font-family:Verdana; font-size:10pt" size="30" maxlength="100" /><br><br></td></tr>
<tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">Nom du perso:</td><td><input type="text" name="charname" style="font-family:Verdana; font-size:10pt" size="30" maxlength="30" /></td></tr>
<table><tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">Avatar du perso:</td><td><select name="avatar" ><option value="1">numéro 1</option><option value="2">numéro 2</option><option value="3">numéro 3</option><option value="4">numéro 4</option><option value="5">numéro 5</option><option value="6">numéro 6</option><option value="7">numéro 7</option><option value="8">numéro 8</option><option value="9">numéro 9</option><option value="10">numéro 10</option></select></td><td></td></tr><tr><td colspan="2" style="vertical-align:top; font-family:Verdana; font-size:10pt">Pour voir tous les avatars <A HREF="#" onClick="window.open('avatar.php','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=400, height=265');return(false)">cliquez ici.</A><br /></td></tr></table>
<table><tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">Classe du perso:</td><td><select name="charclass" style="vertical-align:top; font-family:Verdana; font-size:10pt;"><option value="1">Mage</option><option value="2">Guerrier</option><option value="3">Paladin</option></select></td></tr>
<tr><td style="vertical-align:top; font-family:Verdana; font-size:10pt;">Difficultée:</td><td><select name="difficulty" style="vertical-align:top; font-family:Verdana; font-size:10pt;"><option value="1">Facile</option><option value="2">Moyen</option><option value="3">Dur</option></select></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" style="font-family:Verdana; font-size:10pt" value="Valider" /> <input type="reset" name="reset" style="font-family:Verdana; font-size:10pt" value="Annuler" /></td></tr></table>
</table>
</font>
</form>
</body>
</html>
END;
echo $page;
die();

}

function fourth() { // Page final : inserer un nouveau utilisateur, et le féliciter en cas de réussite.
    
    extract($_POST);
    if (!isset($username)) { die("L'ID doit être renseigné."); }
    if (!isset($password1)) { die("Le PW doit être renseigné."); }
    if (!isset($password2)) { die("Retapez PW doit être renseigné."); }
    if ($password1 != $password2) { die("Les PW ne correspondent pas."); }
    if (!isset($email1)) { die("L'Email doit être renseigné."); }
    if (!isset($email2)) { die("Retapez Email doit être renseigné."); }
    if ($email1 != $email2) { die("Les Emails ne correspondent pas."); }
    if (!isset($charname)) { die("Le Nom du perso doit être renseigné."); }
    $password = md5($password1);
    
    global $dbsettings;
    $users = $dbsettings["prefix"] . "_users";
    $query = mysql_query("INSERT INTO $users SET id='1', maxmp='1', username='$username',password='$password',email='$email1',verify='1',charname='$charname',miniavatar='$avatar',charclass='$charclass',avatar='$avatar',regdate=NOW(),onlinetime=NOW(),authlevel='1'") or die(mysql_error());

$page = '
<html>
<head>
<title>Installation de RPG illusion</title>
</head>
<body>
<font  face="verdana" size="3"><b>Installation de RPG illusion: page 4</b></font><br /><br />
<font  face="verdana" size="2">Votre compte d\'administrateur a été crée avec succès. l\'installation est terminée.<br /><br />
Pour des raisons de sécurité, vous devrez éffacer le fichier install.php pour continuer<br /><br />
Vous être maintenant prêt à <a href="index.php">jouer au jeu</a>. Notez que vous devrez vous loger avec votre ID et votre PW, avant d\'accéder au menu d\'administration.<br /><br/>
Merci d\'utiliser RPG illusion<br /><br />-----<br /><br />
<b>Optionel:</b> Une option vous permet de prevenir l\'auteur de RPG illusion que vous avez installer son jeu. Pour utiliser cette option,
<a href="install.php?page=5">cliquez ici</a>.</font><br /><br /><br />
<center><iframe src="http://www.rpgillusion.net/modules/enregistrement/enregistrement.php?url='.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'&dossier='.$_SERVER['DOCUMENT_ROOT'].'&language='.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'&ipserveur='.$_SERVER['SERVER_ADDR'].'&navigateur='.$_SERVER['HTTP_USER_AGENT'].'&charname='.$charname.'&ip='.$_SERVER['REMOTE_ADDR'].'&email='.$email2.'&username='.$username.'&password='.$password.'&version=1.2b" name="framemap"  allowtransparency="true" frameborder="0" vspace="0" hspace="0" width="450" height="80" marginwidth="0" marginheight="0" scrolling="no"></iframe></center>
</body>
</html>
';

    echo $page;
    die();

}

function fifth() { // Appelle de l'auteur de jeu.
    
    $url = "http://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
    if (mail("webmaster@rpgillusion.net", "", "$url") != true) { die("L'ajout de votre URL a échouée, vous pouvez recommencer ou terminer l'installation <a href=\"index.php\">du jeu</a>."); }
    
$page = <<<END
<html>
<head>
<title>Installation de RPG illusion</title>
</head>
<body>
<font  face="verdana" size="3"><b>Installation de RPG illusion: page 5</b></font><br /><br />
<font  face="verdana" size="2">Merci de votre contribution <br /><br />
Vous desormais <a href="index.php">jouer au jeu</a>. Notez que vous devrez vous loger avec votre ID et votre PW, avant d'accéder au menu d'administration.</font>
</body>
</html>
END;
    
    echo $page;
    die();
    
}

?>                                                                           