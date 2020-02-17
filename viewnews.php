<?
/*******************************************************
Viewnews.php ==> Vue différente des news
Dévelopée par Tsunami <http://zfusion.free.fr>
Problème? Questions? 
--> http://rpgillusion.com/forums/
--> http://zfusion.free.fr

********************************************************/
include('lib_log.php');
$link = opendb();

$page = gettemplate("news_accueil");
$title = "$gameinfos[gamename] :: News";
display($page, $title, false, true, false);