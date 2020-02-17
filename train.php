<?php // train.php :: La fonction d'entraînement. (c) 2005 Aweb antoninweb@hotmail.com

function fight() { // One big long function that determines the outcome of the fight.
    
    global $userrow, $controlrow;
    $pagearray = array();
    $playerisdead = 0;
    
    $pagearray["magiclist"] = "";
    $userspells = explode(",",$userrow["spells"]);
    $spellquery = doquery("SELECT id,name FROM {{table}}", "spells");
    while ($spellrow = mysql_fetch_array($spellquery)) {
        $spell = false;
        foreach ($userspells as $a => $b) {
            if ($b == $spellrow["id"]) { $spell = true; }
        }
        if ($spell == true) {
            $pagearray["magiclist"] .= "<option value=\"".$spellrow["id"]."\">".$spellrow["name"]."</option>\n";
        }
        unset($spell);
    }
    if ($pagearray["magiclist"] == "") { $pagearray["magiclist"] = "<option value=\"0\">Aucun</option>\n"; }
    $magiclist = $pagearray["magiclist"];
    
    $chancetoswingfirst = 1;

    // First, check to see if we need to pick a monster.
    if ($userrow["currentfight"] == 1) {
        
        if ($userrow["latitude"] < 0) { $userrow["latitude"] *= -1; } // Equalize negatives.
        if ($userrow["longitude"] < 0) { $userrow["longitude"] *= -1; } // Ditto.
        $maxlevel = floor(max($userrow["latitude"]+5, $userrow["longitude"]+5) / 5); // One mlevel per five spaces.
        if ($maxlevel < 1) { $maxlevel = 1; }
        $minlevel = $maxlevel - 2;
        if ($minlevel < 1) { $minlevel = 1; }
        
        
        // Pick a monster.
        $monsterquery = doquery("SELECT * FROM {{table}} WHERE level>='$minlevel' AND level<='$maxlevel' ORDER BY RAND() LIMIT 1", "monsters");
        $monsterrow = mysql_fetch_array($monsterquery);
        $userrow["currentmonster"] = $monsterrow["id"];
        $userrow["currentmonsterhp"] = rand((($monsterrow["maxhp"]/5)*4),$monsterrow["maxhp"]);
        if ($userrow["difficulty"] == 2) { $userrow["currentmonsterhp"] = ceil($userrow["currentmonsterhp"] * $controlrow["diff2mod"]); }
        if ($userrow["difficulty"] == 3) { $userrow["currentmonsterhp"] = ceil($userrow["currentmonsterhp"] * $controlrow["diff3mod"]); }
        $userrow["currentmonstersleep"] = 0;
        $userrow["currentmonsterimmune"] = $monsterrow["immune"];
        
        $chancetoswingfirst = rand(1,10) + ceil(sqrt($userrow["dexterity"]));
        if ($chancetoswingfirst > (rand(1,7) + ceil(sqrt($monsterrow["maxdam"])))) { $chancetoswingfirst = 1; } else { $chancetoswingfirst = 0; }
        
        unset($monsterquery);
        unset($monsterrow);
        
    }
    
    // Next, get the monster statistics.
    $monsterquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["currentmonster"]."' LIMIT 1", "monsters");
    $monsterrow = mysql_fetch_array($monsterquery);
    $pagearray["monstername"] = $monsterrow["name"];
    $pagearray["image"] = $monsterrow["image"];
    $pagearray["immunecontre"] = $monsterrow["immunecontre"];
	$pagearray["image2"] = $userrow["avatar"];
 
