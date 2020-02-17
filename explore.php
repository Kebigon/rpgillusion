<?php // explore.php :: Déplacements et actions en cours "Actuellement".

function move() {
    
    global $userrow, $controlrow;
    
    if ($userrow["currentaction"] == "En combat") { header("Location: index.php?do=fight"); die(); }
    
    $latitude = $userrow["latitude"];
    $longitude = $userrow["longitude"];
    if (isset($_POST["north_x"])) { $latitude++; if ($latitude > $controlrow["gamesize"]) { $latitude = $controlrow["gamesize"]; } }
    if (isset($_POST["south_x"])) { $latitude--; if ($latitude < ($controlrow["gamesize"]*-1)) { $latitude = ($controlrow["gamesize"]*-1); } }
    if (isset($_POST["east_x"])) { $longitude++; if ($longitude > $controlrow["gamesize"]) { $longitude = $controlrow["gamesize"]; } }
    if (isset($_POST["west_x"])) { $longitude--; if ($longitude < ($controlrow["gamesize"]*-1)) { $longitude = ($controlrow["gamesize"]*-1); } }
    
    $townquery = doquery("SELECT id FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "towns");
    if (mysql_num_rows($townquery) > 0) {
        $townrow = mysql_fetch_array($townquery);
        include('towns.php');
        travelto($townrow["id"], false);
        die();
    }
	
	$homequery = doquery("SELECT id FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "maison");
    if (mysql_num_rows($homequery) > 0) {
        $homerow = mysql_fetch_array($homequery);
        include('home.php');
        travelto($homerow["id"], false);
        die();
    }

    
    $chancetofight = rand(1,5);
    if ($chancetofight == 1) { 
        $action = "currentaction='En combat', currentfight='1',";
    } else {
        $action = "currentaction='En exploration',";
    }

    
    $updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
    header("Location: index.php");

    
}

?>