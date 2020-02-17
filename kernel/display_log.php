<?php // display_log.php :: Affichage accueil

function display($content, $title, $leftnavlog) { 
    
global $userrow, $controlrow;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
   
    $template = gettemplate("primary");
	
	$styles='<link rel="stylesheet" href="styles/css_login.css" type="text/css">
    <script type="text/javascript" src="styles/js_login.js"></script>';
	$load_classement='onLoad="javascript:classement(\'1\')"';
    $userrow = array();
    
    $finalarray = array(
        "rpgname"=>$controlrow["gamename"],
		"copyright"=>$controlrow["copyright"],
        "title"=>$title,
		"styles"=>$styles,
		"load_classement"=>$load_classement,
        "content"=>$content,
		"leftnavlog"=>$leftnavlog,
		"leftnav"=>null,
	   );
    $page = parsetemplate($template, $finalarray);
    
    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo stripslashes($page);
    die();
    
}

?>