// Do run stuff.
    if (isset($_POST["run"])) {

        $chancetorun = rand(4,10) + ceil(sqrt($userrow["dexterity"]));
        if ($chancetorun > (rand(1,5) + ceil(sqrt($monsterrow["maxdam"])))) { $chancetorun = 1; } else { $chancetorun = 0; }
        
        if ($chancetorun == 0) { 
            $pagearray["yourturn"] = "Vous avez essayé de prendre la fuite, mais avez été bloqués par l'avant!<br /><br />";
            $pagearray["monsterhp"] = "HP du monstre: " . $userrow["currentmonsterhp"] . "";
            $pagearray["levelmonstre"] = "Niv. du monstre: " . $monsterrow["level"] . "";

 $pagearray["monsterturn"] = "";
            if ($userrow["currentmonstersleep"] != 0) { // Check to wake up.
                $chancetowake = rand(1,15);
                if ($chancetowake > $userrow["currentmonstersleep"]) {
                    $userrow["currentmonstersleep"] = 0;
                    $pagearray["monsterturn"] .= "Le monstre s'est réveillé.<br />";
                } else {
                    $pagearray["monsterturn"] .= "Le monstre est encore endormi.<br />";
                }
            }
            if ($userrow["currentmonstersleep"] == 0) { // Only do this if the monster is awake.
                $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
                if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
                if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
                $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
                $tododge = rand(1,150);
                if ($tododge <= sqrt($userrow["dexterity"])) {
                    $tohit = 0; $pagearray["monsterturn"] .= "Vous avez esquivé l'attaque du monstre. Il n'y a eu aucun domages.<br />";
                    $persondamage = 0;
                } else {
                    $persondamage = $tohit - $toblock;
                    if ($persondamage < 1) { $persondamage = 1; }
                    if ($userrow["currentuberdefense"] != 0) {
                        $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                    }
                    if ($persondamage < 1) { $persondamage = 1; }
                }
                $pagearray["monsterturn"] .= "Le monstre vous a attaqué, et a occasionné $persondamage points de dommage sur vous.<br /><br />";
                $userrow["currenthp"] -= $persondamage;
                if ($userrow["currenthp"] <= 0) {
                    $newgold = ceil($userrow["gold"]/2);
                    $newhp = ceil($userrow["maxhp"]/4);
                    $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                    $playerisdead = 1;
                }
            }
        }

         $updatequery = doquery("UPDATE {{table}} SET currentaction='En exploration' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
        header("Location: index.php");
        die();
        
    // Do fight stuff.
    } elseif (isset($_POST["fight"])) {
        
        // Your turn.
        $pagearray["yourturn"] = "";
        $tohit = ceil(rand($userrow["attackpower"]*.75,$userrow["attackpower"])/3);
        $toexcellent = rand(1,150);
        if ($toexcellent <= sqrt($userrow["strength"])) { $tohit *= 2; $pagearray["yourturn"] .= "Excellent hit!<br />"; }
        $toblock = ceil(rand($monsterrow["armor"]*.75,$monsterrow["armor"])/3);        
        $tododge = rand(1,200);
        if ($tododge <= sqrt($monsterrow["armor"])) { 
            $tohit = 0; $pagearray["yourturn"] .= "Le monstre à esquivé votre attaque. Aucun dommage n'a été constaté.<br />"; 
            $monsterdamage = 0;
        } else {
            $monsterdamage = $tohit - $toblock;
            if ($monsterdamage < 1) { $monsterdamage = 1; }
            if ($userrow["currentuberdamage"] != 0) {
                $monsterdamage += ceil($monsterdamage * ($userrow["currentuberdamage"]/100));
            }
        }
        $pagearray["yourturn"] .= "Votre attaque sur le monstre a accasionné $monsterdamage points de dommage sur lui.<br /><br />";
        $userrow["currentmonsterhp"] -= $monsterdamage;
        $pagearray["monsterhp"] = "HP du monstre: " . $userrow["currentmonsterhp"] . "";
        $pagearray["levelmonstre"] = "Niv. du monstre: " . $monsterrow["level"] . "";


        $pagearray["level"] = $userrow["level"] . "<br /><br />";
        if ($userrow["currentmonsterhp"] <= 0) {
            $updatequery = doquery("UPDATE {{table}} SET currentmonsterhp='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
            header("Location: index.php?do=trainvictory");
            die();
        }
        
        // Monster's turn.
        $pagearray["monsterturn"] = "";
        if ($userrow["currentmonstersleep"] != 0) { // Check to wake up.
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $pagearray["monsterturn"] .= "Le monstre s'est réveillé.<br />";
            } else {
                $pagearray["monsterturn"] .= "Le monstre est encore endormi.<br />";
            }
        }
        if ($userrow["currentmonstersleep"] == 0) { // Only do this if the monster is awake.
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; $pagearray["monsterturn"] .= "Vous avez esquivé l'attaque du monstre. Il n'y a eu aucun domages.<br />";
                $persondamage = 0;
            } else {
                $persondamage = $tohit - $toblock;
                if ($persondamage < 1) { $persondamage = 1; }
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $pagearray["monsterturn"] .= "Le monstre vous a attaqué, et a occasionné $persondamage points de dommage sur vous.<br /><br />";
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                $playerisdead = 1;
            }
        }
        
    // Do spell stuff.
    } elseif (isset($_POST["spell"])) {
        
        // Your turn.
        $pickedspell = $_POST["userspell"];
        if ($pickedspell == 0) { display("Vous devez tout d'abord choisir un sort. Veuillez retourner et recommencer.", "Erreur"); die(); }
        
        $newspellquery = doquery("SELECT * FROM {{table}} WHERE id='$pickedspell' LIMIT 1", "spells");
        $newspellrow = mysql_fetch_array($newspellquery);
        $spell = false;
        foreach($userspells as $a => $b) {
            if ($b == $pickedspell) { $spell = true; }
        }
        if ($pickedspell != true) { display("Vous n'avez pas encore appris ce sort. Veuillez retourner et recommencer.", "Erreur"); die(); }
        if ($userrow["currentmp"] < $newspellrow["mp"]) { display("Vous n'avez pas assez de points de magie pour éxécuter ce sort.  Veuillez retourner et recommencer.", "Erreur"); die(); }
        
        if ($newspellrow["type"] == 1) { // Heal spell.
            $newhp = $userrow["currenthp"] + $newspellrow["attribute"];
            if ($userrow["maxhp"] < $newhp) { $newspellrow["attribute"] = $userrow["maxhp"] - $userrow["currenthp"]; $newhp = $userrow["currenthp"] + $newspellrow["attribute"]; }
            $userrow["currenthp"] = $newhp;
            $userrow["currentmp"] -= $newspellrow["mp"];
            $pagearray["yourturn"] = "En éxécutant le sort ".$newspellrow["name"]." , vous avez gagné ".$newspellrow["attribute"]." points hit.<br /><br />";
        } elseif ($newspellrow["type"] == 2) { // Hurt spell.
            if ($userrow["currentmonsterimmune"] == 0) {
                $monsterdamage = rand((($newspellrow["attribute"]/6)*5), $newspellrow["attribute"]);
                $userrow["currentmonsterhp"] -= $monsterdamage;
                $pagearray["yourturn"] = "En éxécutant le sort".$newspellrow["name"]." , vous avez fait $monsterdamage points de dommage sur le monstre.<br /><br />";
            } else {
                $pagearray["yourturn"] = "Vous avez éxécuté le sort".$newspellrow["name"]." , mais le monstre est immunisé contre ca.<br /><br />";
            }
            $userrow["currentmp"] -= $newspellrow["mp"];
        } elseif ($newspellrow["type"] == 3) { // Sleep spell.
            if ($userrow["currentmonsterimmune"] != 2) {
                $userrow["currentmonstersleep"] = $newspellrow["attribute"];
                $pagearray["yourturn"] = "En éxécutant le sort ".$newspellrow["name"]." , le montre s'est endormi.<br /><br />";
            } else {
                $pagearray["yourturn"] = "Vous avez éxécuté le sort ".$newspellrow["name"]." , mais le monstre est immunisé contre ca.<br /><br />";
            }
            $userrow["currentmp"] -= $newspellrow["mp"];
        } elseif ($newspellrow["type"] == 4) { // +Damage spell.
            $userrow["currentuberdamage"] = $newspellrow["attribute"];
            $userrow["currentmp"] -= $newspellrow["mp"];
            $pagearray["yourturn"] = "Vous avez éxécuté le sort ".$newspellrow["name"]." , et vous avez eu ".$newspellrow["attribute"]."% de dommage sur vous.<br /><br />";
        } elseif ($newspellrow["type"] == 5) { // +Defense spell.
            $userrow["currentuberdefense"] = $newspellrow["attribute"];
            $userrow["currentmp"] -= $newspellrow["mp"];
            $pagearray["yourturn"] = "Vous avez éxécuté le sort".$newspellrow["name"]." , et vous avez gagné ".$newspellrow["attribute"]."% de défense à la fin de ce combat.<br /><br />";            
        }
            
        $pagearray["monsterhp"] = "HP du monstre: " . $userrow["currentmonsterhp"] . "";
        $pagearray["levelmonstre"] = "Niv. du monstre: " . $monsterrow["level"] . "";


if ($userrow["currentmonsterhp"] <= 0) {
            $updatequery = doquery("UPDATE {{table}} SET currentmonsterhp='0',currenthp='".$userrow["currenthp"]."',currentmp='".$userrow["currentmp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
            header("Location: index.php?do=trainvictory");
            die();
        }
        
        // Monster's turn.
        $pagearray["monsterturn"] = "";
        if ($userrow["currentmonstersleep"] != 0) { // Check to wake up.
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $pagearray["monsterturn"] .= "Le monstre s'est réveillé.<br />";
            } else {
                $pagearray["monsterturn"] .= "Le monstre est encore endormi.<br />";
            }
        }
        if ($userrow["currentmonstersleep"] == 0) { // Only do this if the monster is awake.
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; $pagearray["monsterturn"] .= "Vous avez esquivé l'attaque du monstre. Il n'y a eu aucun domages.<br />";
                $persondamage = 0;
            } else {
                if ($tohit <= $toblock) { $tohit = $toblock + 1; }
                $persondamage = $tohit - $toblock;
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $pagearray["monsterturn"] .= "Le monstre vous a attaqué, et a occasionné $persondamage points de dommage sur vous.<br /><br />";
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                $playerisdead = 1;
            }
        }
    
    // Do a monster's turn if person lost the chance to swing first. Serves him right!
    } elseif ( $chancetoswingfirst == 0 ) {
        $pagearray["yourturn"] = "Le monstre attaque avant que vous soyez prêt!<br /><br />";
        $pagearray["monsterhp"] = "HP du monstre: " . $userrow["currentmonsterhp"] . "";
        $pagearray["levelmonstre"] = "Niv. du monstre: " . $monsterrow["level"] . "";
        

$pagearray["monsterturn"] = "";
        if ($userrow["currentmonstersleep"] != 0) { // Check to wake up.
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $pagearray["monsterturn"] .= "Le monstre s'est réveillé.<br />";
            } else {
                $pagearray["monsterturn"] .= "Le monstre est encore endormi.<br />";
            }
        }
        if ($userrow["currentmonstersleep"] == 0) { // Only do this if the monster is awake.
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; $pagearray["monsterturn"] .= "Vous avez esquivez l'attaque du monstre. Il n'y a eu aucun domages.<br />";
                $persondamage = 0;
            } else {
                $persondamage = $tohit - $toblock;
                if ($persondamage < 1) { $persondamage = 1; }
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $pagearray["monsterturn"] .= "Le monstre vous a attaqué, et a occasionné $persondamage points de dommage sur vous.<br /><br />";
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                $playerisdead = 1;
            }
        }

    } else {
        $pagearray["yourturn"] = "";
        $pagearray["monsterhp"] = "HP du monstre: " . $userrow["currentmonsterhp"] . "";$pagearray["monsterturn"] = "";
     $pagearray["levelmonstre"] = "Niv. du monstre: " . $monsterrow["level"] . "";

}
    
    $newmonster = $userrow["currentmonster"];

    $newmonsterhp = $userrow["currentmonsterhp"];
    $newmonstersleep = $userrow["currentmonstersleep"];
    $newmonsterimmune = $userrow["currentmonsterimmune"];
    $newuberdamage = $userrow["currentuberdamage"];
    $newuberdefense = $userrow["currentuberdefense"];
    $newfight = $userrow["currentfight"] + 1;
    $newhp = $userrow["currenthp"];
    $newmp = $userrow["currentmp"];    
    
