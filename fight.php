<?php // fight.php :: Les fonctions essentielles aux combats.

function fight() {
    
    global $userrow, $controlrow;
	
	$page ='<img src="images/jeu/actions/combat.jpg" width="580" height="82" alt="En combat"><br><br>';
	
    if ($userrow["currentaction"] != "En combat") { 
    $page .='<span class="alerte">Erreur de manipulation!</span><br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au jeu</a>';
	}else{
    $pagearray = array();
    $playerisdead = 0;
    
    $magiclist = null;
    $userspells = explode(",",$userrow["spells"]);
    $spellquery = doquery("SELECT id,name FROM {{table}}", "spells");
    while ($spellrow = mysql_fetch_array($spellquery)) {
        $spell = false;
        foreach ($userspells as $a => $b) {
            if ($b == $spellrow["id"]) { $spell = true; }
			}
        if ($spell == true) {
            $magiclist .= "<option value=\"".$spellrow["id"]."\">".$spellrow["name"]."</option>\n";
        }
        unset($spell);
    }
    if ($magiclist == null) { $magiclist = '<option value="0">Aucun sort</option>'; }
    
    
    $chancetoswingfirst = 1;

    if ($userrow["currentfight"] == 1) {
        
        if ($userrow["latitude"] < 0) { $userrow["latitude"] *= -1; }
        if ($userrow["longitude"] < 0) { $userrow["longitude"] *= -1; }
        $maxlevel = floor(max($userrow["latitude"]+5, $userrow["longitude"]+5) / 5);
        if ($maxlevel < 1) { $maxlevel = 1; }
        $minlevel = $maxlevel - 2;
        if ($minlevel < 1) { $minlevel = 1; }
        
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
        
		//Enregistrement dans l'historique.
        $history = doquery("INSERT INTO {{table}} SET time='".time()."', content='<p><span class=\"mauve1\">".$userrow['charname']."</span> est en train de combattre le monstre <span class=\"mauve2\">".$monsterrow['name']."</span></p>', charname='" . $userrow['charname'] . "'", "history"); 
		
        unset($monsterquery);
        unset($monsterrow);
        
    }
    
    $monsterquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["currentmonster"]."' LIMIT 1", "monsters");
    $monsterrow = mysql_fetch_array($monsterquery);
    
    if (isset($_POST["run"])) {

        $chancetorun = rand(4,10) + ceil(sqrt($userrow["dexterity"]));
        if ($chancetorun > (rand(1,5) + ceil(sqrt($monsterrow["maxdam"])))) { $chancetorun = 1; } else { $chancetorun = 0; }
		
	//Enregistrement dans l'historique.
        $history = doquery("INSERT INTO {{table}} SET time='".time()."', content='<p><span class=\"mauve1\">".$userrow['charname']."</span> a fuit le combat, contre le monstre <span class=\"mauve2\">".$monsterrow['name']."</span></p>', charname='" . $userrow['charname'] . "'", "history"); 
        
        if ($chancetorun == 0) { 
            $page.= 'Vous avez essayé de prendre la fuite, mais avez été bloqués par l\'avant!<br>Le monstre <b>'.$monsterrow['name'].'</b> ne semble pas être décidé à vous laisser partir.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner au combat/a>';
            $monsterturn = null;
            if ($userrow["currentmonstersleep"] != 0) { 
                $chancetowake = rand(1,15);
                if ($chancetowake > $userrow["currentmonstersleep"]) {
                    $userrow["currentmonstersleep"] = 0;
                    $monsterturn = 'Le monstre s\'est réveillé, garde à vous!<br>';
                } else {
                    $monsterturn = 'Le monstre est toujours endormi, profitez en!<br>';
                }
            }
            if ($userrow["currentmonstersleep"] == 0) {
                $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
                if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
                if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
                $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
                $tododge = rand(1,150);
                if ($tododge <= sqrt($userrow["dexterity"])) {
                    $tohit = 0; 
					$monsterturn = 'Vous avez esquivé l\'attaque du monstre. Il n\'y a eu aucun dommage constaté sur '.$userrow['charname'].'.<br>';
                    $persondamage = 0;
                } else {
                    $persondamage = $tohit - $toblock;
                    if ($persondamage < 1) { $persondamage = 1; }
                    if ($userrow["currentuberdefense"] != 0) {
                        $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                    }
                    if ($persondamage < 1) { $persondamage = 1; }
                }
                $monsterturn = 'En attaquant, le monstre a occasionné <span class="mauve2"><b>'.$persondamage.' HP</b></span> de dommage sur '.$userrow['charname'].'.<br>';
                $userrow["currenthp"] -= $persondamage;
                if ($userrow["currenthp"] <= 0) {
                    $newgold = ceil($userrow["gold"]/2);
                    $newhp = ceil($userrow["maxhp"]/4);
                    $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                    $playerisdead = 1;
                }
            }
        }

        $updatequery = doquery("UPDATE {{table}} SET currentaction='En exploration', currentuberdamage='0', currentuberdefense='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
        header("Location: index.php");
        die();
        
    } elseif (isset($_POST["fight"])) {
        
        $yourturn = null;
        $tohit = ceil(rand($userrow["attackpower"]*.75,$userrow["attackpower"])/3);
        $toexcellent = rand(1,150);
        if ($toexcellent <= sqrt($userrow["strength"])) { $tohit *= 2; $yourturn= '<b>Excellente attaque!</b><br><br>'; }
        $toblock = ceil(rand($monsterrow["armor"]*.75,$monsterrow["armor"])/3);        
        $tododge = rand(1,200);
        if ($tododge <= sqrt($monsterrow["armor"])) { 
            $tohit = 0; 
			$yourturn = 'Le monstre à esquivé votre attaque. Malheuresement il n\'y a eu aucun dommage sur lui.<br><br>'; 
            $monsterdamage = 0;
        } else {
            $monsterdamage = $tohit - $toblock;
            if ($monsterdamage < 1) { $monsterdamage = 1; }
            if ($userrow["currentuberdamage"] != 0) {
                $monsterdamage += ceil($monsterdamage * ($userrow["currentuberdamage"]/100));
            }
        }
        $yourturn = 'Votre attaque sur le monstre a accasionné <span class="mauve2"><b>'.$monsterdamage.' HP</b></span> de dommage sur lui.<br><br>';
        $userrow["currentmonsterhp"] -= $monsterdamage;
        if ($userrow["currentmonsterhp"] <= 0) {
            $updatequery = doquery("UPDATE {{table}} SET currentmonsterhp='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
            header("Location: index.php?do=victory");
            die();
        }
        
        $monsterturn = null;
        if ($userrow["currentmonstersleep"] != 0) {
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $monsterturn = 'Le monstre s\'est réveillé, garde à vous!<br>';
            } else {
                $monsterturn = 'Le monstre est toujours endormi, profitez en!<br>';
            }
        }
        if ($userrow["currentmonstersleep"] == 0) { 
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; $monsterturn = 'Vous avez esquivé l\'attaque du monstre. Il n\'y a eu aucun dommage constaté sur '.$userrow['charname'].'.<br>';
                $persondamage = 0;
            } else {
                $persondamage = $tohit - $toblock;
                if ($persondamage < 1) { $persondamage = 1; }
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $monsterturn = 'En attaquant, le monstre a occasionné <span class="mauve2"><b>'.$persondamage.' HP</b></span> de dommage sur '.$userrow['charname'].'.<br>';
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                $playerisdead = 1;
            }
        }
        

    } elseif (isset($_POST["spell"])) {
        $monsterturn = null;
        $pickedspell = $_POST["userspell"];
		
		$newspellquery = doquery("SELECT * FROM {{table}} WHERE id='$pickedspell' LIMIT 1", "spells");
        $newspellrow = mysql_fetch_array($newspellquery);
	
     	$spell = false;
        foreach($userspells as $a => $b) {
        if ($b == $pickedspell) { $spell = true; }
        }
		
        if ($pickedspell == 0) { $yourturn ='<span class="alerte">Erreur: Vous devez tout d\'abord choisir un sort dans la liste.</span><br>';}
        elseif ($spell != true) { $yourturn='<span class="alerte">Erreur: Vous n\'avez pas encore appris ce sort.</span><br>'; } 
        elseif($userrow["currentmp"] < $newspellrow["mp"]) { $yourturn ='<span class="alerte">Erreur: Vous n\'avez pas assez de points de magie (<span class="mauve1"><b>MP</b></span>) pour éxécuter ce sort.</span><br>'; }else{
     
     	if ($newspellrow["type"] == 1) { 
            $newhp = $userrow["currenthp"] + $newspellrow["attribute"];
            if ($userrow["maxhp"] < $newhp) { $newspellrow["attribute"] = $userrow["maxhp"] - $userrow["currenthp"]; $newhp = $userrow["currenthp"] + $newspellrow["attribute"]; }
            $userrow["currenthp"] = $newhp;
            $userrow["currentmp"] -= $newspellrow["mp"];
            $yourturn = 'En éxécutant le sort <b>'.$newspellrow['name'].'</b>, '.$userrow['charname'].' a gagné <span class="mauve2"><b>'.$newspellrow['attribute'].' HP</b></span>.<br><br>';
        } elseif ($newspellrow["type"] == 2) {
            if ($userrow["currentmonsterimmune"] == 0) {
                $monsterdamage = rand((($newspellrow["attribute"]/6)*5), $newspellrow["attribute"]);
                $userrow["currentmonsterhp"] -= $monsterdamage;
                $yourturn = 'En éxécutant le sort <b>'.$newspellrow['name'].'</b>, '.$userrow['charname'].' a fait <span class="mauve2"><b>'.$monsterdamage.' HP</b></span> de dommage sur le monstre.<br><br>';
            } else {
                $yourturn = 'Vous avez éxécuté le sort <b>'.$newspellrow['name'].'</b>, mais le monstre est malheuresement immunisé contre ca.<br><br>';
            }
            $userrow["currentmp"] -= $newspellrow["mp"];
        } elseif ($newspellrow["type"] == 3) {
            if ($userrow["currentmonsterimmune"] != 2) {
                $userrow["currentmonstersleep"] = $newspellrow["attribute"];
                $yourturn = 'En éxécutant le sort <b>'.$newspellrow['name'].'</b>, le montre s\'est soudainement endormi.<br><br>';
            } else {
                $yourturn = 'Vous avez éxécuté le sort '.$newspellrow['name'].', mais le monstre est malheuresement immunisé contre ca.<br><br>';
            }
            $userrow["currentmp"] -= $newspellrow["mp"];
        } elseif ($newspellrow["type"] == 4) { 
            $userrow["currentuberdamage"] = $newspellrow["attribute"];
            $userrow["currentmp"] -= $newspellrow["mp"];
            $yourturn = 'En éxécutant le sort <b>'.$newspellrow['name'].'</b>, vous avez augmenté votre attaque de <b>'.$newspellrow['attribute'].'%</b> et ceci jusqu\'à la fin du combat. Vos points de magie ont par ailleur baissé de <span class="mauve1"><b>'.$newspellrow['attribute'].' MP</b></span>.<br><br>';
        } elseif ($newspellrow["type"] == 5) {
            $userrow["currentuberdefense"] = $newspellrow["attribute"];
            $userrow["currentmp"] -= $newspellrow["mp"];
            $yourturn = 'En éxécutant le sort <b>'.$newspellrow['name'].'</b>, vous avez augmenté votre défense de <b>'.$newspellrow['attribute'].'%</b> et ceci jusqu\'à la fin du combat. Vos points de magie ont par ailleur baissé de <span class="mauve1"><b>'.$newspellrow['attribute'].' MP</b></span>.<br><br>';            
        }
            
        if ($userrow["currentmonsterhp"] <= 0) {
            $updatequery = doquery("UPDATE {{table}} SET currentmonsterhp='0',currenthp='".$userrow["currenthp"]."',currentmp='".$userrow["currentmp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
            header("Location: index.php?do=victory");
            die();
        
        }
        $monsterturn = null;
        if ($userrow["currentmonstersleep"] != 0) {
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $monsterturn = 'Le monstre s\'est réveillé, garde à vous!<br>';
            } else {
                $monsterturn = 'Le monstre est toujours endormi, profitez en!<br>';
            }
        }
        if ($userrow["currentmonstersleep"] == 0) {
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; 
				$monsterturn = 'Vous avez esquivé l\'attaque du monstre. Il n\'y a eu aucun dommage constaté sur '.$userrow['charname'].'.<br>';
                $persondamage = 0;
            } else {
                if ($tohit <= $toblock) { $tohit = $toblock + 1; }
                $persondamage = $tohit - $toblock;
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $monsterturn = 'En attaquant, le monstre a occasionné <span class="mauve2"><b>'.$persondamage.' HP</b></span> de dommage sur '.$userrow['charname'].'.<br>';
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                $playerisdead = 1;
            }
        }
}
    } elseif ( $chancetoswingfirst == 0 ) {
		$yourturn = 'Le monstre a attaqué avant que vous soyez prêt!<br><br>';

        $monsterturn = null;
        if ($userrow["currentmonstersleep"] != 0) { 
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $monsterturn = 'Le monstre s\'est réveillé, garde à vous!<br>';
            } else {
                $monsterturn = 'Le monstre est toujours endormi, profitez en!<br>';
            }
        }
        if ($userrow["currentmonstersleep"] == 0) {
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; 
				$monsterturn = 'Vous avez esquivé l\'attaque du monstre. Il n\'y a eu aucun dommage constaté sur '.$userrow['charname'].'.<br>';
                $persondamage = 0;
            } else {
                $persondamage = $tohit - $toblock;
                if ($persondamage < 1) { $persondamage = 1; }
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $monsterturn = 'En attaquant, le monstre a occasionné <span class="mauve2"><b>'.$persondamage.' HP</b></span> de dommage sur '.$userrow['charname'].'.<br>';
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En ville',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
                $playerisdead = 1;
            }
        }

    } else {
        $yourturn = null;
        $monsterturn = null;
    }
    
    $newmonster = $userrow["currentmonster"];
    $newmonsterhp = $userrow["currentmonsterhp"];
    $newmonstersleep = $userrow["currentmonstersleep"];
    $newmonsterimmune = $monsterrow["immune"];
    $newuberdamage = $userrow["currentuberdamage"];
    $newuberdefense = $userrow["currentuberdefense"];
    $newfight = $userrow["currentfight"] + 1;
    $newhp = $userrow["currenthp"];
    $newmp = $userrow["currentmp"];    
	    
