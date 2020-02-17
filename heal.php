<?php // heal.php :: Handles stuff from the Quick Spells menu. (Healing spells only... other spells are handled in fight.php.)

function healspells($id) {
    
    global $userrow;
    
    $userspells = explode(",",$userrow["spells"]);
    $spellquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "spells");
    $spellrow = mysql_fetch_array($spellquery);
    
    // All the various ways to error out.
    $spell = false;
    foreach ($userspells as $a => $b) {
        if ($b == $id) { $spell = true; }
    }
    if ($spell != true) { display("Vous n'avez pas encore appris ce sort. Veuillez retourner et recommencer.", "Erreur"); die(); }
    if ($spellrow["type"] != 1) { display("Ce n'est pas un sort qui guérit. Veuiller retourner et recommencer.", "Erreur"); die(); }
    if ($userrow["currentmp"] < $spellrow["mp"]) { display("Vous n'avez pas assez de points de magie pour éxécuter ce sort. Veuillez retourner et recommencer.", "Erreur"); die(); }
    if ($userrow["currentaction"] == "En combat") { display("Vous ne pouvez pas utiliser la liste des sorts rapide pendant un combat. Veuillez retourner et choisir le sort guérisseur que vous souhaitez utiliser.", "Erreur"); die(); }
    if ($userrow["currenthp"] == $userrow["maxhp"]) { display("Vos points hit sont déja pleins. Vous n'avez pas besoin d'utiliser un sort guérisseur maintenant.", "Erreur"); die(); }
    
    $newhp = $userrow["currenthp"] + $spellrow["attribute"];
    if ($userrow["maxhp"] < $newhp) { $spellrow["attribute"] = $userrow["maxhp"] - $userrow["currenthp"]; $newhp = $userrow["currenthp"] + $spellrow["attribute"]; }
    $newmp = $userrow["currentmp"] - $spellrow["mp"];
    
    $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp', currentmp='$newmp' WHERE id='".$userrow["id"]."' LIMIT 1", "users");
    
    display("Vous avez éxécuté le sort ".$spellrow["name"]." , et gagné ".$spellrow["attribute"]." points Hit. Vous pouvez maintenant continuer à  <a href=\"index.php\">explorer le monde</a>.", "Sort,guérisseur");
    die();
    
}

?>