if ($playerisdead != 1) { 
$pagearray["command"] = <<<END
Que voulez vous faire?<br /><br />
<form action="index.php?do=train" method="post">
 <input type="submit" name="fight" value="Attaquer" /><br /><br />
 <select name="userspell"><option value="0">Les Sorts</option>$magiclist</select><input type="submit" name="spell" value="Exécuter" /><br /><br />
 <A HREF="index.php">S'enfuir et retourner à la ville
</A><br /><br />
</form>
END;
    $updatequery = doquery("UPDATE {{table}} SET currentaction='En combat',currenthp='$newhp',currentmp='$newmp',currentfight='$newfight',currentmonster='$newmonster',currentmonsterhp='$newmonsterhp',currentmonstersleep='$newmonstersleep',currentmonsterimmune='$newmonsterimmune',currentuberdamage='$newuberdamage',currentuberdefense='$newuberdefense' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
} else {
    $pagearray["command"] = "<b>Vous êtes mort.</b><br /><br />En conséquence, vous avez perdu la moitié de vos gils. Cependant, vous avez gardé une partie de vos points hit, pour continuer votre voyage.<br /><br />Vous pouvez maintenant <a href=\"index.php\">retourner à la ville</a>, et nous espéront que vous ferez mieux la prochaine fois.";
}
    
    // Finalize page and display it.
    $template = gettemplate("fight");
    $page = parsetemplate($template,$pagearray);
    
    display($page, "En combat");
    
}

