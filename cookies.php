<?php // cookies.php :: Création et utilisation du cookies de session.


function checkcookies() {

    include('config.php');
    
    $row = false;
    
    if (isset($_COOKIE["dkgame"])) {
        
        // Format du cookies:
        // {ID} {USERNAME} {PASSWORDHASH} {REMEMBERME}
        $theuser = explode(" ",$_COOKIE["dkgame"]);
        $query = doquery("SELECT * FROM {{table}} WHERE username='$theuser[1]'", "users");
        if (mysql_num_rows($query) != 1) { die("Erreur 1: cookie invalide, veuillez éffacer le cookies et vous reloger ensuite."); }
        $row = mysql_fetch_array($query);
        if ($row["id"] != $theuser[0]) { die("Erreur 2: cookie invalide, veuillez éffacer le cookies et vous reloger ensuite."); }
        if (md5($row["password"] . "--" . $dbsettings["secretword"]) != $theuser[2]) { die("Erreur 3: cookie invalide, veuillez éffacer le cookies et vous reloger ensuite."); }
        
        // If we've gotten this far, cookie should be valid, so write a new one.
        $newcookie = implode(" ",$theuser);
        if ($theuser[3] == 1) { $expiretime = time()+31536000; } else { $expiretime = 0; }
        $onlinequery = doquery("UPDATE {{table}} SET onlinetime=NOW() WHERE id='$theuser[0]' LIMIT 1", "users");
        
    }
        
    return $row;
    
}

?>