if ($playerisdead != 1) { 

$page .='
Vous êtes en train de combattre un <b>'.$monsterrow['name'].'</b> (Niv.: '.$monsterrow['level'].', <span class="mauve2">HP: <b>'.$userrow['currentmonsterhp'].'</b> /'.$monsterrow['maxhp'].'</span>)<br><br>
'.$yourturn.'
'.$monsterturn.'<br>
Que voulez vous faire?<br><br>
<form action="index.php?do=fight" method="post"><div>
<img src="images/jeu/puce3.gif" alt=""> <input type="submit" name="fight" value="Attaquer"><br><br>
<img src="images/jeu/puce3.gif" alt=""> <select name="userspell"><option value="0">Les Sorts</option>'.$magiclist.'</select><input type="submit" name="spell" value="Exécuter"><br><br>
<img src="images/jeu/puce3.gif" alt=""> <input type="submit" name="run" value="Fuire le combat"><br><br></div>
</form>
';
    $updatequery = doquery("UPDATE {{table}} SET currentaction='En combat',currenthp='$newhp',currentmp='$newmp',currentfight='$newfight',currentmonster='$newmonster',currentmonsterhp='$newmonsterhp',currentmonstersleep='$newmonstersleep',currentmonsterimmune='$newmonsterimmune',currentuberdamage='$newuberdamage',currentuberdefense='$newuberdefense' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
	} else {
    $page .= '<b>Vous venez de mourrir!</b><br><br>Par conséquent, vous avez perdu la moitié de vos rubis. Cependant, vous avez gardé une partie de vos points de voyage (<span class="rouge1"><b>TP</b></span>), pour continuer à explorer le monde.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner en exploration</a>';

	}
}
   
    display($page, 'En combat');
    
}

