<?php // login.php :: Handles logins and cookies.

include('lib_log.php');
if (isset($_GET["do"])) {
    if ($_GET["do"] == "login") { login(); }
    elseif ($_GET["do"] == "logout") { logout(); }
}

function login() {
    
    include('config.php');
    $link = opendb();
    
    if (isset($_POST["submit_x"])) {
        
        $query = doquery("SELECT * FROM {{table}} WHERE username='".$_POST["username"]."' AND password='".md5($_POST["password"])."' LIMIT 1", "users");
        if (mysql_num_rows($query) != 1) { die("ID ou PW invalide, veuillez vous reloger avec vos bon identifiants."); }
        $row = mysql_fetch_array($query);
        if (isset($_POST["rememberme"])) { $expiretime = time()+31536000; $rememberme = 1; } else { $expiretime = 0; $rememberme = 0; }
        $cookie = $row["id"] . " " . $row["username"] . " " . md5($row["password"] . "--" . $dbsettings["secretword"]) . " " . $rememberme;
        setcookie("dkgame", $cookie, $expiretime, "/", "", 0);
        header("Location: index.php");
        die();
        
    }
    
    $page = gettemplate("guide");
    $title = "Guide du jeu";
    display($page, $title, false, true, false);
    
}
    

function logout() {
    
    setcookie("dkgame", "", time()-100000, "/", "", 0);
    header("Location: login.php?do=login");
    die();
    
}

?>