function trainvictory() {
    
    global $userrow, $controlrow;
    
    if ($userrow["currentmonsterhp"] != 0) { header("Location: index.php?do=fight"); die(); }
    if ($userrow["currentfight"] == 0) { header("Location: index.php"); die(); }
    
    $monsterquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["currentmonster"]."' LIMIT 1", "monsters");
    $monsterrow = mysql_fetch_array($monsterquery);
    
    $exp = rand((($monsterrow["maxexp"]/6)*5),$monsterrow["maxexp"]);
    if ($exp < 1) { $exp = 1; }
    if ($userrow["difficulty"] == 2) { $exp = ceil($exp * $controlrow["diff2mod"]); }
    if ($userrow["difficulty"] == 3) { $exp = ceil($exp * $controlrow["diff3mod"]); }
    if ($userrow["expbonus"] != 0) { $exp += ceil(($userrow["expbonus"]/100)*$exp); }
    $gold = rand((($monsterrow["maxgold"]/6)*5),$monsterrow["maxgold"]);
    if ($gold < 1) { $gold = 1; }
    if ($userrow["difficulty"] == 2) { $gold = ceil($gold * $controlrow["diff2mod"]); }
    if ($userrow["difficulty"] == 3) { $gold = ceil($gold * $controlrow["diff3mod"]); }
    if ($userrow["goldbonus"] != 0) { $gold += ceil(($userrow["goldbonus"]/100)*$exp); }
    if ($userrow["experience"] + $exp < 16777215) { $newexp = $userrow["experience"] + $exp; $warnexp = ""; } else { $newexp = $userrow["experience"]; $exp = 0; $warnexp = "You have maxed out your experience points."; }
    if ($userrow["gold"] + $gold < 16777215) { $newgold = $userrow["gold"] + $gold; $warngold = ""; } else { $newgold = $userrow["gold"]; $gold = 0; $warngold = "You have maxed out your experience points."; }
    
    $levelquery = doquery("SELECT * FROM {{table}} WHERE id='".($userrow["level"]+1)."' LIMIT 1", "levels");
    if (mysql_num_rows($levelquery) == 1) { $levelrow = mysql_fetch_array($levelquery); }
    
    if ($userrow["level"] < 100) {
        if ($newexp >= $levelrow[$userrow["charclass"]."_exp"]) {
            $newhp = $userrow["maxhp"] + $levelrow[$userrow["charclass"]."_hp"];
            $newmp = $userrow["maxmp"] + $levelrow[$userrow["charclass"]."_mp"];
            $newtp = $userrow["maxtp"] + $levelrow[$userrow["charclass"]."_tp"];
            $newstrength = $userrow["strength"] + $levelrow[$userrow["charclass"]."_strength"];
            $newdexterity = $userrow["dexterity"] + $levelrow[$userrow["charclass"]."_dexterity"];
            $newattack = $userrow["attackpower"] + $levelrow[$userrow["charclass"]."_strength"];
            $newdefense = $userrow["defensepower"] + $levelrow[$userrow["charclass"]."_dexterity"];
            $newlevel = $levelrow["id"];
            
            if ($levelrow[$userrow["charclass"]."_spells"] != 0) {
                $userspells = $userrow["spells"] . ",".$levelrow[$userrow["charclass"]."_spells"];
                $newspell = "spells='$userspells',";
                $spelltext = "Vous avez appris un nouveau sort<br />";
            } else { $spelltext = ""; $newspell=""; }
            
            $page = "<center> <br>   Trop drôle, l'autre va avoir mal à la tête pendant un bon moment !!!!<br> <br> &nbsp;<img src=./images/vainqueur.gif /> <br> <br> Félicitation. Vous avez battu le ".$monsterrow["name"].".<br />Vous gagnez $exp d'expérience. $warnexp <br />Vous gagnez $gold gils. $warngold <br /><br /><b>Vous avez gagné 1 niveau!</b><br /><br />Vous gagnez ".$levelrow[$userrow["charclass"]."_hp"]." points hit.<br />Vous gagnez ".$levelrow[$userrow["charclass"]."_mp"]." points de magie.<br />Vous gagnez ".$levelrow[$userrow["charclass"]."_tp"]." points de voyage.<br />Vous gagnez ".$levelrow[$userrow["charclass"]."_strength"]." points de force.<br />Vous gagnez ".$levelrow[$userrow["charclass"]."_dexterity"]." points de dextérité.<br />$spelltext<br />Vous pouvez maintenant <br> <a href=\"index.php\">retourner à la ville</a>.<br>Ou continuer l'entraînement";
            $title = "Le courage et le bon esprit vous ont bien servi!";
            $dropcode = "";
        } else {
            $newhp = $userrow["maxhp"];
            $newmp = $userrow["maxmp"];
            $newtp = $userrow["maxtp"];
            $newstrength = $userrow["strength"];
            $newdexterity = $userrow["dexterity"];
            $newattack = $userrow["attackpower"];
            $newdefense = $userrow["defensepower"];
            $newlevel = $userrow["level"];
            $newspell = "";
            $page = "<center> <br>   Trop drôle, l'autre va avoir mal à la tête pendant un bon moment !!!!<br> <br> &nbsp;<img src=./images/vainqueur.gif /> <br> <br> Félicitation. Vous avez battu le ".$monsterrow["name"].".<br />Vous gagnez $exp points d'experience. $warnexp <br />Vous gagnez $gold gils. $warngold <br /><br />";
            
            if (rand(1,30) == 1) {
                $dropquery = doquery("SELECT * FROM {{table}} WHERE mlevel <= '".$monsterrow["level"]."' ORDER BY RAND() LIMIT 1", "drops");
                $droprow = mysql_fetch_array($dropquery);
                $dropcode = "dropcode='".$droprow["id"]."',";
                $page .= "Ce monstre a laisser tomber un objet. <a href=\"index.php?do=traindrop\">Cliquez ici</a> pour le rammasser et vous équiper de cet article, ou vous pouvez également passer et <br> <a href=\"index.php\">retourner à la ville</a>.";
            } else { 
                $dropcode = "";
                $page .= "Vous pouvez maintenant <br><a href=\"index.php\">retourner à la ville</a>.</center> ";
            }

            $title = "Victoire!";
        }
    }

    $updatequery = doquery("UPDATE {{table}} SET currentaction='En exploration',level='$newlevel',maxhp='$newhp',maxmp='$newmp',maxtp='$newtp',strength='$newstrength',dexterity='$newdexterity',attackpower='$newattack',defensepower='$newdefense', $newspell currentfight='0',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentuberdamage='0',currentuberdefense='0',$dropcode experience='$newexp',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
    

    display($page, $title);
    
}