function victory() {
    
    global $userrow, $controlrow;
	
    $page ='<img src="images/jeu/actions/combat.jpg" width="580" height="82" alt="En combat"><br><br>';
    
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
    if ($userrow["experience"] + $exp < 16777215) { $newexp = $userrow["experience"] + $exp; $warnexp = ""; } else { $newexp = $userrow["experience"]; $exp = 0; $warnexp = ' (vous avez le maximum autorisé)'; }
    if ($userrow["gold"] + $gold < 16777215) { $newgold = $userrow["gold"] + $gold; $warngold = ""; } else { $newgold = $userrow["gold"]; $gold = 0; $warngold = ' (vous avez le maximum autorisé)'; }
    
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
                $spelltext = ' ,et enfin vous avez appris un nouveau sort';
            } else { $spelltext = ""; $newspell=""; }
            
            $page .= 'Bravo, vous avez battu le monstre <b>'.$monsterrow['name'].'</b>!<br><br>Vous avez gagnez <b>'.$exp.' points d\'expérience</b>'.$warnexp.', <b>'.$gold.' rubis</b>'.$warngold.'.<br><br>'.$userrow['charname'].' gagne également <b>1 niveau, <span class="mauve2">'.$levelrow[$userrow['charclass'].'_hp'].' HP</span>, <span class="mauve1">'.$levelrow[$userrow['charclass'].'_mp'].' MP</span>, <span class="rouge1">'.$levelrow[$userrow['charclass'].'_tp'].' TP</span>, '.$levelrow[$userrow['charclass'].'_strength'].' points de force, '.$levelrow[$userrow['charclass'].'_dexterity'].' points de dextérité</b>'.$spelltext.'.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner en exploration</a>';
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
            $page .= 'Bravo, vous avez battu le monstre <b>'.$monsterrow['name'].'</b>!<br><br>Vous avez gagnez <b>'.$exp.' points d\'expérience</b>'.$warnexp.' et <b>'.$gold.' rubis</b>'.$warngold.'.<br><br>';
            
            if (rand(1,30) == 1) {
                $dropquery = doquery("SELECT * FROM {{table}} WHERE mlevel <= '".$monsterrow["level"]."' ORDER BY RAND() LIMIT 1", "drops");
                $droprow = mysql_fetch_array($dropquery);
                $dropcode = "dropcode='".$droprow["id"]."',";
                $page .= '<b>Ce monstre a laisser tomber un objet!</b> <a href="?do=drop">Cliquez ici</a> pour le rammasser et vous équiper de cet article.<br><br>Vous pouvez également:<br><br><a href="index.php">» retourner en exploration</a>';
            } else { 
                $dropcode = "";
				$page .= 'Maintenant vous pouvez:<br><br><a href="index.php">» retourner en exploration</a>';
            }

        }
    }

    $updatequery = doquery("UPDATE {{table}} SET currentaction='En exploration',level='$newlevel',maxhp='$newhp',maxmp='$newmp',maxtp='$newtp',strength='$newstrength',dexterity='$newdexterity',attackpower='$newattack',defensepower='$newdefense', $newspell currentfight='0',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentuberdamage='0',currentuberdefense='0',$dropcode experience='$newexp',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
    
    display($page, 'Victoire!');
    
}

