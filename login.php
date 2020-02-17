<?php // login.php :: Fonctions pour se loger et quitter.
header('P3P: CP="NON ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
include('lib_log.php');
if (isset($_GET["do"])) {
    if ($_GET["do"] == "login") { login(); }
	elseif ($_GET["do"] == "login2") { login2(); }
	elseif ($_GET["do"] == "login4") { login4(); }
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
    
    $page = gettemplate("login");
    $title = "Bienvenue sur RPG illusion";
    display($page, $title, false, true, false);
    
}

function login2() {
    
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
    
    $page = gettemplate("login2");
    $title = "Rpg illusion 1.2c";
    display($page, $title, false, true, false);
    
}

function login4() {
    
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
    
    $page = gettemplate("login4");
    $title = "Rpg illusion 1.2c";
    display($page, $title, false, true, false);
    
}
    
function logout() {
    
    setcookie("dkgame", "", time()-100000, "/", "", 0);
    header("Location: login.php?do=login");
    die();
    
}

?>