function drop() {
    
    global $userrow;
    
    if ($userrow["dropcode"] == 0) { header("Location: index.php"); die(); }
    
    $dropquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["dropcode"]."' LIMIT 1", "drops");
    $droprow = mysql_fetch_array($dropquery);
    
    if (isset($_POST["submit"])) {
        
        $slot = $_POST["slot"];
        
        if ($slot == 0) { display("Veuillez retourner et choisir une fente de l'inventaire pour continuer.","Erreur"); }
        
        if ($userrow["slot".$slot."id"] != 0) {
            
            $slotquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["slot".$slot."id"]."' LIMIT 1", "drops");
            $slotrow = mysql_fetch_array($slotquery);
            
            $old1 = explode(",",$slotrow["attribute1"]);
            if ($slotrow["attribute2"] != "X") { $old2 = explode(",",$slotrow["attribute2"]); } else { $old2 = array(0=>"maxhp",1=>0); }
            $new1 = explode(",",$droprow["attribute1"]);
            if ($droprow["attribute2"] != "X") { $new2 = explode(",",$droprow["attribute2"]); } else { $new2 = array(0=>"maxhp",1=>0); }
            
            $userrow[$old1[0]] -= $old1[1];
            $userrow[$old2[0]] -= $old2[1];
            if ($old1[0] == "strength") { $userrow["attackpower"] -= $old1[1]; }
            if ($old1[0] == "dexterity") { $userrow["defensepower"] -= $old1[1]; }
            if ($old2[0] == "strength") { $userrow["attackpower"] -= $old2[1]; }
            if ($old2[0] == "dexterity") { $userrow["defensepower"] -= $old2[1]; }
            
            $userrow[$new1[0]] += $new1[1];
            $userrow[$new2[0]] += $new2[1];
            if ($new1[0] == "strength") { $userrow["attackpower"] += $new1[1]; }
            if ($new1[0] == "dexterity") { $userrow["defensepower"] += $new1[1]; }
            if ($new2[0] == "strength") { $userrow["attackpower"] += $new2[1]; }
            if ($new2[0] == "dexterity") { $userrow["defensepower"] += $new2[1]; }
            
            if ($userrow["currenthp"] > $userrow["maxhp"]) { $userrow["currenthp"] = $userrow["maxhp"]; }
            if ($userrow["currentmp"] > $userrow["maxmp"]) { $userrow["currentmp"] = $userrow["maxmp"]; }
            if ($userrow["currenttp"] > $userrow["maxtp"]) { $userrow["currenttp"] = $userrow["maxtp"]; }
            
            $newname = addslashes($droprow["name"]);
            $query = doquery("UPDATE {{table}} SET slot".$_POST["slot"]."name='$newname',slot".$_POST["slot"]."id='".$droprow["id"]."',$old1[0]='".$userrow[$old1[0]]."',$old2[0]='".$userrow[$old2[0]]."',$new1[0]='".$userrow[$new1[0]]."',$new2[0]='".$userrow[$new2[0]]."',attackpower='".$userrow["attackpower"]."',defensepower='".$userrow["defensepower"]."',currenthp='".$userrow["currenthp"]."',currentmp='".$userrow["currentmp"]."',currenttp='".$userrow["currenttp"]."',dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
            
        } else {
            
            $new1 = explode(",",$droprow["attribute1"]);
            if ($droprow["attribute2"] != "X") { $new2 = explode(",",$droprow["attribute2"]); } else { $new2 = array(0=>"maxhp",1=>0); }
            
            $userrow[$new1[0]] += $new1[1];
            $userrow[$new2[0]] += $new2[1];
            if ($new1[0] == "strength") { $userrow["attackpower"] += $new1[1]; }
            if ($new1[0] == "dexterity") { $userrow["defensepower"] += $new1[1]; }
            if ($new2[0] == "strength") { $userrow["attackpower"] += $new2[1]; }
            if ($new2[0] == "dexterity") { $userrow["defensepower"] += $new2[1]; }
            
            $newname = addslashes($droprow["name"]);
            $query = doquery("UPDATE {{table}} SET slot".$_POST["slot"]."name='$newname',slot".$_POST["slot"]."id='".$droprow["id"]."',$new1[0]='".$userrow[$new1[0]]."',$new2[0]='".$userrow[$new2[0]]."',attackpower='".$userrow["attackpower"]."',defensepower='".$userrow["defensepower"]."',dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
            
        }
        $page = "L'objet a été équipé. Vous pouvez maintenant <a href=\"index.php\">retourner à la ville</a>.</center> ";
        display($page, "Item Drop");
        
    }
    
    $attributearray = array("maxhp"=>"HP Max",
                            "maxmp"=>"MP Max",
                            "maxtp"=>"TP Max",
                            "defensepower"=>"Pouvoir de défense",
                            "attackpower"=>"Pouvoir d'attaque",
                            "strength"=>"Force",
                            "dexterity"=>"Dextérité",
                            "expbonus"=>"Experience Bonus",
                            "goldbonus"=>"Gils Bonus");
    
    $page = "Le monstre a fait tomber l'objet suivant: <b>".$droprow["name"]."</b><br /><br />";
    $page .= "Cet objet a l'attribut(s) suivant:<br />";
    
    $attribute1 = explode(",",$droprow["attribute1"]);
    $page .= $attributearray[$attribute1[0]];
    if ($attribute1[1] > 0) { $page .= " +" . $attribute1[1] . "<br />"; } else { $page .= $attribute1[1] . "<br />"; }
    
    if ($droprow["attribute2"] != "X") { 
        $attribute2 = explode(",",$droprow["attribute2"]);
        $page .= $attributearray[$attribute2[0]];
        if ($attribute2[1] > 0) { $page .= " +" . $attribute2[1] . "<br />"; } else { $page .= $attribute2[1] . "<br />"; }
    }
    
    $page .= "<br />Choisissez une fente dans l'inventaire à partir de la liste ci-dessous pour vous équiper de cet objet. Si la fente de l'inventaire est déja pleine, l'ancien objet sera jeté.";
    $page .= "<form action=\"index.php?do=traindrop\" method=\"post\"><select name=\"slot\"><option value=\"0\">Les Fentes</option><option value=\"1\">Fente 1: ".$userrow["slot1name"]."</option><option value=\"2\">Fente 2: ".$userrow["slot2name"]."</option><option value=\"3\">Fente 3: ".$userrow["slot3name"]."</option></select> <input type=\"submit\" name=\"submit\" value=\"Valider\" /></form>";
    $page .= "Vous pouvez également choisir de <a href=\"index.php\">retourner à la ville</a> et renoncer à cet objet.";
    
    display($page, "Item Drop");
    
}
    

function dead() {
    
    $page = "<b>Vous êtes mort.</b><br /><br />En conséquence, vous avez perdu la moitié de vos gils. Cependant, vous avez gardé une partie de vos points hit, pour continuer votre voyage.<br /><br />Vous pouvez maintenant <a href=\"index.php\">retourner à la ville</a>, et nous espérons que vous ferez mieux la prochaine fois.";
        
}



?>