function drop() {
    
    global $userrow;
	
	$page ='<img src="images/jeu/actions/combat.jpg" width="580" height="82" alt="En combat"><br><br>';
    
    if ($userrow["dropcode"] == 0) { header("Location: index.php"); die(); }
    
    $dropquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["dropcode"]."' LIMIT 1", "drops");
    $droprow = mysql_fetch_array($dropquery);
    
    if (isset($_POST["submit"])) {
        
        $slot = $_POST["slot"];
        
        if ($slot == 0) { $page .= '<span class="alerte">Erreur: Vous devez tout d\'abord choisir une fente dans la liste.</span><br>'; }
        
        if ($userrow["slot".$slot."id"] != 0) {
            
            $slotquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["slot".$slot."id"]."' LIMIT 1", "drops");
            $slotrow = mysql_fetch_array($slotquery);
            
            $old1 = explode(",",$slotrow["attribute1"]);
            if ($slotrow["attribute2"] != "Aucun") { $old2 = explode(",",$slotrow["attribute2"]); } else { $old2 = array(0=>"maxhp",1=>0); }
            $new1 = explode(",",$droprow["attribute1"]);
            if ($droprow["attribute2"] != "Aucun") { $new2 = explode(",",$droprow["attribute2"]); } else { $new2 = array(0=>"maxhp",1=>0); }
            
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
            
        }else {
            
            $new1 = explode(",",$droprow["attribute1"]);
            if ($droprow["attribute2"] != "Aucun") { $new2 = explode(",",$droprow["attribute2"]); } else { $new2 = array(0=>"maxhp",1=>0); }
            
            $userrow[$new1[0]] += $new1[1];
            $userrow[$new2[0]] += $new2[1];
            if ($new1[0] == "strength") { $userrow["attackpower"] += $new1[1]; }
            if ($new1[0] == "dexterity") { $userrow["defensepower"] += $new1[1]; }
            if ($new2[0] == "strength") { $userrow["attackpower"] += $new2[1]; }
            if ($new2[0] == "dexterity") { $userrow["defensepower"] += $new2[1]; }
            
            $newname = addslashes($droprow["name"]);
            $query = doquery("UPDATE {{table}} SET slot".$_POST["slot"]."name='$newname',slot".$_POST["slot"]."id='".$droprow["id"]."',$new1[0]='".$userrow[$new1[0]]."',$new2[0]='".$userrow[$new2[0]]."',attackpower='".$userrow["attackpower"]."',defensepower='".$userrow["defensepower"]."',dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
            
        }
        $page .= 'L\'objet a été équipé.<br><br>Maintenant vous pouvez:<br><br><a href="index.php">» retourner en exploration</a>';
        display($page, 'Objet perdu');
        
    }
    
    $attributearray = array("maxhp"=>"HP Max",
                            "maxmp"=>"MP Max",
                            "maxtp"=>"TP Max",
                            "defensepower"=>"Pouvoir de défense",
                            "attackpower"=>"Pouvoir d'attaque",
                            "strength"=>"Force",
                            "dexterity"=>"Dextérité",
                            "expbonus"=>"Experience Bonus",
                            "goldbonus"=>"Bonus rubis");
    
    $page .= 'Le monstre a fait tomber un objet se nommant <b>'.$droprow['name'].'</b><br><br>';
    $page .= 'Cet objet a l\'attribut(s) suivant:<br><b>';
    
    $attribute1 = explode(",",$droprow["attribute1"]);
    $page .= $attributearray[$attribute1[0]];
    if ($attribute1[1] > 0) { $page .= " +" . $attribute1[1] . "<br><br>"; } else { $page .= $attribute1[1] . "<br><br>"; }
    
    if ($droprow["attribute2"] != "Aucun") { 
        $attribute2 = explode(",",$droprow["attribute2"]);
        $page .= $attributearray[$attribute2[0]];
        if ($attribute2[1] > 0) { $page .= " +" . $attribute2[1] . "<br><br>"; } else { $page .= $attribute2[1] . "<br><br>"; }
    }
    
    $page .= '</b>Pour vous équiper de l\'objet mettez le dans votre sac à dos à partir de la liste ci-dessous. Si votre sac est plein, vous pouvez remplacer un ancien objet, par celui-ci, en selectionnant celui de votre choix.<br><br>
    <form action="index.php?do=drop" method="post"><div><select name="slot"><option value="0">Votre sac à dos</option><option value="1">Objet 1: '.$userrow['slot1name'].'</option><option value="2">Objet 2: '.$userrow['slot2name'].'</option><option value="3">Objet 3: '.$userrow['slot3name'].'</option></select> <input type="submit" name="submit" value="Valider"><br><br></div></form>
    Vous pouvez également:<br><br><a href="index.php">» retourner en exploration</a>';

    display($page, 'Objet perdu');
    
}


?>