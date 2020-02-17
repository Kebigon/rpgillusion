<?php // functions.php :: Fonctions maitres du jeu
//Ouverture de la BDD.
function opendb() {
    include('config.php');
    extract($dbsettings);
    $link = mysql_connect($server, $user, $pass) or die(mysql_error());
    mysql_select_db($name) or die(mysql_error());
    return $link;

}

//Validation d'une adresse email.
function is_email($email) {

    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

//Gestion des requetes SQL.
function doquery($query, $table) {
 
    include('config.php');
    $sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"] . "_" . $table, $query)) or die(mysql_error());
    return $sqlquery;

}

//Aller chercher le fichier template.
function gettemplate($templatename) {

    $filename = "templates/" . $templatename . ".php";
    include("$filename");
    return $template;
    
}

//Fonction pour la gestion des contenus dans les templates.
function parsetemplate($template, $array) {
    
    foreach($array as $a => $b) {
        $template = str_replace("{{{$a}}}", $b, $template);
    }
    return $template;
    
}

//Fonction pour l'affichage de la date du flash.
function datefrance($MyDate, $WeekDayOn=1, $YearOn=1)
{
  $MyMonths = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
        "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
  $MyDays = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", 
                  "Vendredi", "Samedi");

  $DF=explode('-',$MyDate);
  $TheDay=getdate(mktime(0,0,0,$DF[1],$DF[2],$DF[0]));

  $MyDate=$DF[2]." ".$MyMonths[$DF[1]-1];
  if($WeekDayOn){$MyDate=$MyDays[$TheDay["wday"]]." ".$MyDate;}
  if($YearOn){$MyDate.=" ".$DF[0];}
        
  return $MyDate; 
}
?>